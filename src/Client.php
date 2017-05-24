<?php

namespace Alcohol\GoAnywhere;

use Alcohol\GoAnywhere\Exception\BadMethodCallException;
use Alcohol\GoAnywhere\Exception\InvalidArgumentException;
use Alcohol\GoAnywhere\HttpClient\Plugin\PathPrepend;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\Authentication\BasicAuth;
use Http\Message\MessageFactory;
use Http\Message\UriFactory;

/**
 * @method Api\SshKeys sshkeys()
 * @method Api\WebGroups webgroups()
 * @method Api\WebUsers webusers()
 */
final class Client
{
    /**
     * @var \Http\Client\Common\PluginClient
     */
    private $httpClient;
    /**
     * @var \Http\Message\MessageFactory
     */
    private $messageFactory;
    /**
     * @var \Http\Message\UriFactory
     */
    private $uriFactory;

    /**
     * @param string $hostname
     * @param string $username
     * @param string $password
     * @param string $apiVersion
     * @param \Http\Client\HttpClient|null $httpClient
     * @param \Http\Message\MessageFactory|null $messageFactory
     * @param \Http\Message\UriFactory|null $uriFactory
     */
    public function __construct(
        $hostname,
        $username,
        $password,
        $apiVersion = 'v1',
        HttpClient $httpClient = null,
        MessageFactory $messageFactory = null,
        UriFactory $uriFactory = null
    ) {
        $httpClient = $httpClient ?: HttpClientDiscovery::find();

        $this->messageFactory = $messageFactory ?: MessageFactoryDiscovery::find();
        $this->uriFactory = $uriFactory ?: UriFactoryDiscovery::find();
        $this->httpClient = new PluginClient($httpClient, [
            new RedirectPlugin(),
            new AddHostPlugin($this->uriFactory->createUri($hostname)),
            new PathPrepend(sprintf('/goanywhere/rest/gacmd/%s', $apiVersion)),
            new AuthenticationPlugin(new BasicAuth($username, $password)),
            new HeaderDefaultsPlugin([
                'User-Agent' => 'php-goanywhere (http://github.com/alcohol/php-goanywhere)',
            ]),
        ]);
    }

    /**
     * @return \Http\Client\Common\PluginClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param string $name
     *
     * @return \Alcohol\GoAnywhere\Api\ApiInterface
     */
    public function api($name)
    {
        switch ($name) {
            case 'sshkeys':
                return new Api\SshKeys($this->httpClient, $this->messageFactory);

            case 'webgroups':
                return new Api\WebGroups($this->httpClient, $this->messageFactory);

            case 'webusers':
                return new Api\WebUsers($this->httpClient, $this->messageFactory);

            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }
    }

    /**
     * @param string $name
     * @param mixed $args
     *
     * @throws \BadMethodCallException
     *
     * @return \Alcohol\GoAnywhere\Api\ApiInterface
     */
    public function __call($name, $args)
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name));
        }
    }
}

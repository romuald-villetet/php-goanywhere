<?php

namespace Alcohol\GoAnywhere;

use Alcohol\GoAnywhere\Exception\BadMethodCallException;
use Alcohol\GoAnywhere\Exception\InvalidArgumentException;
use Alcohol\GoAnywhere\HttpClient\Builder;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\MessageFactory;

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
     * @param \Http\Client\HttpClient|null $httpClient
     * @param \Http\Message\MessageFactory|null $messageFactory
     */
    public function __construct(HttpClient $httpClient = null, MessageFactory $messageFactory = null)
    {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->messageFactory = $messageFactory ?: MessageFactoryDiscovery::find();
    }

    /**
     * @param string $endpoint
     * @param string $username
     * @param string $password
     *
     * @return \Alcohol\GoAnywhere\Client
     */
    public static function create($endpoint, $username, $password)
    {
        $httpClient = (new Builder())
            ->withEndpoint($endpoint)
            ->withCredentials($username, $password)
        ;

        return new self($httpClient);
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

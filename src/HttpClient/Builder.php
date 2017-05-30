<?php

namespace Alcohol\GoAnywhere\HttpClient;

use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\Authentication\BasicAuth;
use Http\Message\MessageFactory;
use Http\Message\UriFactory;

final class Builder
{
    /**
     * @var string
     */
    private $endpoint;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;
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
     * @var \Http\Client\Common\Plugin[]
     */
    private $appendPlugins = [];
    /**
     * @var \Http\Client\Common\Plugin[]
     */
    private $prependPlugins = [];

    /**
     * @param \Http\Client\HttpClient|null $httpClient
     * @param \Http\Message\MessageFactory|null $messageFactory
     * @param \Http\Message\UriFactory|null $uriFactory
     */
    public function __construct(
        HttpClient $httpClient = null,
        MessageFactory $messageFactory = null,
        UriFactory $uriFactory = null
    ) {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->messageFactory = $messageFactory ?: MessageFactoryDiscovery::find();
        $this->uriFactory = $uriFactory ?: UriFactoryDiscovery::find();
    }

    /**
     * @return \Http\Client\Common\PluginClient
     */
    public function createConfiguredHttpClient()
    {
        $plugins = $this->prependPlugins;

        $plugins[] = new HeaderDefaultsPlugin([
            'User-Agent' => 'php-goanywhere (http://github.com/alcohol/php-goanywhere)',
        ]);

        if (null !== $this->endpoint) {
            $plugins[] = new BaseUriPlugin($this->uriFactory->createUri($this->endpoint));
        }

        if (null !== $this->username && null !== $this->password) {
            $plugins[] = new AuthenticationPlugin(new BasicAuth($this->username, $this->password));
        }

        $pluginClient = new PluginClient($this->httpClient, array_merge($plugins, $this->appendPlugins));

        return $pluginClient;
    }

    /**
     * @param string $endpoint
     *
     * @return \Alcohol\GoAnywhere\HttpClient\Builder
     */
    public function withEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @param string $username
     *
     * @return \Alcohol\GoAnywhere\HttpClient\Builder
     */
    public function withUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return \Alcohol\GoAnywhere\HttpClient\Builder
     */
    public function withPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return \Alcohol\GoAnywhere\HttpClient\Builder
     */
    public function withCredentials($username, $password)
    {
        return $this
            ->withUsername($username)
            ->withPassword($password)
        ;
    }

    /**
     * @param \Http\Client\Common\Plugin[] $plugin
     *
     * @return \Alcohol\GoAnywhere\HttpClient\Builder
     */
    public function appendPlugin(Plugin ...$plugin)
    {
        foreach ($plugin as $p) {
            $this->appendPlugins[] = $p;
        }

        return $this;
    }

    /**
     * @param \Http\Client\Common\Plugin[] $plugin
     *
     * @return \Alcohol\GoAnywhere\HttpClient\Builder
     */
    public function prependPlugin(Plugin ...$plugin)
    {
        $plugin = array_reverse($plugin);

        foreach ($plugin as $p) {
            array_unshift($this->prependPlugins, $p);
        }

        return $this;
    }
}

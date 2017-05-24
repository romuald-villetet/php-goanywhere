<?php

namespace Alcohol\GoAnywhere\Api;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;

abstract class HttpApi implements ApiInterface
{
    /**
     * @var \Http\Client\HttpClient
     */
    private $httpClient;

    /**
     * @param \Http\Client\HttpClient $httpClient
     * @param \Http\Message\MessageFactory $messageFactory
     */
    public function __construct(HttpClient $httpClient, MessageFactory $messageFactory)
    {
        $this->httpClient = new HttpMethodsClient($httpClient, $messageFactory);
    }

    /**
     * @param string $path
     * @param array $parameters
     * @param array $requestHeaders
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function get($path, array $parameters = [], $requestHeaders = [])
    {
        if (count($parameters) > 0) {
            $path .= '?' . http_build_query($parameters);
        }

        return $this->httpClient->get($path, $requestHeaders);
    }

    /**
     * @param string $path
     * @param array $parameters
     * @param array $requestHeaders
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function patch($path, array $parameters = [], $requestHeaders = [])
    {
        return $this->httpClient->patch(
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters)
        );
    }

    /**
     * @param string $path
     * @param array $parameters
     * @param array $requestHeaders
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function put($path, array $parameters = [], $requestHeaders = ['Content-Type' => 'application/json'])
    {
        return $this->httpClient->put(
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters)
        );
    }

    /**
     * @param string $path
     * @param array $parameters
     * @param array $requestHeaders
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function delete($path, array $parameters = [], $requestHeaders = [])
    {
        return $this->httpClient->delete(
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters)
        );
    }

    /**
     * @param string $path
     * @param array $parameters
     * @param array $requestHeaders
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function post($path, array $parameters = [], array $requestHeaders = ['Content-Type' => 'application/json'])
    {
        return $this->postRaw(
            $path,
            $this->createJsonBody($parameters),
            $requestHeaders
        );
    }

    /**
     * Send a POST request with raw data.
     *
     * @param string $path
     * @param string $body
     * @param array $requestHeaders
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function postRaw($path, $body, array $requestHeaders = [])
    {
        return $this->httpClient->post(
            $path,
            $requestHeaders,
            $body
        );
    }

    /**
     * Create a JSON encoded version of an array of parameters.
     *
     * @param array $parameters
     *
     * @return null|string
     */
    private function createJsonBody(array $parameters)
    {
        return (count($parameters) === 0) ? null : json_encode($parameters, empty($parameters) ? JSON_FORCE_OBJECT : 0);
    }
}

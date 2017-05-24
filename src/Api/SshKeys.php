<?php

namespace Alcohol\GoAnywhere\Api;

use Alcohol\GoAnywhere\Exception\HttpException;

final class SshKeys extends HttpApi
{
    /**
     * Add a new SSH Key.
     *
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function addKey(array $parameters)
    {
        $response = $this->post('/sshkeys', $parameters, ['Content-Type' => 'application/json']);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->getContents());
        }
    }

    /**
     * Delete a SSH Key.
     *
     * @param string $type
     *   Type of key to delete, either public or private
     * @param string $name
     *   Name of the key to delete
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function deleteKey($type, $name)
    {
        $response = $this->delete(sprintf('/sshkeys/%s/%s', urlencode($type), urlencode($name)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->getContents());
        }
    }
}

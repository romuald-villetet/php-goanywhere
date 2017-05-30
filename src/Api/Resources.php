<?php

namespace Alcohol\GoAnywhere\Api;

use Alcohol\GoAnywhere\Exception\HttpException;
use Alcohol\GoAnywhere\HttpClient\Message\ResponseMediator;

final class Resources extends HttpApi
{
    /**
     * Delete a resource.
     *
     * @param string $type
     *   The type of resource do delete
     * @param string $resource
     *   The name of the resource to delete
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function deleteResource($type, $resource)
    {
        $response = $this->delete(sprintf('/resources/%s/%s', urlencode($type), urlencode($resource)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Export a resource as XML.
     *
     * @param string $type
     *   The type of resource do delete
     * @param string $resource
     *   The name of the resource to export
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     *
     * @return string
     */
    public function exportResource($type, $resource)
    {
        $response = $this->get(sprintf('/resources/%s/%s', urlencode($type), urlencode($resource)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }

        return ResponseMediator::getContent($response);
    }

    /**
     * Import a resource.
     *
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function importResource(array $parameters)
    {
        $response = $this->post('/resources', $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Promote a resource from one GoAnywhere server to another GoAnywhere server.
     *
     * @param string $type
     *   The type of resource to promote
     * @param string $resource
     *   The name of the resource to promote
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function promoteResource($type, $resource, array $parameters)
    {
        $response = $this->post(sprintf('/resources/%s/%s', urlencode($type), urlencode($resource)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }
}

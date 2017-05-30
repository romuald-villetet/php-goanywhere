<?php

namespace Alcohol\GoAnywhere\Api;

use Alcohol\GoAnywhere\Exception\HttpException;
use Alcohol\GoAnywhere\HttpClient\Message\ResponseMediator;

final class Monitors extends HttpApi
{
    /**
     * Delete a monitor.
     *
     * @param $type
     *   The type of monitor do delete
     * @param string $monitor
     *   The name of the monitor to delete
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function deleteMonitor($type, $monitor)
    {
        $response = $this->delete(sprintf('/monitors/%s/%s', urlencode($type), urlencode($monitor)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Export a monitor as XML.
     *
     * @param $type
     *   The type of monitor do delete
     * @param string $monitor
     *   The name of the monitor to export
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     *
     * @return string
     */
    public function exportMonitor($type, $monitor)
    {
        $response = $this->get(sprintf('/monitors/%s/%s', urlencode($type), urlencode($monitor)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }

        return ResponseMediator::getContent($response);
    }

    /**
     * Import a monitor.
     *
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function importMonitor(array $parameters)
    {
        $response = $this->post('/monitors', $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Promote a monitor from one GoAnywhere server to another GoAnywhere server.
     *
     * @param $type
     *   The type of monitor to promote
     * @param string $monitor
     *   The name of the monitor to promote
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function promoteMonitor($type, $monitor, array $parameters)
    {
        $response = $this->post(sprintf('/monitors/%s/%s/promote', urlencode($type), urlencode($monitor)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }
}

<?php

namespace Alcohol\GoAnywhere\Api;

use Alcohol\GoAnywhere\Exception\HttpException;
use Alcohol\GoAnywhere\HttpClient\Message\ResponseMediator;

final class Triggers extends HttpApi
{
    /**
     * Delete a trigger.
     *
     * @param string $type
     *   The type of trigger do delete
     * @param string $trigger
     *   The name of the trigger to delete
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function deleteTrigger($type, $trigger)
    {
        $response = $this->delete(sprintf('/triggers/%s/%s', urlencode($type), urlencode($trigger)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Export a trigger as XML.
     *
     * @param string $type
     *   The type of trigger do delete
     * @param string $trigger
     *   The name of the trigger to export
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     *
     * @return string
     */
    public function exportTrigger($type, $trigger)
    {
        $response = $this->get(sprintf('/triggers/%s/%s', urlencode($type), urlencode($trigger)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }

        return ResponseMediator::getContent($response);
    }

    /**
     * Import a trigger.
     *
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function importTrigger(array $parameters)
    {
        $response = $this->post('/triggers', $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Promote a trigger from one GoAnywhere server to another GoAnywhere server.
     *
     * @param string $type
     *   The type of trigger to promote
     * @param string $trigger
     *   The name of the trigger to promote
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function promoteTrigger($type, $trigger, array $parameters)
    {
        $response = $this->post(sprintf('/triggers/%s/%s/promote', urlencode($type), urlencode($trigger)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }
}

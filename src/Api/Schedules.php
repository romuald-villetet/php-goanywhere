<?php

namespace Alcohol\GoAnywhere\Api;

use Alcohol\GoAnywhere\Exception\HttpException;
use Alcohol\GoAnywhere\HttpClient\Message\ResponseMediator;

final class Schedules extends HttpApi
{
    /**
     * Delete a schedule.
     *
     * @param string $schedule
     *   The name of the schedule to delete
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function deleteSchedule($schedule)
    {
        $response = $this->delete(sprintf('/schedules/%s', urlencode($schedule)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Export a schedule as XML.
     *
     * @param string $schedule
     *   The name of the schedule to export
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     *
     * @return string
     */
    public function exportSchedule($schedule)
    {
        $response = $this->get(sprintf('/schedules/%s', urlencode($schedule)));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }

        return ResponseMediator::getContent($response);
    }

    /**
     * Import a schedule.
     *
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function importSchedule(array $parameters)
    {
        $response = $this->post('/schedules', $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Promote a schedule from one GoAnywhere server to another GoAnywhere server.
     *
     * @param string $schedule
     *   The name of the schedule to promote
     * @param array $parameters
     *   An array representation of the expected JSON body
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function promoteSchedule($schedule, array $parameters)
    {
        $response = $this->post(sprintf('/schedules/%s/promote', urlencode($schedule)), $parameters);

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }
}

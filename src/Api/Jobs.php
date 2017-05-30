<?php

namespace Alcohol\GoAnywhere\Api;

use Alcohol\GoAnywhere\Exception\HttpException;
use Alcohol\GoAnywhere\HttpClient\Message\ResponseMediator;

final class Jobs extends HttpApi
{
    /**
     * Cancel a job.
     *
     * @param int $job
     *   A unique job number
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function cancelJob($job)
    {
        $response = $this->post(sprintf('/jobs/%u/cancel', $job));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Download a job log.
     *
     * @param int $job
     *   A unique job number
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     *
     * @return string
     */
    public function getJobLog($job)
    {
        $response = $this->get(sprintf('/jobs/%u', $job));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }

        return ResponseMediator::getContent($response);
    }

    /**
     * Pause a job.
     *
     * @param int $job
     *   A unique job number
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function pauseJob($job)
    {
        $response = $this->post(sprintf('/jobs/%u/pause', $job));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }

    /**
     * Resume a paused job.
     *
     * @param int $job
     *   A unique job number
     *
     * @throws \Alcohol\GoAnywhere\Exception\HttpException
     */
    public function resumeJob($job)
    {
        $response = $this->post(sprintf('/jobs/%u/resume', $job));

        if (400 <= $response->getStatusCode()) {
            throw new HttpException($response->getStatusCode(), $response->getBody()->__toString());
        }
    }
}

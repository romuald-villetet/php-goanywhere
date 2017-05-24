<?php

namespace Alcohol\GoAnywhere\HttpClient\Message;

use Psr\Http\Message\ResponseInterface;

final class ResponseMediator
{
    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return array|string
     */
    public static function getContent(ResponseInterface $response)
    {
        $body = $response->getBody()->__toString();

        if (0 === strpos($response->getHeaderLine('Content-Type'), 'application/json')) {
            $content = json_decode($body, true);

            if (JSON_ERROR_NONE === json_last_error()) {
                return $content;
            }
        }

        return $body;
    }
}

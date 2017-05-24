<?php

namespace Alcohol\GoAnywhere\Exception;

use Alcohol\GoAnywhere\Exception;

final class HttpException extends \Exception implements Exception
{
    /**
     * List of HTTP status codes (from 400 and up).
     *
     * From http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
     *
     * @var array
     */
    private $codes = [
        400 => 'Bad Request',
        401 => 'Unauthorized', // RFC 7235
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required', // RFC 7235
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed', // RFC 7232
        413 => 'Payload Too Large', // RFC 7231
        414 => 'URI Too Long',  // RFC 7231
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',  // RFC 7233
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot', // RFC 2324
        419 => 'Authentication Timeout', // not in RFC 2616
        420 => 'Method Failure', // Spring Framework
        421 => 'Misdirected Request', // RFC 7540
        422 => 'Unprocessable Entity', // WebDAV; RFC 4918
        423 => 'Locked', // WebDAV; RFC 4918
        424 => 'Failed Dependency', // WebDAV; RFC 4918
        425 => 'Unordered Collection', // Internet draft
        426 => 'Upgrade Required', // RFC 2817
        428 => 'Precondition Required', // RFC 6585
        429 => 'Too Many Requests', // RFC 6585
        431 => 'Request Header Fields Too Large', // RFC 6585
        440 => 'Login Time-out', // IIS
        444 => 'No Response', // Nginx
        449 => 'Retry With', // IIS
        450 => 'Blocked by Windows Parental Controls', // Microsoft
        451 => 'Unavailable For Legal Reasons', // RFC 7725
        494 => 'Request Header Too Large', // Nginx
        495 => 'Cert Error', // Nginx
        496 => 'No Cert', // Nginx
        497 => 'HTTP to HTTPS', // Nginx
        499 => 'Client Closed Request', // Nginx
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates', // RFC 2295
        507 => 'Insufficient Storage', // WebDAV; RFC 4918
        508 => 'Loop Detected', // WebDAV; RFC 5842
        509 => 'Bandwidth Limit Exceeded', // Apache bw/limited extension
        510 => 'Not Extended', // RFC 2774
        511 => 'Network Authentication Required', // RFC 6585
        520 => 'Unknown Error', // Cloudflare
        521 => 'Web Server Is Down', // Cloudflare
        522 => 'Connection Timed Out', // Cloudflare
        523 => 'Origin Is Unreachable', // Cloudflare
        524 => 'A Timeout Occured', // Cloudflare
        525 => 'SSL Handshake Failed', // Cloudflare
        526 => 'Invalid SSL Certificate', // Cloudflare
        527 => 'Railgun Error', // Cloudflare
        598 => 'Network read timeout error', // Unknown
        599 => 'Network connect timeout error', // Unknown
    ];

    /**
     * @param int $code
     * @param string $message
     */
    public function __construct($code = 500, $message = null)
    {
        if (array_key_exists($code, $this->codes)) {
            if (!empty($message)) {
                $message = sprintf('%s: %s', $this->codes[$code], $message);
            } else {
                $message = $this->codes[$code];
            }
        }

        parent::__construct($message, $code);
    }
}

<?php

namespace Alcohol\GoAnywhere\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;

final class PathPrepend implements Plugin
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param callable $next
     * @param callable $first
     *
     * @return mixed
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first)
    {
        $currentPath = $request->getUri()->getPath();
        $uri = $request->getUri()->withPath($this->path . $currentPath);
        $request = $request->withUri($uri);

        return $next($request);
    }
}

# alcohol/php-goanywhere

A PHP library providing a client for the REST API of [GoAnywhere](https://www.goanywhere.com).

[![License](https://img.shields.io/packagist/l/alcohol/php-goanywhere.svg?style=flat-square)](https://packagist.org/packages/alcohol/go-anywhere)

## Installing

``` sh
$ composer require alcohol/php-goanywhere
```

> NOTE: This library does not require a specific HTTP client implementation. Pick one that suits you best. See
> http://docs.php-http.org/en/latest/httplug/users.html for more details.

## Using

``` php
<?php

require_once 'vendor/autoload.php';

$httpClient = (new Alcohol\GoAnywhere\HttpClient\Builder())
    ->withEndpoint('http://localhost:8001/goanywhere/rest/gacmd/v1')
    ->withCredentials('username', 'password')
    ->getConfiguredHttpClient()
;

$apiClient = new Alcohol\GoAnywhere\Client($httpClient);

try {
    $client->webusers()->addUser(['addParameters' => ['template' => 'my-template', 'username' => 'Foo']]);
} catch (\Alcohol\GoAnywhere\Exception $exception) {
    // handle errors
}
```

## Disclaimer

The GoAnywhere REST API is not very consistent, nor would I qualify their documentation as "complete"¹. This 
implementation therefor is made on a best-effort basis only. Should you run into any problems however, we can
look into resolving them together. Please open an issue or submit a pull-request.

¹) For example;

- the keys in JSON payload examples are sometimes shown as camelCase, but the API actually expects them to be lowercase (or vice-versa),
- the endpoint URLs or JSON payloads are not always very consistent in format/layout, or sometimes just plain wrong,
- in case of an error, the response body is often merely a short string.

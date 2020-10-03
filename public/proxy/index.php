<?php

require dirname(__DIR__, 2) . '/vendor/autoload.php';
require __DIR__ . '/auth.php';

use GuzzleHttp\Client;

$username = USER['username'];
$password = USER['password'];
$path = $_SERVER['REQUEST_URI'];

// find origin host
if (isset($_SERVER['HTTP_REFERER'])) {
  $origin = parse_url($_SERVER['HTTP_REFERER'])['host']; // e.g. referrer = http://localhost:8080 > $origin will be 'localhost'
}

// get the correct protocol
if (
  isset($_SERVER['HTTPS']) &&
  ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
  isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
  $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
{
    $protocol = 'https://';
}
else {
  $protocol = 'http://';
}
$host = $_SERVER['HTTP_HOST'];
$baseUri = $protocol . $host;

// Remove /proxy from request
// https://regex101.com/r/vesbph/1
preg_match("/\/proxy([a-zA-Z+0-9\/-]+)/", $path, $match);
// get the matching group (after /proxy) and remove leading and trailing slashes
$requestUrl = trim($match[1], '/');

// Create a client with a base URI
$client = new GuzzleHttp\Client([
	'base_uri' => $baseUri . '/',
  'http_errors' => false,
  'timeout' => 10,
  'headers' => [
    'Accept' => 'application/json; charset=utf-8'
  ]
]);
// Send a request with basic authentication
$promise = $client->requestAsync(
	'GET',
	$requestUrl,
	[
		'auth' => [$username, $password],
		'Origin' => $baseUri
	]
);

$promise->then(
  function($response) {
    $statusCode = $response->getStatusCode();

    if (200 === $statusCode) {
      echo $response->getBody();
    }
    else {
      echo json_encode([
        'error' => true,
        'status' => $statusCode
      ]);
    }
  },
  function($exeption) {
    echo json_encode([
      'error' => true,
      'expection' => $exeption->getMessage()
    ]);
  }
);

// https://github.com/guzzle/guzzle/issues/1848
header('Content-type: application/json');

// Allow CORS only for a limited amount of domains
if (in_array($host, ALLOWED_ORIGINS, true)) {
  header('Access-Control-Allow-Origin: *');
}

$promise->wait();




<?php

require dirname(__DIR__, 2) . '/vendor/autoload.php';
require __DIR__ . '/auth.php';

use GuzzleHttp\Client;

$username = USER['username'];
$password = USER['password'];
$path = $_SERVER['REQUEST_URI'];

// find origin host
$origin = parse_url($_SERVER['HTTP_REFERER'])['host']; // e.g. referrer = http://localhost:8080 > $origin will be 'localhost'

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
	'base_uri' => $baseUri . '/rest/',
  'http_errors' => false,
  'headers' => [
    'Accept' => 'application/json; charset=utf-8'
  ]
]);
// Send a request with basic authentication
$response = $client->request(
	'GET',
	$requestUrl,
	[
		'auth' => [$username, $password],
		'Origin' => $baseUri
	]
);
// https://github.com/guzzle/guzzle/issues/1848

// Set headers and look for the right referrers
if (in_array($origin, LIST_OF_ALLOWED_ORIGINS)) {
  header('Content-type: application/json');
  header('Access-Control-Allow-Origin:' . $_SERVER['HTTP_ORIGIN']);
}

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


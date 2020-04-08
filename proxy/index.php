<?php

require dirname(__DIR__, 1) . '/vendor/autoload.php';
require __DIR__ . '/auth.php';

use GuzzleHttp\Client;

$username = USER['username'];
$password = USER['password'];
$path = $_SERVER['REQUEST_URI'];
$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$baseUri = $protocol . $host;

// echo $path;
// echo $host;
// echo $baseUri;

// Remove /proxy from request
// https://regex101.com/r/vesbph/1
preg_match("/\/proxy([a-zA-Z+0-9\/-]+)/", $path, $match);
// get the matching group (after /proxy) and remove leading and trailing slashes
$requestUrl = trim($match[1], '/');

// Create a client with a base URI
$client = new GuzzleHttp\Client([
	// ⚠️ Change the url depending on if you are on your local computer or on remote
	'base_uri' => $baseUri . '/api/',
	// 'base_uri' => 'https://cms.ssar.ch/api/',
	'http_errors' => false
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
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');

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


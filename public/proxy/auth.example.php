<?php

// This user has to be set up to have only very few rights and should only be on the server.
// So create the user only (use the API Consumer credentials, for which there is a user blueprint) online
// and add the credentials to the online auth.php file!
const USER = [
  'username' => 'js+megahex-api@wearelucid.ch',
  'password' => 'your-password'

];

// Send back correct request headers to not allow returns to anywhere
const ALLOWED_ORIGINS = [
	'localhost',
	'cms.megahex.test',
	'cms.megahex.fm',
	'megahex.fm'
];

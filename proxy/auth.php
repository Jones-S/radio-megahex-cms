<?php

// This user has to be set up to have only very few rights and should only be on the server.
// So create the user only (use the API Consumer credentials, for which there is a user blueprint) online
// and add the credentials to the online auth.php file!
const USER = [
	'username' => 'js+megahex-api@wearelucid.ch',
	'password' => 'hubbub.hotshot.skull.armoire.backfill'
];

// Send back correct request headers to not allow returns to anywhere
// const LIST_OF_ALLOWED_ORIGINS = [
// 	'localhost',
// 	'cms.sar.test',
// 	'ssar.ch'
// ];

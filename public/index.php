<?php

include '../vendor/autoload.php';

// Define kirby directories in a way that all the storage folders are collected in one directory
// This should allow good symlinking in a continuous deployment setup
$kirby = new Kirby([
  'roots' => [
    'index'    => __DIR__,
    'base'     => $base    = dirname(__DIR__),
    'site'     => $base . '/site',
    'storage'  => $storage = $base . '/storage',
    'content'  => $storage . '/content',
    'accounts' => $storage . '/accounts',
    'cache'    => $storage . '/cache',
    'media'    => $storage . '/media', // NOTE: needs symlink /public/media to /storage/media
    'sessions' => $storage . '/sessions',
  ]
]);

// create symlink if needed
$symlink = __DIR__ . '/media';
if (!file_exists($symlink)) {
  symlink($kirby->roots()->media(), $symlink);
}

echo $kirby->render();



// <?php

// include '../vendor/autoload.php';

// // Define kirby directories in a way that all the storage folders are collected in one directory
// // This should allow good symlinking in a continuous deployment setup
// $kirby = new Kirby([
//   'roots' => [
//     'index'    => __DIR__,
//     'base'     => $base = dirname(__DIR__),
//     'shared'   => $shared = dirname(__DIR__, 3) . '/shared',
//     'site'     => $base . '/site',
//     'storage'  => $storage = $shared . '/storage',
//     'content'  => $storage . '/content',
//     'accounts' => $storage . '/accounts',
//     'cache'    => $storage . '/cache',
//     'media'    => $storage . '/media', // NOTE: needs symlink /public/media to /storage/media
//     'sessions' => $storage . '/sessions',
//   ]
// ]);

// // create symlink if needed
// $symlink = __DIR__ . '/media';
// if (!file_exists($symlink)) {
//   symlink($kirby->roots()->media(), $symlink);
// }

// echo $kirby->render();

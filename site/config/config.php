<?php

/**
 * The config file is optional. It accepts a return array with config options
 * Note: Never include more than one return statement, all options go within this single return array
 * In this example, we set debugging to true, so that errors are displayed onscreen.
 * This setting must be set to false in production.
 * All config options: https://getkirby.com/docs/reference/system/options
 */

return [
  'debug' => true,
  'smartypants' => true, // https://getkirby.com/docs/guide/content/text-formatting#smartypants
  'api' => [
    'slug' => 'api',
    'basicAuth' => true,
    'allowInsecure' => true,
    'robinscholz.better-rest.smartypants' => true,
    'robinscholz.better-rest.srcset' => [333, 777, 888, 1111]

    // // Here we define custom endpoints
    // 'routes' => [
    // 	[
    // 		'pattern' => 'projects',
    // 		'method' => 'GET',
    // 		'action'  => function ($path = null) {
    // 			// we need to create a new kirby instance to get access to all the kirby methods (like resize(), getting content etc.)
    // 			$kirby = new Kirby([
    // 				'roots' => [
    // 						'index'    => dirname(dirname(__DIR__)),
    // 						'base'     => $base    = dirname(dirname(__DIR__)),
    // 						'content'  => $base . '/content',
    // 						'site'     => dirname(dirname(__DIR__)) . '/site',
    // 						'storage'  => $storage = $base . '/storage',
    // 						'accounts' => $storage . '/accounts',
    // 						'cache'    => $storage . '/cache',
    // 						'sessions' => $storage . '/sessions',
    // 				]
    // 			]);
    // 			$children = $kirby->page('architektur')->children();
    // 			$projects = [];

    // 			foreach ($children as $child) {
    // 				if ($child->status() !== 'listed') {
    // 					continue;
    // 				}

    // 				$title = $child->title()->toString();
    // 				$uri = $child->uri(); // 'architektur\/busdach-laufen
    // 				$content = $child->content();
    // 				$index = $child->indexOf();
    // 				$files = $child->images();
    // 				$images = [];

    // 				foreach ($files as $file) {
    // 					$images[] = [
    // 						'filename' => $file->filename(),
    // 						'index' => $file->indexOf(),
    // 						'sizes' => [
    // 							'original' => $file->url(),
    // 							'alt' => $file->content()->alt()->toString(),
    // 							'thumb' => $file->crop(400, 226, 80)->url(),
    // 							'small' => $file->resize(720, null, 60)->url(),
    // 							'medium' => $file->resize(1440, null, 60)->url(),
    // 							'large' => $file->resize(2000, null, 60)->url(), // if the original image is smaller than size, it will just return the biggest possible 👌🏼
    // 							'ogimage' => $file->crop(1200, 630, 70)->url(),
    // 						]
    // 					];
    // 				}

    // 				$projects[] = [
    // 					'title' => $title,
    // 					'slug' => $uri,
    // 					'index' => $index,
    // 					'uri' => $child->uri(),
    // 					'slug' => $child->slug(),
    // 					'text' => $content->text()->toString(),
    // 					'meta' => $content->metadesc()->toString(),
    // 					'images' => $images
    // 				];
    // 			}

    // 			return [
    // 				'projects' => $projects
    // 			];
    // 		}
    // 	]
    // ]
  ]
];

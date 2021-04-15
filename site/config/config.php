<?php

// helper functions
if (!function_exists('removeEmpty')) {
  function removeEmpty($var) {
    return($var->value !== null && $var->value !== '');
  }
}

/**
 * The config file is optional. It accepts a return array with config options
 * Note: Never include more than one return statement, all options go within this single return array
 * In this example, we set debugging to true, so that errors are displayed onscreen.
 * This setting must be set to false in production.
 * All config options: https://getkirby.com/docs/reference/system/options
 */

return [
  'debug' => true,
  'languages' => true, // enable multilang
  'smartypants' => true, // https://getkirby.com/docs/guide/content/text-formatting#smartypants
  'api' => [
    'slug' => 'api',
    'basicAuth' => true,
    'allowInsecure' => true
  ],
  'robinscholz.better-rest.smartypants' => true,
  'robinscholz.better-rest.kirbytags' => true,
  'robinscholz.better-rest.srcset' => [333, 777, 888, 1111],
  // 'robinscholz.better-rest.language' => 'en'
  'panel' =>[
    'install' => true
  ],
  'routes' => function() {
    // we need to create a new kirby instance to get access to all the kirby methods (like resize(), getting content etc.)
    // $kirby = new Kirby([
    //   'roots' => [
    //       'index'    => (dirname(__DIR__)),
    //       'base'     => $base    = dirname(__DIR__, 2),
    //       'site'     => $base . '/site',
    //       'storage'  => $storage = $base . '/storage',
    //       'content'  => $storage . '/content',
    //       'accounts' => $storage . '/accounts',
    //       'cache'    => $storage . '/cache',
    //       'media'    => $storage . '/media', // NOTE: needs symlink /public/media to /storage/media
    //       'sessions' => $storage . '/sessions',
    //   ]
    // ]);

    return [
      // TODO: register plugin to provide custom endpoints:
      // https://getkirby.com/docs/reference/plugins/extensions/api
      [
        // Custom route to get all blog entries
        'pattern' => 'blog',
        'method' => 'GET',
        'action'  => function ($path = null) {
          $kirby = new Kirby([
            'roots' => [
                'index'    => (dirname(__DIR__)),
                'base'     => $base    = dirname(__DIR__, 2),
                'site'     => $base . '/site',
                'storage'  => $storage = $base . '/storage',
                'content'  => $storage . '/content',
                'accounts' => $storage . '/accounts',
                'cache'    => $storage . '/cache',
                'media'    => $storage . '/media', // NOTE: needs symlink /public/media to /storage/media
                'sessions' => $storage . '/sessions',
            ]
          ]);
          $children = $kirby->page('blog')->children();
          $entries = [];

          foreach ($children as $child) {
            if ($child->status() !== 'listed') {
              continue;
            }

            $title = $child->title()->toString();
            $uri = $child->uri();
            $content = $child->content();
            $index = $child->indexOf();
            $images = [];
            $date = $child->content()->date()->toDate('Y-m-d\TH:i:s\Z'); // ISO format like: "2020-04-18T20:30:00Z", should be parseable by all browsers

            $entries[] = [
              'title' => $title,
              'slug' => $uri,
              'index' => $index,
              'uri' => $child->uri(),
              'slug' => $child->slug(),
              'file' => $child->filename()->toString(),
              'date' => $date,
            ];
          }

          return [
            'blog_entries' => $entries
          ];
        }
      ],
      [
        // Custom route to get all necessary archive info, which is directly saved within the entry page
        'pattern' => 'archive',
        'method' => 'GET',
        'action'  => function ($path = null) {
          $kirby = new Kirby([
            'roots' => [
                'index'    => (dirname(__DIR__)),
                'base'     => $base    = dirname(__DIR__, 2),
                'site'     => $base . '/site',
                'storage'  => $storage = $base . '/storage',
                'content'  => $storage . '/content',
                'accounts' => $storage . '/accounts',
                'cache'    => $storage . '/cache',
                'media'    => $storage . '/media', // NOTE: needs symlink /public/media to /storage/media
                'sessions' => $storage . '/sessions',
            ]
          ]);
          $children = $kirby->page('archive')->children();
          $entries = [];

          foreach ($children as $child) {
            if ($child->status() !== 'listed') {
              continue;
            }

            $title = $child->title()->toString();
            $uri = $child->uri();
            $content = $child->content();
            $index = $child->indexOf();
            $images = [];
            $date = $child->content()->date()->toDate('Y-m-d\TH:i:s\Z'); // ISO format like: "2020-04-18T20:30:00Z", should be parseable by all browsers

            $entries[] = [
              'title' => $title,
              'slug' => $uri,
              'index' => $index,
              'uri' => $child->uri(),
              'slug' => $child->slug(),
              'file' => $child->filename()->toString(),
              'date' => $date,
              'end_time' => $child->content()->end_time()->toString(),
              'format' => $child->content()->format()->toString(),
              'tags' => $child->content()->tags()->split(',')
            ];
          }

          return [
            'archive_entries' => $entries
          ];
        }
      ],
      [
        // Custom route to get all necessary archive info, which is directly saved within the entry page
        'pattern' => 'filter',
        'method' => 'GET',
        'action'  => function ($path = null) {
          $kirby = new Kirby([
            'roots' => [
                'index'    => (dirname(__DIR__)),
                'base'     => $base    = dirname(__DIR__, 2),
                'site'     => $base . '/site',
                'storage'  => $storage = $base . '/storage',
                'content'  => $storage . '/content',
                'accounts' => $storage . '/accounts',
                'cache'    => $storage . '/cache',
                'media'    => $storage . '/media', // NOTE: needs symlink /public/media to /storage/media
                'sessions' => $storage . '/sessions',
            ]
          ]);
          $pages = $kirby->page('archive')->children();
          $unique = true;
          // getting all values of select field «format», and removing duplicate values.
          $formats = $pages->pluck('format', ',', $unique);
          $tags = $pages->pluck('tags', ',', $unique);

          return [
            'formats' => $formats,
            'tags' => $tags
          ];
        }
      ],
      [
        // Custom route to get all necessary archive info, which is directly saved within the entry page
        'pattern' => 'megahex',
        'method' => 'GET',
        'action'  => function ($path = null) {
          $kirby = new Kirby([
            'roots' => [
                'index'    => (dirname(__DIR__)),
                'base'     => $base    = dirname(__DIR__, 2),
                'site'     => $base . '/site',
                'storage'  => $storage = $base . '/storage',
                'content'  => $storage . '/content',
                'accounts' => $storage . '/accounts',
                'cache'    => $storage . '/cache',
                'media'    => $storage . '/media', // NOTE: needs symlink /public/media to /storage/media
                'sessions' => $storage . '/sessions',
            ]
          ]);
          $site = $kirby->site();
          $home = $kirby->page('home');
          $children = $site->children();
          $entries = [];

          foreach ($children as $child) {
            // print('<pre>' . print_r($child, true) . '</pre>');
            if ($child->status() !== 'listed') {
              continue;
            }

            $title = $child->title()->toString();
            $uri = $child->uri();
            $content = $child->content();
            $index = $child->indexOf();

            $entries[] = [
              'title' => $title,
              'slug' => $uri,
              'index' => $index,
              'uri' => $child->uri(),
              'slug' => $child->slug()
            ];
          }

          $site = [
            'broadcast' => $home->broadcast()->toString(),
            'navigation' => $entries
          ];

          return [
            'site' => $site
          ];
        }
      ]
    ];
  }
];

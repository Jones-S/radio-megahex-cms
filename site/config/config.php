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
        // Overriding robinscholz/better-rest route for home (.../rest/pages/home)
        'pattern' => 'megahex-home',
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
          $home = $kirby->page('home');
          $content = $home->content();
          $broadcast = $content->broadcast()->toString();
          $twitch = $content->twitch_channel()->toString();
          $relatedPages = $content->related()->toPages();
          $relatedPagesExtended = [];

          foreach($relatedPages as $relatedPage) {
            $content = $relatedPage->content();
            // $files = $content->draggable_images()->files();
            $images = $relatedPage->images();
            $teaserImages = [];
            $teaserImage = 'nope';

            if (!empty($images)) {
              $teaserImage  = $relatedPage->image();
            }

            foreach ($images as $file) {
              $teaserImages[] = [
                'filename' => $file->filename(),
                'index' => $file->indexOf(),
                'sizes' => [
                  'original' => $file->url(),
                  'alt' => $file->content()->alt()->toString(),
                  'thumb' => $file->crop(400, 226, 80)->url(),
                  'small' => $file->resize(720, null, 60)->url(),
                  'medium' => $file->resize(1440, null, 60)->url(),
                  'large' => $file->resize(2000, null, 60)->url(), // if the original image is smaller than size, it will just return the biggest possible 👌🏼
                  'ogimage' => $file->crop(1200, 630, 70)->url(),
                ]
              ];
            }

            $relatedPagesExtended[] = [
              'title' => $relatedPage->title()->toString(),
              'slug' => $relatedPage->uri(),
              'uri' => $relatedPage->uri(),
              'index' => $relatedPage->indexOf(),
              'slug' => $relatedPage->slug(),
              'filename' => $content->filename()->toString(),
              'date' => $content->date()->toDate('Y-m-d\TH:i:s\Z'), // ISO format like: "2020-04-18T20:30:00Z", should be parseable by all browsers
              'teaserImage' => $teaserImage,
              'teaserImages' => $teaserImages
              // 'file' => $relatePage->filename()->toString(),
              // 'date' => $date,
              // 'end_time' => $relatePage->content()->end_time()->toString(),
              // 'format' => $relatePage->content()->format()->toString(),
              // 'tags' => $relatePage->content()->tags()->split(',')
            ];
          }
          // $entries = [];

          // foreach ($children as $child) {
          //   if ($child->status() !== 'listed') {
          //     continue;
          //   }

          //   $title = $child->title()->toString();
          //   $uri = $child->uri();
          //   $content = $child->content();
          //   $index = $child->indexOf();
          //   $images = [];
          //   $date = $child->content()->date()->toDate('Y-m-d\TH:i:s\Z'); // ISO format like: "2020-04-18T20:30:00Z", should be parseable by all browsers

          //   $entries[] = [
          //     'title' => $title,
          //     'slug' => $uri,
          //     'index' => $index,
          //     'uri' => $child->uri(),
          //     'slug' => $child->slug(),
          //     'file' => $child->filename()->toString(),
          //     'date' => $date,
          //     'end_time' => $child->content()->end_time()->toString(),
          //     'format' => $child->content()->format()->toString(),
          //     'tags' => $child->content()->tags()->split(',')
          //   ];
          // }

          return [
            'code' => '200',
            'data' => [
              'content' => [
                'broadcast' => $broadcast,
                'twitch_channel' => $twitch,
                'related' => $relatedPagesExtended
              ]
            ]
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

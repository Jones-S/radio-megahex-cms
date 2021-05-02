<?php

Kirby::plugin('jones-s/mh-image-block', [
  'blueprints' => [
    'blocks/mhimage' => __DIR__ . '/blueprints/blocks/mhimage.yml',
    'files/mhimage'  => __DIR__ . '/blueprints/files/mhblockimage.yml',
  ],
  'hooks' => [
    'page.update:after' => function ($newPage, $oldPage) {
      $blocks = $newPage->teaserText()->toBlocks();

      $mh = new Kirby\Cms\Block([
        "content" => [
          "image" => [
            "screenshot-2021-04-14-at-20.41.20.png"
          ],
          "alt" => "alttext",
          "caption" => "acse",
          "link" => ""
        ],
        "type" => "mhimage"
      ]);

      // $mh = new Kirby\Cms\Block([
      //   'content' => [
      //     'text' => '<p>Hug them if you like. They might not appreciate it though.</p><p>Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum id ligula porta felis euismod semper. Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>',
      //   ],
      //   'type' => 'text',
      // ]);

      $blocks = $blocks->add(new Kirby\Cms\Blocks([$mh]));

      // $blocks = Kirby\Cms\Blocks::factory([
      //   [
      //     'content' => [
      //       'text' => 'oo Nice heading'
      //     ],
      //     'type' => 'heading'
      //   ],
      //   [
      //     "content" => [
      //       "image" => [
      //         "screenshot-2021-04-14-at-20.41.20.png"
      //       ],
      //       "alt" => "alttext",
      //       "caption" => "acse",
      //       "link" => ""
      //     ],
      //     "type" => "mhimage"
      //   ],
      //   [
      //     'content' => [
      //       'text' => 'oo This is some text'
      //     ],
      //     'type' => 'text'
      //   ],
      // ]);



      // $newBlock = [
      //   [
      //     "content" => [
      //       "image" => [
      //         "screenshot-2021-04-14-at-20.41.20.png"
      //       ],
      //       "alt" => "alttext",
      //       "caption" => "acse",
      //       "link" => ""
      //     ],
      //     "type" => "mh-image"
      //   ],
      //   [
      //     "content" => [
      //       "text" => print_r($blocks, true)
      //     ],
      //     "type" => "text"
      //   ],
      // ];




      $kirby = kirby();
      $kirby->impersonate('kirby');

      // $newPage->update([
      //   'teaserText' => $blocks,
      // ]);
    }
  ]
]);

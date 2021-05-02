<?php

Kirby::plugin('jones-s/mh-image-block', [
  'hooks' => [
    'page.update:after' => function ($newPage, $oldPage) {

      foreach ($newPage->content()->fields() as $field) {
          $newBlocks = new Kirby\Cms\Blocks();
          // there is no method to get the fields type
          // except by getting the pages blueprint and looking for the fields key
          // https://forum.getkirby.com/t/how-to-determine-field-type-in-custom-field-method/19254
          $fieldKey = $field->key(); // name of the field, like 'teasertext'

          // https://getkirby.com/docs/reference/objects/cms/page-blueprint/field
          $fieldDefinition = $newPage->blueprint()->field($fieldKey);

          if (isset($fieldDefinition['type'])) { // some field definitions dont have a type 🤷‍♂️
            if ($fieldDefinition['type'] === 'blocks') {
              $blocks = $field->toBlocks();

              foreach ($blocks as $block) {
                if (
                  $block->type() !== 'image' ||
                  ($block->type() === 'image' && empty($block->image())) // dont do it for empty image blocks
                ) {
                  $newBlocks->add($block);
                } else {
                  $url      = $block->image()->toFile()->url();
                  $images   = $block->image()->toFiles()->pluck('filename');
                  $newBlock = new \Kirby\Cms\Block([
                    "content" => [
                      'location' => 'kirby',
                      'image'    => $images,
                      'alt'      => $block->alt()->value(),
                      'caption'  => $block->caption()->value(),
                      'url'  => $url,
                      'link'     => $block->link()->value(),
                    ],
                    'id'   => $block->id(),
                    'type' => $block->type()
                  ]);
                  $newBlocks->add($newBlock);
                }
              }

              $newPage->update([
                $fieldKey => $newBlocks->toArray(),
              ]);
            }
          }
        }
    }
  ]
]);

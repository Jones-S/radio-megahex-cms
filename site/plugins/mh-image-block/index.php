<?php

Kirby::plugin('jones-s/mh-image-block', [
  'hooks' => [
    'page.update:after' => function ($newPage, $oldPage) {

      $updatedBlockFields = [];

      foreach ($newPage->content()->fields() as $field) {
        // there is no method to get the fields type
        // except by getting the pages blueprint and looking for the fields key
        // https://forum.getkirby.com/t/how-to-determine-field-type-in-custom-field-method/19254
        $fieldKey = $field->key(); // name of the field, like 'teasertext'

        // https://getkirby.com/docs/reference/objects/cms/page-blueprint/field
        $fieldDefinition = $newPage->blueprint()->field($fieldKey);

        if (isset($fieldDefinition['type']) && $fieldDefinition['type'] === 'blocks') { // some field definitions dont have a type 🤷‍♂️
          $newBlocks = new Kirby\Cms\Blocks();
          $blocks = $newPage->content()->get($fieldKey)->toBlocks();

          foreach ($blocks as $block) {
              if (
                $block->type() !== 'image' ||
                ($block->type() === 'image' && empty($block->image())) // dont do it for empty image blocks
              ) {
                  $newBlocks->add($block);
              } else {
                  $url      = $block->image()->toFile()->url();
                  $thumb    = $block->image()->toFile()->crop(400, 400, ['quality' => 60, 'crop' => 'center'])->url();
                  $medium    = $block->image()->toFile()->resize(800, 800)->url();
                  $images   = $block->image()->toFiles()->pluck('filename');
                  $newBlock = new \Kirby\Cms\Block(
                      [
                  "content" => [
                    'location' => 'kirby',
                    'image'    => $images,
                    'alt'      => $block->alt()->value(),
                    'caption'  => $block->caption()->value(),
                    'url'      => $url,
                    'thumb'      => $thumb,
                    'medium'      => $medium,
                    'link'     => $block->link()->value(),
                  ],
                  'id'   => $block->id(),
                  'type' => $block->type()
                ],
                  );
                  $newBlocks->add($newBlock);
              }
          }

          $updatedBlockFields[$fieldKey] = $newBlocks->toArray();
        }
      }

      // update once!
      $newPage->update($updatedBlockFields);
    }
  ]
]);

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
  'languages' => true, // enable multilang
  // 'smartypants' => true, // https://getkirby.com/docs/guide/content/text-formatting#smartypants
  'api' => [
    'slug' => 'api',
    'basicAuth' => true,
    'allowInsecure' => true
  ],
  'robinscholz.better-rest.smartypants' => true,
  'robinscholz.better-rest.srcset' => [333, 777, 888, 1111],
  // 'robinscholz.better-rest.language' => 'en'
];

<?php

return
  [
    'woo_url' => env('WOOCOMMERCE_URL'),
    'woo_key' => env('WOOCOMMERCE_CONSUMER_KEY'),
    'woo_secret' => env('WOOCOMMERCE_CONSUMER_SECRET'),

    'parameters' =>
    [
      'delete_unused_in_months' => env('DELETE_PARAM_IN_MONTH', 3)
    ]
  ];

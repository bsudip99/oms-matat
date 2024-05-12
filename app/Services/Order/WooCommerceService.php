<?php

namespace App\Services\Order;

use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Contracts\Database\Eloquent\Builder;

class WooCommerceService
{

  protected $wooCommerce;
  protected $guzzleClient;

  public function __construct()
  {
    $this->initializeClient();
  }

  protected function initializeClient()
  {
    try {
      $this->guzzleClient =  new GuzzleHttpClient([
        'base_uri' => config('api.woo_url'),
        'timeout' => 10,
        'headers' => [
          'Authorization' => 'Basic ' . base64_encode(config('api.woo_key') . ':' . config('api.woo_secret')),
          'Accept' => 'application/json',
        ],
      ]);
    } catch (Exception $e) {
      logger()->error('Failed to connect to WooCommerce:' . $e->getMessage());
      throw $e;
    }
  }
  /**
   * @param  array  $where
   * @param  array  $with
   * @return Builder
   */
  public function fetchOrders()
  {
    try {
      // Check if Guzzle client is initialized
      if (!$this->guzzleClient) {
        // Re-initialize client if not initialized
        $this->initializeClient(); 
      }
      // Make request to fetch orders
      $response = $this->guzzleClient->get('orders?fields=id', ['http_errors' => false]);
      // Get response status code
      $statusCode = $response->getStatusCode();
      // Handle different response status codes
      switch ($statusCode) {
        case 200:
          return json_decode($response->getBody()->getContents(), true);
        case 401:
          // Unauthorized, handle accordingly
          logger()->error('Unauthorized request to fetch orders from WooCommerce');
          return false;
        case 404:
          // Not found, handle accordingly
          logger()->error('Route Not found on WooCommerce');
          return false;
        case 500:
          logger()->error('Server Error');
          return false;
        default:
          // Unexpected response status code, log and handle accordingly
          logger()->error('Unexpected response status code: ' . $statusCode);
          return false;
      }
    } catch (\Exception $e) {
      // Log other exceptions
      logger()->error('Failed to fetch orders from WooCommerce: ' . $e->getMessage());
      return false;
    }
  }
}

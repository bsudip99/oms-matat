<?php

namespace App\Services\Order;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Contracts\Database\Eloquent\Builder;

class WooCommerceService
{

  /** @var GuzzleHttpClient The Guzzle HTTP client instance. */
  private $guzzleClient;
  private $perPage;

  /**
   * Initialize the Guzzle HTTP client with WooCommerce API configurations.
   *
   * @return void
   */
  public function __construct()
  {
    $this->perPage = 100;
    $this->initializeClient();
  }

  /**
   * Set up the Guzzle HTTP client with WooCommerce API configurations.
   *
   * @return void
   * @throws Exception if the initialization fails.
   */
  protected function initializeClient()
  {
    try {
      $this->guzzleClient =  new GuzzleHttpClient([
        'base_uri' => config('api.woo_url'),
        'headers' => [
          'Authorization' => 'Basic ' . base64_encode(config('api.woo_key') . ':' . config('api.woo_secret')),
          'Accept' => 'application/json',
        ],
      ]);
    } catch (Exception $exception) {
      logger()->error('Failed to connect to WooCommerce:' . $exception->getMessage());
      throw $exception;
    }
  }

  /**
   * Fetch orders from the WooCommerce API.
   *
   * @return array|bool Returns an array of orders if successful, or false otherwise.
   */
  public function fetchOrders()
  {
    try {
      $page = 1;
      $allOrders = [];

      // DO loop while the data is not empty for handling pagination
      do {
        // Make request to fetch orders
        $response = $this->fetchData($page);
        // Get response status code
        $statusCode = $response->getStatusCode();
        // Handle different response status codes
        switch ($statusCode) {
          case 200:
            $data =  json_decode($response->getBody()->getContents(), true);
            $allOrders = array_merge($allOrders, $data);
            $page++;
            break;
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
        // while not empty data
      } while (!empty($data));

      // returning all order data after all pagination
      return $allOrders;
    } catch (\Exception $exception) {
      // Log other exceptions
      logger()->error('Failed to fetch orders from WooCommerce: ' . $exception->getMessage());
      return false;
    }
  }

  private function fetchData($page)
  {
    // Calculate the date one month ago
    $oneMonthAgo = Carbon::now()->subMonth()->setTimezone('UTC')->toIso8601ZuluString();
    // Make request to fetch orders
    $response = $this->guzzleClient->get('orders?page=' . $page . '&per_page=' . $this->perPage . '&after=' . $oneMonthAgo, ['http_errors' => false]);
    return $response;
  }
}

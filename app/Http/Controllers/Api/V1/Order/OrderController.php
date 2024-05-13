<?php

namespace App\Http\Controllers\Api\V1\Order;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Resources\Order\OrderListResource;
use App\Http\Resources\PaginationResource;
use App\Services\Order\OrderService;
use App\Services\Order\WooCommerceService;
use Exception;
use Illuminate\Http\JsonResponse;

class OrderController extends BaseApiController
{

  /**
   * The below PHP function is a constructor with an empty body.
   */
  public function __construct(
    protected OrderService $orderService,
    protected WooCommerceService $wooCommerceService
  ) {
  }

  /**
   * Retrieve Order List from woo-commerce
   * 
   */
  public function index(): JsonResponse
  {

    $perPage = request('per_page') ?? 10;
    try {
      $orders = $this->orderService->index([], ['line_items']);
      $orders = $orders->paginate($perPage);
    } catch (\Exception $exception) {
      logger()->error($exception->getMessage());

      return $this->failure('Failed to fetch Order\'s list');
    }

    return $this->success(
      "Order's list!",
      OrderListResource::collection($orders),
      new PaginationResource($orders)
    );
  }

  public function getOrderWoo()
  {
    $orders = $this->wooCommerceService->fetchOrders();
    if ($orders) {
      return $orders;
    } else {
      return $this->failure('Failed to fetch Order\'s list');
    }
  }

  public function syncNewOrders()
  {
    try {
      $orders = $this->orderService->syncNewOrdersFromWoo();
      if(!$orders)
      {
        throw new Exception('Failed to sync new Orders');
      }
    } catch (\Exception $exception) {
      logger()->error($exception->getMessage());
      return $this->failure('Failed to sync New Orders');
    }

    return $this->success(
      "Order Synced!",
    );
  }
}

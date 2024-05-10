<?php

namespace App\Http\Controllers\Api\V1\Order;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;

class OrderController extends BaseApiController
{

  /**
   * The below PHP function is a constructor with an empty body.
   */
  public function __construct()
  {
  }

  /**
   * Retrieve Order List from woo-commerce
   * 
   */
  // public function index(Request $request): JsonResponse
  // {
  //   return $this->success(
  //     "Order's list!",
  //     UserListResource::collection($users),
  //     new PaginationResource($users)
  // );
  // }
}

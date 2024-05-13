<?php

namespace App\Services\Order;

use App\Repositories\Order\OrderRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class OrderService
{


  public function __construct(protected OrderRepository $orderRepository)
  {
  }
  /**
   * @param  array  $where
   * @param  array  $with
   * @return Builder
   */
  public function index(array $where = [], array $with = []): Builder
  {
    return $this->orderRepository->index($where, $with)
      ->when(request('search'), function ($query, $search) {
        return $query->searchQuery($search);
      });
  }
}

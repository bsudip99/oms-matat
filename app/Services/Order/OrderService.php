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
    $sortBy = request('sortBy'); 
    $sortDirection = request('sortDirection'); 
    return $this->orderRepository->index($where, $with,$sortBy,$sortDirection)
      ->when(request('search'), function ($query, $search) {
        return $query->searchQuery($search);
      });
  }
}

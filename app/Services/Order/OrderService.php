<?php

namespace App\Services\Order;

use App\Repositories\Order\OrderRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

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
    //Sort By and Sort Order (asc or desc)
    $sortBy = request('sortBy');
    $sortDirection = request('sortDirection');

    //Filter based on status of Order
    $status = request('status');
    if ($status) {
      array_push($where, ['status', $status]);
    }

    //Filter based on date_created
    $startDate = request('startDate');
    $endDate = request('endDate');
    if ($startDate || $endDate) {
      if ($startDate && $endDate) {
        // Filter orders based on both start and end dates
        array_push($where, [DB::raw('DATE(date_created)'), '>=', $startDate]);
        array_push($where, [DB::raw('DATE(date_created)'), '<=', $endDate]);
      } elseif ($startDate) {
        // Filter orders based on start date only
        array_push($where, [DB::raw('DATE(date_created)'), '>=', $startDate]);
      } elseif ($endDate) {
        // Filter orders based on end date only
        array_push($where, [DB::raw('DATE(date_created)'), '<=', $endDate]);
      }
    }

    return $this->orderRepository->index($where, $with, $sortBy, $sortDirection)
      //Search param from search Query Scope in Order model
      ->when(request('search'), function ($query, $search) {
        return $query->searchQuery($search);
      });
  }

  public function syncNewOrdersFromWoo()
  {
   $process =  Artisan::call('app:sync-woo-order');
   return $process;
  }
}

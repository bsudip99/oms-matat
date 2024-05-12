<?php 

namespace App\Repositories\Order;

use App\Models\Order\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Order::class;
    }
}
<?php

namespace App\Models\Order;

use App\Models\LineItem\LineItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'woo_order_id',
        'number',
        'order_key',
        'status',
        'date_created',
        'total',
        'customer_id',
        'customer_note',
        'billing',
        'shipping',
    ];

    protected $casts =
    [
        'billing' => 'json',
        'shipping' => 'json',
    ];

    public function line_items()
    {
        return $this->hasMany(LineItem::class);
    }
}

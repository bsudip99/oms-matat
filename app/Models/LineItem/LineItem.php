<?php

namespace App\Models\LineItem;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LineItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'woo_line_item_id',
        'name',
        'product_id',
        'variation_id',
        'quantity',
        'tax_class',
        'subtotal',
        'subtotal_tax',
        'total',
        'total_tax',
        'taxes',
        'meta_data',
        'sku',
        'price',
        'image',
        'parent_name',

        'order_id'
    ];

    protected $casts =
    [
        'meta_data' => 'json',
        'taxes' => 'json',
        'image' => 'json',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

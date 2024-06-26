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
        'date_modified'
    ];

    /* The `protected ` property in the Order model is used to specify the data types of certain
attributes when retrieving them from the database. In this case, it is telling Laravel that the
'billing' and 'shipping' attributes should be treated as JSON data types. */
    protected $casts =
    [
        'billing' => 'json',
        'shipping' => 'json',
    ];

    protected static function booted()
    {
        static::deleting(function ($order) {
            /** 
             * 
             * Delete associated line items when the order is deleted
             *
             * Added this code since cascade on delete is 
             * not working for some reason
             */
            $order->line_items()->delete();
        });
    }

    public function line_items()
    {
        return $this->hasMany(LineItem::class);
    }

    public function scopeSearchQuery($query, $search)
    {
        return $query->where('number', 'ilike', '%' . $search . '%')
            ->orWhere('order_key', 'ilike', '%' . $search . '%')
            ->orWhere('customer_note', 'ilike', '%' . $search . '%')
            ->orWhere('total', 'ilike', '%' . $search . '%');
    }
}

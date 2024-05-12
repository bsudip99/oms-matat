<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\LineItem\LineItemListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'number' => $this['number'],
            'order_key' => $this['order_key'],
            'status' => $this['status'],
            'date_created' => $this['date_created'],
            'total' => $this['total'],
            'customer_id' => $this['customer_id'],
            'customer_note' => $this['customer_note'],
            'billing' => $this['billing'],
            'shipping' => $this['shipping'],
            'line_items' => LineItemListResource::collection($this['line_items'])
        ];
    }
}

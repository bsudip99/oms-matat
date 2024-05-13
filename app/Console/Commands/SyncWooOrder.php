<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\V1\Order\OrderController;
use App\Models\LineItem\LineItem;
use App\Models\Order\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncWooOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-woo-order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncing Order and Line Items In';

    protected $orderController;

    public function __construct(OrderController $orderController)
    {
        parent::__construct();
        $this->orderController = $orderController;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('SYNCING ORDER AND LINE-ITEM TABLE');
        try {
            DB::beginTransaction();
            $orders = $this->orderController->getOrderWoo();
            if ($orders) {
                foreach ($orders as $orderData) {
                    $order = $this->syncOrder($orderData);
                }
            }
            DB::commit();
            $this->info('Order and Line item SYNCED!');
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Command error: Order and Line item table not synced');
            $this->error('ERROR in command: ' . $e->getMessage());
        }
    }


    // Method to sync an order
    private function syncOrder($orderData)
    {
        // Extract relevant data from $orderData
        $orderDataFiltered = [
            'woo_order_id' => $orderData['id'],
            'number' => $orderData['number'],
            'order_key' => $orderData['order_key'],
            'status' => $orderData['status'],
            'date_created' => $orderData['date_created'],
            'total' => $orderData['total'],
            'customer_id' => $orderData['customer_id'],
            'customer_note' => $orderData['customer_note'],
            'billing' => $orderData['billing'],
            'shipping' => $orderData['shipping'],
            'date_modified' => $orderData['date_modified']
        ];

        // Check if the order already exists (including soft deleted)
        $existingOrder = Order::withTrashed()->where('woo_order_id', $orderData['id'])->first();

        // If the order exists and it's not deleted, update it
        if ($existingOrder) {
            if ($existingOrder->trashed()) {
                // If the existing order is soft-deleted, check if it should be restored based on modification date
                if ($orderData['date_modified'] >  deleteDataDate()) {
                    $existingOrder->restore(); // Restore the soft-deleted order
                    $this->updateOrder($orderData, $orderDataFiltered);
                }
            } else {
                // If the existing order is not soft-deleted, update it
                $this->updateOrder($orderData, $orderDataFiltered);
            }
        } else {
            // If the order doesn't exist, create a new order
            $this->updateOrder($orderData, $orderDataFiltered);
        }

        // Sync or update the order

        return true;
    }

    private function updateOrder($orderData, $orderDataFiltered)
    {
        $order = Order::updateOrCreate(['woo_order_id' => $orderData['id']], $orderDataFiltered);
        $this->syncLineItems($order->id, $orderData['line_items']);
    }

    // Method to sync line items for an order
    private function syncLineItems($orderId, $lineItemsData)
    {
        foreach ($lineItemsData as $lineItemData) {
            // Extract relevant data from $lineItemData
            $lineItemDataFiltered = [
                'woo_line_item_id' => $lineItemData['id'],
                'name' => $lineItemData['name'],
                'product_id' => $lineItemData['product_id'],
                'variation_id' => $lineItemData['variation_id'],
                'quantity' => $lineItemData['quantity'],
                'tax_class' => $lineItemData['tax_class'],
                'subtotal' => $lineItemData['subtotal'],
                'subtotal_tax' => $lineItemData['subtotal_tax'],
                'total' => $lineItemData['total'],
                'total_tax' => $lineItemData['total_tax'],
                'taxes' => $lineItemData['taxes'],
                'meta_data' => $lineItemData['meta_data'],
                'sku' => $lineItemData['sku'],
                'price' => $lineItemData['price'],
                'image' => $lineItemData['image'],
                'parent_name' => $lineItemData['parent_name'],
                'order_id' => $orderId,
            ];
            $existingLineItem = LineItem::withTrashed()->where('woo_line_item_id', $lineItemData['id'])->first();
            if($existingLineItem && $existingLineItem->trashed())
            {
                $existingLineItem->restore();
            }
            // Sync or update the line item
            LineItem::updateOrCreate(['woo_line_item_id' => $lineItemData['id']], $lineItemDataFiltered);
        }
    }
}

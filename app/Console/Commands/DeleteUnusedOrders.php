<?php

namespace App\Console\Commands;

use App\Models\Order\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteUnusedOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-unused-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete unused Orders for past 3 months';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Deleting unused order from table');
        try {
            DB::beginTransaction();

            // Calculate the date 3 months ago
            $deleteParam = deleteDataDate();

            // Retrieve orders older than 3 months and delete them
            $ordersToDelete = Order::where('date_modified', '<', $deleteParam)->get();

            if ($ordersToDelete->isEmpty()) {
                $this->info('No orders found older than ' . config('api.parameters.delete_unused_in_months') . ' months. Exiting...');
                return;
            }

            $ordersToDelete->each->delete();
            DB::commit();

            // Output a message indicating the number of orders deleted
            $this->info(count($ordersToDelete) . ' orders deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Command error: Order  items not deleted');
            $this->error('ERROR in command: ' . $e->getMessage());
        }
    }
}

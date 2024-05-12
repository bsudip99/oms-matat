<?php

use App\Constants\DbTable;
use App\Constants\Order\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(DbTable::ORDERS->value, function (Blueprint $table) {
            $statusArray = getEnumCasesArray(OrderStatus::cases());

            $table->id();
            $table->string('number');
            $table->string('order_key');
            $table->enum(
                'status',
                $statusArray
            )->default('pending');
            $table->dateTime('date_created');
            $table->string('total');
            $table->integer('customer_id');
            $table->string('customer_note');
            $table->json('billing');
            $table->json('shipping');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(DbTable::ORDERS->value);
    }
};

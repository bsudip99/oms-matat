<?php

use App\Constants\DbTable;
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
        Schema::create(DbTable::LINE_ITEMS->value, function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('product_id');
            $table->integer('variation_id');
            $table->integer('quantity');
            $table->string('tax_class');
            $table->string('subtotal');
            $table->string('subtotal_tax');
            $table->string('total');
            $table->string('total_tax');
            $table->json('taxes');
            $table->json('meta_data');
            $table->string('sku');
            $table->string('price');
            $table->json('image');
            $table->string('parent_name');
            $table->softDeletes();
            $table->timestamps();

            $table->foreignId('order_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(DbTable::LINE_ITEMS->value);
    }
};

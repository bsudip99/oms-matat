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
            $table->integer('woo_line_item_id');
            $table->string('name');
            $table->integer('product_id');
            $table->integer('variation_id');
            $table->integer('quantity')->nullable();
            $table->string('tax_class')->nullable();
            $table->string('subtotal')->nullable();
            $table->string('subtotal_tax')->nullable();
            $table->string('total')->nullable();
            $table->string('total_tax')->nullable();
            $table->json('taxes')->nullable();
            $table->json('meta_data')->nullable();
            $table->string('sku')->nullable();
            $table->string('price')->nullable();
            $table->json('image')->nullable();
            $table->string('parent_name')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreignId('order_id')->constrained()->onDelete('cascade');
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

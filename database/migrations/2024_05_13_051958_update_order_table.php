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
        Schema::table(DbTable::ORDERS->value, function (Blueprint $table) {
            $table->addColumn('dateTime', 'date_modified')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(DbTable::ORDERS->value, function (Blueprint $table) {
            $table->dropColumn('date_modified');
        });
    }
};

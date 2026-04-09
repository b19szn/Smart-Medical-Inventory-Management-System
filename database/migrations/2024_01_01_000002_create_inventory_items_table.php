<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('item_code')->unique();
            $table->text('description')->nullable();
            $table->string('category');
            $table->string('unit_of_measure'); // e.g., pieces, boxes, bottles
            $table->integer('quantity')->default(0);
            $table->integer('minimum_stock_level')->default(10);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->string('supplier_name')->nullable();
            $table->string('batch_number')->nullable();
            $table->date('manufacturing_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('storage_location')->nullable();
            $table->string('qr_code')->nullable();
            $table->boolean('is_critical')->default(false); // For ICU/ER critical items
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};

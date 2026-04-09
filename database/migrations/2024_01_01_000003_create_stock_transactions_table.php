<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('transaction_type', ['add', 'consume', 'transfer_out', 'transfer_in', 'adjustment']);
            $table->integer('quantity');
            $table->integer('balance_after')->default(0);
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->string('transfer_from')->nullable(); // Hospital/location name
            $table->string('transfer_to')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('completed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};

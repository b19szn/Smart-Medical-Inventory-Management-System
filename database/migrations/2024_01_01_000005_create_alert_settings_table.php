<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alert_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('low_stock_threshold_days')->default(10);
            $table->integer('expiry_warning_days')->default(30);
            $table->boolean('email_notifications')->default(true);
            $table->boolean('system_notifications')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alert_settings');
    }
};

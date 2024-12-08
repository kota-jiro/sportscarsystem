<?php

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('orderId', 15)->unique();
            $table->string('orderedCar', 50);
            $table->string('orderedBy', 50);
            $table->string('address', 255);
            $table->string('orderedImage', 255);
            $table->string('status', 50);
            $table->string('created_at')->nullable();
            $table->string('updated_at')->nullable();
            $table->boolean('isDeleted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

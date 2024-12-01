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
        Schema::create('sportsCars', function (Blueprint $table) {
            $table->id();
            $table->string('sportsCarId', 15)->unique();
            $table->string('brand', 50)->nullable();
            $table->string('model', 50)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('speed', 25)->nullable();
            $table->string('drivetrain', 25)->nullable();
            $table->double('price')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('sportsCars');
    }
};

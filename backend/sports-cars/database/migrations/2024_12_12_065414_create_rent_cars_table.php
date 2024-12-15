<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentCarsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('rent_cars')) {
            Schema::create('rent_cars', function (Blueprint $table) {
                $table->string('rentId', 15)->primary();
                $table->string('sportsCarId', 15);
                $table->string('userId', 15);
                $table->string('name');
                $table->string('phone');
                $table->string('address');
                $table->string('brandModel');
                $table->decimal('carPrice', 10, 2);
                $table->decimal('rentPrice', 10, 2);
                $table->string('rentDuration');
                $table->date('startDate');
                $table->date('endDate');
                $table->string('status')->default('pending');
                $table->text('damageNotes')->nullable();
                $table->decimal('damageCharges', 10, 2)->nullable();
                $table->timestamps();
                
                $table->foreign('sportsCarId')
                      ->references('sportsCarId')
                      ->on('sports_cars')
                      ->onDelete('restrict');
                      
                $table->foreign('userId')
                      ->references('userId')
                      ->on('users')
                      ->onDelete('restrict');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('rent_cars');
    }
}

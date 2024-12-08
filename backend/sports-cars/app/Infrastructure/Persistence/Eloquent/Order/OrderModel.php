<?php

namespace App\Infrastructure\Persistence\Eloquent\Order;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'id',
        'orderId',
        'orderedCar',
        'orderedBy',
        'address',
        'status',
        'orderedImage',
        'created_at',
        'updated_at',
        'isDeleted',
    ];
}

<?php

namespace App\Infrastructure\Persistence\Eloquent\SportsCar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportsCarModel extends Model {
    use HasFactory;
    protected $table = 'sportscar';
    protected $fillable = [
        'id',
        'sportsCarId',
        'brand',
        'model' ,
        'description',
        'speed',
        'drivetrain',
        'price',
        'image',
        'created_at',
        'updated_at',
    ];
}
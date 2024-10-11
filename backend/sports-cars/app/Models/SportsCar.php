<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportsCar extends Model
{
    use HasFactory;

    protected $fillable = ['make', 'model', 'year', 'price', 'quantity', 'image'];

}

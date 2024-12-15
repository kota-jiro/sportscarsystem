<?php

namespace App\Infrastructure\Persistence\Eloquent\RentCar;

use Illuminate\Database\Eloquent\Model;
use App\Infrastructure\Persistence\Eloquent\SportsCar\SportsCarModel;
use App\Infrastructure\Persistence\Eloquent\User\UserModel;

class RentCarModel extends Model
{
    protected $table = 'rent_cars';
    protected $primaryKey = 'rentId';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'rentId',
        'sportsCarId',
        'userId',
        'name',
        'phone',
        'address',
        'brandModel',
        'carPrice',
        'rentPrice',
        'rentDuration',
        'startDate',
        'endDate',
        'status',
        'damageNotes',
        'damageCharges'
    ];

    public function sportsCar()
    {
        return $this->belongsTo(SportsCarModel::class, 'sportsCarId', 'sportsCarId');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'userId', 'userId');
    }
}

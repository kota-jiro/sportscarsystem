<?php

namespace App\Infrastructure\Persistence\Eloquent\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model {
    use HasFactory;
    protected $table = 'user';
    protected $fillable = [
        'id',
        'userId',
        'firstName',
        'lastName',
        'phone',
        'address',
        'email',
        'password',
        'image',
        'created_at',
        'updated_at',
        'isDeleted',
    ];
}
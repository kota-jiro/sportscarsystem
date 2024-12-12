<?php

namespace App\Infrastructure\Persistence\Eloquent\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
    protected $fillable = [
        'firstName', 
        'lastName', 
        'username', 
        'password', 
        'api_token', 
        'created_at', 
        'updated_at'
    ];
}
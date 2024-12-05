<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SportsCar\API\SportsCarAPIController;
use App\Http\Controllers\User\API\UserAPIController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/* http://127.0.0.1:8000/api/sportsCars */
Route::get('/sportsCars', [SportsCarAPIController::class, 'getAll']); // done its working
Route::get('/sportsCar/{sportsCarId}', [SportsCarAPIController::class, 'getBySportsCarId']); // done its working
Route::get('/sportsCar/brand/{brand}', [SportsCarAPIController::class, 'getByBrand']); // done its working
Route::post('/sportsCar/add', [SportsCarAPIController::class, 'addSportsCar']); // done its working
Route::put('/sportsCar/update/{sportsCarId}', [SportsCarAPIController::class, 'updateSportsCar']); // done its working
Route::get('/sportsCar/search', [SportsCarAPIController::class, 'searchSportsCar']); //undone

/* http://127.0.0.1:8000/api/user */
Route::get('/users', [UserAPIController::class, 'getAll']); // done its working
Route::get('/user/{userId}', [UserAPIController::class, 'getByUserId']); // done its working
Route::get('/user/email/{email}', [UserAPIController::class, 'getByEmail']); // done its working
Route::post('/user/login', [UserAPIController::class, 'login']); // done its working
Route::post('/user/register', [UserAPIController::class, 'addUser']); // done its working
Route::put('/user/update/{userId}', [UserAPIController::class, 'updateUser']); // done its working
Route::get('/user/search', [UserAPIController::class, 'searchUser']); // undone

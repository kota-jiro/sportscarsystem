<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SportsCar\API\SportsCarAPIController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/* http://127.0.0.1:8000/api/sportsCars */
Route::get('/sportsCars', [SportsCarAPIController::class, 'getAll']); // done its working
Route::get('/sportsCar/{sportsCarId}', [SportsCarAPIController::class, 'getBySportsCarId']); // done its working
Route::post('/sportsCar/add', [SportsCarAPIController::class, 'addSportsCar']); // done its working
Route::put('/sportsCar/update/{sportsCarId}', [SportsCarAPIController::class, 'updateSportsCar']); // done its working
Route::get('/sportsCar/search', [SportsCarAPIController::class, 'searchSportsCar']);


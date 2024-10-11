<?php

use App\Http\Controllers\SportsCar\SportsCarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Route for the home page that lists all sports cars
Route::get('/sportscars', [SportsCarController::class, 'index'])->name('sportscars.index');

// Route for showing the form to add a new sports car
Route::get('/sportscars/create', [SportsCarController::class, 'create'])->name('sportscars.create');

// Route for storing a new sports car in the database
Route::post('/sportscars', [SportsCarController::class, 'store'])->name('sportscars.store');

// Route for viewing the details of a specific sports car
Route::get('/sportscars/{id}', [SportsCarController::class, 'show'])->name('sportscars.show');

// Route for showing the form to edit an existing sports car
Route::get('/sportscars/{id}/edit', [SportsCarController::class, 'edit'])->name('sportscars.edit');

// Route for updating a sports car in the database
Route::put('/sportscars/{id}', [SportsCarController::class, 'update'])->name('sportscars.update');

// Route for deleting a sports car
Route::delete('/sportscars/{id}', [SportsCarController::class, 'destroy'])->name('sportscars.destroy');


// // Display a listing of the sports cars
// Route::get('/sportscars', [SportsCarController::class, 'index'])->name('sportscars.index');

// // Show the form for creating a new sports car
// Route::get('/sportscars/create', [SportsCarController::class, 'create'])->name('sportscars.create');

// // Store a newly created sports car in storage
// Route::post('/sportscars', [SportsCarController::class, 'store'])->name('sportscars.store');

// // Display the specified sports car
// Route::get('/sportscars/{sportsCar}', [SportsCarController::class, 'show'])->name('sportscars.show');

// // Show the form for editing the specified sports car
// Route::get('/sportscars/{sportsCar}/edit', [SportsCarController::class, 'edit'])->name('sportscars.edit');

// // Update the specified sports car in storage
// Route::put('/sportscars/{sportsCar}', [SportsCarController::class, 'update'])->name('sportscars.update');

// // Remove the specified sports car from storage
// Route::delete('/sportscars/{sportsCar}', [SportsCarController::class, 'destroy'])->name('sportscars.destroy');

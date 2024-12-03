<?php

/* use App\Http\Controllers\SportsCar\SportsCarController; //my old controller */
use App\Http\Controllers\SportsCar\Web\SportsCarWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/* http://127.0.0.1:8000/web/sportsCars */
Route::get('/sportsCars', [SportsCarWebController::class, 'index'])->name('sportsCars.index'); // done its working
Route::get('/sportsCar/create', [SportsCarWebController::class, 'create'])->name('sportsCars.create'); // done its working
Route::post('/sportsCar/store', [SportsCarWebController::class, 'store'])->name('sportsCars.store'); // done its working
Route::get('/sportsCar/show/{sportsCarId}', [SportsCarWebController::class, 'show'])->name('sportsCars.show'); // done its working
Route::get('/sportsCar/showAll', [SportsCarWebController::class, 'showAll'])->name('sportsCars.showAll'); // done its working
Route::get('/sportsCar/edit/{sportsCarId}', [SportsCarWebController::class, 'edit'])->name('sportsCars.edit'); // done its working
Route::put('/sportsCar/update/{sportsCarId}', [SportsCarWebController::class, 'update'])->name('sportsCars.update'); // done its working
Route::delete('/sportsCar/{id}', [SportsCarWebController::class, 'destroy'])->name('sportsCars.destroy'); // done its working
Route::get('/sportsCar/archive', [SportsCarWebController::class, 'archive'])->name('sportsCars.archive'); // done its working
Route::get('/sportsCar/restore/{id}', [SportsCarWebController::class, 'restore'])->name('sportsCars.restore'); // done its working
Route::delete('/sportsCar/permanentDelete/{id}', [SportsCarWebController::class, 'permanentDelete'])->name('sportsCars.permanentDelete'); // done its working

/* //my old routes
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
 */

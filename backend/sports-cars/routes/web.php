<?php

/* use App\Http\Controllers\SportsCar\SportsCarController; //my old controller */
use App\Http\Controllers\SportsCar\Web\SportsCarWebController;
use App\Http\Controllers\User\Web\UserWebController;
use App\Http\Controllers\Order\Web\OrderWebController;
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

/* http://127.0.0.1:8000/web/users */
Route::get('/users', [UserWebController::class, 'index'])->name('users.index'); // done its working
Route::get('/users/create', [UserWebController::class, 'create'])->name('users.create'); // done its working
Route::post('/users/store', [UserWebController::class, 'store'])->name('users.store'); // done its working
Route::get('/users/show/{userId}', [UserWebController::class, 'show'])->name('users.show'); // done its working
Route::get('/users/showAll', [UserWebController::class, 'showAll'])->name('users.showAll'); // done its working
Route::get('/users/edit/{userId}', [UserWebController::class, 'edit'])->name('users.edit'); // done its working
Route::put('/users/update/{userId}', [UserWebController::class, 'update'])->name('users.update'); // done its working
Route::delete('/users/{id}', [UserWebController::class, 'destroy'])->name('users.destroy'); // done its working
Route::get('/users/archive', [UserWebController::class, 'archive'])->name('users.archive'); // done its working
Route::get('/users/restore/{id}', [UserWebController::class, 'restore'])->name('users.restore'); // done its working
Route::delete('/users/permanentDelete/{id}', [UserWebController::class, 'permanentDelete'])->name('users.permanentDelete'); // done its working

/* http://127.0.0.1:8000/web/orders */
Route::get('/orders', [OrderWebController::class, 'index'])->name('orders.index'); // done its working
Route::get('/orders/create', [OrderWebController::class, 'create'])->name('orders.create'); // done its working
Route::post('/orders/store', [OrderWebController::class, 'store'])->name('orders.store'); // done its working
Route::get('/orders/show/{orderId}', [OrderWebController::class, 'show'])->name('orders.show'); // done its working
Route::get('/orders/showAll', [OrderWebController::class, 'showAll'])->name('orders.showAll'); // done its working
Route::get('/orders/edit/{orderId}', [OrderWebController::class, 'edit'])->name('orders.edit'); // done its working
Route::put('/orders/update/{orderId}', [OrderWebController::class, 'update'])->name('orders.update'); // done its working // removed
Route::delete('/orders/{id}', [OrderWebController::class, 'destroy'])->name('orders.destroy'); // done its working
Route::get('/orders/archive', [OrderWebController::class, 'archive'])->name('orders.archive'); // done its working
Route::get('/orders/restore/{id}', [OrderWebController::class, 'restore'])->name('orders.restore'); // done its working
Route::delete('/orders/permanentDelete/{id}', [OrderWebController::class, 'permanentDelete'])->name('orders.permanentDelete'); // done its working
Route::put('/orders/status/{id}', [OrderWebController::class, 'updateStatus'])->name('orders.updateStatus'); // done its working

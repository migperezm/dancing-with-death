<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DancerController;
use App\Http\Controllers\AppointmentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Dancer Routing al final no las usé :(
// Route::get('/dancer', [DancerController::class, 'getAll']);
// Route::post('/dancer', [DancerController::class, 'postDancer']);
// Route::get('/dancer/{id}', [DancerController::class, 'getDancerById']);
// Route::put('/dancer/{id}', [DancerController::class, 'update']);

//Appointment Route
Route::post('/appointment/save', [AppointmentController::class, 'postAppointment']);
Route::get('/appointment', [AppointmentController::class, 'getAllByDate']);
// Route::get('/appointment/{id}', [AppointmentController::class, 'getAppointmentById']);
// Route::put('/appointment/{id}', [AppointmentController::class, 'update']);
// Route::delete('/appointment/{id}', [AppointmentController::class, 'destroy']);
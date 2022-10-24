<?php

use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

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
    return view('dashboard');
});

Route::get('/patient', [PatientController::class, 'index']);
Route::get('/patient/add', [PatientController::class, 'add']);
Route::post('/patient/store', [PatientController::class, 'store']);
Route::post('/patient/delete', [PatientController::class, 'destroy']);
Route::get('/patient/getTensionHistory', [PatientController::class, 'getTensionHistory']);
Route::get('/patient/{id}', [PatientController::class, 'show']);
Route::get('/patient/{id}/edit', [PatientController::class, 'showEditPage']);
Route::post('/patient/{id}/edit', [PatientController::class, 'save']);

Route::get('/consultation', [ConsultationController::class, 'index']);

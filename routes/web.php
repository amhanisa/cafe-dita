<?php

use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
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

Route::get('/patient', [PatientController::class, 'index'])->name('patien.index');
Route::get('/patient/add', [PatientController::class, 'add']);
Route::post('/patient/store', [PatientController::class, 'store']);
Route::post('/patient/delete', [PatientController::class, 'destroy']);
Route::get('/patient/getTensionHistory', [PatientController::class, 'getTensionHistory']);
Route::get('/patient/{id}', [PatientController::class, 'show']);
Route::get('/patient/{id}/edit', [PatientController::class, 'showEditPage']);
Route::post('/patient/{id}/edit', [PatientController::class, 'save']);

Route::get('/consultation', [ConsultationController::class, 'index']);
Route::get('/consultation/import', [ConsultationController::class, 'showImportPage']);
Route::post('/consultation/import', [ConsultationController::class, 'storeImportedConsultations']);

Route::get('/habit/edit', [HabitController::class, 'showEditPage']);
Route::post('/habit/edit', [HabitController::class, 'store']);

Route::get('/report', [ReportController::class, 'index']);

Route::get('/user', [UserController::class, 'index']);

Route::group(['prefix' => 'datatable'], function () {
    Route::get('patient', [PatientController::class, 'getAjaxDatatable'])->name('datatable.patient');
});

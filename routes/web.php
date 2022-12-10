<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientHabitController;
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

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [AuthController::class, 'showDashboard']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/patient', [PatientController::class, 'showListPatientPage']);
    Route::get('/patient/add', [PatientController::class, 'showAddPatientPage']);
    Route::post('/patient/store', [PatientController::class, 'storePatient']);
    Route::post('/patient/delete', [PatientController::class, 'destroyPatient']);
    Route::get('/patient/{id}', [PatientController::class, 'showDetailPatientPage']);
    Route::get('/patient/{id}/edit', [PatientController::class, 'showEditPage']);
    Route::post('/patient/{id}/update', [PatientController::class, 'updatePatient']);

    Route::get('/consultation', [ConsultationController::class, 'showListConsultationPage']);
    Route::get('/consultation/import', [ConsultationController::class, 'showImportPage'])->middleware('role:admin');
    Route::post('/consultation/import', [ConsultationController::class, 'storeImportedConsultations'])->middleware('role:admin');

    Route::post('/consultation/delete', [ConsultationController::class, 'destroyConsultation']);
    Route::get('/consultation/{id}/add', [ConsultationController::class, 'showAddConsultationPage']);
    Route::post('/consultation/{id}/store', [ConsultationController::class, 'storeConsultation']);
    Route::get('/consultation/{id}/edit', [ConsultationController::class, 'showEditConsultationPage']);
    Route::post('/consultation/{id}/update', [ConsultationController::class, 'updateConsultation']);

    Route::get('/patient-habit/edit', [PatientHabitController::class, 'showEditPatientHabitPage']);
    Route::post('/patient-habit/store', [PatientHabitController::class, 'storePatientHabit']);

    Route::get('/report', [ReportController::class, 'showReportPage'])->middleware('role:admin');
    Route::get('/report/export', [ReportController::class, 'exportReport'])->middleware('role:admin');

    Route::get('/user', [UserController::class, 'showListUserPage'])->middleware('role:admin');
    Route::get('/user/add', [UserController::class, 'showAddUserPage'])->middleware('role:admin');
    Route::post('/user/store', [UserController::class, 'storeUser'])->middleware('role:admin');
    Route::post('/user/delete', [UserController::class, 'destroyUser'])->middleware('role:admin');
    Route::get('/user/{id}/edit', [UserController::class, 'showEditUserPage'])->middleware('role:admin');
    Route::post('/user/{id}/update', [UserController::class, 'updateUser'])->middleware('role:admin');

    Route::group(['prefix' => 'datatable'], function () {
        Route::get('patient', [PatientController::class, 'getAjaxDatatable'])->name('datatable.patient');
        Route::get('consultation', [ConsultationController::class, 'getAjaxDatatable'])->name('datatable.consultation');
    });
});

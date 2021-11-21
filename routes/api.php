<?php

use App\Http\Controllers\API\Authentication\AdminLoginController;
use App\Http\Controllers\API\CategoryProcedures\CreateCategoryProcedureController;
use App\Http\Controllers\API\CategoryProcedures\ListCategoryProcedureController;
use App\Http\Controllers\API\Patients\CreatePatientController;
use App\Http\Controllers\API\Patients\CreatePatientProcedureController;
use App\Http\Controllers\API\Patients\CreatePatientVisitsController;
use App\Http\Controllers\API\Patients\ListPatientController;
use App\Http\Controllers\API\Patients\ListPatientVisitController;
use App\Http\Controllers\API\Patients\ShowPatientController;
use App\Http\Controllers\API\Patients\ShowPatientVisitsController;
use App\Http\Controllers\API\Patients\UpdatePatientController;
use App\Http\Controllers\API\Patients\UploadPatientProfileController;
use App\Http\Controllers\API\Procedures\CreateProcedureController;
use App\Http\Controllers\API\Procedures\ListProcedureController;
use App\Http\Controllers\API\Queue\ListProcedureQueueController;
use App\Http\Controllers\API\RegisterUser\RegisterAdminUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'admin',
], static function (): void {

    Route::post('/register', [
        'as' => 'register-admin',
        'uses' => RegisterAdminUserController::class,
    ]);

    Route::post('/login', [
        'as' => 'login-admin',
        'uses' => AdminLoginController::class,
    ]);
});


Route::group([
    'middleware' => 'auth:api',
    'prefix' => ''

], function ($router) {

    // Patients
    Route::get('/patients', [
        'as' => 'patient-list',
        'uses' => ListPatientController::class,
    ]);

    Route::get('/patients/{patientCode}', [
        'as' => 'patient-view',
        'uses' => ShowPatientController::class,
    ]);

    Route::put('/patients/{patientCode}', [
        'as' => 'patient-update',
        'uses' => UpdatePatientController::class,
    ]);

    Route::post('/patients', [
        'as' => 'patient-create',
        'uses' => CreatePatientController::class,
    ]);

    Route::post('/patients/upload-profile', [
        'as' => 'patient-profile-upload',
        'uses' => UploadPatientProfileController::class,
    ]);


    // Patient Visits
    Route::get('/patient-visits', [
        'as' => 'patient-list',
        'uses' => ListPatientVisitController::class,
    ]);

    Route::get('/patient-visits/{patientCode}', [
        'as' => 'patient-view',
        'uses' => ShowPatientVisitsController::class,
    ]);

    Route::post('/patient-visits', [
        'as' => 'patient-visit-create',
        'uses' => CreatePatientVisitsController::class,
    ]);

    // Category Procedures
    Route::post('/category-procedures', [
        'as' => 'category-procedures-create',
        'uses' => CreateCategoryProcedureController::class,
    ]);
    Route::get('/category-procedures', [
        'as' => 'category-procedures-list',
        'uses' => ListCategoryProcedureController::class,
    ]);


    // Procedures
    Route::post('/procedures', [
        'as' => 'procedures-create',
        'uses' => CreateProcedureController::class,
    ]);
    Route::get('/procedures', [
        'as' => 'procedures-list',
        'uses' => ListProcedureController::class,
    ]);
    Route::get('/procedure-queues', [
        'as' => 'procedures-queue-list',
        'uses' => ListProcedureQueueController::class,
    ]);

    // Patient Procedure
    Route::post('/patient-procedures', [
        'as' => 'patient-procedures-create',
        'uses' => CreatePatientProcedureController::class,
    ]);




});

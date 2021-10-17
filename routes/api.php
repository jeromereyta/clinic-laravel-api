<?php

use App\Http\Controllers\API\Authentication\AdminLoginController;
use App\Http\Controllers\API\Patients\CreatePatientController;
use App\Http\Controllers\API\Patients\CreatePatientVisitsController;
use App\Http\Controllers\API\Patients\ListPatientController;
use App\Http\Controllers\API\Patients\ShowPatientController;
use App\Http\Controllers\API\Patients\ShowPatientVisitsController;
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

    Route::post('/patients', [
        'as' => 'patient-create',
        'uses' => CreatePatientController::class,
    ]);

    // Patient Visits

    Route::get('/patient-visits/{patientCode}', [
        'as' => 'patient-view',
        'uses' => ShowPatientVisitsController::class,
    ]);

    Route::post('/patient-visits', [
        'as' => 'patient-visit-create',
        'uses' => CreatePatientVisitsController::class,
    ]);

});

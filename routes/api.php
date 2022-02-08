<?php

use App\Http\Controllers\API\Authentication\AdminLoginController;
use App\Http\Controllers\API\CategoryProcedures\CreateCategoryProcedureController;
use App\Http\Controllers\API\CategoryProcedures\DeleteCategoryProcedureController;
use App\Http\Controllers\API\CategoryProcedures\ListCategoryProcedureController;
use App\Http\Controllers\API\CategoryProcedures\UpdateCategoryProcedureController;
use App\Http\Controllers\API\FileUpload\CreateFileTypeController;
use App\Http\Controllers\API\FileUpload\CreateFileUploadController;
use App\Http\Controllers\API\FileUpload\DeleteFileTypeController;
use App\Http\Controllers\API\FileUpload\FileTypeListController;
use App\Http\Controllers\API\FileUpload\UpdateFileTypeController;
use App\Http\Controllers\API\PackageProcedure\CreatePackageProcedureController;
use App\Http\Controllers\API\PackageProcedure\EditPackageController;
use App\Http\Controllers\API\PackageProcedure\EditPackageProcedureController;
use App\Http\Controllers\API\PackageProcedure\ListPackageProcedureController;
use App\Http\Controllers\API\Patients\CreatePatientController;
use App\Http\Controllers\API\Patients\CreatePatientProcedureController;
use App\Http\Controllers\API\Patients\CreatePatientVisitsController;
use App\Http\Controllers\API\Patients\CreateTransactionSummaryController;
use App\Http\Controllers\API\Patients\ListPatientController;
use App\Http\Controllers\API\Patients\ListPatientVisitController;
use App\Http\Controllers\API\Patients\ShowPatientController;
use App\Http\Controllers\API\Patients\ShowPatientVisitController;
use App\Http\Controllers\API\Patients\ShowPatientVisitsController;
use App\Http\Controllers\API\Patients\UpdatePatientController;
use App\Http\Controllers\API\Patients\UploadPatientProfileController;
use App\Http\Controllers\API\PatientVisits\AddPackageProcedureController;
use App\Http\Controllers\API\PatientVisits\RemoveProcedureController;
use App\Http\Controllers\API\Procedures\CreateProcedureController;
use App\Http\Controllers\API\Procedures\DeleteProcedureController;
use App\Http\Controllers\API\Procedures\ListProcedureController;
use App\Http\Controllers\API\Procedures\UpdateProcedureController;
use App\Http\Controllers\API\Queue\ListProcedureQueueController;
use App\Http\Controllers\API\Queue\UpdateProcedureQueueController;
use App\Http\Controllers\API\RegisterUser\RegisterAdminUserController;
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

    /**
     * Patients
     */
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


    /**
     * Patient Visits
     */
    Route::get('/patient-visits', [
        'as' => 'patient-visit-list',
        'uses' => ListPatientVisitController::class,
    ]);

    Route::get('/patient-visits/{patientCode}', [
        'as' => 'patient-visits-view',
        'uses' => ShowPatientVisitsController::class,
    ]);

    Route::post('/patient-visits', [
        'as' => 'patient-visit-create',
        'uses' => CreatePatientVisitsController::class,
    ]);

    Route::get('/patient-visit/{patientVisitId}', [
        'as' => 'patient-visit-view',
        'uses' => ShowPatientVisitController::class,
    ]);

    Route::post('/patient-visits/upload-file', [
        'as' => 'patient-visit-upload-file',
        'uses' => CreateFileUploadController::class,
    ]);

    Route::delete('/patient-procedure/{id}', [
        'as' => 'patient-visit-remove-procedure',
        'uses' => RemoveProcedureController::class,
    ]);

    /**
     * File Types and File Uploads
     */
    Route::post('/file-types', [
        'as' => 'file-type-create',
        'uses' => CreateFileTypeController::class,
    ]);

    Route::delete('/file-types/{id}', [
        'as' => 'file-types-delete',
        'uses' => DeleteFileTypeController::class,
    ]);
    Route::put('/file-types/{id}', [
        'as' => 'file-types-update',
        'uses' => UpdateFileTypeController::class,
    ]);

    Route::get('/file-types', [
        'as' => 'file-type-list',
        'uses' => FileTypeListController::class,
    ]);


    /**
     * Category Procedures
     */
    Route::post('/category-procedures', [
        'as' => 'category-procedures-create',
        'uses' => CreateCategoryProcedureController::class,
    ]);
    Route::delete('/category-procedures/{categoryProcedureId}', [
        'as' => 'category-procedures-delete',
        'uses' => DeleteCategoryProcedureController::class,
    ]);
    Route::put('/category-procedures/{categoryProcedureId}', [
        'as' => 'category-procedures-update',
        'uses' => UpdateCategoryProcedureController::class,
    ]);
    Route::get('/category-procedures', [
        'as' => 'category-procedures-list',
        'uses' => ListCategoryProcedureController::class,
    ]);


    /**
     * Procedures
     */

    Route::post('/packages', [
        'as' => 'packages-create',
        'uses' => CreatePackageProcedureController::class,
    ]);

    Route::put('/packages/{id}', [
        'as' => 'packages-edit',
        'uses' => EditPackageController::class,
    ]);

    Route::put('/package-procedures/{id}', [
        'as' => 'packages-procedures-edit',
        'uses' => EditPackageProcedureController::class,
    ]);

    Route::post('/procedures', [
        'as' => 'procedures-create',
        'uses' => CreateProcedureController::class,
    ]);

    Route::delete('/procedures/{procedureId}', [
        'as' => 'procedures-delete',
        'uses' => DeleteProcedureController::class,
    ]);
    Route::put('/procedures/{procedureId}', [
        'as' => 'procedures-update',
        'uses' => UpdateProcedureController::class,
    ]);
    Route::get('/procedures', [
        'as' => 'procedures-list',
        'uses' => ListProcedureController::class,
    ]);
    Route::get('/procedure-queues', [
        'as' => 'procedures-queue-list',
        'uses' => ListProcedureQueueController::class,
    ]);

    Route::put('/procedures-queues', [
        'as' => 'procedures-queue-update',
        'uses' => UpdateProcedureQueueController::class,
    ]);


    Route::post('/transaction', [
        'as' => 'transactions-create',
        'uses' => CreateTransactionSummaryController::class,
    ]);

    /**
     * Patient Procedures
     */
    Route::post('/patient-procedures', [
        'as' => 'patient-procedures-create',
        'uses' => CreatePatientProcedureController::class,
    ]);

    Route::post('/patient-package-procedures', [
        'as' => 'patient-package-procedures-create',
        'uses' => AddPackageProcedureController::class,
    ]);

    Route::get('/packages', [
        'as' => 'packages-list',
        'uses' => ListPackageProcedureController::class,
    ]);

});

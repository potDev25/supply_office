<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DailyTimeRecordController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\PurchaseDocumentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->group(function() {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/user', 'index');
        Route::get('/users/user/{user}', 'getUser');
        Route::post('/users/edit/{user}', 'editUser');
        Route::post('/user/logout', 'logout');
    });

    Route::controller(ApplicantController::class)->group(function () {
        Route::get('/applicants', 'index');
        Route::post('/applicant/store', 'store');
        Route::post('/applicants/batch-delete', 'batch_delete');
        Route::post('/applicants/destroy/{user}', 'destroy');
    });

    Route::controller(DepartmentController::class)->group(function () {
        Route::get('/departments', 'index');
        Route::post('/departments/store', 'store');
        Route::post('/departments/batch-delete', 'batch_delete');
        Route::post('/departments/destroy/{department}', 'destroy');
    });

    Route::controller(DocumentController::class)->group(function () {
        Route::get('/documents', 'index');
        Route::get('/documents/archives/{department}', 'archives');
        Route::post('/documents/store', 'store');
        Route::post('/documents/cancel/{document}', 'cancel');
        Route::post('/documents/status/{document}', 'changeStatus');
        Route::post('/documents/return-status/{document}', 'returnStatus');
        Route::post('/documents/return-file-status/{document}', 'updateFile');
        Route::post('/documents/batch-delete', 'batch_delete');
        Route::post('/documents/destroy/{document}', 'destroy');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('/reports', 'index');
    });

    Route::controller(LogsController::class)->group(function () {
        Route::get('/process-logs/{document}', 'index');
    });

    Route::controller(PurchaseDocumentController::class)->group(function () {
        Route::get('/po-request', 'index');
        Route::get('/po-request/request', 'purchaseRequest');
        Route::post('/po-request/store', 'store');
        Route::post('/po-request/po/{document}', 'storePo');
        Route::post('/po-request/update-status/{document}', 'updateStatus');
        Route::delete('/po-request/destroy/{purchase}', 'destroy');
        Route::post('/po-request/po-destroy/{document}', 'poCancel');
    });
});


Route::controller(AuthController::class)->group(function() {
    Route::post('/login', 'login');
});
<?php

use App\Http\Controllers\AnnualProcurementPlanController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientParController;
use App\Http\Controllers\DailyTimeRecordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\ParSupplyController;
use App\Http\Controllers\PurchaseDocumentController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReturnStatusController;
use App\Http\Controllers\RisController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\TestController;
use App\Http\Requests\CategoryRequest;
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

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index');
    });

    Route::controller(ApplicantController::class)->group(function () {
        Route::get('/applicants', 'index');
        Route::post('/applicant/store', 'store');
        Route::post('/applicants/batch-delete', 'batch_delete');
        Route::post('/applicants/destroy/{user}', 'destroy');
    });

    Route::controller(DepartmentController::class)->group(function () {
        Route::get('/departments', 'index');
        Route::get('/departments/show/{department}', 'show');
        Route::post('/departments/update/{department}', 'update');
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

    Route::controller(ReturnStatusController::class)->group(function () {
        Route::get('/return-status', 'index');
        Route::post('/return-status/store', 'store');
        Route::post('/return-status/destroy/{id}', 'destroy');
        Route::post('/return-status/batch-delete/', 'batch_delete');
    });

    Route::controller(PurchaseDocumentController::class)->group(function () {
        Route::get('/po-request', 'index');
        Route::get('/po-request/request', 'purchaseRequest');
        Route::post('/po-request/store', 'store');
        Route::post('/po-request/po/{document}', 'storePo');
        Route::post('/po-request/update-status/{document}', 'updateStatus');
        Route::post('/po-request/update-po-status/{document}', 'updatePoStatus');
        Route::delete('/po-request/destroy/{purchase}', 'destroy');
        Route::post('/po-request/po-destroy/{document}', 'poCancel');
    });

    Route::controller(AnnualProcurementPlanController::class)->group(function () {
        Route::get('/annual', 'index');
        Route::get('/annual/show/{id}', 'show');
        Route::post('/annual/update/{id}', 'update');
        Route::post('/annual/store', 'store');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category', 'index');
        Route::get('/category/show/{id}', 'show');
        Route::post('/category/update/{id}', 'update');
        Route::post('/category/store', 'store');
    });

    Route::controller(SupplyController::class)->group(function () {
        Route::get('/supply', 'index');
        Route::get('/supply/show/{id}', 'show');
        Route::post('/supply/update/{id}', 'update');
        Route::post('/supply/store', 'store');
    });

    Route::controller(SupplierController::class)->group(function () {
        Route::get('/suppliers', 'index');
        Route::get('/suppliers/show/{id}', 'show');
        Route::post('/suppliers/update/{id}', 'update');
        Route::post('/suppliers/store', 'store');
    });

    Route::controller(ReceivingController::class)->group(function () {
        Route::get('/receving', 'index');
        Route::get('/receving/show/{id}', 'show');
        Route::post('/receving/update/{id}', 'update');
        Route::post('/receving/store', 'store');
    });

    Route::controller(ClientParController::class)->group(function () {
        Route::get('/par', 'index');
        Route::get('/par/show/{id}', 'show');
        Route::post('/par/update/{id}', 'update');
        Route::post('/par/store', 'store');
    });

    Route::controller(StockController::class)->group(function () {
        Route::get('/stocks/{receiving}', 'index');
        Route::get('/stocks/requests/{requesition}', 'requests');
        Route::get('/stocks/show/{id}', 'show');
        Route::post('/stocks/update/{id}', 'update');
        Route::post('/stocks/store/{id}/{receive}', 'store');
        Route::post('/stocks/request/store/{id}/{receive}', 'requestStore');
        Route::post('/stocks/submit-form/{requesition}', 'submitForm');
        Route::post('/stocks/approve-form/{requesition}', 'approveForm');
    });

    Route::controller(RisController::class)->group(function () {
        Route::get('/ris', 'index');
        Route::get('/ris/show/{id}', 'show');
        Route::get('/ris/show/supply/{id}', 'supply');
        Route::post('/ris/show/supply/issue/{id}', 'supplyUpdate');
        Route::post('/ris/update/{id}', 'update');
        Route::post('/ris/store', 'store');
    });

    Route::controller(ParSupplyController::class)->group(function () {
        Route::get('/par-supplies/{id}', 'index');
        Route::get('/par-supplies/client/{id}', 'client');
        Route::get('/par-supplies/show/{id}', 'show');
        Route::get('/par-supplies/show/supply/{id}', 'supply');
        Route::post('/par-supplies/show/supply/issue/{id}', 'supplyUpdate');
        Route::post('/par-supplies/update/{id}', 'update');
        Route::post('/par-supplies/store/{par}/{id}', 'store');
    });
});


Route::controller(AuthController::class)->group(function() {
    Route::post('/login', 'login');
});
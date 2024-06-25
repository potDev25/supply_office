<?php

use App\Http\Controllers\DailyTimeRecordController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(DailyTimeRecordController::class)->group(function(){
    Route::get('/dtr', 'index');
    Route::get('/dtr/accounts', 'getAccounts');
    Route::get('/dtr/dates', 'getDates');
    Route::get('/dtr/testDate', 'testDate');
    Route::get('/dtr/test-filter', 'testFilter');
});

Route::controller(TestController::class)->group(function(){
    Route::get('/test', 'index');
});

Route::controller(DailyTimeRecordController::class)->group(function(){
    Route::get('/dtr/test-dtr', 'test_dtr');
    Route::get('/dtr/test-dtr-one', 'test_dtr_one');
});
<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('v1/reports', [App\Http\Controllers\Api\V1\ReportController::class, 'create'])->name('api.v1.reports.create');
Route::post('v1/reports/export', [App\Http\Controllers\Api\V1\ReportController::class, 'export'])->name('api.v1.reports.export');
Route::get('v1/reports/download/{file}', [App\Http\Controllers\Api\V1\ReportController::class, 'download'])->name('api.v1.reports.download');

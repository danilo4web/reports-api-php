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

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ReportController;

Route::post('v1/auth/register', [AuthController::class, 'register']);
Route::post('v1/auth/login', [AuthController::class, 'login'])->name('login');
Route::get('v1/reports/download/{file}', [ReportController::class, 'download'])->name('api.v1.reports.download');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('v1/auth/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('v1/reports', [ReportController::class, 'create'])->name('api.v1.reports.create');
    Route::post('v1/reports/export', [ReportController::class, 'export'])->name('api.v1.reports.export');
});

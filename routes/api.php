<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
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
Route::post('login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/generate-report', [ReportController::class, 'addReport']);
    Route::get('/get-report/{report_id}', [ReportController::class, 'getReport']);
    Route::get('/list-reports', [ReportController::class, 'getReports']);
});

Route::get('unauthorized', function () {
    header('Access-Control-Allow-Origin: *');
    return view('401error');
})->name('noautorizado');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
});

Broadcast::routes(['middleware' => ['auth:sanctum']]);
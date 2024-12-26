<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PPBController;
use App\Http\Controllers\PPLController;

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

Route::get('/api/datapesertabalita', [PPBcontroller::class, 'index']);

Route::get('/api/datapesertalansia', [PPLcontroller::class, 'index']);

Route::get('/jadwal/{id}', [JadwalController::class, 'getDetailJadwal']);

Route::get('/search', [PPBcontroller::class, 'search'])->name('api.search');


Route::get('/jadwal-options', [JadwalController::class, 'getJadwalOptions']);


Route::get('/chart-data/{peserta_id}', [PPBController::class, 'getChartDataByPeserta']);
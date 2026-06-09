<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AsramaController;

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

Route::prefix('asrama')->group(function () {
    Route::get('/', [AsramaController::class, 'index']);
    Route::get('/{id}/siswa', [AsramaController::class, 'siswa']);
});

<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\Sistema;
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

Route::get('/ping', function(){
    return response()->json(["status" => 200]);
});

/**
 * Autenticação
 */
Route::post('/token/create', [AuthController::class, 'cadastro']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/sistema', [AuthController::class, 'getAuthSistema']);
    Route::delete('/sistema/{tokenId?}', [AuthController::class, 'deleteToken']);
});


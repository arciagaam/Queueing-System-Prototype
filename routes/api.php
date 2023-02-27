<?php

use App\Http\Controllers\QueueController;
use App\Models\Queue;
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


Route::post('/queue/{office_id}/{window_id}', [QueueController::class, 'api']);
Route::post('/office_window/{office_id}/{window_id}', [QueueController::class, 'getOfficeWindow']);
Route::post('/windows/{office_id}', [QueueController::class, 'windows']);
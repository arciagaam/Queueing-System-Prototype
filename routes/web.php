<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\ScreenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WindowController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [UserController::class, 'index'])->middleware('guest');
Route::get('/login', [UserController::class, 'login'])->middleware('guest');
Route::post('/login', [UserController::class, 'authenticate'])->middleware('guest');
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth');

Route::get('/dashboard', [AdminController::class, 'index'])->middleware('auth');

// OFFICE ROUTES
Route::get('/offices', [OfficeController::class, 'index'])->middleware('auth');
Route::get('/offices/new', [OfficeController::class, 'create']);
Route::post('/offices/new', [OfficeController::class, 'insert']);
Route::get('/offices/{office}/edit', [OfficeController::class, 'edit']);
Route::post('/offices/{office}/edit', [OfficeController::class, 'update']);
Route::post('/offices/{office}/delete', [OfficeController::class, 'delete']);

// WINDOW ROUTES
Route::get('/offices/{office}', [WindowController::class, 'index'])->middleware('auth'); //do not move this
Route::get('/offices/{office}/new', [WindowController::class, 'create'])->middleware('auth'); 
Route::post('/offices/{office}/new', [WindowController::class, 'insert'])->middleware('auth');
Route::get('/offices/{office}/{window}/edit', [WindowController::class, 'edit'])->middleware('auth');
Route::post('/offices/{office}/{window}/edit', [WindowController::class, 'update'])->middleware('auth');
Route::post('/offices/{office}/{window}/delete', [WindowController::class, 'delete'])->middleware('auth');

//QUEUEING ROUTES
Route::get('/offices/{office}/{window}', [QueueController::class, 'index']);
Route::post('/update_window', [QueueController::class, 'test']);


// USER ROUTES
Route::get('/users', [ManageUserController::class, 'index'])->middleware('auth');

// SCREEN ROUTES
Route::get('/screens', [ScreenController::class, 'index'])->middleware('auth');
Route::get('/screens/edit', [ScreenController::class, 'edit'])->middleware('auth');
Route::post('/screens/edit', [ScreenController::class, 'update'])->middleware('auth');
Route::post('/screens/delete', [ScreenController::class, 'delete'])->middleware('auth');

Route::get('/screens/new/step-one', [ScreenController::class, 'createStepOne'])->middleware('auth');
Route::post('/screens/new/step-one', [ScreenController::class, 'postStepOne'])->middleware('auth');

Route::get('/screens/new/step-two', [ScreenController::class, 'createStepTwo'])->middleware('auth');
Route::post('/screens/new/step-two', [ScreenController::class, 'postStepTwo'])->middleware('auth');

// LOGS ROUTES
Route::get('/logs', [ScreenController::class, 'index'])->middleware('auth');

// KIOSK ROUTES
Route::get('/home', [KioskController::class, 'index'])->middleware('auth');

Route::get('/queueing/step-one', [KioskController::class, 'createStepOne'])->middleware('auth');
Route::post('/queueing/step-one', [KioskController::class, 'postStepOne'])->middleware('auth');

Route::get('/queueing/step-two', [KioskController::class, 'createStepTwo'])->middleware('auth');
Route::post('/queueing/step-two', [KioskController::class, 'postStepTwo'])->middleware('auth');

Route::get('/queueing/step-three', [KioskController::class, 'createStepThree'])->middleware('auth');

// DISPLAY MONITOR ROUTES
Route::get('/monitor/display/{id}', [ScreenController::class, 'display'])->middleware('auth');

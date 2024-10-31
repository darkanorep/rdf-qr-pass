<?php

use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LimitController;
use App\Http\Controllers\RoleController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//FOR AUTHENTICATION
Route::post('signup', [AuthController::class, 'signup']);
//FOR ATTENDEES
Route::post('register', [AttendeeController::class, 'store']);

Route::put('roles/change-status/{role}', [RoleController::class, 'changeStatus']);
Route::resource('roles', RoleController::class);

Route::put('groups/change-status/{group}', [GroupController::class, 'changeStatus']);
Route::resource('groups', GroupController::class);

Route::resource('attendees', AttendeeController::class);
Route::put('attendees/change-status/{attendee}', [AttendeeController::class, 'changeStatus']);

Route::resource('limits', LimitController::class);
Route::put('limits/change-status/{limit}', [LimitController::class, 'changeStatus']);

Route::get('read-qr', [AttendeeController::class, 'readQR']);

<?php

use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LimitController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ColorController;
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
Route::post('login', [AuthController::class, 'login']);

//FOR ATTENDEES
Route::post('register', [AttendeeController::class, 'store']);
Route::get('read-qr', [AttendeeController::class, 'readQR']);
Route::get('dropdown-groups', [GroupController::class, 'index']);
Route::get('dropdown-buildings', [BuildingController::class, 'index']);
<<<<<<< HEAD
=======
Route::get('pre-register-checker', [AttendeeController::class, 'preRegisterChecker']);
Route::get('find-qr', [AttendeeController::class, 'findQR']);
>>>>>>> eb0fff2802ba39e5279f5d2703f1b2e447ad9d50

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('logout', [AuthController::class, 'logout']);

    Route::group(['middleware' => 'admin'], function () {
        Route::put('users/change-status/{user}', [UserController::class, 'changeStatus']);
        Route::resource('users', UserController::class);

        Route::put('roles/change-status/{role}', [RoleController::class, 'changeStatus']);
        Route::resource('roles', RoleController::class);

        Route::put('groups/change-status/{group}', [GroupController::class, 'changeStatus']);
        Route::resource('groups', GroupController::class);

        Route::put('attendees/change-status/{attendee}', [AttendeeController::class, 'changeStatus']);
        Route::resource('attendees', AttendeeController::class);

        Route::put('limits/change-status/{limit}', [LimitController::class, 'changeStatus']);
        Route::resource('limits', LimitController::class);

        Route::put('buildings/change-status/{building}', [BuildingController::class, 'changeStatus']);
        Route::resource('buildings', BuildingController::class);

        Route::put('colors/change-status/{color}', [ColorController::class, 'changeStatus']);
        Route::resource('colors', ColorController::class);
    });
});

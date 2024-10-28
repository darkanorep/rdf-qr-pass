<?php

use App\Http\Controllers\GroupController;
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

Route::post('signup', [\App\Http\Controllers\AuthController::class, 'signup']);

Route::put('roles/change-status/{role}', [RoleController::class, 'changeStatus']);
Route::resource('roles', RoleController::class);

Route::put('groups/change-status/{group}', [GroupController::class, 'changeStatus']);
Route::resource('groups', GroupController::class);

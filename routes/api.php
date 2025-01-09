<?php

use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LimitController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\AttendanceController;
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
Route::put('register/{attendee}', [AttendeeController::class, 'update']);
Route::post('register', [AttendeeController::class, 'store']);
Route::get('dropdown-groups', [GroupController::class, 'index']);
Route::get('dropdown-buildings', [BuildingController::class, 'index']);
Route::get('pre-register-checker', [AttendeeController::class, 'preRegisterChecker']);
Route::post('scan-qr', [AttendeeController::class, 'attendance']);
//Route::post('factory', [AttendeeController::class, 'attendanceFactory']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('logout', [AuthController::class, 'logout']);

    Route::group(['middleware' => 'admin'], function () {
        Route::prefix('attendees')->group(function () {
            Route::get('/attendance-list', [AttendeeController::class, 'attendeesList']);
            Route::get('/attendance-list-report', [AttendeeController::class, 'attendeesListReport']);
            Route::put('/change-status/{attendee}', [AttendeeController::class, 'changeStatus']);
            Route::post('/import', [AttendeeController::class, 'import']);
            Route::get('/attendance-list-report/export', [AttendeeController::class, 'export']);
            Route::post('/winner', [AttendeeController::class, 'winner']);
            Route::get('/winners', [AttendeeController::class, 'getWinners']);
            Route::post('/winners/reset', [AttendeeController::class, 'resetWinners']);
            Route::post('/import-eligible', [AttendeeController::class, 'importELigbles']);
            Route::post('/import-non-eligible', [AttendeeController::class, 'importNonEligbles']);
        });

        Route::resource('attendees', AttendeeController::class);

        Route::put('users/change-status/{user}', [UserController::class, 'changeStatus']);
        Route::resource('users', UserController::class);

        Route::put('roles/change-status/{role}', [RoleController::class, 'changeStatus']);
        Route::resource('roles', RoleController::class);

        Route::put('groups/change-status/{group}', [GroupController::class, 'changeStatus']);
        Route::resource('groups', GroupController::class);

        Route::put('limits/change-status/{limit}', [LimitController::class, 'changeStatus']);
        Route::resource('limits', LimitController::class);

        Route::put('buildings/change-status/{building}', [BuildingController::class, 'changeStatus']);
        Route::resource('buildings', BuildingController::class);

        Route::put('colors/change-status/{color}', [ColorController::class, 'changeStatus']);
        Route::resource('colors', ColorController::class);

        Route::put('permissions/change-status/{permission}', [PermissionController::class, 'changeStatus']);
        Route::resource('permissions', PermissionController::class);
    });
});

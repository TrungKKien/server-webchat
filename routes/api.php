<?php

use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Api\UserGroupController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('', function () {
    return response()->json('oke');
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('logout', [AuthController::class, 'logout']);
    });

    Route::group(['prefix' => 'users'], function (){
        Route::get('', [UserController::class, 'index']);
    });

    Route::group(['prefix' => 'groups'], function () {
        Route::post('', [GroupController::class, 'store']);
        Route::get('', [GroupController::class, 'index']);
        Route::put('{id}', [GroupController::class, 'update']);
        Route::get('{id}', [GroupController::class, 'show']);

        Route::group(['prefix' => 'users'], function () {
            Route::post('', [UserGroupController::class, 'store']);
            Route::delete('{userId}', [UserGroupController::class, 'destroy']);
        });
    });

    Route::group(['prefix' => 'messages'], function () {
        Route::post('', [MessageController::class, 'store']);
        Route::get('', [MessageController::class, 'index']);
        Route::get('{group_id}', [MessageController::class, 'show']);
        Route::put('{id}', [MessageController::class, 'update']);
        Route::delete('{id}', [MessageController::class, 'destroy']);
    });
});

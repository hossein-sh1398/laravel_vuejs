<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\AuthenticationController;


Route::get('/v1/users', [UserController::class, 'index']);
Route::delete('/v1/users/destroy', [UserController::class, 'destroy']);
Route::get('/v1/users/edit/{user}', [UserController::class, 'edit']);
Route::patch('/v1/users/update/{user}', [UserController::class, 'update']);
Route::post('/v1/login', [AuthenticationController::class, 'login']);
Route::post('/v1/register', [AuthenticationController::class, 'register']);

Route::middleware('auth:sanctum')->group(function() {
	Route::post('/v1/users/create', [UserController::class, 'create']);
	Route::get('/v1/user', [AuthenticationController::class, 'user']);
	Route::get('/v1/logout', [AuthenticationController::class, 'logout']);
});


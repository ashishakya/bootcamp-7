<?php

use App\Http\Controllers\Api\Auth\AccountRequestController;
use App\Http\Controllers\Api\Auth\ForgotPassword;
use App\Http\Controllers\Api\Auth\ResetPassword;
use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/test', function (Request $request) {
    return "hey";
});

Route::post('login', [AuthController::class, "login"])->name("login");
Route::post('logout', [AuthController::class, "logout"])->name("logout")->middleware('auth:sanctum');
//Route::post('me', [AuthController::class, "me"])->name("me")->middleware(['auth:sanctum', "abilities:server:update"]);
Route::post('me', [AuthController::class, "me"])->name("me")->middleware(['auth:sanctum']);
Route::post('unprotected', [AuthController::class, "me"])->name("me")->middleware(['auth:sanctum']);
//Route::post('/forgot-password', ForgotPassword::class)->name("forgot_password");
//Route::post('/reset-password', ResetPassword::class)->name("reset_password");
//Route::post('account-request', AccountRequestController::class)->name("account_request");
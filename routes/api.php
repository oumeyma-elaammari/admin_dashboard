<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;

Route::post('/login', [AuthController::class,'login']);
Route::post('/register', [AuthController::class,'register']);

Route::middleware(['auth:sanctum','role:admin'])->group(function(){
    Route::get('/users',[UserController::class,'index']);
    Route::post('/users',[UserController::class,'store']);
    Route::delete('/users/{id}',[UserController::class,'destroy']);
    Route::get('/clients',[UserController::class,'clients']);
    Route::get('/admin-emails', function(){
        return \App\Models\User::whereIn('role',['admin','subadmin'])->pluck('email');
    });
});

Route::middleware(['auth:sanctum','role:admin,subadmin'])->group(function(){
    Route::apiResource('products', ProductController::class)->only(['index','store','update','destroy']);
    Route::get('/orders',[OrderController::class,'index']);
});

Route::middleware(['auth:sanctum','role:client'])->post('/orders',[OrderController::class,'store']);

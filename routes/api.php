<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthApi;
use App\Http\Controllers\FeedApi;
use Illuminate\Support\Facades\Route;


Route::post('register',[AuthApi::class,'register']);
Route::post('login',[AuthApi::class,'login']);
Route::post('feed/create',[FeedApi::class,'create']);

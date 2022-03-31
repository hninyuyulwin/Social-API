<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthApi;
use App\Http\Controllers\FeedApi;
use App\Http\Controllers\LikeApi;
use Illuminate\Support\Facades\Route;


Route::post('register',[AuthApi::class,'register']);
Route::post('login',[AuthApi::class,'login']);

Route::group(['middleware'=>'auth:api'],function(){
    Route::get('feed',[FeedApi::class,'feed']);
    Route::post('feed/create',[FeedApi::class,'create']);
    Route::delete('feed/delete',[FeedApi::class,'delete']);

    // Comments
    Route::post('comment/create',[FeedApi::class,'createComment']);
    Route::get('comment',[FeedApi::class,'comment']);
    Route::delete('comment/delete',[FeedApi::class,'deleteComment']);

    // Likes
    Route::post('like',[LikeApi::class,'like']);
    Route::delete('unlike',[LikeApi::class,'unlike']);
});


<?php


use Illuminate\Support\Facades\Route;

Route::post('/login','App\Http\Controllers\AuthController@login');
Route::post('/register','App\Http\Controllers\AuthController@register');

Route::group(['middleware' => 'auth.jwt'], function (){
Route::post('/logout','App\Http\Controllers\AuthController@logout');

});


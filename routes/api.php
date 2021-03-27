<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::post('/login','App\Http\Controllers\AuthController@login');
//Route::post('/register','App\Http\Controllers\AuthController@register');
//
//Route::group(['middleware' => 'auth.jwt'], function (){
//Route::post('/logout','App\Http\Controllers\AuthController@logout');
//
//});

Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/recover', 'App\Http\Controllers\AuthController@recover');
Route::resource('/helpline', 'App\Http\Controllers\HelplineController')->except([
   'create', 'edit'
]);
Route::resource('/rescue', 'App\Http\Controllers\RescueController')->except([
    'create', 'edit'
]);

Route::group(['middleware' => ['jwt.auth']], function() {
   Route::get('/logout', 'App\Http\Controllers\AuthController@logout');

   Route::get('/test', function(){
       return response()->json(['foo'=>'bar']);
   });

   Route::get('/categories/select', 'App\Http\Controllers\CategoriaController@select');
});


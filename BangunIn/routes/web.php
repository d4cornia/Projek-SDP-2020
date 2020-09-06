<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//start login
Route::get('/','loginController@index');
Route::get('/vlogin', 'loginController@vlogin');
Route::post('/login', 'loginController@login');
Route::any('/register', 'loginController@register');
//end login

//kontraktor
Route::group(['prefix' => 'kontraktor'], function () {
    Route::get('/','kontraktorController@index');
    Route::get('/rMandor', 'kontraktorController@indexRegisterMandor');
    Route::get('/rAdmin', 'kontraktorController@indexRegisterAdmin');
    Route::post('/submitRegMandor', 'kontraktorController@storeMandor');
    Route::post('/submitRegAdmin', 'kontraktorController@storeAdmin');
});

//mandor
Route::group(['prefix' => 'mandor'], function () {
    Route::get('/','mandorController@index');
});

//tukang
Route::group(['prefix' => 'tukang'], function () {
    Route::get('/','tukangController@index');
});

//admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/','adminController@index');
});

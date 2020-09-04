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

Route::get('/', 'registerController@index');
Route::get('/rMandor', 'registerController@indexRegisterMandor');
Route::get('/rAdmin', 'registerController@indexRegisterAdmin');
Route::post('/submitRegMandor', 'registerController@storeMandor');
Route::post('/submitRegAdmin', 'registerController@storeAdmin');

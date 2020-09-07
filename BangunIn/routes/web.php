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
Route::get('/', 'loginController@index');
Route::get('/vlogin', 'loginController@vlogin');
Route::post('/login', 'loginController@login');
Route::any('/register', 'loginController@register');
//end login

//kontraktor
Route::group(['prefix' => 'kontraktor'], function () {
    Route::get('/', 'kontraktorController@index');
    Route::get('/rMandor', 'kontraktorController@indexRegisterMandor');
    Route::get('/rAdmin', 'kontraktorController@indexRegisterAdmin');
    Route::get('/aWork', 'kontraktorController@indexAddWork');
    Route::get('/aSpWork', 'kontraktorController@indexAddSpecialWork');

    Route::get('/lMandor', 'kontraktorController@indexListMandor');
    Route::get('/lAdmin', 'kontraktorController@indexListAdmin');
    Route::get('/lWork', 'kontraktorController@indexListWork');
    Route::get('/iSpWork', 'kontraktorController@indexSpecialWork');
    Route::get('/search', 'kontraktorController@searchListSpecialWork');

    Route::get('/detWork/{n?}', 'kontraktorController@indexListWork');

    Route::post('/submitRegMandor', 'kontraktorController@storeMandor');
    Route::post('/submitRegAdmin', 'kontraktorController@storeAdmin');
    Route::post('/submitAddWork', 'kontraktorController@storeWork');

    Route::get('/addClient', 'kontraktorController@addClient');
    Route::post('/submitRegClient', 'kontraktorController@storeClient');
    Route::get('/lihatClient', 'kontraktorController@indexListClient');
    Route::get('/pembayaran', 'kontraktorController@pembayaranClient');
    Route::post('/submitPembayaran', 'kontraktorController@bayar');
});

//mandor
Route::group(['prefix' => 'mandor'], function () {
    Route::get('/', 'mandorController@index');

    //jenistukang
    Route::get('/tambahJenisTukang', 'mandorController@tambahJenisTukang');
    Route::post('/submitRegJenisTukang', 'mandorController@storeJenisTukang');
    Route::get('/lihatJenisTukang', 'mandorController@lihatJenisTukang');

    //tukang
    Route::get('/tambahTukang', 'mandorController@tambahTukang');
    Route::post('/submitRegTukang', 'mandorController@storeTukang');
    Route::get('/lihatTukang', 'mandorController@lihatTukang');

    //bon
    Route::get('/tambahBon', 'mandorController@tambahBon');
    Route::post('/submitRegBon', 'mandorController@storeBon');
});

//tukang
Route::group(['prefix' => 'tukang'], function () {
    Route::get('/', 'tukangController@index');
});

//admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'adminController@index');
});

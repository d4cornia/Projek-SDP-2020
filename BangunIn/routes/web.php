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
    //index for insert
    Route::get('/', 'kontraktorController@index');
    Route::get('/rMandor', 'kontraktorController@indexRegisterMandor');
    Route::get('/rAdmin', 'kontraktorController@indexRegisterAdmin');
    Route::get('/aWork', 'kontraktorController@indexAddWork');
    Route::get('/aSpWork', 'kontraktorController@indexAddSpecialWork');

    //list
    Route::get('/lMandor', 'kontraktorController@indexListMandor');
    Route::get('/lAdmin', 'kontraktorController@indexListAdmin');
    Route::get('/lWork', 'kontraktorController@indexListWork');
    Route::get('/iSpWork', 'kontraktorController@indexSpecialWork');
    Route::post('/search', 'kontraktorController@searchListSpecialWork');

    //insert
    Route::post('/submitRegMandor', 'kontraktorController@storeMandor');
    Route::post('/submitRegAdmin', 'kontraktorController@storeAdmin');
    Route::post('/submitAddWork', 'kontraktorController@storeWork');
    Route::post('/submitAddSpecWork', 'kontraktorController@storeSpecialWork');

    // detail
    Route::get('/detMandor/{n?}', 'kontraktorController@detailMandor');
    Route::get('/detAdmin/{n?}', 'kontraktorController@detailAdmin');
    Route::get('/detWork/{n?}', 'kontraktorController@detailWork');
    Route::get('/detSpWork/{n?}', 'kontraktorController@detailSpecialWork');

    // Update
    Route::post('/updMandor', 'kontraktorController@updateMandor');
    Route::post('/updAdmin', 'kontraktorController@updateAdmin');
    Route::post('/updWork', 'kontraktorController@updateWork');
    Route::post('/updSpWork', 'kontraktorController@updateSpecialWork');

    Route::get('/addClient', 'kontraktorController@addClient');
    Route::post('/submitRegClient', 'kontraktorController@storeClient');
    Route::get('/lihatClient', 'kontraktorController@indexListClient');
    Route::get('/pembayaran', 'kontraktorController@pembayaranClient');
    Route::post('/submitPembayaran', 'kontraktorController@bayar');
    Route::get('/detClient/{n?}', 'kontraktorController@toDetailClient');
    Route::post('/update', 'kontraktorController@updateClient');
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
    Route::get('/tambahPembayaranBon', "mandorController@bayarBon");
    Route::post('/fetch', "mandorController@fetch")->name('dynamicdependent.fetch');
});

//tukang
Route::group(['prefix' => 'tukang'], function () {
    Route::get('/', 'tukangController@index');
});

//admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'adminController@index');
});

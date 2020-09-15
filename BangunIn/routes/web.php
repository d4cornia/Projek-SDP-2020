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
Route::get('/logout', 'loginController@logout');
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
    Route::get('/sDelMandor', 'kontraktorController@listDeletedMandor');
    Route::get('/sDelAdmin', 'kontraktorController@listDeletedAdmin');

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
    Route::get('/updPass/{n?}/{m?}', 'kontraktorController@updatePassword');
    Route::post('/updMandor', 'kontraktorController@updateMandor');
    Route::post('/updAdmin', 'kontraktorController@updateAdmin');
    Route::post('/updPassMandor', 'kontraktorController@updatePassMandor');
    Route::post('/updPassAdmin', 'kontraktorController@updatePassAdmin');
    Route::post('/updWork', 'kontraktorController@updateWork');
    Route::post('/updSpWork', 'kontraktorController@updateSpecialWork');

    // Delete
    Route::get('/delConf/{n?}', 'kontraktorController@deleteMandor');
    Route::get('/delMandor/{n?}', 'kontraktorController@deleteMandor');
    Route::get('/delAdmin/{n?}', 'kontraktorController@deleteAdmin');
    Route::get('/delWork/{n?}', 'kontraktorController@deleteWork');
    Route::get('/delSpWork/{n?}', 'kontraktorController@deleteSpecialWork');

    // Rollback
    Route::get('/rollbackMandor/{n?}', 'kontraktorController@rollbackMandor');
    Route::get('/rollbackAdmin/{n?}', 'kontraktorController@rollbackAdmin');


    Route::get('/addClient', 'kontraktorController@addClient');
    Route::post('/submitRegClient', 'kontraktorController@storeClient');
    Route::get('/lihatClient', 'kontraktorController@indexListClient');
    Route::get('/pembayaran', 'kontraktorController@pembayaranClient');
    Route::post('/submitPembayaran', 'kontraktorController@bayar');
    Route::get('/detClient/{n?}', 'kontraktorController@toDetailClient');
    Route::get('/show', 'kontraktorController@showPembayaranForm');
    Route::post('/update', 'kontraktorController@updateClient');
    Route::post('/fetch', "kontraktorController@fetch")->name('cbPekerjaan.fetch');
    Route::get('/delClient/{n?}', "kontraktorController@deleteClient");
    Route::get('/listPembayaran', "kontraktorController@listPembayaranClient");
});

//mandor
Route::group(['prefix' => 'mandor'], function () {
    Route::get('/', 'mandorController@index');

    //jenistukang
    //insert
    Route::get('/tambahJenisTukang', 'mandorController@tambahJenisTukang');
    Route::post('/submitRegJenisTukang', 'mandorController@storeJenisTukang');
    Route::get('/lihatJenisTukang', 'mandorController@lihatJenisTukang');
    //detail
    Route::get('/detjenis/{n?}', 'mandorController@detailjenis');
    //delete
    Route::get('/deljenis/{n?}', 'mandorController@deleteJenis');
    //update
    Route::post('/updateJenisTukang', 'mandorController@updateJenisTukang');


    //tukang
    Route::get('/tambahTukang', 'mandorController@tambahTukang');
    Route::post('/submitRegTukang', 'mandorController@storeTukang');
    Route::get('/lihatTukang', 'mandorController@lihatTukang');
    //detail
    Route::get('/detTukang/{n?}', 'mandorController@detailtukang');
    //update
    Route::post('/updateTukang', 'mandorController@updateTukang');
    //delete
    Route::get('/delTukang/{n?}', 'mandorController@deleteTukang');

    //bon
    //tambahbon
    Route::get('/tambahBon', 'mandorController@tambahBon');
    Route::post('/submitRegBon', 'mandorController@storeBon');
    Route::get('/lihatBon', 'mandorController@lihatBon');
    Route::get('/delBon/{n?}', 'mandorController@deleteBon');
    //pembayaranbon
    Route::get('/tambahPembayaranBon', "mandorController@bayarBon");
    Route::post('/fetch', "mandorController@fetch")->name('dynamicdependent.fetch');
    Route::post('/submitBayarBon', 'mandorController@tambahBayar');
    Route::post('/tabelBayar', 'mandorController@batalBayar');
    Route::post('/simpanBayarBon', 'mandorController@simpanPembayaran');
});

//tukang
Route::group(['prefix' => 'tukang'], function () {
    Route::get('/', 'tukangController@index');
});

//admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'adminController@index');
});

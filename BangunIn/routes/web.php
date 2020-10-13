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
Route::get('/', 'loginController@home');
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
    Route::get('/aSpWork/{n?}', 'kontraktorController@indexAddSpecialWork');

    //list
    Route::get('/lMandor', 'kontraktorController@indexListMandor');
    Route::get('/lAdmin', 'kontraktorController@indexListAdmin');
    Route::get('/lWork', 'kontraktorController@indexListWork');
    Route::get('/iSpWork', 'kontraktorController@indexSpecialWork');
    Route::get('/iSpWork/{n?}', 'kontraktorController@indexSpecialWorkParam');
    Route::post('/search', 'kontraktorController@searchListSpecialWork');
    Route::get('/sDelMandor', 'kontraktorController@listDeletedMandor');
    Route::get('/sDelAdmin', 'kontraktorController@listDeletedAdmin');
    Route::get('/sDelWork', 'kontraktorController@listDeletedWork');
    Route::get('/sSpDelWork/{n?}', 'kontraktorController@listDeletedSpecialWork');

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
    Route::get('/detSpWorkMenu/{n?}', 'kontraktorController@detailSpecialWorkMenu');

    // Update
    Route::get('/updPass/{n?}/{m?}', 'kontraktorController@updatePassword');
    Route::post('/updMandor', 'kontraktorController@updateMandor');
    Route::post('/updAdmin', 'kontraktorController@updateAdmin');
    Route::post('/updPassMandor', 'kontraktorController@updatePassMandor');
    Route::post('/updPassAdmin', 'kontraktorController@updatePassAdmin');
    Route::post('/updWork', 'kontraktorController@updateWork');
    Route::post('/updSpWork', 'kontraktorController@updateSpecialWork');
    Route::post('/updProfilePerusahaan', 'kontraktorController@updateProfilePerusahaan');

    // Delete
    Route::get('/delConf/{n?}', 'kontraktorController@deleteMandor');
    Route::get('/delMandor/{n?}', 'kontraktorController@deleteMandor');
    Route::get('/delAdmin/{n?}', 'kontraktorController@deleteAdmin');
    Route::get('/delWork/{n?}', 'kontraktorController@deleteWork');
    Route::get('/delSpWork/{n?}', 'kontraktorController@deleteSpecialWork');
    Route::get('/delSpWorkMenu/{n?}', 'kontraktorController@deleteSpecialWorkMenu');
    Route::get('/delSpWorkRow/{n?}', 'kontraktorController@deleteRowSpWork');

    // Rollback
    Route::get('/rollbackMandor/{n?}', 'kontraktorController@rollbackMandor');
    Route::get('/rollbackAdmin/{n?}', 'kontraktorController@rollbackAdmin');
    Route::get('/rollbackWork/{n?}', 'kontraktorController@rollbackWork');
    Route::get('/rollbackSpWork/{n?}', 'kontraktorController@rollbackSpecialWork');
    Route::get('/rollbackSpWorkMenu/{n?}', 'kontraktorController@rollbackSpecialWorkMenu');


    Route::get('/addClient', 'kontraktorController@addClient');
    Route::post('/submitRegClient', 'kontraktorController@storeClient');
    Route::get('/lihatClient', 'kontraktorController@indexListClient');
    Route::get('/pembayaran', 'kontraktorController@pembayaranClient');
    Route::post('/submitPembayaran', 'kontraktorController@bayar');
    Route::post('/submitTagihan', 'kontraktorController@storeTagihan');
    Route::get('/detClient/{n?}', 'kontraktorController@toDetailClient');
    Route::get('/show', 'kontraktorController@showPembayaranForm');
    Route::post('/update', 'kontraktorController@updateClient');
    Route::post('/fetch', "kontraktorController@fetch")->name('cbPekerjaan.fetch');
    Route::post('/fetch1', "kontraktorController@getKode")->name('cb.fetch1');
    Route::post('/cekTagihan', "kontraktorController@cekTagihan")->name('cbKirim.cekTagihan');
    Route::get('/setujui/{m?}', "kontraktorController@setujuiKomisi");
    Route::get('/batal/{m?}', "kontraktorController@batalSetujui");
    Route::get('/delClient/{n?}', "kontraktorController@deleteClient");
    Route::get('/resClient/{n?}', "kontraktorController@restoreClient");
    Route::get('/listPembayaran', "kontraktorController@listPembayaranClient");
    Route::get('/listDeleteClient', "kontraktorController@listDeleteClient");
    Route::get('/inputTagihan', "kontraktorController@menuTagihan");
    Route::get('/edProfile', 'kontraktorController@showProfilePerusahaan');
    Route::get('/listTagihan', 'kontraktorController@showListTagihan');
    Route::get('/listKomisi', 'kontraktorController@showListKomisi');
    Route::get('/tambahTagihan/{n?}', "kontraktorController@tambahTagihanDenganKode");
    Route::get('/hapusTagihan/{n?}', "kontraktorController@hapusTagihan");
});

//mandor
Route::group(['prefix' => 'mandor'], function () {
    Route::get('/', 'mandorController@index');
    //Absen Tukang
    Route::get('/absenTukang', 'mandorAbsenController@lihatAbsenTukang');
    Route::post('/filterAbsen', 'mandorAbsenController@filterAbsen');
    Route::post('/konfirmasiAbsen', 'mandorAbsenController@konfirmasiAbsen');
    //jenistukang
    //insert
    Route::get('/tambahJenisTukang', 'mandorController@tambahJenisTukang');
    Route::post('/submitRegJenisTukang', 'mandorController@storeJenisTukang');
    Route::get('/lihatJenisTukang', 'mandorController@lihatJenisTukang');
    //Deleted
    Route::get('/lihatJenisTerhapus', 'mandorController@lihatdeletedJenis');
    Route::get('/rollbackJenisTukang/{n?}', 'mandorController@rollbackJenisTukang');
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
    Route::post('/fetch2', "mandorController@fetchgaji")->name('dynamicdependent2.fetch');
    //Deleted
    Route::get('/lihatTukangTerhapus', 'mandorController@lihatdeletedTukang');
    Route::get('/rollbackTukang/{n?}', 'mandorController@rollbackTukang');
    Route::get('/updatePass/{n?}', 'mandorController@gantiPass');
    Route::post('/storeGantiPass', 'mandorController@storeGantiPass');
    //detail
    Route::get('/detTukang/{n?}', 'mandorController@detailtukang');
    //update
    Route::post('/updateTukang', 'mandorController@updateTukang');
    //delete
    Route::get('/delTukang/{n?}', 'mandorController@deleteTukang');

    //bon
    //tambahbon
    Route::get('/lihatBonTukang/{n?}', 'mandorController@lihatBonTukang');
    Route::get('/cekBonTukang/{n?}', 'mandorController@cekBonTukang');
    Route::get('/tambahBon', 'mandorController@tambahBon');
    Route::get("/tambahBonTukangX/{n?}", "mandorController@tambahBonTukangX");
    Route::post('/submitRegBon', 'mandorController@storeBon');
    Route::post('/submitRegBonKhusus', "mandorController@storeBonKhusus");
    Route::get('/lihatBon', 'mandorController@lihatBon');
    Route::get('/delBon/{n?}', 'mandorController@deleteBon');
    //pembayaranbon
    Route::get('/tambahPembayaranBon', "mandorController@bayarBon");
    Route::post('/tambahBayarKhusus', "mandorController@tambahBayarKhusus");
    Route::post('/fetch', "mandorController@fetch")->name('dynamicdependent.fetch');
    Route::post('/submitBayarBon', 'mandorController@tambahBayar');
    Route::post('/tabelBayar', 'mandorController@batalBayar');
    Route::post('/simpanBayarBon', 'mandorController@simpanPembayaran');
    Route::get('/detailPembayaranBon/{n?}', 'mandorController@detailPembayaranBon');
    Route::get('/lihatRincianPembayaran', 'mandorController@rincianPembayaran');
    Route::post('/filterRincianBon', 'mandorController@filterRincianBon');
    //selesain pekerjaan
    Route::get('/lihatPekerjaan', "mandorController@lihatPekerjaan");
    Route::get('/lihatHistoryPekerjaan', "mandorController@lihatHistoryPekerjaan");

    Route::get('/detWork/{id?}', "mandorController@detailWork");
    Route::get('/sProject/{id?}', "mandorController@selesaiProject");
    Route::post('/finishWork', "mandorController@finishWork");
});

//tukang
Route::group(['prefix' => 'tukang'], function () {
    Route::get('/', 'tukangController@index');
    Route::get('/history', 'tukangController@listRiwayatAbsen');
    Route::get('/absen', 'tukangController@indexAbsen');
    Route::post('/upload', 'tukangController@absen');
});

//admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'adminController@index');
    Route::get('/tambahToko','adminController@tambahToko');
    Route::post('/submitToko','adminController@submitToko');
    Route::get('/lihatToko','adminController@lihatToko');
    Route::get('/editToko/{n?}', 'adminController@editToko');
    Route::post('/storeEditToko','adminController@storeEditToko');
    Route::get('/inputBahan', 'adminController@inputBahan');
    Route::post('/alamatToko', "adminController@getAlamat")->name('admin.getAlamat');
    Route::post('/addBahan', "adminController@tambahBahan");
    Route::get('/lBahan/{n?}', "adminController@lBahan");
    Route::get('/deleteBahan/{n?}/{m?}', "adminController@deleteBahan");
    Route::get('/veditBahan/{n?}/{m?}', "adminController@veditBahan");
    Route::post('/editBahan', "adminController@editBahan");
});

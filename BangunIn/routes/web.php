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

    //dana
    Route::get('/lihatRequest', "kontraktorKonfirmDanaController@index");
    Route::get('/konfirmasiRequest/{n?}', "kontraktorKonfirmDanaController@konfirmasiReq");
    Route::post('/bayarRequest', "kontraktorKonfirmDanaController@bayar");
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

    // nota pembelian
    Route::get('/menuNota', 'mandorController@menuNota');
    Route::get('/listNota', 'mandorController@indexList');
    Route::post('/submitNotaPembelian', 'mandorController@inputNota');
    Route::get('/delNota/{n?}', 'mandorController@deleteNotaPembelian');

    //dana
    Route::get('/requestDana', 'mandorRequestController@index');
    Route::post('/querynota', "mandorRequestController@querynota")->name('querynota');
    Route::post('/querybon', "mandorRequestController@querybon")->name('querybon');
    Route::post('/querypkall', "mandorRequestController@querypkall")->name('querypkall');
    Route::post('/queryjumpkall', "mandorRequestController@querypkalls")->name('queryjumpkall');
    Route::post('/hitungpk', "mandorRequestController@hitungpk")->name('hitungpk');
    Route::post('/querygaji', "mandorRequestController@querygaji")->name('querygaji');
    Route::post('/tambahRequestDana', "mandorRequestController@tambahRequestDana");
    Route::get('/tabelReq/{n?}', "mandorRequestController@batalReq");
    Route::post('/hitungtotal', "mandorRequestController@hitungtotal")->name('hitungtotal');
    Route::post('/simpanReqDana', "mandorRequestController@simpanReqDana");

    Route::get('/lihatRequestDana', "mandorRequestController@listReqDana");
    Route::get('/detReq/{n?}', "mandorRequestController@detailrequest");

    //Pekerjaan khusus
    Route::get('/indexSpWork', 'mandorController@indexSpecWork');
    Route::get('/editSpWork', 'mandorController@editSpWork');
    Route::post('/searchSpWork', 'mandorController@searchSpWork');
    Route::post('/assignSpWork', 'mandorController@assign');
    Route::get('/ieditBuktiTsf/{n?}', 'mandorController@ieditBuktiTsf');
    Route::post('/confirmEditBukti', 'mandorController@confirmEditBukti');
    Route::get('/backToEditSpWork', 'mandorController@backToEditSpWork');

    // complain
    Route::get('/complain', 'mandorComplainController@indexComplain');
    Route::post('/accComp', 'mandorComplainController@accComplain');
    Route::get('/decComp/{n?}', 'mandorComplainController@decComplain');
});

//tukang
Route::group(['prefix' => 'tukang'], function () {
    Route::get('/', 'tukangController@index');
    Route::get('/history', 'tukangController@listRiwayatAbsen');
    Route::get('/absen', 'tukangController@indexAbsen');
    Route::post('/confirmAbsen', 'tukangController@confirmAbsen');
    Route::get('/komplain', 'tukangController@complainMode');
    Route::get('/selesaiComplain', 'tukangController@doneComplain');
    Route::get('/konfirmasi', 'tukangController@menuKonfirmasiDana');
    Route::get('/complainA/{n?}', 'tukangController@complain');
    Route::get('/batal/{n?}', 'tukangController@batal');
    Route::post('/upload', 'tukangController@absen');
    Route::post('/confirmDana', 'tukangController@confirmDana');
    Route::get('/konfirmasi', 'tukangController@konfirmasiPenerimaanDana');
});

//admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'adminController@index');
    Route::get('/tambahToko', 'adminController@tambahToko');
    Route::post('/submitToko', 'adminController@submitToko');
    Route::get('/lihatToko', 'adminController@lihatToko');
    Route::get('/editToko/{n?}', 'adminController@editToko');
    Route::post('/storeEditToko', 'adminController@storeEditToko');
    Route::get('/inputBahan', 'adminController@inputBahan');
    Route::post('/alamatToko', "adminController@getAlamat")->name('admin.getAlamat');
    Route::post('/addBahan', "adminController@tambahBahan");
    Route::get('/lBahan/{n?}', "adminController@lBahan");
    Route::get('/lnota/{n?}', "adminController@lNota");
    Route::get('/deleteBahan/{n?}/{m?}', "adminController@deleteBahan");
    Route::get('/veditBahan/{n?}/{m?}', "adminController@veditBahan");
    Route::post('/editBahan', "adminController@editBahan");

    Route::post('/getBahan', "adminController@getBahan")->name('admin.getBahan');
    Route::post('/getSpesial', "adminController@getSpesial")->name('admin.getSpesial');
    Route::get('/vpembelianNota', 'adminController@vnota');
    Route::post('/pembelianNota', 'adminController@pembelianNota');
    Route::post('/tabelBeli', 'adminController@tabelBeli');
    Route::post('/simpanPembelian', 'adminController@simpanPembelian');
    Route::post('/checkout', 'adminController@checkout');

    Route::get('/vListNotaBon', 'adminController@vnotabon');
    Route::get('/detnotabeli/{n?}', 'adminController@detnotabeli');
    Route::post('/bayarBonBahan', 'adminController@pembayaranBonBahan');
});


Route::group(['prefix' => 'report'], function () {
    Route::get('/pekerjaan/{n?}', 'reportController@rPekerjaan');
    Route::get('/iPeriode', 'reportController@indexPeriode');
    Route::post('/sPeriode', 'reportController@searchPeriode');
    Route::get('/budgetMandor/{n?}/{m?}', 'reportController@rBudgetingMandor');
    Route::get('/gajiAllTukang/{n?}/{m?}', 'reportController@gajiAllTukang');
    Route::get('/iuangKeseluruhan', 'reportController@indexKeseluruhan');
    Route::get('/buktiPembayaran', 'reportController@indexBuktiPembayaran');
    Route::post('/search', 'reportController@uangKeseluruhanProyek');
    Route::post('/searchPembayaran', 'reportController@searchPembayaran');
    Route::post('/reportPembelian', 'reportController@reportPembelian');
    Route::get('/iPembelian', 'reportController@indexPembelian');
});

<?php

namespace App\Http\Controllers;

use App\administrator;
use App\bukti_pembelian_mandor;
use App\pekerjaan;
use App\Rules\cekNamaToko;
use App\toko_bangunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class adminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    public function tambahToko(){
        $bukti = new bukti_pembelian_mandor();
        $kode = session()->get('kode');
        $pekerjaan = new pekerjaan();
        $daftarpekerjaan = $pekerjaan->where('kode_admin',$kode)->pluck('kode_pekerjaan');
        if(Cookie::has('berhasiltoko')){
            $data = [
                'error'=>0,
                'title' => 'Detail Pekerjaan',
                'listFoto' => $bukti->whereIn('kode_pekerjaan', $daftarpekerjaan)->where('status_input',0)
                                ->where('status_delete_bukti',0)->get()
            ];
            Cookie::queue('berhasiltoko',1,-10);
        }
        else{
            $data = [
                'title' => 'Detail Pekerjaan',
                'listFoto' => $bukti->whereIn('kode_pekerjaan', $daftarpekerjaan)->where('status_input',0)
                                ->where('status_delete_bukti',0)->get()
            ];
        }

        return view('admin.tambahToko',$data);
    }
    public function submitToko(Request $request){
        $alamat = $request->alamat;
        $request->validate([
            'name' => ['required','string',new cekNamaToko($alamat)],
            'alamat' => 'required|string',
            'telepon'=>'required|numeric'
        ],
        [
            'name.required' => 'Kolom Nama Belum diisi',
            'alamat.required'=>'Kolom Alamat Belum diisi',
            'telepon.required'=>'Kolom Telepon Belum diisi',
            'telepon.numeric'=>'Kolom Telepon hanya berisi angka'
        ]);
        $toko = new toko_bangunan();
        $kodeadmin = session()->get('kode');
        $adm = new administrator();
        $kodekontraktor = $adm->getKodeKontraktor($kodeadmin)[0];
        $toko->insertToko($request,$kodekontraktor);
        $error=0;
        Cookie::queue('berhasiltoko',1,1);
        return redirect('/admin/tambahToko');
    }
    public function lihatToko()
    {
        $toko = new toko_bangunan();
        $kodeadmin = session()->get('kode');
        $adm = new administrator();
        $kodekontraktor = $adm->getKodeKontraktor($kodeadmin)[0];
        if(Cookie::has("berhasilupdate")){
            $data = [
                'error'=>9,
                'title' => 'List Toko',
                'listToko' => $toko->where('kode_kontraktor', $kodekontraktor)->where('status_delete_tb',0)->get()
            ];
            Cookie::queue("berhasilupdate",1,-10);
        }
        else{
            $data = [
                'title' => 'List Toko',
                'listToko' => $toko->where('kode_kontraktor', $kodekontraktor)->where('status_delete_tb',0)->get()
            ];
        }
        return view('admin.List.tokobangunan', $data);
    }
    public function editToko($id)
    {
        $kode = $id;
        $tokobangunan = new toko_bangunan();
        $dataku = $tokobangunan->where('id_kerjasama',$kode)->get()[0];
        $param['kode'] = $kode;
        $param['nama'] = $dataku->nama_toko;
        $param['alamat'] = $dataku->alamat_toko;
        $param['notelp'] = $dataku->no_hp_toko;
        return view('admin.Edit.editToko')->with($param);
    }
    public function storeEditToko(Request $request)
    {
        $kode= $request->idkerjasama;
        $request->validate([
            'telepon'=>'required|numeric'
        ],
        [
            'telepon.required'=>'Kolom Telepon Belum diisi',
            'telepon.numeric'=>'Kolom Telepon hanya berisi angka'
        ]);
        $toko = new toko_bangunan();
        $toko->updateToko($request,$kode);
        Cookie::queue("berhasilupdate",1,10);
        return redirect('/admin/lihatToko');
    }
}

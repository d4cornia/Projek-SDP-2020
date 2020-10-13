<?php

namespace App\Http\Controllers;

use App\administrator;
use App\bukti_pembelian_mandor;
use App\pekerjaan;
use App\Rules\cekNamaToko;
use App\toko_bangunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\bahan_bangunan;
use App\pekerjaan_khusus;

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
    public function inputBahan()
    {
        $bukti = new bukti_pembelian_mandor();
        $toko = new toko_bangunan();
        $kodeadmin = session()->get('kode');
        $adm = new administrator();
        $pekerjaan = new pekerjaan();
        $kodekontraktor = $adm->getKodeKontraktor($kodeadmin)[0];
        $daftarpekerjaan = $pekerjaan->where('kode_admin',$kodeadmin)->pluck('kode_pekerjaan');
        $data = $toko->where('kode_kontraktor', $kodekontraktor)->where('status_delete_tb',0)->pluck('nama_toko');
        $nama = array();
        for($i=0;$i<count($data);$i++){
            array_push($nama,$data[$i]);
        }
        $namaku = array_unique($nama);
        $param['listFoto'] = $bukti->whereIn('kode_pekerjaan', $daftarpekerjaan)->where('status_input',0)
                                    ->where('status_delete_bukti',0)->get();
        $param["listToko"] = $namaku;
        return view('admin.tambahBahan')->with($param);
    }
    public function getAlamat(Request $req)
    {
        $nmToko = $req->get('value');
        $toko = new toko_bangunan();
        $data = $toko->where("nama_toko",$nmToko)->get();
        $select = "<option disabled selected>Pilih Alamat Toko</option>";
        foreach ($data as $key => $value) {
            $select .= "<option value='".$value->id_kerjasama."'>".$value->alamat_toko."</option>";
        }
        echo $select;
    }
    public function tambahBahan(Request $req)
    {
        $idKerjasama = $req->alamat;
        $nmbahan = $req->nmbahan;
        $harga = $req->hargabahan;
        $bahan  = new bahan_bangunan();
        $bahan->addBahan($idKerjasama,$nmbahan,$harga);
        return redirect("admin/inputBahan")->with(['success' => 'Berhasil Menambah Bahan!']);
    }
    public function lBahan($id)
    {
        $bahan  = new bahan_bangunan();
        $toko = new toko_bangunan();
        $param["toko"] = $toko->where("id_kerjasama",$id)->get();
        $param["listBahan"] = $bahan->where('id_kerjasama',$id)->where('status_delete_bb',0)->get();
        return view("admin.List.listBahan")->with($param);
    }
    public function deleteBahan($idbahan,$id)
    {
        $bahan  = new bahan_bangunan();
        $bahan->deleteBahan($idbahan);
        return redirect("/admin/lBahan/".$id)->with(['success' => 'Berhasil Menghapus Bahan!']);
    }
    public function veditBahan($idbahan,$id)
    {
        $bahan  = new bahan_bangunan();
        $toko = new toko_bangunan();
        $param["idbahan"] = $idbahan;
        $param["id"] = $id;
        $param["toko"] = $toko->where("id_kerjasama",$id)->get();
        $param["bahan"] = $bahan->find($idbahan);
        return view('/admin/Edit/vedit')->with($param);
    }
    public function editBahan(Request $req)
    {
        $idbahan = $req->query('idbahan');
        $id = $req->query('idkerjasama');
        $bahan  = new bahan_bangunan();
        $bahan->editBahan($idbahan,$req->nmbahan,$req->hargabahan);
        return redirect("/admin/lBahan/".$id)->with(['success' => 'Berhasil Edit Bahan!']);
    }
    public function getBahan(Request $req)
    {
        $id = $req->get('value');
        $bahan = new bahan_bangunan();
        $data = $bahan->where("id_kerjasama",$id)->get();
        $select = "<option disabled selected>Pilih Nama Barang</option>";
        foreach ($data as $key => $value) {
            $select .= "<option value='".$value->id_bahan."' harga='".$value->harga_satuan."' >".$value->nama_bahan."</option>";
        }
        echo $select;
    }
    public function getSpesial(Request $req)
    {
        $id = $req->get('value');
        $spesial = new pekerjaan_khusus();
        $data = $spesial->where("kode_pekerjaan",$id)->get();
        $select = "<option disabled selected value='-'>Pilih Pekerjaan Khusus</option>";
        foreach ($data as $key => $value) {
            $select .= "<option value='".$value->kode_pk."'>".$value->keterangan_pk."</option>";
        }
        echo $select;
    }
    public function vnota()
    {
            $bukti = new bukti_pembelian_mandor();
            $toko = new toko_bangunan();
            $kodeadmin = session()->get('kode');
            $adm = new administrator();
            $pekerjaan = new pekerjaan();
            $kodekontraktor = $adm->getKodeKontraktor($kodeadmin)[0];
            $daftarpekerjaan = $pekerjaan->where('kode_admin',$kodeadmin)->where('status_delete_pekerjaan',0)->get();
            $data = $toko->where('kode_kontraktor', $kodekontraktor)->where('status_delete_tb',0)->pluck('nama_toko');
            $nama = array();
            for($i=0;$i<count($data);$i++){
                array_push($nama,$data[$i]);
            }
            $namaku = array_unique($nama);
            $kode =array();
            for($i=0;$i<count($daftarpekerjaan);$i++){
                array_push($kode,$daftarpekerjaan[$i]["kode_pekerjaan"]);
            }
            $param['listFoto'] = $bukti->whereIn('kode_pekerjaan',$kode )->where('status_input',0)
                                        ->where('status_delete_bukti',0)->get();
            $param["listToko"] = $namaku;
            $param["listPekerjaan"] = $daftarpekerjaan;
            return view('admin.pembelian_bahan')->with($param);
    }
    public function pembelianNota(Request $req)
    {
        $param["success"] = "Berhasil Tambah Nota Pembelian";
        return redirect('/admin/vpembelianNota')->with($param);
    }
}

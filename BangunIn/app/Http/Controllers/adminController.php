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
use App\memiliki_detail_pembelian;
use App\pekerjaan_khusus;
use App\pembelian;
use App\pk_memakai_bahan;
use CreateBuktiPembelianMandorsTable;

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
        $select = "<option selected value='' >Pilih Alamat Toko</option>";
        if(session()->has('idker')){
            $idker=session()->get('idker');
        }
        else{
            $idker="";
        }
        foreach ($data as $key => $value) {
            if($value->id_kerjasama==$idker){
                $select .= "<option value='".$value->id_kerjasama."' selected>".$value->alamat_toko."</option>";
            }
            else{
                $select .= "<option value='".$value->id_kerjasama."'>".$value->alamat_toko."</option>";
            }
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
        if(session()->has('idker'))
        {
            $id = session()->get('idker');
        }
        else{
            $id = $req->get('value');
        }
        $bahan = new bahan_bangunan();
        $data = $bahan->where("id_kerjasama",$id)->get();
        $d = json_encode($data);
        echo $d;
    }
    public function getSpesial(Request $req)
    {
        $id = $req->get('value');
        $spesial = new pekerjaan_khusus();
        $data = $spesial->where("kode_pekerjaan",$id)->get();
        $select = "<option selected value=''>Pilih Pekerjaan Khusus</option>";
        foreach ($data as $key => $value) {
            $select .= "<option value='".$value->kode_pk."'>".$value->keterangan_pk."</option>";
        }
        echo $select;
    }
    public function vnota()
    {
            $listBeli = [];
            if(session()->has('arraybeli')){
                $listBeli=session()->get('arraybeli');
            }
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
            $param["listBeli"] = json_encode($listBeli);
            return view('admin.pembelian_bahan')->with($param);
    }
    public function pembelianNota(Request $request)
    {
        //$param["success"] = "Berhasil Tambah Nota Pembelian";
        //return redirect('/admin/vpembelianNota')->with($param);
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'bahan'=>'required',
            'hargabahan'=>'required'
        ],
        [
            'required' => 'Harap Isi semua Field',
        ]);

        $listBeli=[];
        if(session()->has('arraybeli')){
            $listBeli=session()->get('arraybeli');
        }
        $nmtk="";$idker="";
        if(session()->has('namatoko')){
            $nmtk=session()->get('namatoko');
            $idker=session()->get('idker');
        }

        $namatoko = $request->nama;
        $idkerjasama = $request->alamat;

        if($nmtk==$namatoko && $idker==$idkerjasama){
        }
        else{
            //ganti toko, maka session dihapus
            $request->session()->forget('arraybeli');
            $listBeli=[];
        }

        $bahanbgg = new bahan_bangunan();
        $idbahan = $request->bahan;
        $nmbahan = $request->nmbahan;
        $harga = $request->hargabahan;
        $ada = $bahanbgg->where('id_kerjasama',$idkerjasama)->where('nama_bahan',$nmbahan)->count();
        if($ada<=0){
            $idbahan = $bahanbgg->addBahan($idkerjasama,$nmbahan,$harga);

        }
        $namabahan = $nmbahan;
        $jumlah = $request->jumlah;
        $diskon = $request->diskon;
        $subtotal = $request->subtotal;
        $baru = array(
            'id_bahan' => $idbahan,
            'nama_bahan'=>$namabahan,
            'jumlah_barang'=>$jumlah,
            'harga_satuan'=>$harga,
            'persen_diskon'=>$diskon,
            'subtotal'=>$subtotal
        );
        array_push($listBeli,$baru);
        session()->put('arraybeli',$listBeli);
        session()->put('namatoko',$namatoko);
        session()->put('idker',$idkerjasama);
        return redirect('/admin/vpembelianNota');

    }
    public function tabelBeli(Request $request)
    {
        $kode = $request->kodeku;
        $listBeli=[];
        if(session()->has('arraybeli')){
            $listBeli=session()->get('arraybeli');
        }
        $posisi=-1;
        for($i=0;$i<count($listBeli);$i++){
            if($listBeli[$i]['nama_bahan']==$kode){
                $posisi=$i;
            }
        }
        array_splice($listBeli,$posisi,1);
        session()->put('arraybeli',$listBeli);
        return redirect('/admin/vpembelianNota');
    }

    public function simpanPembelian(Request $req)
    {
        $listBeli = [];
        if(session()->has('arraybeli')){
            $listBeli=session()->get('arraybeli');
        }
        $kodeadmin = session()->get('kode');
        $pekerjaan  = new pekerjaan();
        $toko = new toko_bangunan();
        $bukti = new bukti_pembelian_mandor();
        $id = $req->active;
        $daftarpekerjaan = $pekerjaan->where('kode_admin',$kodeadmin)->where('status_delete_pekerjaan',0)->get();
        $param["id_foto"] = $id;
        $param["foto"] = $bukti->where('id_bukti',$id)->get();
        $param["listBeli"] = json_encode($listBeli);
        $param["listPekerjaan"] = $daftarpekerjaan;
        $param["alamat"] = $toko->where('id_kerjasama',session()->get('idker'))->pluck("alamat_toko");
        return view('admin.detail_pembelian')->with($param);
    }

    public function checkout(Request $req)
    {
        $listBeli = [];
        if(session()->has('arraybeli')){
            $listBeli=session()->get('arraybeli');
        }

        $pk = new pekerjaan_khusus();
        $pek =  new pekerjaan();
       $pembelian = new pembelian();
       $detail = new memiliki_detail_pembelian();
       $bpembelian = new bukti_pembelian_mandor();
       $pkm = new pk_memakai_bahan();
       $status = $req->status;
       $id = $req->now;
       $total = $req->vtotal;
       $pekerjaan = $req->pekerjaan;
       $spekerjaan = $req->spekerjaan;
       $tanggal_beli = $req->beli;
       $tanggal_bayar = $tanggal_beli;
       $date=date_create($tanggal_beli);

       date_add($date,date_interval_create_from_date_string("30 days"));
       $tanggal_jatuh_tempo = date_format($date,"Y-m-d");

       if($status == "bon"){
            $pembelian->PembelianBon($id,$pekerjaan,session()->get('idker'),$total,$tanggal_beli,$tanggal_jatuh_tempo);
        }
       else{
            $pembelian->PembelianLunas($id,$pekerjaan,session()->get('idker'),$total,$tanggal_beli,$tanggal_bayar);
       }

       $tipe = $pek->where('kode_pekerjaan',$id)->select('jenis_pekerjaan')->first();



       $idpembelian = $pembelian->max("id_pembelian");
       foreach ($listBeli as $key => $value) {
            $detail->insert($idpembelian,$value["id_bahan"],$value["jumlah_barang"],$value["harga_satuan"],$value["persen_diskon"],$value["subtotal"]);
       }
       $bpembelian->selesaiInput($id,$idpembelian);
       if($spekerjaan!=null){
            $pk->PembelihanBahan($spekerjaan,$total);
            $pkm->insert($id,$idpembelian);
        }
        else{
            if($tipe =='1'){
                $pek->tambahHargaDeal($pekerjaan,$total);
            }
        }
        session()->forget('arraybeli');
        session()->forget('namatoko');
        session()->forget('idker');
        session()->forget('pek');
        session()->forget('pk');
        return redirect('/admin/lihatToko')->with(["success" => "Berhasil Input Nota Pembelian!"]);
    }
    public function lNota($id)
    {
        $pembelian = new pembelian();
        $spekerjaan = new pekerjaan_khusus();
        $param["nmToko"] = toko_bangunan::where('id_kerjasama',$id)->pluck('nama_toko');
        $param["pembelian"]=$pembelian->where('id_kerjasama',$id)->get();
        $param["foto"] = $pembelian->getFoto($id);
        $param["pekerjaan"] = $pembelian->where('pembelians.id_kerjasama',$id)->join('pekerjaans as p','p.kode_pekerjaan','pembelians.kode_pekerjaan')->get();
        $param["toko"] = $pembelian->where('pembelians.id_kerjasama',$id)
                                    ->join('toko_bangunans as tb','tb.id_kerjasama','pembelians.id_kerjasama')->get();
        $param["getPK"] =$pembelian->where('pembelians.id_kerjasama',$id)
                                    ->join('pekerjaans as pp','pp.kode_pekerjaan','pembelians.kode_pekerjaan')
                                    ->join('pekerjaan_khususes','pekerjaan_khususes.kode_pekerjaan','pp.kode_pekerjaan')
                                    ->where('pekerjaan_khususes.membutuhkan_bahan', 1)
                                    ->join('pk_memakai_bahans as pk', 'pk.kode_pk', 'pekerjaan_khususes.kode_pk')
                                    ->join('pembelians as p', 'p.id_pembelian', 'pk.id_pembelian')
                                    ->get();
        $param["arrBeli"] = $pembelian->getListBahan($id);
        return view('admin.List.listnota')->with($param);
    }
    public function vnotabon()
    {
        $data=[];
        if(Cookie::has('sudahbayar')){
            $data = [
                'title' => 'Bayar Bon Bahan',
                'error' => 19
            ];
            Cookie::queue('sudahbayar','1',-10);
        }
        $pembelian = new pembelian();
        $toko = new toko_bangunan();
        $pekerjaan = new pekerjaan();
        $param["pembelian"] = $pembelian->where('status_lunas_bon_toko','0')->orderBy('tanggal_beli')->get();
        $param["toko"] = $toko->get();
        $param["pekerjaan"] = $pekerjaan->get();
        return view('admin.List.listBon',$data)->with($param);
    }
    public function detnotabeli($id)
    {
        $detailbeli = new memiliki_detail_pembelian();
        $pembelian = new pembelian();
        $pkmemakaibahan = new pk_memakai_bahan();
        $toko = new toko_bangunan();
        $pekerjaan = new pekerjaan();
        $pk = new pekerjaan_khusus();
        $bahan = new bahan_bangunan();
        $buktipembelian = new bukti_pembelian_mandor();
        $param['pembelian'] = $pembelian->where('id_pembelian',$id)->get();
        $param['detailbeli'] = $detailbeli->where('id_pembelian',$id)->get();
        $param["toko"] = $toko->get();
        $param["pekerjaan"] = $pekerjaan->get();
        $param['pk']=$pk->get();
        $param['bahan']=$bahan->get();
        $param['bukti']=$buktipembelian->get();
        $hitung = $pkmemakaibahan->where('id_pembelian',$id)->count();
        if($hitung>0){
            $param['pkmemakaibahan']=$pkmemakaibahan->where('id_pembelian',$id)->get();
        }
        else{
            $param['pkmemakaibahan']="";
        }
        return view('admin.List.detailNotaBon')->with($param);
    }
    public function pembayaranBonBahan(Request $request)
    {
        $kodepembelian = $request->kodepembelian;
        $idbukti = $request->idbukti;

        $bukti = new bukti_pembelian_mandor();
        $buktib = $request->file('foto');
        $buktibaru = $buktib->getClientOriginalName();
        $buktib->move(public_path('/assets/nota_beli/'),  $buktib->getClientOriginalName());

        $tanggal = $request->tanggal;
        $bukti->updateBukti($idbukti,$buktibaru);

        $pembelian = new pembelian();
        $pembelian->updateLunas($kodepembelian,$tanggal);

        Cookie::queue('sudahbayar','1',10);
        return redirect('/admin/vListNotaBon')->with(["success" => "Berhasil Melunasi Nota Pembelian!"]);
    }
}

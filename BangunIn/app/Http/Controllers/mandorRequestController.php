<?php

namespace App\Http\Controllers;

use App\absen_harian;
use App\bon_tukang;
use App\detail_absen;
use App\pekerjaan;
use App\pekerjaan_khusus;
use App\pembelian;
use App\tukang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class mandorRequestController extends Controller
{
    //
    public function index()
    {
        $kodemandor = session()->get('kode');
        $pekerjaan = new pekerjaan();
        $param['listPekerjaan']=$pekerjaan->where('kode_mandor',$kodemandor)->where('status_selesai',0)->get();
        return view('mandor.Creation.requestDana')->with($param);
    }
    public function querynota(Request $request)
    {
        $jumlah=0;
        $value=$request->value;
        $pekerjaan = new pekerjaan();
        $pekerjaanmandor = $pekerjaan->where('kode_pekerjaan',$value)->get();

        $arr = [];
        foreach($pekerjaanmandor as $item){
            array_push($arr,$item->kode_pekerjaan);
        }

        $pembelian = new pembelian();
        $pembelianku = $pembelian->whereIn('kode_pekerjaan',$arr)->where('status_pembayaran_oleh','1')->where('status_request_dana',0)->get();
        //dd($pembelianku);
        foreach($pembelianku as $itemku){
            $jumlah+=$itemku->total_pembelian;
        }
        echo $jumlah;
    }
    public function querybon(Request $request)
    {
        $maxbulan = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $tahun = date('Y');
        $bulan = date('m');
        $tanggal = date('d');
        $fulldate= $tahun."-".$bulan."-".$tanggal;
        $date=date_create($fulldate);
        $harike=date_format($date,"N");
        for($i = 1; $i < $harike; $i++) //1 karena hari senin
        {
            $tanggal-=1;
            if($tanggal == 0) {
                if($bulan == 1)
                { $tanggal+=31; }
                else
                { $tanggal+=$maxbulan[$bulan - 2]; }
                $bulan-=1;
            }
        }
        $tanggalawal = date_create($tahun."-".$bulan."-".$tanggal);
        $tukang = new tukang();
        $mytukang = $tukang->where('kode_mandor',session()->get('kode'))->get();
        $arrtukang=[];
        foreach($mytukang as $itemt){
            array_push($arrtukang,$itemt->kode_tukang);
        }
        $bon = new bon_tukang();
        $mybon = $bon->whereIn('kode_tukang',$arrtukang)->whereDate('tanggal_pengajuan',">=",$tanggalawal)->get();
        $jumlah=0;
        foreach($mybon as $itemku){
            $jumlah+=$itemku->jumlah_bon;
        }
        echo $jumlah;
    }
    public function querypkall(Request $request)
    {
        $value=$request->value;
        $pekerjaan = new pekerjaan();
        $pekerjaanmandor = $pekerjaan->where('kode_pekerjaan',$value)->get();
        $pekerjaankhusus = new pekerjaan_khusus();
        $mypk = $pekerjaankhusus->whereIn('kode_pekerjaan',$pekerjaanmandor)
                                ->get();
        $arrpk=[];
        foreach($mypk as $itempk){
            if($itempk->status_selesai==0 && $itempk->id_detail_permintaan_uang==null){
                array_push($arrpk,$itempk);
            }
        }

        $kalimat="";
        foreach($mypk as $pk){
            $kalimat.="<input type='checkbox' name='pk' onclick='ganti();' checked value='$pk->kode_pk'>$pk->keterangan_pk.<br>";
        }
        echo $kalimat;
    }
    public function querypkalls(Request $request)
    {
        $value=$request->value;
        $pekerjaan = new pekerjaan();
        $pekerjaanmandor = $pekerjaan->where('kode_pekerjaan',$value)->get();
        $pekerjaankhusus = new pekerjaan_khusus();
        $mypk = $pekerjaankhusus->whereIn('kode_pekerjaan',$pekerjaanmandor)
                                ->get();
        $arrpk=[];
        foreach($mypk as $itempk){
            if($itempk->status_selesai==0 && $itempk->id_detail_permintaan_uang==null){
                array_push($arrpk,$itempk);
            }
        }
        //echo count($arrpk);
        $jumlah=0;
        foreach($arrpk as $item){
            $jumlah+=$item->total_jasa;
        }
        echo $jumlah;
    }
    public function hitungpk(Request $request)
    {
        //echo 12;
        $pk=[];
        $pk=$request->pktake;
        if($pk==null){
            echo 0;
        }
        else{
            $jumlah=0;
            $pekerjaankhusus=new pekerjaan_khusus();
            $ambilpk = $pekerjaankhusus->whereIn('kode_pk',$pk)->get();
            foreach($ambilpk as $item){
                $jumlah+=$item->total_jasa;
            }
            echo $jumlah;
        }
    }
    public function querygaji(Request $request)
    {
        $kode_pekerjaan=$request->value;
        $maxbulan = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        $tahun = date('Y');
        $bulan = date('m');
        $tanggal = date('d');
        $fulldate= $tahun."-".$bulan."-".$tanggal;
        $date=date_create($fulldate);
        $harike=date_format($date,"N");
        for($i = 1; $i < $harike; $i++) //1 karena hari senin
        {
            $tanggal-=1;
            if($tanggal == 0) {
                if($bulan == 1)
                { $tanggal+=31; }
                else
                { $tanggal+=$maxbulan[$bulan - 2]; }
                $bulan-=1;
            }
        }
        $tanggalawal = date_create($tahun."-".$bulan."-".$tanggal);

        $absenharian = new absen_harian();
        $absenharianku = $absenharian->where('kode_pekerjaan',$kode_pekerjaan)->whereDate('tanggal_absen',">=",$tanggalawal)->get();

        $arrabsen = [];
        foreach($absenharianku as $item){
            array_push($arrabsen,$item->kode_absen_harians);
        }
        $detailabsen = new detail_absen();
        $mydet = $detailabsen->whereIn('kode_absen_harians',$arrabsen)->get();

        $tukang = new tukang();
        $listTukang = $tukang->all();

        $jumlah=0;
        foreach($mydet as $item){
            $jumlah+=$item->ongkos_lembur;
            foreach($listTukang as $tkg){
                if($tkg->kode_tukang == $item->kode_tukang){
                    $jumlah+=$tkg->gaji_pokok_tukang;
                }
            }
        }

        echo $jumlah;
    }
}

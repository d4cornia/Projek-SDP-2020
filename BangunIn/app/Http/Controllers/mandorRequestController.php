<?php

namespace App\Http\Controllers;

use App\absen_harian;
use App\bon_tukang;
use App\detail_absen;
use App\detail_permintaan_uang;
use App\mandor;
use App\pekerjaan;
use App\pekerjaan_khusus;
use App\pembelian;
use App\permintaan_uang;
use App\Rules\CekMaksimalRequest;
use App\tukang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;

class mandorRequestController extends Controller
{
    //
    public function index()
    {
        $tanggal = date('Y-m-d');
        $permintaanuang = new permintaan_uang();
        $mypermintaan = $permintaanuang->whereDate('tanggal_permintaan_uang','=',$tanggal)->get();
        //dd(count($mypermintaan));
        if(count($mypermintaan)==0){
            $arrreqdana=[];
            if(session()->has('reqdana')){
                $arrreqdana=session()->get('reqdana');
            }
            $kodemandor = session()->get('kode');
            $pekerjaan = new pekerjaan();
            $pekerjaankhusus = new pekerjaan_khusus();
            if(Cookie::has('berhasilreq')){
                echo "<script>alert('Request Dana Berhasil');</script>";
                $data=[
                    'listPk'=>$pekerjaankhusus->get(),
                    'listReq'=>$arrreqdana,
                    'listPekerjaan'=>$pekerjaan->where('kode_mandor',$kodemandor)->where('status_selesai',0)->get(),
                ];
                Cookie::queue('berhasilreq',"",-10);
            }
            else{
                $data=[
                    'listPk'=>$pekerjaankhusus->get(),
                    'listReq'=>$arrreqdana,
                    'listPekerjaan'=>$pekerjaan->where('kode_mandor',$kodemandor)->where('status_selesai',0)->get()
                ];
            }

            return view('mandor.Creation.requestDana',$data);
        }
        else{
            return view('mandor.Creation.tidakbolehrequest');
        }
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
        foreach($arrpk as $pk){
            $kalimat.="<input type='checkbox' name='pk[]' onclick='ganti();' checked value='$pk->kode_pk'>$pk->keterangan_pk.<br>";
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
        //echo $tahun."-".$bulan."-".$tanggal;
        $absenharian = new absen_harian();
        $absenharianku = $absenharian->where('kode_pekerjaan',$kode_pekerjaan)->get();


        $arrabsen = [];
        foreach($absenharianku as $item){
            $tanggal = $item->tanggal_absen;
            $arrxplode = explode("-",$tanggal);
            $tanggals=$arrxplode[0];
            $bulans=$arrxplode[1];
            $tahuns=$arrxplode[2];
            $date = date_create($tahuns."-".$bulans."-".$tanggals);
            if($date>=$tanggalawal){
                array_push($arrabsen,$item->kode_absen_harians);
            }
        }
        //echo count($arrabsen);

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

    public function tambahRequestDana(Request $request)
    {
        $kodepek = $request->pekerjaan;
        //dd($kodepek);
        $pktake=$request->pk;
        $totalpk = $request->pkh;
        $nota = $request->nota;
        $gaji = $request->gaji;
        $subtotal = $totalpk+$nota+$gaji;

        $arrayrequestdana=[];
        if(session()->has('reqdana')){
            $arrayrequestdana=session()->get('reqdana');
        }

        $ada=0;
        foreach($arrayrequestdana as $item){
            if($item["kodepek"]==$kodepek){
                $ada=1;
            }
        }

        //dd($ada);
        if($ada==0){
            $baru = array(
                "kodepek"=>$kodepek,
                "pekerjaankhusus"=>$pktake,
                "totalpk"=>$totalpk,
                "totalnota"=>$nota,
                "totalgaji"=>$gaji,
                "subtotal"=>$subtotal
            );
            array_push($arrayrequestdana,$baru);
            session()->put('reqdana',$arrayrequestdana);
        }
        else{
            //yg lama dihapus dulu
            $kode=$kodepek;
            //dd($kode);
            $posisi=0;
            $arrreq = [];
            if(session()->has("reqdana")){
                $arrreq=session()->get('reqdana');
            }
            $counter=0;
            foreach($arrreq as $items){
                if($items["kodepek"]==$kode){
                    $posisi=$counter;
                }
                $counter++;
            }
            //dd($posisi);
            array_splice($arrreq,$posisi,1);

            $kodepek = $request->pekerjaan;
            //dd($kodepek);
            $pktake=$request->pk;
            $totalpk = $request->pkh;
            $nota = $request->nota;
            $gaji = $request->gaji;
            $subtotal=$totalpk+$nota+$gaji;

            $baru = array(
                "kodepek"=>$kodepek,
                "pekerjaankhusus"=>$pktake,
                "totalpk"=>$totalpk,
                "totalnota"=>$nota,
                "totalgaji"=>$gaji,
                "subtotal"=>$subtotal
            );
            array_push($arrreq,$baru);

            session()->put('reqdana',$arrreq);
        }
        return redirect('/mandor/requestDana');
    }
    public function batalReq($id)
    {
        //session()->forget('reqdana');
        $kode=$id;
        //dd($kode);
        $posisi=0;
        $arrreq = [];
        if(session()->has("reqdana")){
            $arrreq=session()->get('reqdana');
        }
        $counter=0;
        foreach($arrreq as $items){
            if($items["kodepek"]==$kode){
                $posisi=$counter;
            }
            $counter++;
        }
        //dd($posisi);
        array_splice($arrreq,$posisi,1);
        session()->put('reqdana',$arrreq);
        return redirect('/mandor/requestDana');
    }
    public function hitungtotal(Request $request)
    {
        //hitungbon
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
        $jumlahbon=$jumlah;

        //hitungsubtotal
        $arrdana=[];
        if(session()->has('reqdana')){
            $arrdana = session()->get('reqdana');
        }
        $jumlah=0;
        foreach($arrdana as $arr){
            $jumlah+=$arr["subtotal"];
        }
        $jumlahfull=$jumlah+$jumlahbon;
        echo $jumlahfull;
    }
    public function simpanReqDana(Request $request)
    {
        $kode_mandor = session()->get('kode');
        $tanggal_permintaan_uang=date('Y-m-d');
        $totalkeseluruhan = $request->totalsistem;
        $total_bon = $request->bon;
        $total_detail=$totalkeseluruhan-$total_bon;
        $total_sistem=$totalkeseluruhan;
        $real_total=$request->totalrequest;
        $keterangan=$request->keterangan;
        $request->validate(
            [
                'totalrequest'=>[new CekMaksimalRequest($total_sistem)]
            ]
        );

        //insertheader
        $permintaanuang = new permintaan_uang();
        $permintaanuang->insertheader($kode_mandor,$tanggal_permintaan_uang,$total_detail,$total_bon,$total_sistem,$real_total,$keterangan);

        $kodemax = $permintaanuang->getMaxKode();
        //insertdetail
        $arrdana=[];
        if(session()->has('reqdana')){
            $arrdana=session()->get('reqdana');
        }

        foreach($arrdana as $item){
            $det = new detail_permintaan_uang();
            $kodepekerjaan=$item["kodepek"];
            $totalnota=$item["totalnota"];
            $totalgaji=$item["totalgaji"];
            $totalpk=$item["totalpk"];
            $subtotal=$item["subtotal"];
            $pk=$item["pekerjaankhusus"];
            $det->insertdetail($kodemax,$kodepekerjaan,$totalnota,$totalgaji,$totalpk,$subtotal,$pk);

            $pembelian = new pembelian();
            $mypembelian = $pembelian->where('kode_pekerjaan',$kodepekerjaan)->where('status_pembayaran_oleh','1')
                            ->where('status_request_dana',0)->get();
            foreach($mypembelian as $beli){
                $beli->status_request_dana=1;
                $beli->save();
            }
        }
        //hapus session
        session()->forget('reqdana');
        //return redirect
        Cookie::queue('berhasilreq',"0",10);
        return redirect('/mandor/requestDana');
    }

    public function listReqDana()
    {
        $permintaanuang = new permintaan_uang();
        $kode_mandor = session()->get('kode');
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
        $param['listReq'] = $permintaanuang->whereDate('tanggal_permintaan_uang','>=',$tanggalawal)->where('kode_mandor',$kode_mandor)->get();

        return view('mandor.List.ReqDana')->with($param);
    }

    public function detailrequest($id)
    {
        $mandor = new mandor();
        $kode = session()->get('kode');

        $namamandor = $mandor->where('kode_mandor',$kode)->get()[0]->nama_mandor;



        $permintaanuang = new permintaan_uang();
        $param['header']=$permintaanuang->where('id_permintaan_uang',$id)->get()[0];

        $detreq = new detail_permintaan_uang();
        $param['detail']=$detreq->where('id_permintaan_uang',$id)->get();
        $param['nama']=$namamandor;

        $pekerjaan = new pekerjaan();
        $param['pekerjaan']=$pekerjaan->get();

        $permintaancekbon = $permintaanuang->where('kode_mandor',$kode)->get();
        $totalbon =0;
        $selisih =0;
        foreach($permintaancekbon as $item){
            $totalbon+=$item->total_bon;
            $selisih+=$item->total_sistem-$item->real_total;
        }
        $sisa=$totalbon-$selisih;
        $param['sisa']=$sisa;

        $pekerjaankhusus = new pekerjaan_khusus();
        $param['pekerjaan_khusus']=$pekerjaankhusus->get();
        return view('mandor.Detail.detailRequestUang')->with($param);
    }
}

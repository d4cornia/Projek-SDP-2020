<?php

namespace App\Http\Controllers;

use App\detail_permintaan_uang;
use App\mandor;
use App\pekerjaan;
use App\pekerjaan_khusus;
use App\permintaan_uang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class kontraktorKonfirmDanaController extends Controller
{
    //
    public function index()
    {
        $mandor = new mandor();
        $kode_kontraktor = session()->get('kode');
        $pilmandor = $mandor->where('kode_kontraktor',$kode_kontraktor)->get();

        $arrMandor = [];
        foreach($pilmandor as $item){
            array_push($arrMandor,$item->kode_mandor);
        }

        $permintaandana = new permintaan_uang();
        $mypermintaan = $permintaandana->whereIn('kode_mandor',$arrMandor)->where('konfirmasi_kontraktor_telah_transfer',0)->get();

        $param['listReq']=$mypermintaan;
        $param['listMandor']=$pilmandor;
        return view('kontraktor.List.listRequestDana')->with($param);
    }

    public function konfirmasiReq($id)
    {
        $permintaanuang = new permintaan_uang();
        $headers = $permintaanuang->where('id_permintaan_uang',$id)->get()[0];
        $param['header']=$permintaanuang->where('id_permintaan_uang',$id)->get()[0];

        $mandor = new mandor();
        $kode = $headers->kode_mandor;
        $namamandor = $mandor->where('kode_mandor',$kode)->get()[0]->nama_mandor;

        $permintaancekbon = $permintaanuang->where('kode_mandor',$kode)->get();
        $totalbon =0;
        $selisih =0;
        foreach($permintaancekbon as $item){
            $totalbon+=$item->total_bon;
            $selisih+=$item->total_sistem-$item->real_total;
        }
        $sisa=$totalbon-$selisih;
        $param['sisa']=$sisa;


        $detreq = new detail_permintaan_uang();
        $param['detail']=$detreq->where('id_permintaan_uang',$id)->get();
        $param['nama']=$namamandor;

        $pekerjaan = new pekerjaan();
        $param['pekerjaan']=$pekerjaan->get();

        $pekerjaankhusus = new pekerjaan_khusus();
        $param['pekerjaan_khusus']=$pekerjaankhusus->get();
        return view('kontraktor.Detail.detailRequestDana')->with($param);
    }
    public function bayar(Request $request)
    {
        $idheader = $request->idheader;
        $permintaanuang = new permintaan_uang();
        $mypermintaan = $permintaanuang->where('id_permintaan_uang',$idheader)->get()[0];
        $buktib = $request->file('foto');
        $buktibaru = $buktib->getClientOriginalName();
        $buktib->move(public_path('/assets/buktikontraktor/'),  $buktib->getClientOriginalName());

        $mypermintaan->konfirmasi_kontraktor_telah_transfer=1;
        $mypermintaan->bukti_trf_req=$buktibaru;
        $mypermintaan->save();
        return redirect('/kontraktor/lihatRequest')->with(["success" => "Berhasil Melunasi Nota Pembelian!"]);
    }
}

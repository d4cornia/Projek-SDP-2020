<?php

namespace App\Http\Controllers;

use App\absen_harian;
use App\absen_tukang;
use App\bon_tukang;
use App\client;
use App\detail_absen;
use App\kontraktor;
use App\mandor;
use App\memiliki_detail_bon;
use App\pekerjaan;
use App\pekerjaan_khusus;
use App\pembayaran_bon_tukang;
use App\pembayaran_client;
use App\permintaan_uang;
use App\pk_dana;
use App\Rules\cbRequired;
use App\tukang;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\Snappy\Facades\SnappyPdf as sPDF;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class reportController extends Controller
{
    public function rPekerjaan($kode_pekerjaan)
    {
        $work = null;
        $spWork = null;
        $pk = new pekerjaan_khusus();
        $p = new pekerjaan();

        $work = $p->find($kode_pekerjaan);
        if ($pk->where('kode_pekerjaan', $kode_pekerjaan)->exists()) {
            $spWork = $pk->where('kode_pekerjaan', $kode_pekerjaan)->get();
        }
        // dd($spWork[1]->bahans[0]->pembelian->detail[0]->bhn->nama_bahan);
        $data = [
            'spWork' => $spWork,
            'work' => $work
        ];

        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML('<h1>Test</h1>');
        $pdf = PDF::loadView('kontraktor.Report.report_pekerjaan_khusus', $data);
        return $pdf->stream();
        // return view('kontraktor.Report.report_pekerjaan_khusus', $data);
    }

    public function indexPeriode()
    {
        return view('kontraktor.Report.index_periode');
    }

    public function searchPeriode(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'mode' => [new cbRequired]
        ]);

        if ($validator->fails()) {
            return redirect('/report/iPeriode')
                ->withErrors($validator)
                ->withInput();
        }
        $fday = intval(date('d', strtotime($req->periodeAwal)));
        $fmonth = intval(date('m', strtotime($req->periodeAwal)));
        $fyear = intval(date('Y', strtotime($req->periodeAwal)));
        $eday = intval(date('d', strtotime($req->periodeAkhir)));
        $emonth = intval(date('m', strtotime($req->periodeAkhir)));
        $eyear = intval(date('Y', strtotime($req->periodeAkhir)));
        if ($eyear >= $fyear && $emonth >= $fmonth && $eday >= $fday) {
            if ($req->mode == "all_proyek") {
                return redirect('/report/iuangKeseluruhan/' . $req->periodeAwal . '/' . $req->periodeAkhir);
            } else if ($req->mode == "req_mandor") {
                return redirect('/report/budgetMandor/' . $req->periodeAwal . '/' . $req->periodeAkhir);
            } else if ($req->mode == "gaji_tukang") {
                return redirect('/report/gajiAllTukang/' . $req->periodeAwal . '/' . $req->periodeAkhir);
            }
        }
        session()->put('err', 'Tanggal awal tidak boleh melebihi tanggal akhir!');
        return view('kontraktor.Report.index_periode');
    }

    public function gajiAllTukang($tglAwal, $tglAkhir)
    {
        $m = new mandor();
        $ab = new absen_harian();

        $temp = $ab->orderBy('tanggal_absen', 'asc')->get();
        $fday = intval(date('d', strtotime($tglAwal)));
        $fmonth = intval(date('m', strtotime($tglAwal)));
        $fyear = intval(date('Y', strtotime($tglAwal)));
        $eday = intval(date('d', strtotime($tglAkhir)));
        $emonth = intval(date('m', strtotime($tglAkhir)));
        $eyear = intval(date('Y', strtotime($tglAkhir)));
        $header = null;
        if ($temp !== null) {
            foreach ($temp as $item) {
                $tglHari = intval(date('d', strtotime($item['tanggal_absen'])));
                $tglBulan = intval(date('m', strtotime($item['tanggal_absen'])));
                $tglTahun = intval(date('Y', strtotime($item['tanggal_absen'])));
                // dd($tglHari);
                if (
                    $tglTahun >= $fyear && $tglTahun <= $eyear
                    && $tglBulan >= $fmonth && $tglBulan <= $emonth
                    && $tglHari >= $fday && $tglHari <= $eday
                ) {
                    $header[] = $item;
                }
            }
        }

        $data = [
            'mans' => $m->where('kode_kontraktor', session()->get('kode'))->get(),
            'header' => $header,
            'tglAwal' => date('Y/m/d', strtotime($tglAwal)),
            'tglAkhir' => date('Y/m/d', strtotime($tglAkhir))
        ];
        // dd($data);
        $pdf = PDF::loadView('kontraktor.Report.report_all_gaji_tukang', $data);
        return $pdf->stream();
    }

    public function rBudgetingMandor($tglAwal, $tglAkhir)
    {
        $m = new mandor();
        $pu = new permintaan_uang();
        $mandors = $m->where('kode_kontraktor', session()->get('kode'))->get();
        $req = null;

        $temp = $pu->orderBy('tanggal_permintaan_uang', 'asc')->get();
        $fday = intval(date('d', strtotime($tglAwal)));
        $fmonth = intval(date('m', strtotime($tglAwal)));
        $fyear = intval(date('Y', strtotime($tglAwal)));
        $eday = intval(date('d', strtotime($tglAkhir)));
        $emonth = intval(date('m', strtotime($tglAkhir)));
        $eyear = intval(date('Y', strtotime($tglAkhir)));
        if ($temp !== null) {
            foreach ($temp as $item) {
                $tglHari = intval(date('d', strtotime($item['tanggal_permintaan_uang'])));
                $tglBulan = intval(date('m', strtotime($item['tanggal_permintaan_uang'])));
                $tglTahun = intval(date('Y', strtotime($item['tanggal_permintaan_uang'])));
                if (
                    $tglTahun >= $fyear && $tglTahun <= $eyear
                    && $tglBulan >= $fmonth && $tglBulan <= $emonth
                    && $tglHari >= $fday && $tglHari <= $eday
                ) {
                    $req[] = $item;
                }
            }
        }

        $data = [
            'mans' => $mandors,
            'req' => $req,
            'tglAwal' => date('Y/m/d', strtotime($tglAwal)),
            'tglAkhir' => date('Y/m/d', strtotime($tglAkhir))
        ];
        // dd($data);

        $pdf = PDF::loadView('kontraktor.Report.report_request_dana_mandor', $data);
        return $pdf->stream();
        // return view('kontraktor.Report.report_request_dana_mandor', $data);
    }

    public function uangKeseluruhanProyek($tglAwal, $tglAkhir)
    {
        $p = new pekerjaan();
        $ab = new absen_harian();
        $work = $p->where('kode_kontraktor', session()->get('kode'))->get();
        //     // $temp = $m->find($w->kode_mandor)->get()->first();
        //     // if ($ab->where('kode_pekerjaan', $w->kode_pekerjaan)
        //     //     ->orderBy('tanggal_absen', 'asc')
        //     //     ->exists()
        //     // ) {
        //     //     $firstAbsen = $ab->where('kode_pekerjaan', $w->kode_pekerjaan)
        //     //         ->orderBy('tanggal_absen', 'asc')
        //     //         ->get()->first();

        //     //     $fd = new DateTime(date('Y/m/d', strtotime("today")));
        //     //     $tgla = new DateTime(date('Y/m/d', strtotime($firstAbsen['tanggal_absen'])));
        //     //     // dd($tgla);
        //     //     // dd((int)($fd->diff($tgla)->days / 7));

        //     //     $total = 0;
        //     //     $bahan = 0;
        //     //     $pk = 0;
        //     //     $tp = 0;

        //     //     if ($temp->tukangs !== null && count($temp->tukangs) > 0) {
        //     //         foreach ($temp->tukangs as $item) {
        //     //             $ctr = 0;
        //     //             $lembur = 0;
        //     //             $header = $ab->where('kode_pekerjaan', $w->kode_pekerjaan)->get(); // header per hari
        //     //             if ($header !== null) {
        //     //                 foreach ($header as $h) {
        //     //                     if ($h->details !== null) {
        //     //                         foreach ($h->details as $d) {
        //     //                             if ($d->kode_tukang == $item['kode_tukang']) {
        //     //                                 if ($d->buktiAbsen->konfirmasi_absen == '1') {
        //     //                                     $ctr++;
        //     //                                     $lembur += $d->ongkos_lembur;
        //     //                                 }
        //     //                             }
        //     //                         }
        //     //                     }
        //     //                 }
        //     //             }

        //     //             $total += ($ctr * $item['gaji_pokok_tukang']) + $lembur;
        //     //         }
        //     //     }

        $data = [
            'work' => $work,
            'tglAwal' => date('Y/m/d', strtotime($tglAwal)),
            'tglAkhir' => date('Y/m/d', strtotime($tglAkhir))
        ];
        $pdf = PDF::loadView('kontraktor.Report.report_uang_keseluruhan_proyek', $data);
        return $pdf->stream();
    }

    public function indexBuktiPembayaran()
    {
        $allPekerjaan = pekerjaan::all();
        return view('kontraktor.Report.index_bukti_pembayaran', ['listPekerjaan' => $allPekerjaan]);
    }

    public function searchPembayaran(Request $request)
    {
        $work = $request->input('work');
        $w = new pekerjaan();
        $tmp = $w->find($work);
        $data = [
            'pembayaranPekerjaan' => $tmp
        ];

        $pdf = PDF::loadView('kontraktor.Report.report_bukti_pembayaran', $data);
        return $pdf->stream();
    }

    public function reportPembelian(Request $req)
    {
        $id = $req->id_project;

        if($req->jenis=="all"){

            $start="1000-1-1";
            $end = "9000-1-1";
        }
        else{
            $start=$req->start;
            $end = $req->end;
        }
        $param["toko"] =  DB::table('pembelians as p')->where('p.kode_pekerjaan', $id)
            ->join("toko_bangunans as t", "t.id_kerjasama", "p.id_kerjasama")
            ->whereBetween('p.tanggal_beli',[$start,$end])
            ->orderBy('p.tanggal_beli')
            ->get();

        $param["data"] = DB::table('memiliki_detail_pembelians as md')
            ->join("pembelians as p", "md.id_pembelian", "p.id_pembelian")
            ->where('p.kode_pekerjaan', $id)
            ->join("toko_bangunans as t", "t.id_kerjasama", "p.id_kerjasama")
            ->join("bahan_bangunans as b", "b.id_bahan", "md.id_bahan")
            ->whereBetween('p.tanggal_beli',[$start,$end])
            ->orderBy('p.tanggal_beli')
            ->get();
        $pdf = PDF::loadView('kontraktor.Report.report_pembelian_bahan', $param);
        return $pdf->stream();
    }
    public function indexPembelian()
    {
        $p = new pekerjaan();
        $data = [
            'work' => $p->where('kode_kontraktor', session()->get('kode'))->get()
        ];
        return view('kontraktor.Report.index_report_pembelian_bahan', $data);
    }
}

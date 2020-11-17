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

    public function rBudgetingMandor()
    {
        $m = new mandor();
        $pu = new permintaan_uang();
        $mandors = $m->where('kode_kontraktor', session()->get('kode'))->get();
        $req = null;

        $temp = $pu->orderBy('tanggal_permintaan_uang', 'asc')->get();
        $firstday = date('d/m/Y', strtotime("monday -1 week"));
        $fd = new DateTime(date('Y/m/d', strtotime("monday -1 week")));
        if ($temp !== null) {
            foreach ($temp as $item) {
                $tgl = date_create($item['tanggal_permintaan_uang']);
                $tgla = new DateTime(date('Y/m/d', strtotime($item['tanggal_permintaan_uang'])));
                // dd($fd);
                if ($fd->diff($tgla)->days < 7 && (intval(date_format($tgl, 'd-m-Y')) - intval($firstday)) >= 0) {
                    $req[] = $item;
                }
            }
        }

        $data = [
            'mans' => $mandors,
            'req' => $req
        ];
        // dd($data);

        $pdf = PDF::loadView('kontraktor.Report.report_request_dana_mandor', $data);
        return $pdf->stream();
        // return view('kontraktor.Report.report_request_dana_mandor', $data);
    }

    public function indexKeseluruhan()
    {
        $p = new pekerjaan();
        $data = [
            'work' => $p->where('kode_kontraktor', session()->get('kode'))->get()
        ];
        return view('kontraktor.Report.index_report_uang_keseluruhan', $data);
    }

    public function uangKeseluruhanProyek(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'work' => [new cbRequired]
        ]);

        if ($validator->fails()) {
            return redirect('/report/iuangKeseluruhan')
                ->withErrors($validator)
                ->withInput();
        }

        $p = new pekerjaan();
        $m = new mandor();
        $ab = new absen_harian();
        $work = $p->where('kode_pekerjaan', $req->work)->get()->first();
        $temp = $m->find($work->kode_mandor)->get()->first();
        if ($ab->where('kode_pekerjaan', $req->work)
            ->orderBy('tanggal_absen', 'asc')
            ->exists()
        ) {
            $firstAbsen = $ab->where('kode_pekerjaan', $req->work)
                ->orderBy('tanggal_absen', 'asc')
                ->get()->first();

            $fd = new DateTime(date('Y/m/d', strtotime("today")));
            $tgla = new DateTime(date('Y/m/d', strtotime($firstAbsen['tanggal_absen'])));
            // dd($tgla);
            // dd((int)($fd->diff($tgla)->days / 7));

            $total = 0;
            $bahan = 0;
            $pk = 0;
            $tp = 0;

            if ($temp->tukangs !== null && count($temp->tukangs) > 0) {
                foreach ($temp->tukangs as $item) {
                    $ctr = 0;
                    $lembur = 0;
                    $header = $ab->where('kode_pekerjaan', $req->work)->get(); // header per hari
                    if ($header !== null) {
                        foreach ($header as $h) {
                            if ($h->details !== null) {
                                foreach ($h->details as $d) {
                                    if ($d->kode_tukang == $item['kode_tukang']) {
                                        if ($d->buktiAbsen->konfirmasi_absen == '1') {
                                            $ctr++;
                                            $lembur += $d->ongkos_lembur;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $total += ($ctr * $item['gaji_pokok_tukang']) + $lembur;
                }
            }

            if ($work->pk !== null) {
                foreach ($work->pk as $item) {
                    $pk += $item['total_keseluruhan'];
                }
            }

            if ($work->pembelian !== null) {
                foreach ($work->pembelian as $item) {
                    $bahan += $item['total_pembelian'];
                }
            }

            // total pembayaran client
            if ($work->pc !== null) {
                foreach ($work->pc as $item) {
                    $tp += $item['jumlah_pembayaran_client'];
                }
            }

            $data = [
                'work' => $work,
                'tukang' => $total,
                'minggu' => ((int)($fd->diff($tgla)->days / 7)),
                'hari' => (($fd->diff($tgla)->days % 7)),
                'bahan' => $bahan,
                'pk' => $pk,
                'total_pembayaran' => $tp
            ];

            $pdf = PDF::loadView('kontraktor.Report.report_uang_keseluruhan_proyek', $data);
            return $pdf->stream();
        }

        session()->put('err', 'Belum ada absen!');
        return redirect('/kontraktor');
    }

    public function gajiAllTukang()
    {
        $m = new mandor();
        $ab = new absen_harian();

        $temp = $ab->orderBy('tanggal_absen', 'asc')->get();
        $firstday = date('d/m/Y', strtotime("monday -1 week"));
        $fd = new DateTime(date('Y/m/d', strtotime("monday -1 week")));
        $header = null;
        if ($temp !== null) {
            foreach ($temp as $item) {
                $tgl = date_create($item['tanggal_absen']);
                $tgla = new DateTime(date('Y/m/d', strtotime($item['tanggal_absen'])));
                if ($fd->diff($tgla)->days < 7 && (intval(date_format($tgl, 'd-m-Y')) - intval($firstday)) >= 0) {
                    $header[] = $item;
                }
            }
        }

        $data = [
            'mans' => $m->where('kode_kontraktor', session()->get('kode'))->get(),
            'header' => $header
        ];
        // dd($data);
        $pdf = PDF::loadView('kontraktor.Report.report_all_gaji_tukang', $data);
        return $pdf->stream();
        // return view('kontraktor.Report.report_all_gaji_tukang', $data);
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
        /*
            SELECT t.nama_toko,p.tanggal_beli,b.nama_bahan,b.harga_satuan,md.jumlah_barang,md.subtotal,p.total_pembelian FROM `memiliki_detail_pembelians` as md
            join pembelians as p on p.id_pembelian = md.id_pembelian
            join toko_bangunans as t on t.id_kerjasama = p.id_kerjasama
            join bahan_bangunans as b  on md.id_bahan = b.id_bahan
        */

        $param["toko"] =  DB::table('pembelians as p')->where('p.kode_pekerjaan',$id)
                    ->join("toko_bangunans as t","t.id_kerjasama","p.id_kerjasama")
                    ->get();

        $param["data"] = DB::table('memiliki_detail_pembelians as md')
        ->join("pembelians as p","md.id_pembelian","p.id_pembelian")
        ->where('p.kode_pekerjaan',$id)
        ->join("toko_bangunans as t","t.id_kerjasama","p.id_kerjasama")
        ->join("bahan_bangunans as b","b.id_bahan","md.id_bahan")
        ->get();
        $pdf = PDF::loadView('kontraktor.Report.report_pembelian_bahan', $param);
        return $pdf->stream();
        //return view('kontraktor.Report.report_pembelian_bahan')->with($param);
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

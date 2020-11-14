<?php

namespace App\Http\Controllers;

use App\kontraktor;
use App\mandor;
use App\pekerjaan;
use App\pekerjaan_khusus;
use App\permintaan_uang;
use DateTime;
use Illuminate\Http\Request;
use PDF;

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
        // $pdf = PDF::loadview('kontraktor.Report.report_pekerjaan_khusus', $data);
        // return $pdf->download('pekerjaan_' . $work->nama_pekerjaan . '.pdf');
        return view('kontraktor.Report.report_pekerjaan_khusus', $data);
    }

    public function rBudgetingMandor()
    {
        $m = new mandor();
        $pu = new permintaan_uang();
        $mandors = $m->where('kode_kontraktor', session()->get('kode'))->get();
        $req = null;

        $temp = $pu->orderBy('tanggal_permintaan_uang', 'asc')->get();
        $firstday = date('d/m/Y', strtotime("sunday -1 week"));
        $fd = new DateTime(date('Y/m/d', strtotime("sunday -1 week")));
        if ($temp !== null) {
            foreach ($temp as $item) {
                $tgl = date_create($item['tanggal_permintaan_uang']);
                $tgla = new DateTime(date('Y/m/d', strtotime($item['tanggal_permintaan_uang'])));
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
        return view('kontraktor.Report.report_request_dana_mandor', $data);
    }

    public function uangKeseluruhanProyek()
    {
        $data = [];
        return view('kontraktor.Report.report_uang_keseluruhan_proyek', $data);
    }
}

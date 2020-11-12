<?php

namespace App\Http\Controllers;

use App\kontraktor;
use App\pekerjaan;
use App\pekerjaan_khusus;
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

    public function rBudgetingMandor($kode)
    {
        # code...
    }
}

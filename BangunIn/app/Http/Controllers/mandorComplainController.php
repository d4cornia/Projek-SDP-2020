<?php

namespace App\Http\Controllers;

use App\absen_tukang;
use App\pekerjaan;
use Illuminate\Http\Request;

class mandorComplainController extends Controller
{
    public function indexComplain()
    {
        $a = new absen_tukang();
        $p = new pekerjaan();
        $data = [
            'title' => 'Komplain',
            'listComp' => $a->getAllComplain(),
            'listWork' => $p->getAllWork()
        ];
        return view('mandor.List.listComplain', $data);
    }

    public function accComplain(Request $req)
    {
        $a = new absen_tukang();
        $a->accComp($req);
        return redirect('/mandor/complain');
    }

    public function decComplain($kode_absen)
    {
        $a = new absen_tukang();
        $a->decComp($kode_absen);
        return redirect('/mandor/complain');
    }
}

<?php

namespace App\Http\Controllers;

use App\absen_tukang;
use Illuminate\Http\Request;

class mandorComplainController extends Controller
{
    public function indexComplain()
    {
        $a = new absen_tukang();
        $data = [
            'title' => 'Komplain',
            'listComp' => $a->getAllComplain()
        ];
        dd($data);
        return view('listComplain', $data);
    }

    public function accComplain($kode_absen)
    {
        $a = new absen_tukang();
        return redirect('/mandor/listComp');
    }

    public function decComplain($kode_absen)
    {
        $a = new absen_tukang();
        return redirect('/mandor/listComp');
    }
}

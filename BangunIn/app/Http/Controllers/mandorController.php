<?php

namespace App\Http\Controllers;

use App\jenis_tukang;
use Illuminate\Http\Request;

class mandorController extends Controller
{
    public function index()
    {
        return view('mandor.navbar');
    }

    //jenistukang
    public function tambahJenisTukang()
    {
        return view("mandor.Creation.tambahJenisTukang", ['title' => 'Tambah Jenis Tukang']);
    }

    public function storeJenisTukang(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha',
            'gaji' => 'required|numeric',
        ]);
        $jt = new jenis_tukang();
        $data = [
            'title' => 'Tambah Jenis Tukang',
            'error' => 0
        ];
        if ($jt->cekJenis($request->input('name')) == 0) {
            $jt->insertJenis($request);
            return view('mandor.Creation.tambahJenisTukang');
        } else {
            $data['error'] = 5; //nama jenis sdh ada
            return view('mandor.Creation.tambahJenisTukang',$data);
        }
    }
    public function lihatJenisTukang()
    {
        $jt = new jenis_tukang();
        $data = [
            'title' => 'List Jenis Tukang',
            'listJenisTukangs' => $jt->where('kode_mandor', session()->get('kode'))->get()
        ];
        return view('mandor.List.listJenisTukang', $data);
    }

    //tukang
    public function tambahTukang(){
        $jt = new jenis_tukang();
        $data = [
            'title' => 'Detail Pekerjaan',
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->get()
        ];
        return view("mandor.Creation.tambahTukang", ['title' => 'Tambah Tukang'],$data);
    }
}

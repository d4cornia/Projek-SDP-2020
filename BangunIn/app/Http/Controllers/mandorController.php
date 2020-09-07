<?php

namespace App\Http\Controllers;

use App\jenis_tukang;
use App\mandor;
use App\kontraktor;
use App\administrator;
use App\tukang;
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
            'title' => 'Register Tukang',
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->get()
        ];
        return view("mandor.Creation.tambahTukang", ['title' => 'Tambah Tukang'],$data);
    }
    public function storeTukang(Request $request)
    {
        // validation form -> ada yang kosong / salah ga, kasi warning di form
        $request->validate([
            'name' => 'required|alpha',
            'no' => 'required|numeric',
            'username' => 'required',
            'email' => 'required',
            'pass' => 'required',
            'gaji'=>'required|numeric'
        ]);
        $jenis = $request->jenis;
        $un = $request->username;

        $jt = new jenis_tukang();
        $m = new mandor();
        $a = new administrator();
        $k = new kontraktor();
        $tukang = new tukang();
        $data = [
            'title' => 'Register Tukang',
            'error' => 0, // 0 = success,
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->get()
        ];
        if (count($jt->nameToCode($jenis)) == 0) {
            $data['error'] = 6; // 6 = belum pilih jenis tukang
        } else if (count($m->nameToCode($un)) != 0 ) {
            $data['error'] = 1; //username sdh terpakai
        } else if (count($a->nameToCode($un)) != 0 ) {
            $data['error'] = 1;
        } else if (count($k->nameToCode($un)) != 0 ) {
            $data['error'] = 1;
        } else if (count($tukang->nameToCode($un)) != 0){
            $data['error'] = 1;
        }
        if ($data['error'] == 6 || $data['error'] == 1) {
            return view('mandor.Creation.tambahTukang', $data);
        }
        else{

            $kj = $jt->nameToCode($jenis);
            $kj = substr($kj,1);
            $kj = substr($kj,0,strlen($kj)-1);
            $tukang->insertTukang($request,$kj);
            return view('mandor.Creation.tambahTukang', $data);
        }
    }
    public function lihatTukang()
    {
        $t = new tukang();
        $jt = new jenis_tukang();
        $data = [
            'title' => 'List Tukang',
            'listTukang' => $t->where('kode_mandor', session()->get('kode'))->get(),
            'listJenis' => $jt->where('kode_mandor', session()->get('kode'))->get()
        ];
        return view('mandor.List.listTukang', $data);
    }
}

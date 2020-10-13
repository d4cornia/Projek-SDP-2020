<?php

namespace App\Http\Controllers;

use App\absen_tukang;
use App\tukang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class tukangController extends Controller
{
    public function index()
    {
        return view('tukang.navbar');
    }

    public function listRiwayatAbsen()
    {
        date_default_timezone_set("Asia/Bangkok");
        $t = new tukang();
        $a = new absen_tukang();
        $temp = $t->nameToCode(session()->get('nama'));
        $data = [
            'title' => 'Absen',
            'listHistory' => $a->getAllMyHist($temp[0])
        ];

        $date = mktime(8, 0, 0);
        $data['buka'] = false;
        if (date('H:i:s') <= date('H:i:s', $date) && !$a->doneAbsen($temp[0])) {
            $data['buka'] = true;
        }
        return view('tukang.List.historyAbsenTukang', $data);
    }

    public function indexAbsen()
    {
        date_default_timezone_set("Asia/Bangkok");
        $t = new tukang();
        $temp = $t->nameToCode(session()->get('nama'));
        $data = [
            'title' => 'Absen',
            'kode' => $temp[0]
        ];
        $a = new absen_tukang();
        $date = mktime(8, 0, 0);
        $data['buka'] = true;
        // if (date('H:i:s') <= date('H:i:s', $date) && !$a->doneAbsen($temp[0])) {
        //     $data['buka'] = true;
        // } else if ($a->doneAbsen($temp[0])) {
        //     $data['msg'] = 'Anda sudah melakukan absen!';
        // } else if (date('H:i:s') > date('H:i:s', $date)) {
        //     $data['msg'] = 'Anda Telat!';
        // }
        return view('tukang.Creation.absen', $data);
    }

    public function absen(Request $request)
    {
        $request->validate([
            'bukti' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ], [
            'bukti.required' => 'Tolong masukkan bukti gambar anda untuk absen!'
        ]);
        $fileName =  "image-" . time() . '.' . $request->file('bukti')->getClientOriginalName();
        $request->file('bukti')->move(public_path('/assets/absen_tukang'), $fileName);

        session()->put('bukti', $fileName);
        $a = new absen_tukang();
        $a->insert($request);


        $t = new tukang();
        $temp = $t->nameToCode(session()->get('nama'));
        $data = [
            'title' => 'Absen',
            'listHistory' => $a->getAllMyHist($temp[0]),
            'title' => 'Riwayat absen',
            'succ' => 'Silahkan tunggu konfirmasi dari mandor'
        ];
        $date = mktime(8, 0, 0);
        $data['buka'] = false;
        if (date('H:i:s') <= date('H:i:s', $date) && !$a->doneAbsen($temp[0])) {
            $data['buka'] = true;
        }
        return view('tukang.List.historyAbsenTukang', $data);
    }
}

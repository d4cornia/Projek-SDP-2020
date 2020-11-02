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
        $temp = $t->nameToCode(session()->get('username'));
        $filter = null;

        $firstday = date('d/m/Y', strtotime("sunday -1 week"));
        if ($a->getAllMyHist($temp[0]) !== null) {
            foreach ($a->getAllMyHist($temp[0]) as $item) {
                $tgl = date_create($item['tanggal_absen']);
                if ((intval(date_format($tgl, 'd-m-Y')) - intval($firstday)) >= 0) {
                    $filter[] = $item;
                }
            }
        }

        $data = [
            'title' => 'Riwayat Absen',
            'listHistory' => $filter
        ];

        $date = mktime(8, 0, 0);
        $data['buka'] = false;
        if (date('H:i:s') <= date('H:i:s', $date) && !$a->doneAbsen($temp[0])) {
            $data['buka'] = true;
        } else {
            $mode = "0";
            if (session()->has('mode')) {
                $mode = '2'; // mode komplain
            } else if (date('l') == "Saturday") { // di hari sabtu dan absen sudah ditutup
                $mode = "1"; // saatnya konfirmasi absen dan mengajukan komplain

                if ($filter !== null) {
                    if ($filter[0]->status_komplain == '2') {
                        $mode = '0';
                    }
                }
            }
            $data['mode'] = $mode;
        }
        return view('tukang.List.historyAbsenTukang', $data);
    }

    public function confirmAbsen(Request $req)
    {
        $a = new absen_tukang();
        foreach ($req->idAbsen as $item) {
            $temp = $a->where('kode_absen', $item)->pluck('status_komplain')->first();
            if ($temp == "1") {
                session()->flash('err', 'Masih ada absen yang sedang di komplain!');
                return redirect('/tukang/history');
            }
        }
        foreach ($req->idAbsen as $item) {
            $a->confirm($item); // ubah status komplain mnjadi 2
        }
        return redirect('/tukang/history');
    }

    public function complainMode()
    {
        session()->put('mode', '2');
        return redirect('/tukang/history');
    }

    public function doneComplain()
    {
        session()->forget('mode');
        return redirect('/tukang/history');
    }

    public function complain($kode_absen)
    {
        $a = new absen_tukang();
        $a->complain($kode_absen); // ubah status complain mnjadi 1

        return redirect('/tukang/history');
    }

    public function batal($kode_absen)
    {
        $a = new absen_tukang();
        $a->batal($kode_absen); // ubah status complain mnjadi 0

        return redirect('/tukang/history');
    }

    public function indexAbsen()
    {
        date_default_timezone_set("Asia/Bangkok");
        $t = new tukang();
        $temp = $t->nameToCode(session()->get('username'));
        $data = [
            'title' => 'Absen',
            'kode' => $temp[0]
        ];
        $a = new absen_tukang();
        $date = mktime(8, 0, 0);
        $data['buka'] = true;
        // dd(date('H:i:s'));
        // if (date('H:i:s') <= date('H:i:s', $date) && !$a->doneAbsen($temp[0])) {
        //     $data['buka'] = true;
        // }
        // else if ($a->doneAbsen($temp[0])) {
        //     $data['msg'] = 'Anda sudah melakukan absen!';
        // } else if (date('H:i:s') > date('H:i:s', $date)) {
        //     $data['msg'] = 'Anda Telat!';
        // }
        return view('tukang.Creation.absen', $data);
    }

    public function absen(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
        $img = $request->input('image');
        $folderPath = public_path('/assets/absen_tukang/');

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = "image-" . time() . "-" .  uniqid() . '.png';

        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        session()->put('bukti', $fileName);
        $a = new absen_tukang();
        $a->insert($request);

        session()->put('done', 'Silahkan tunggu konfirmasi dari mandor!');
        return redirect('/tukang/history');
    }
}

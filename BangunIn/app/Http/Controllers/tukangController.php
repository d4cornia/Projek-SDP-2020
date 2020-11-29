<?php

namespace App\Http\Controllers;

use App\absen_tukang;
use App\bon_tukang;
use App\detail_absen;
use App\memiliki_detail_bon;
use App\pekerjaan_khusus;
use App\pembayaran_bon_tukang;
use App\pk_dana;
use App\tukang;
use DateTime;
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

        $firstday = date('d/m/Y', strtotime("monday -1 week"));
        $fd = new DateTime(date('Y/m/d', strtotime("monday -1 week")));
        // dd($firstday);
        if ($a->getAllMyHist($temp[0]) !== null) {
            foreach ($a->getAllMyHist($temp[0]) as $item) {
                $tgl = date_create($item['tanggal_absen']);
                $tgla = new DateTime(date('Y/m/d', strtotime($item['tanggal_absen'])));
                if ($fd->diff($tgla)->days < 7 && (intval(date_format($tgl, 'd-m-Y')) - intval($firstday)) >= 0) {
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
        $data['mode'] = null;
        if (date('H:i:s') <= date('H:i:s', $date) && !$a->doneAbsen($temp[0])) {
            $data['buka'] = true;
        } else {
            $mode = "0";
            if (session()->has('mode')) {
                $mode = '2'; // mode komplain
            } else if (date('l') == "Saturday") { // di hari sabtu dan absen sudah ditutup date('l') == "Saturday"
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
        $data['buka'] = false;
        if (date('H:i:s') <= date('H:i:s', $date) && !$a->doneAbsen($temp[0])) {
            $data['buka'] = true;
        } else if ($a->doneAbsen($temp[0])) {
            $data['msg'] = 'Anda sudah melakukan absen!';
        } else if (date('H:i:s') > date('H:i:s', $date)) {
            $data['msg'] = 'Anda Telat!';
        }
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

    public function konfirmasiPenerimaanDana()
    {
        $firstday = new DateTime(date('Y/m/d', strtotime("monday -1 week")));

        $filter = null;
        $kodetukang = session()->get('kode');
        //Cari di bukti absen
        $b = new absen_tukang();
        $tgl = date('Y/m/d');
        $tol = 0;
        $tgla = new DateTime(date('Y/m/d', strtotime($tgl)));
        $result = $b->getTukangAbsen($kodetukang);
        if (count($result) > 0) {
            foreach ($result as $baru) {
                $tglAbsen = new DateTime(date('Y/m/d', strtotime($baru->tanggal_absen)));
                if ($tglAbsen->diff($firstday)->days < 7 && (intval(date('d/m/Y', strtotime($baru->tanggal_absen))) - intval(date('d/m/Y', strtotime("monday -1 week")))) >= 0) {
                    $filter[] = $baru;
                    if ($baru->details != null && $baru->details->ongkos_lembur != 0) {
                        $tol++;
                    }
                }
            }
            $kodemandor = 0;
            $totalgajipokok = 0;
            if ($filter == null) {
                $jumlah_absen = 0;
            } else {
                $jumlah_absen = count($filter);
                $c = new tukang();
                $gajipokok = $c->getGajiPokokTukang($kodetukang);
                $kodemandor = $gajipokok[0]->kode_mandor;
                $totalgajipokok = $jumlah_absen * $gajipokok[0]->gaji_pokok_tukang;
            }
        } else {
            return redirect('/tukang')->with('error', 'Tidak ada absen minggu ini !');
        }


        $pk = new pekerjaan_khusus();
        $pekerjaankhusus = $pk->getPekerjaanKhususTukang($kodetukang);
        if (count($pekerjaankhusus) < 1) {
            $totalgajipokokdankhusus = 0;
        } else {
            $kodepk = $pekerjaankhusus[0]->kode_pk;
            $d = new pk_dana();
            $pkdana = $d->getDanaPK($kodepk);
            $totalgajipokokdankhusus = $pkdana[0]->dana;
        }

        $e = new pembayaran_bon_tukang();
        $pembayaranbon = $e->getBonTukang($kodemandor);
        $totalBon = 0;
        $jumlah_bon = 0;
        if (count($pembayaranbon) < 1) {
            $totalBon = 0;
        } else {
            foreach ($pembayaranbon as $key) {
                $tglbon = new DateTime(date('Y/m/d', strtotime($key->tanggal_pembayaran_bon)));
                if ($tglbon->diff($firstday)->days < 7 && (intval(date('d/m/Y', strtotime($key->tanggal_pembayaran_bon))) - intval(date('d/m/Y', strtotime("monday -1 week")))) >= 0) {
                    $kodepembayaranbon = $key->kode_pembayaran_bon;
                    $f = new memiliki_detail_bon();
                    $detailbon = $f->getDetailBon($kodepembayaranbon);
                    foreach ($detailbon as $item) {
                        $jumlah_pembayaran_bon = $item->jumlah_pembayaran_bon;
                        $kodebon = $item->kode_bon;
                        $g = new bon_tukang();
                        $bontukang = $g->selectBonTukang($kodetukang, $kodebon);
                        if (count($bontukang) < 1) {
                            $jumlah_bon = 0;
                            $totalBon = 0;
                        } else {
                            $jumlah_bon = count($bontukang);
                            $totalBon += $bontukang[0]->jumlah_bon;
                        }
                    }
                }
            }
        }

        $ga = detail_absen::where('kode_tukang', $kodetukang)->pluck('ongkos_lembur');

        $totalGajiDapat = ($totalgajipokok + $totalgajipokokdankhusus + $ga[0]) - $totalBon;

        $data = [
            'title' => 'Data Konfirmasi Pembayaran',
            'totalAbsen' => $totalgajipokok,
            'countAbsen' => $jumlah_absen,
            'pekerjaanKhusus' => count($pekerjaankhusus),
            'totalPekerjaanKhusus' => $totalgajipokokdankhusus,
            'ongkos_lembur' => $ga[0],
            'tol' => $tol,
            'jumlahBon' => $jumlah_bon,
            'totalBonTukang' => $totalBon,
            'totalGajiDapat' => $totalGajiDapat
        ];

        return view('tukang.List.konfirmasiDana', $data);
    }
}

<?php

namespace App\Http\Controllers;

use App\absen_harian;
use App\absen_tukang;
use App\detail_absen;
use App\jenis_tukang;
use App\pekerjaan;
use App\tukang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class mandorAbsenController extends Controller
{
    //Absen Tukang
    public function lihatAbsenTukang()
    {
        return view('mandor.List.listAbsenTukang');
    }

    public function filterAbsen(Request $req)
    {
        $b = new absen_tukang();
        $ah = new absen_harian();
        $p = new pekerjaan();
        $jt = new jenis_tukang();
        $tanggal = $req->input('tanggalabsen');
        $date = date_create($tanggal);
        $format = date_format($date, "d-m-Y");

        // jika sudah dikonfirmasi maka tidak ada konfirmasi lagi
        if ($ah->doneKonfirmasi($format)) {
            // jika sudah dikonfirmasi
            $q = null;
            $nc = null;
            $da = new detail_absen();
            $t = new tukang();
            foreach ($ah->getHeader($format) as $header) {
                // untuk header ini yang dikonfrim apa aja
                foreach ($da->getDetail($header['kode_absen_harians']) as $detail) {
                    $tem = $p->getWork($header['kode_pekerjaan']);
                    $tuk = $t->getKodeJenis($detail['kode_tukang']);
                    $jenis = $jt->getNamaJenis($tuk[0]);
                    $bukti = $detail['kode_absen'];
                    if ($detail['kode_absen'] != null) {
                        $bukti = $b->getBukti($detail['kode_absen']);
                    } else {
                        $bukti[] = null;
                    }
                    $nama = $t->getNamaTukang($detail['kode_tukang']);
                    $q[] = [
                        'kode_tukang' => $detail['kode_tukang'],
                        'nama_tukang' => $nama[0],
                        'kode_pekerjaan' => $header['kode_pekerjaan'],
                        'nama_pekerjaan' => $tem[0]['nama_pekerjaan'],
                        'jenis_tukang' => $jenis[0],
                        'tanggal_absen' => $header['tanggal_absen'],
                        'bukti' => $bukti[0]
                    ];
                }

                // untuk header ini yang ga konfirm apa aja
                $tem = $da->getNotConfirm($header['kode_absen_harians']);
                if ($tem != null) {
                    foreach ($tem as $item) {
                        $jenis = $jt->getNamaJenis($item['kode_jenis']);
                        $item['jenis_tukang'] = $jenis[0];
                        $nc[] = $item;
                    }
                }
            }
            //tampilkan yang sudah terkonfirmasi absennya
            $data = [
                'title' => 'List Absen Client',
                'hid' => '1',
                'list' => $q,
                'nc' => $nc,
                'ctr' => 0
            ];
        } else {
            // jika belum dikonfirmasi

            // tukang yang telat checkbox tidak dicentang
            $tt = null;
            if ($b->tukangTelat($format) !== null) {
                foreach ($b->tukangTelat($format) as $item) {
                    $temp = $jt->getNamaJenis($item['kode_jenis']);
                    $tt[] = [
                        'kode_tukang' => $item['kode_tukang'],
                        'kode_mandor' => $item['kode_mandor'],
                        'jenis_tukang' => $temp[0],
                        'nama_tukang' => $item['nama_tukang'],
                    ];
                }
            }

            $data = [
                'title' => 'List Absen Tukang',
                'listFilterAbsen' => $b->filterTanggalAbsen($format),
                'tukang_telat' => $tt,
                'listWork' => $p->getAllWork(),
                'hid' => '0',
                'tgl' => $format,
                'ctr' => 0
            ];
        }
        // dd($data);
        return view('mandor.List.listAbsenTukang', $data);
    }

    public function konfirmasiAbsen(Request $req)
    {
        // dd($req->input());
        $tanggal = $req->input('tgl');
        $date = date_create($tanggal);
        $format = date_format($date, "d-m-Y");

        // transaction
        $b = new absen_tukang();
        $b->insertAbsen($req, $format);
        return view('mandor.List.listAbsenTukang');
    }
}
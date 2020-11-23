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
        date_default_timezone_set("Asia/Bangkok");
        $b = new absen_tukang();
        $ah = new absen_harian();
        $p = new pekerjaan();
        $jt = new jenis_tukang();
        $tanggal = $req->input('tanggalabsen');
        $date = date_create($tanggal);
        $format = date_format($date, "Y-m-d");

        $firstday = date('d/m/Y', strtotime("monday 0 week"));
        // dd($firstday);
        if ((intval(date_format($date, 'd-m-Y')) - intval($firstday)) >= 0 && intval(date_format($date, 'd-m-Y')) <= intval(date('d-m-Y'))) { // jika sudah dikonfirmasi maka tidak ada konfirmasi lagi
            if ($ah->doneKonfirmasi($format)) {
                // jika sudah dikonfirmasi
                $q = null;
                $nc = null;
                $da = new detail_absen();
                $t = new tukang();
                foreach ($ah->getHeader($format) as $header) {
                    // untuk header ini yang dikonfrim siapa aja
                    foreach ($da->getDetail($header['kode_absen_harians']) as $detail) {
                        $tem = $p->getWork($header['kode_pekerjaan']);
                        $tuk = $t->getKodeJenis($detail['kode_tukang']);
                        $jenis = $jt->getNamaJenis($tuk[0]);
                        $bukti = $detail['kode_absen'];
                        if ($detail['kode_absen'] != null) {
                            $bukti = $b->getBukti($detail['kode_absen']);
                        } else {
                            $bukti[] = '-';
                        }
                        $nama = $t->getNamaTukang($detail['kode_tukang']);
                        $q[] = [
                            'kode_tukang' => $detail['kode_tukang'],
                            'nama_tukang' => $nama[0],
                            'kode_pekerjaan' => $header['kode_pekerjaan'],
                            'nama_pekerjaan' => $tem[0]['nama_pekerjaan'],
                            'jenis_tukang' => $jenis[0],
                            'tanggal_absen' => $header['tanggal_absen'],
                            'ongkos_lembur' => $detail['ongkos_lembur'],
                            'bukti' => $bukti[0]
                        ];
                    }
                }
                // untuk hari ini yang ga konfirm siapa aja
                $tem = $b->notConfirm($format);
                if ($tem != null) {
                    foreach ($tem[0] as $val) {
                        $jenis = $jt->getNamaJenis($t->where('kode_tukang', $val['kode_tukang'])->pluck('kode_jenis')->first());
                        $val['jenis_tukang'] = $jenis[0];
                        $sem = $t->codetoName($val['kode_tukang']);
                        $val['nama_tukang'] = $sem[0];
                        $nc[] = $val;
                    }
                    foreach ($tem[1] as $val) {
                        $jenis = $jt->getNamaJenis($t->where('kode_tukang', $val['kode_tukang'])->pluck('kode_jenis')->first());
                        $val['jenis_tukang'] = $jenis[0];
                        $sem = $t->codetoName($val['kode_tukang']);
                        $val['nama_tukang'] = $sem[0];
                        $nc[] = $val;
                    }
                }

                //tampilkan yang sudah terkonfirmasi dan yang belum absennya
                $data = [
                    'title' => 'List Absen Tukang',
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
        } else {
            $data = [
                'errAbsen' => 'Tanggal yang anda pilih melebihi batas'
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
        $format = date_format($date, "Y-m-d");

        // transaction
        $b = new absen_tukang();
        $b->insertAbsen($req, $format);
        $data = [
            'kon' => 'Berhasil Konfirmasi Absen'
        ];
        return view('mandor.List.listAbsenTukang', $data);
    }
}

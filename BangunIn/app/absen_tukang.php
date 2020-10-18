<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class absen_tukang extends Model
{
    protected $table = "bukti_absens";
    protected $primaryKey = 'kode_absen';
    public  $timestamps = false;
    public  $incrementing = true;

    public function getAllMyHist($id)
    {
        return $this->where('kode_tukang', $id)->orderby('tanggal_absen')->get();
    }

    public function doneAbsen($id)
    {
        if (count($this->where('kode_tukang', $id)->where('tanggal_absen', date("d-m-Y"))->get()) > 0) {
            return true;
        }
        return false;
    }

    public function getBukti($id)
    {
        return $this->where('kode_absen', $id)->pluck('bukti_foto_absen');
    }

    public function insert(Request $req)
    {
        $this->kode_tukang = decrypt($req->kode_tukang);
        $this->tanggal_absen = date("d-m-Y");
        $this->bukti_foto_absen = session()->get('bukti');
        $this->konfirmasi_absen = '0';
        // dd($this);
        $this->save();
    }

    public function insertTidakMasuk($kode, $tanggal)
    {
        $ba = new absen_tukang();
        $ba->kode_tukang = $kode;
        $ba->tanggal_absen = $tanggal;
        $ba->bukti_foto_absen = '-';
        $ba->konfirmasi_absen = '3';
        $ba->save();
    }

    public function filterTanggalAbsen($tanggal)
    {
        $kode_mandor = session()->get('kode');
        $users = DB::table('bukti_absens')
            ->join('tukangs', 'bukti_absens.kode_tukang', '=', 'tukangs.kode_tukang')
            ->join('jenis_tukangs', 'tukangs.kode_jenis', '=', 'jenis_tukangs.kode_jenis')
            ->where('bukti_absens.tanggal_absen', '=', $tanggal)
            ->where('tukangs.kode_mandor', '=', $kode_mandor)
            ->where('bukti_absens.konfirmasi_absen', '=', 0)
            ->get();
        return $users;
    }

    public function tukangTelat($tanggal)
    {
        $t = new tukang();
        $tukangs = $t->where('kode_mandor', session()->get('kode'))->get(); // semua tukang dengan mandor ini
        $data = null;
        foreach ($tukangs as $item) {
            if (count($this->where('kode_tukang', $item['kode_tukang'])
                ->where('tanggal_absen', $tanggal)->get()) == 0) { // yang telat berarti tidak ada di tabel bukti absen pada hari itu
                $data[] = $item;
            }
        }
        return $data;
    }

    public function acceptAbsen($kode_absen)
    {
        $c = $this->find($kode_absen);
        $c->konfirmasi_absen = '1'; // disetujui
        $c->save();
    }

    public function declineAbsen($kode_absen)
    {
        $c = $this->find($kode_absen);
        $c->konfirmasi_absen = '2'; // tidak disetujui
        $c->save();
    }

    public function insertAbsen(Request $req, $tanggal)
    {
        DB::beginTransaction();
        try {
            $works = $req->input('kode_pekerjaan');
            $tukangs = $req->input('kode_tukang');
            if ($req->input('kode_pekerjaan') !== null) {
                // Header
                foreach ($works as $workCode) {
                    $ah = new absen_harian();
                    $ah->insertHeader($workCode, $tanggal);
                }

                // Detail
                $ctr = 0;
                $ah = new absen_harian();
                $data = $req->input('status');
                $ongkos = $req->input('ongkos');
                foreach ($data as $item) {
                    $da = new detail_absen();
                    $temp = $ah->getKodeHeader($works[$ctr], $tanggal); // get kode header sesuai dengan pekerjaan dan tanggal
                    if ($item == "-1") { // telat, detail ada and bukti absen dibuat baru
                        $ba = new absen_tukang();
                        $ba->kode_tukang = $tukangs[$ctr];
                        $ba->tanggal_absen = $tanggal;
                        $ba->bukti_foto_absen = '-';
                        $ba->konfirmasi_absen = '1';
                        $ba->save();
                        $da->insertDetail($temp[0], $ba->orderby('kode_absen', 'desc')->pluck('kode_absen')->first(), $tukangs[$ctr], $ongkos[$ctr]);
                    } else { // tidak telat, bukti sudah ada
                        $da->insertDetail($temp[0], $item, $tukangs[$ctr], $ongkos[$ctr]);
                    }
                    $ctr++;
                }
                // Update
                $ctr = 0;
                foreach ($data as $item) {
                    if ($item != '-1') {
                        $this->acceptAbsen($item); // yang bukti sudah ada di ubah status menjadi disetujui
                    }
                    $ctr++;
                }

                // yang tidak dikonfirmasi tapi sudah absen
                $data = $this->where('tanggal_absen', $tanggal)->get();
                foreach ($data as $item) {
                    if ($item['konfirmasi_absen'] == '0') {
                        $this->declineAbsen($item['kode_absen']); // diubah status menjadi tidak disetujui
                    }
                }

                // tukang yang tidak absen dan tidak dikonfirmasi
                $t = new tukang();
                $listTuk = $t->where('kode_mandor', session()->get('kode'))->get(); // list semua tukang mandor ini
                foreach ($listTuk as $item) {
                    $flag = true;
                    foreach ($data as $tu) {
                        if ($tu['kode_tukang'] == $item['kode_tukang']) {
                            $flag = false;
                        }
                    }
                    if ($flag) {
                        $this->insertTidakMasuk($item['kode_tukang'], $tanggal); // diubah status menjadi tidak masuk
                    }
                }
            } else { // tidak ada yang absen
                $ah = new absen_harian();
                $ah->insertHeader(null, $tanggal);

                // absen tapi tidak disetujui
                $data = $this->where('tanggal_absen', $tanggal)->get();
                foreach ($data as $item) {
                    if ($item['konfirmasi_absen'] == '0') {
                        $this->declineAbsen($item['kode_absen']); // diubah status menjadi tidak disetujui
                    }
                }

                // tukang yang tidak absen dan tidak dikonfirmasi
                $t = new tukang();
                $listTuk = $t->where('kode_mandor', session()->get('kode'))->get(); // list semua tukang mandor ini
                foreach ($listTuk as $item) {
                    $flag = true;
                    foreach ($data as $tu) {
                        if ($tu['kode_tukang'] == $item['kode_tukang']) {
                            $flag = false;
                        }
                    }
                    if ($flag) {
                        $this->insertTidakMasuk($item['kode_tukang'], $tanggal); // diubah status menjadi tidak masuk
                    }
                }
            }
            DB::commit();
        } catch (Exception $e) {
            echo $e->getMessage();
            DB::rollback();
        }
    }

    public function notConfirm($tanggal)
    {
        return $this->where('tanggal_absen', $tanggal)->where('konfirmasi_absen', '2')->orWhere('konfirmasi_absen', '3')->get();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class pembelian extends Model
{
    protected $primaryKey = 'id_pembelian';
    public $timestamps = false;
    public  $incrementing = true;

    public function PembelianBon($id_bukti,$kode_pekerjaan,$id_kerjasama,$total_pembelian,$tanggal_beli,$tanggal_jatuh_tempo)
    {
        $p = new pembelian();
        $p->id_bukti = $id_bukti;
        $p->id_kerjasama = $id_kerjasama;
        $p->kode_pekerjaan = $kode_pekerjaan;
        $p->total_pembelian = $total_pembelian;
        $p->tanggal_beli = $tanggal_beli;
        $p->tanggal_bayar = null;
        $p->tanggal_jatuh_tempo = $tanggal_jatuh_tempo;
        $p->status_lunas_bon_toko ='0';
        $p->status_pembayaran_oleh ='2';
        $p->status_request_dana ='0';
        $p->save();
    }

    public function PembelianLunas($id_bukti,$kode_pekerjaan,$id_kerjasama,$total_pembelian,$tanggal_beli,$tanggal_bayar)
    {
        $p = new pembelian();
        $p->id_bukti = $id_bukti;
        $p->id_kerjasama = $id_kerjasama;
        $p->kode_pekerjaan = $kode_pekerjaan;
        $p->total_pembelian = $total_pembelian;
        $p->tanggal_beli = $tanggal_beli;
        $p->tanggal_bayar = $tanggal_bayar;
        $p->tanggal_jatuh_tempo = null;
        $p->status_lunas_bon_toko = '1';
        $p->status_pembayaran_oleh ='1';
        $p->status_request_dana ='0';
        $p->save();
    }
    public function getFoto($id)
    {
        $data = DB::table('pembelians')->where('pembelians.id_kerjasama',$id)
                            ->join('bukti_pembelian_mandors as bp','bp.id_bukti','pembelians.id_bukti')
                            ->select('bp.file_bukti')->get();

        return $data;
    }
    public function getListBahan($id){
        $data = pembelian::where('pembelians.id_kerjasama',$id)->join('memiliki_detail_pembelians as dp',"dp.id_pembelian","pembelians.id_pembelian")->join('bahan_bangunans as bb','bb.id_bahan','dp.id_bahan')->get();
        return $data;
    }
    public function updateLunas($id,$tl)
    {
        $beli = $this->find($id);
        $beli->status_lunas_bon_toko=1;
        $beli->tanggal_bayar=$tl;
        $beli->save();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class memiliki_detail_pembelian extends Model
{
    protected $primaryKey = 'id_detail_pembelian';
    public $timestamps = false;
    public  $incrementing = true;
    public function insert($id_pembelian,$id_bahan,$jumlah,$harga,$diskon,$subtotal)
    {
        $id = new memiliki_detail_pembelian();
        $id->id_pembelian = $id_pembelian;
        $id->id_bahan = $id_bahan;
        $id->jumlah_barang = $jumlah;
        $id->harga_satuan = $harga;
        $id->persen_diskon = $diskon;
        $id->subtotal = $subtotal;
        $id->save();
    }
}

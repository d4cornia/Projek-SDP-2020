<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class pembayaran_client extends Model
{
    protected $primaryKey = 'kode_pembayaran_client';
    public $timestamps = false;
    public  $incrementing = true;
    //
    public function insertPembayaran($data)
    {
        $this->kode_pekerjaan = $data['pekerjaan_kode'];
        $this->kode_client = $data['client_kode'];
        $this->tanggal_pembayan_client = $data['waktu'];
        $this->jumlah_pembayaran_client = $data['total'];
        $this->save();
    }

    public function getDataPembayaran()
    {
        $kodeKontraktor = session()->get('kode');
        $users = DB::table('pembayaran_clients')
        ->join('pekerjaans', 'pembayaran_clients.kode_pekerjaan', '=', 'pekerjaans.kode_pekerjaan')
        ->join('clients', 'pembayaran_clients.kode_client', '=', 'clients.kode_client')
        ->select('pembayaran_clients.kode_pembayaran_client', 'pekerjaans.nama_pekerjaan', 'clients.nama_client','pembayaran_clients.tanggal_pembayan_client','pembayaran_clients.jumlah_pembayaran_client')
        ->where('clients.kode_kontraktor','=',$kodeKontraktor)
        ->get();
        return $users;
    }

    public function getSumPembayaran($value)
    {
        $sum = DB::table('pembayaran_clients')
                    ->where('pembayaran_clients.kode_pekerjaan', '=', $value)
                    ->sum('pembayaran_clients.jumlah_pembayaran_client');
        return $sum;
    }

    public function getListKomisi()
    {
        $kodeKontraktor = session()->get('kode');
        $users = DB::table('pembayaran_clients')
        ->join('pekerjaans', 'pembayaran_clients.kode_pekerjaan', '=', 'pekerjaans.kode_pekerjaan')
        ->select('pekerjaans.kode_pekerjaan','pekerjaans.nama_pekerjaan', 'pembayaran_clients.tanggal_pembayan_client','pembayaran_clients.jumlah_pembayaran_client','pekerjaans.status_lunas')
        ->where('pekerjaans.jenis_pekerjaan',1)
        ->where('pekerjaans.kode_kontraktor','=',$kodeKontraktor)
        ->get();
        return $users;
    }
}

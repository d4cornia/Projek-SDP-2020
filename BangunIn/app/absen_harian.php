<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class absen_harian extends Model
{
    protected $table = "absen_harians";
    protected $primaryKey = 'kode_absen_harians';
    public  $timestamps = false;
    public  $incrementing = true;

    public function doneKonfirmasi($tanggal)
    {
        if (count($this->where('tanggal_absen', $tanggal)->get()) > 0) {
            return true;
        }
        return false;
    }

    public function insertHeader($kodeP, $tanggal)
    {
        if (count($this->where('tanggal_absen', $tanggal)
            ->where('kode_pekerjaan', $kodeP)
            ->where('kode_mandor', session()->get('kode'))
            ->get()) == 0) {
            $this->kode_pekerjaan = $kodeP;
            $this->kode_mandor = session()->get('kode');
            $this->tanggal_absen = $tanggal;
            $this->save();
        }
    }

    public function getKodeHeader($kodeP, $tanggal) // kode header yang baru dibuat hari ini, dengan pekerjaan spesifik
    {
        return $this->where('tanggal_absen', $tanggal)
            ->where('kode_pekerjaan', $kodeP)
            ->where('kode_mandor', session()->get('kode'))
            ->pluck('kode_absen_harians');
    }

    public function getHeader($tanggal)
    {
        return $this->where('tanggal_absen', $tanggal)
            ->where('kode_mandor', session()->get('kode'))
            ->get();
    }

    public function details()
    {
        return $this->hasMany(detail_absen::class, 'kode_absen_harians');
    }
}

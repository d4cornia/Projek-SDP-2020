<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    protected $primaryKey = 'kode_client';

    public function nameToCode($name)
    {
        return $this::where('nama_client', $name)
            ->pluck('kode_client');
    }
}

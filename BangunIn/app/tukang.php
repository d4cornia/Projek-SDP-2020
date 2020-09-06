<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tukang extends Model
{
    protected $table = "tukangs";
    protected $primaryKey = 'kode_tukang';

    public function CekLogin($username,$password)
    {
        //cek login tukang

        $result = tukang::where('username_tukang',$username)
                        ->where('password_tukang',$password)
                        ->get();
        return $result;
    }
}

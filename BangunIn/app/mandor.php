<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mandor extends Model
{
    protected $table = "mandors";
    protected $primaryKey = 'kode_mandor';

    public function CekLogin($username,$password)
    {
        //cek login Mandor

        $result = mandor::where('username_mandor',$username)
                        ->where('password_mandor',$password)
                        ->get();
        return $result;
    }
}

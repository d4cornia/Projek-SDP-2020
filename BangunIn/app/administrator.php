<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class administrator extends Model
{
    protected $table = "administrators";
    protected $primaryKey = 'kode_admin';

    public function CekLogin($username,$password)
    {
        //cek login Kontraktor

        $result = administrator::where('username_admin',$username)
                        ->where('password_admin',$password)
                        ->get();
        return $result;
    }
}

<?php

namespace App\Http\Controllers;

use App\administrator;
use App\kontraktor;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use App\mandor;
use App\tukang;

class loginController extends Controller
{
    public function index()
    {

        return view('Login.loginUtama');
    }

    public function vlogin(Request $request)
    {
        $stat = $request->stat;
        if ($request->regis) { //dari register
            $param["berhasil"] = "Akun telah di tambahkan, Silahkan Login";
            $param["stat"] = 0;
        } else {
            $param["stat"] = $stat;
        }
        return view('login.login')->with($param);
    }

    public function login(Request $request)
    { //cek login
        $stat = $request->stat;
        $username = $request->username;
        $password = $request->password;
        $gagalLogin = 0;
        if ($stat == 0) { //kontraktor
            $kontraktor = new kontraktor();
            $dataKontraktor = $kontraktor->CekLogin($username, $password);
            if (count($dataKontraktor) > 0) {
                session()->put('kode', $dataKontraktor[0]->kode_kontraktor);
                session()->put('nama', $dataKontraktor[0]->nama_kontraktor);
                session()->put('status', 'kontraktor');
                return redirect('kontraktor/');
            } else {
                $param["error"] = "Username atau Password Salah";
                $gagalLogin = 1;
            }
        } else if ($stat == 1) { //mandor/tukang/admin
            $mandor = new mandor();
            $dataMandor = $mandor->CekLogin($username, $password);
            if (count($dataMandor) > 0) { //mandor
                session()->put('kode', $dataMandor[0]->kode_mandor);
                session()->put('nama', $dataMandor[0]->nama_mandor);
                session()->put('status', 'mandor');
                return redirect('mandor/');
            } else { //tukang/admin
                $tukang = new tukang();
                $dataTukang = $tukang->CekLogin($username, $password);
                if (count($dataTukang) > 0) { //tukang
                    session()->put('kode', $dataTukang[0]->kode_tukang);
                    session()->put('nama', $dataTukang[0]->nama_tukang);
                    session()->put('status', 'tukang');
                    return redirect('tukang/');
                } else {
                    $admin = new administrator();
                    $dataAdmin = $admin->CekLogin($username, $password);
                    if (count($dataAdmin) > 0) { //admin
                        session()->put('kode', $dataAdmin[0]->kode_admin);
                        session()->put('nama', $dataAdmin[0]->nama_admin);
                        session()->put('status', 'admin');
                        return redirect('admin/');
                    } else {
                        $param["error"] = "Username atau Password Salah";
                        $gagalLogin = 1;
                    }
                }
            }
        }
        if ($gagalLogin == 1) {
            //jika username atau password salah
            $param["stat"] = $request->stat;
            return view('Login.login')->with($param);
        }
    }

    public function register(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $nomer = $request->nomer;
        $email = $request->email;
        $nama = $request->nama;
        if ($request->btnRegister) {
            $kontraktor = new kontraktor();
            $result = $kontraktor->CekUsername($username);
            if (count($result) > 0) { //jika username sudah ada
                $param["error"] = "Username telah digunakan";
                return view('Login.register')->with($param);
            } else { //jkika username belum ada
                $kontraktor->TambahKontraktor($username, $password, $nama, $email, $nomer);
                return redirect('/vlogin?regis=1');
            }
        } else {
            return view('Login.register');
        }
    }
    public function logout()
    {
        session()->forget('kode');
        session()->forget('nama');
        session()->forget('status');
        session()->forget('listSpWork');
        return redirect('/');
    }
}

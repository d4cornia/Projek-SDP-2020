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
    public function home()
    {
        $mandor = new mandor();
        $tukang = new tukang();
        $admin = new administrator();
        $kontraktor = new kontraktor();
        $param["kontraktor"] = $kontraktor::count();
        $param["admin"] = $admin::count();
        $param["mandor"] = $mandor::count();
        $param["tukang"] = $tukang::count();

        return view('homepage')->with($param);
    }
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
        $kontraktor = new kontraktor();
        $dataKontraktor = $kontraktor->CekLogin($username, $password);
        if (count($dataKontraktor) > 0) {
            session()->put('kode', $dataKontraktor[0]->kode_kontraktor);
            session()->put('nama', $dataKontraktor[0]->nama_kontraktor);
            session()->put('nmperusahaan', $dataKontraktor[0]->nama_perusahaan);
            session()->put('lgperusahaan', $dataKontraktor[0]->logo_perusahaan);
            session()->put('status', 'kontraktor');
            return redirect('kontraktor/');
        }
        else { //mandor/tukang/admin
            $mandor = new mandor();
            $dataMandor = $mandor->CekLogin($username, $password);
            if (count($dataMandor) > 0) { //mandor
                $dtperusahaan = $mandor->where('kode_kontraktor=',$dataMandor[0]->kode_kontraktor)->get();

                session()->put('kode', $dataMandor[0]->kode_mandor);
                session()->put('nama', $dataMandor[0]->nama_mandor);
                session()->put('nmperusahaan', $dtperusahaan[0]->nama_perusahaan);
                session()->put('lgperusahaan', $dtperusahaan[0]->logo_perusahaan);
                session()->put('status', 'mandor');
                return redirect('mandor/');
            } else { //tukang/admin
                $tukang = new tukang();
                $dataTukang = $tukang->CekLogin($username, $password);
                if (count($dataTukang) > 0) { //tukang
                    $dtperusahaan = $tukang->where('kode_mandor=',$dataTukang[0]->kode_mandor)
                                            ->where('kode_kontraktor=',$dataTukang[0]->kode_kontraktor)
                                            ->get();
                    session()->put('kode', $dataTukang[0]->kode_tukang);
                    session()->put('nama', $dataTukang[0]->nama_tukang);
                    session()->put('nmperusahaan', $dtperusahaan[0]->nama_perusahaan);
                    session()->put('lgperusahaan', $dtperusahaan[0]->logo_perusahaan);
                    session()->put('status', 'tukang');
                    return redirect('tukang/');
                } else {
                    $admin = new administrator();
                    $dataAdmin = $admin->CekLogin($username, $password);
                    if (count($dataAdmin) > 0) { //admin
                        $dtperusahaan = $admin->where('kode_kontraktor=',$dataAdmin[0]->kode_kontraktor)->get();
                        session()->put('kode', $dataAdmin[0]->kode_admin);
                        session()->put('nama', $dataAdmin[0]->nama_admin);
                        session()->put('nmperusahaan', $dtperusahaan[0]->nama_perusahaan);
                        session()->put('lgperusahaan', $dtperusahaan[0]->logo_perusahaan);
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
        if ($request->btnRegister) {
            $username = $request->username;
            $password = $request->password;
            $nomer = $request->nomer;
            $email = $request->email;
            $nama = $request->nama;
            $noperushaan = $request->noperusahaan;
            $nmperushaan = $request->nmperusahaan;
            $alperushaan = $request->alperusahaan;
            $logo = $request->file('logo');
            $nmlogo =$logo->getClientOriginalName();
            $tujuan_upload = '/assets/logo_perusahaan';

            $kontraktor = new kontraktor();
            $mandor = new mandor();
            $admin = new administrator();
            $tukang = new tukang();
            $result = $kontraktor->CekUsername($username);
            if (count($result) > 0||$mandor->cekMandor($username)==false||$admin->cekAdmin($username)==false||$tukang->cekTukang($username)==false) { //jika username sudah ada
                $param["error"] = "Username telah digunakan";
                return view('Login.register')->with($param);
            } else { //jkika username belum ada
                $logo->move(public_path('\assets\logo_perusahaan'),$logo->getClientOriginalName());
                $kontraktor->TambahKontraktor($username, $password, $nama, $email, $nomer,$nmperushaan,$noperushaan,$alperushaan,$nmlogo);
                return redirect('/vlogin?regis=1');
            }
        } else {
            if($request->nm){
                $param["nm"] = $request->nm;
                $param["no"] = $request->no;
            }
            else{
                $param["nm"]="";
            }
            return view('Login.register')->with($param);
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

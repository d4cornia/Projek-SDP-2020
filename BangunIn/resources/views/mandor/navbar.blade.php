@extends('layout.layout')
@section('side-navbar')
<div class="d-none d-lg-block">
    <img class="mx-auto" style="padding-left: 4vh" width="80%" src="/assets/logo_perusahaan/{{session()->get('lgperusahaan')}}">
        <h4 class="judul pt-3">{{session()->get('nmperusahaan')}}</h4>
        <hr>
        <div class="btn-group nav-side">
            <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Welcome,<br>{{session()->get('nama')}}
            </button>
            <div class="dropdown-menu">
                {{--Dropdown Client--}}
                <a class="dropdown-item" href="/logout">Log Out</a>
            </div>
        </div>
    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Pekerjaan
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="/mandor/lihatPekerjaan">Lihat Pekerjaan</a>
            <a class="dropdown-item" href="/mandor/lihatHistoryPekerjaan">History Pekerjaan</a>
            <a class="dropdown-item" href="/mandor/listNota">Lihat Nota Pembelian Bahan</a>
        </div>
    </div>
    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Pekerjaan Khusus
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="/mandor/indexSpWork">Lihat Pekerjaan Khusus</a>
        </div>
    </div>
    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Jenis Tukang
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="/mandor/lihatJenisTukang">Lihat Jenis Tukang</a>
            <a class="dropdown-item" href="/mandor/tambahJenisTukang">Tambah Jenis Tukang</a>
        </div>
    </div>
    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Tukang
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="/mandor/lihatTukang">Lihat Tukang</a>
            <a class="dropdown-item" href="/mandor/tambahTukang">Tambah Tukang</a>
            <a class="dropdown-item" href="/mandor/lihatBon">Lihat Bon</a>
            <a class="dropdown-item" href="/mandor/tambahBon">Tambah Bon</a>
            <a class="dropdown-item" href="/mandor/tambahPembayaranBon">Pembayaran Bon</a>
            <a class="dropdown-item" href="/mandor/lihatRincianPembayaran">Lihat Pembayaran Bon</a>
            <a class="dropdown-item" href="/mandor/absenTukang">Lihat Absen Tukang</a>
            <a class="dropdown-item" href="/mandor/complain">Lihat Komplain Absen</a>
        </div>
    </div>
    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dana
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="/mandor/requestDana">Request Dana</a>
        </div>
    </div>
</div>
@endsection
@section('mob-navbar')
<style>
    .dropdowns{
        background-color: #2d3338;
        color:white;
        text-align: center;
        margin-top: 2vh;
        margin-bottom: 2vh;
    }
    .dropdowns:hover{
        background-color: #2d3338;
        color:white;
    }
    .but:{
        border: 2px solid white;
    }
</style>
<div class="pos-f-t d-lg-none fixed-top">
    <div class="w-100 text-right">
        <nav class="navbar navbar-dark bg-dark" >
            <div class="row w-100">
                <div class="col-9">
                    <h5 class="text-white text-left p-2">{{session()->get('nmperusahaan')}}</h5>
                </div>
                <div class="col-3 pl-5">
                    <button class="navbar-toggler mr-auto" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </nav>
    </div>
    <div class="panel-collapse collapse" id="navbarToggleExternalContent">
        <div class=" p-4 text-white" style="background-color: #2d3338">
            <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="collapse" data-target="#logout" aria-haspopup="true" aria-expanded="false">
                Welcome,<br>{{session()->get('nama')}}
            </button>
            <div class="collapse" id="logout" style="font-size: 2vh">
                <a class="dropdown-item dropdowns" href="/logout">Log Out</a>
                <a class="dropdown-item dropdowns" href="/kontraktor/edProfile">Edit Profile Perusahaan</a>

            </div>
            <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="collapse" data-target="#tukang2" aria-haspopup="true" aria-expanded="false">
                Pekerjaan
            </button>
            <div class="collapse" id="tukang2" style="font-size: 2vh">
                {{--Dropdown Tukang--}}
                <a class="dropdown-item dropdowns" href="/mandor/lihatPekerjaan">Lihat Pekerjaan</a>
                <a class="dropdown-item dropdowns" href="/mandor/lihatHistoryPekerjaan">History Pekerjaan</a>
                <a class="dropdown-item dropdowns" href="/mandor/listNota">Lihat Nota Pembelian Bahan</a>
            </div>
            <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="collapse" data-target="#tukang3" aria-haspopup="true" aria-expanded="false">
                Pekerjaan Khusus
            </button>
            <div class="collapse" id="tukang3" style="font-size: 2vh">
                {{--Dropdown Tukang--}}
                <a class="dropdown-item dropdowns" href="/mandor/indexSpWork">Lihat Pekerjaan Khusus</a>
            </div>
            <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="collapse" data-target="#tukang4" aria-haspopup="true" aria-expanded="false">
                Jenis Tukang
            </button>
            <div class="collapse" id="tukang4" style="font-size: 2vh">
                <a class="dropdown-item dropdowns" href="/mandor/lihatJenisTukang">Lihat Jenis Tukang</a>
                <a class="dropdown-item dropdowns" href="/mandor/tambahJenisTukang">Tambah Jenis Tukang</a>
            </div>
            <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="collapse" data-target="#tukang5" aria-haspopup="true" aria-expanded="false">
                Tukang
            </button>
            <div class="collapse" id="tukang5" style="font-size: 2vh">
                {{--Dropdown Tukang--}}
                <a class="dropdown-item dropdowns" href="/mandor/lihatTukang">Lihat Tukang</a>
                <a class="dropdown-item dropdowns" href="/mandor/tambahTukang">Tambah Tukang</a>
                <a class="dropdown-item dropdowns" href="/mandor/lihatBon">Lihat Bon</a>
                <a class="dropdown-item dropdowns" href="/mandor/tambahBon">Tambah Bon</a>
                <a class="dropdown-item dropdowns" href="/mandor/tambahPembayaranBon">Pembayaran Bon</a>
                <a class="dropdown-item dropdowns" href="/mandor/lihatRincianPembayaran">Lihat Pembayaran Bon</a>
                <a class="dropdown-item dropdowns" href="/mandor/absenTukang">Lihat Absen Tukang</a>
                <a class="dropdown-item dropdowns" href="/mandor/complain">Lihat Komplain Absen</a>
            </div>
            <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="collapse" data-target="#tukang6" aria-haspopup="true" aria-expanded="false">
                 Dana
            </button>
            <div class="collapse" id="tukang6" style="font-size: 2vh">
                <a class="dropdown-item dropdowns" href="/mandor/requestDana">Request Dana</a>
            </div>
        </div>
      </div>
  </div>
@endsection

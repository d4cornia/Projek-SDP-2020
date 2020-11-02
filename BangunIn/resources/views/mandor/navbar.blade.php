@extends('layout.layout')
@section('side-navbar')
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
@endsection

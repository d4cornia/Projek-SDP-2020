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
            <a class="dropdown-item" href="/kontraktor/edProfile">Edit Profile Perusahaan</a>
        </div>
    </div>

    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Client
        </button>
        <div class="dropdown-menu">
            {{--Dropdown Client--}}
            <a class="dropdown-item" href="/kontraktor/lihatClient">Lihat Client</a>
            <a class="dropdown-item" href="/kontraktor/addClient">Tambah Client</a>
            <a class="dropdown-item" href="/kontraktor/show">Input Pembayaran Client</a>
            <a class="dropdown-item" href="/kontraktor/listPembayaran">List Pembayaran Client</a>
            <a class="dropdown-item" href="/kontraktor/listDeleteClient">List Delete Client</a>
            <a class="dropdown-item" href="/kontraktor/inputTagihan">Input Tagihan</a>
            <a class="dropdown-item" href="/kontraktor/listTagihan">List Tagihan</a>
            <a class="dropdown-item" href="/kontraktor/listKomisi">List Pembayaran Komisi</a>
        </div>
    </div>

    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Pekerjaan
        </button>
        <div class="dropdown-menu">
            {{--Dropdown Pekerjaan--}}
            <a class="dropdown-item" href="/kontraktor/lWork">Lihat Pekerjaan</a>
            <a class="dropdown-item" href="/kontraktor/iSpWork">Lihat Pekerjaan Khusus</a>
        </div>
    </div>

    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Mandor
        </button>
        <div class="dropdown-menu">
            {{--Dropdown Mandor--}}
            <a class="dropdown-item" href="/kontraktor/lMandor">Lihat Mandor</a>
        </div>
    </div>

    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Admin
        </button>
        <div class="dropdown-menu">
            {{--Dropdown Admin--}}
            <a class="dropdown-item" href="/kontraktor/lAdmin">Lihat Admin</a>
        </div>
    </div>
    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Request Dana
        </button>
        <div class="dropdown-menu">
            {{--Dropdown Admin--}}
            <a class="dropdown-item" href="/kontraktor/lihatRequest">Konfirmasi Dana</a>
        </div>
    </div>

@endsection


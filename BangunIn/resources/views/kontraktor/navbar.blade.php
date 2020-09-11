@extends('layout.layout')

@section('side-navbar')
    <h2 class="judul">Bangun.in</h2>
    <hr class="w-25 text-center">
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
        </div>
    </div>

    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Pekerjaan
        </button>
        <div class="dropdown-menu">
            {{--Dropdown Pekerjaan--}}
            <a class="dropdown-item" href="/kontraktor/lWork">Lihat Pekerjaan</a>
            <a class="dropdown-item" href="/kontraktor/aWork">Tambah Pekerjaan</a>
            <a class="dropdown-item" href="/kontraktor/iSpWork">Lihat Pekerjaan Khusus</a>
            <a class="dropdown-item" href="/kontraktor/aSpWork">Tambah Pekerjaan Khusus</a>
        </div>
    </div>

    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Mandor
        </button>
        <div class="dropdown-menu">
            {{--Dropdown Mandor--}}
            <a class="dropdown-item" href="/kontraktor/lMandor">Lihat Mandor</a>
            <a class="dropdown-item" href="/kontraktor/rMandor">Tambah Mandor</a>
        </div>
    </div>

    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Admin
        </button>
        <div class="dropdown-menu">
            {{--Dropdown Admin--}}
            <a class="dropdown-item" href="/kontraktor/lAdmin">Lihat Admin</a>
            <a class="dropdown-item" href="/kontraktor/rAdmin">Tambah Admin</a>
        </div>
    </div>
@endsection



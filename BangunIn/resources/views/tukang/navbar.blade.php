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
        Tukang
    </button>
    <div class="dropdown-menu">
        {{--Dropdown Tukang--}}
        <a class="dropdown-item" href="/tukang/history">Lihat Riwayat absen</a>
        <a class="dropdown-item" href="/tukang/absen">Absen</a>
    </div>
</div>
@endsection

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
            Tukang
        </button>
        <div class="dropdown-menu">
            {{--Dropdown Tukang--}}
            <a class="dropdown-item" href="/tukang/history">Lihat Riwayat absen</a>
            <a class="dropdown-item" href="/tukang/absen">Absen</a>
            <a class="dropdown-item" href="/tukang/konfirmasi">Konfirmasi Penerimaan Dana</a>
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
        <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="collapse" data-target="#logout" aria-haspopup="true" aria-expanded="false">
            Welcome,<br>{{session()->get('nama')}}
        </button>
        <div class="collapse" id="logout" style="font-size: 2vh">
            <a class="dropdown-item dropdowns" href="/logout">Log Out</a>
            <a class="dropdown-item dropdowns" href="/kontraktor/edProfile">Edit Profile Perusahaan</a>

        </div>
        <div class=" p-4 text-white" style="background-color: #2d3338">
            <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="collapse" data-target="#tukang" aria-haspopup="true" aria-expanded="false">
                Tukang
            </button>
            <div class="collapse" id="tukang" style="font-size: 2vh">
                {{--Dropdown Tukang--}}
                <a class="dropdown-item dropdowns" href="/tukang/history">Lihat Riwayat absen</a>
                <a class="dropdown-item dropdowns" href="/tukang/absen">Absen</a>
                <a class="dropdown-item dropdowns" href="/tukang/konfirmasi">Konfirmasi Penerimaan Dana</a>
            </div>
        </div>
      </div>
  </div>
@endsection

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
    <div class="btn-group nav-side">
        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Laporan
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="/report/iuangKeseluruhan">Laporan total keseluruhan proyek</a>
            <a class="dropdown-item" href="/kontraktor/iSpWork">Laporan Detail Pekerjaan</a>
            <a class="dropdown-item" href="/report/budgetMandor">Laporan pengeluaran mandor</a>
            <a class="dropdown-item" href="/report/gajiAllTukang">Laporan gaji tukang</a>
            <a class="dropdown-item" href="/report/buktiPembayaran">Bukti Pembayaran Client</a>
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
            <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="collapse" data-target="#tukang2" aria-haspopup="true" aria-expanded="false">
                Welcome,<br>{{session()->get('nama')}}
            </button>
            <div class="collapse" id="tukang2" style="font-size: 2vh">
                <a class="dropdown-item dropdowns" href="/logout">Log Out</a>
                <a class="dropdown-item dropdowns" href="/kontraktor/edProfile">Edit Profile Perusahaan</a>

            </div>
            <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="collapse" data-target="#tukang3" aria-haspopup="true" aria-expanded="false">
                Client
            </button>
            <div class="collapse" id="tukang3" style="font-size: 2vh">
                {{--Dropdown Tukang--}}
                <a class="dropdown-item dropdowns" href="/kontraktor/lihatClient">Lihat Client</a>
                <a class="dropdown-item dropdowns" href="/kontraktor/addClient">Tambah Client</a>
                <a class="dropdown-item dropdowns" href="/kontraktor/show">Input Pembayaran Client</a>
                <a class="dropdown-item dropdowns" href="/kontraktor/listPembayaran">List Pembayaran Client</a>
                <a class="dropdown-item dropdowns" href="/kontraktor/listDeleteClient">List Delete Client</a>
                <a class="dropdown-item dropdowns" href="/kontraktor/inputTagihan">Input Tagihan</a>
                <a class="dropdown-item dropdowns" href="/kontraktor/listTagihan">List Tagihan</a>
                <a class="dropdown-item dropdowns" href="/kontraktor/listKomisi">List Pembayaran Komisi</a>
            </div>
            <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="collapse" data-target="#tukang4" aria-haspopup="true" aria-expanded="false">
                Pekerjaan
            </button>
            <div class="collapse" id="tukang4" style="font-size: 2vh">
                <a class="dropdown-item dropdowns" href="/kontraktor/lWork">Lihat Pekerjaan</a>
            <a class="dropdown-item dropdowns" href="/kontraktor/iSpWork">Lihat Pekerjaan Khusus</a>
            </div>
            <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="collapse" data-target="#tukang5" aria-haspopup="true" aria-expanded="false">
                Mandor
            </button>
            <div class="collapse" id="tukang5" style="font-size: 2vh">
                {{--Dropdown Tukang--}}
                <a class="dropdown-item dropdowns" href="/kontraktor/lMandor">Lihat Mandor</a>
            </div>
            <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="collapse" data-target="#tukang6" aria-haspopup="true" aria-expanded="false">
                 Admin
            </button>
            <div class="collapse" id="tukang6" style="font-size: 2vh">
                <a class="dropdown-item dropdowns" href="/kontraktor/lAdmin">Lihat Admin</a>
            </div>
            <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="collapse" data-target="#tukang7" aria-haspopup="true" aria-expanded="false">
                Request Dana
           </button>
           <div class="collapse" id="tukang7" style="font-size: 2vh">
                <a class="dropdown-item dropdowns" href="/kontraktor/lihatRequest">Konfirmasi Dana</a>
           </div>
           <button type="button" class="btn btn-link dropdown-toggle w-100 text-white but" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Laporan
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item dropdowns" href="/report/iuangKeseluruhan">Laporan total keseluruhan proyek</a>
                <a class="dropdown-item dropdowns" href="/kontraktor/iSpWork">Laporan Detail Pekerjaan</a>
                <a class="dropdown-item dropdowns" href="/report/budgetMandor">Laporan pengeluaran mandor</a>
                <a class="dropdown-item dropdowns" href="/report/gajiAllTukang">Laporan gaji tukang</a>
            </div>
        </div>
      </div>
  </div>
@endsection


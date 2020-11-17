@extends('kontraktor.navbar')

@section('content')
<h1>Periode Laporan</h1>
<hr>
<div class="row-first">
    <form action="/report/sPeriode" method="post">
        @csrf
        <span class="form-group">
            <label for="work">Laporan</label>
            <div class="my-1">
                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="mode" id="mode" style='width:50%;'>
                    <option selected>-</option>
                    <option value="all_proyek">Keseluruhan Proyek</option>
                    <option value="req_mandor">Pengeluaran Mandor</option>
                    <option value="gaji_tukang">Gaji Tukang</option>
                </select>
                @error('mode')
                <div class="err">
                    {{$message}}
                </div>
                @enderror
            </div>
        </span>
        <br>
        <span class="form-group">
            <label for="work">Periode Awal</label>
            <input type="date" class="form-control" name="periodeAwal" value="" style='width:30%;' required>
        </span>
        <br>
        <span class="form-group">
            <label for="work">Periode Akhir</label>
            <input type="date" class="form-control" name="periodeAkhir" value="" style='width:30%;' required>
        </span>
        <div style='float:none;'></div>
        <br>
        <button type="submit" class="btn btn-info">Lihat Laporan</button>
    </form>
</div>
@endsection

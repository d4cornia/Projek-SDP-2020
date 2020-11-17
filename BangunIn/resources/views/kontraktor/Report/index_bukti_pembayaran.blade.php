@extends('kontraktor.navbar')

@section('content')
<h1>Laporan Bukti Pembayaran</h1>
<div class="row-first">
    <form action="/report/searchPembayaran" method="post">
        @csrf
        <span class="form-group">
            <label for="work">Nama Pekerjaan</label>
            <div class="my-1">
                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="work" id="work">
                    <option selected>-</option>
                    @foreach ($listPekerjaan as $item)
                        <option value="{{$item['kode_pekerjaan']}}">{{$item['nama_pekerjaan']}}</option>
                    @endforeach
                </select>
            </div>
        </span>
        <button type="submit" class="btn btn-info">Laporan</button>
    </form>
</div>
@endsection

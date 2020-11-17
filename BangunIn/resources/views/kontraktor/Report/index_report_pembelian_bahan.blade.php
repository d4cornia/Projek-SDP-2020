@extends('kontraktor.navbar')

@section('content')
<h1>Laporan Pembelian Bahan</h1>
<div class="row-first">
    <form action="/report/reportPembelian" method="post">
        @csrf
        <span class="form-group">
            <label for="work">Nama Pekerjaan</label>
            <div class="my-1">
                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="id_project" id="work">
                    <option selected>-</option>
                    @foreach ($work as $item)
                        <option value="{{$item['kode_pekerjaan']}}">{{$item['nama_pekerjaan']}}</option>
                    @endforeach
                </select>
                @error('work')
                <div class="err">
                    {{$message}}
                </div>
                @enderror
            </div>
        </span>
        <button type="submit" class="btn btn-info">Laporan</button>
    </form>
</div>
@endsection
@extends('kontraktor.navbar')

@section('content')
<h1>Laporan Pembelian Bahan</h1>
<div class="row-first  mt-5">
    <form action="/report/reportPembelian" method="post">
        @csrf
        <span class="form-group">
            <label for="work">Nama Pekerjaan</label>
            <div class="my-1 ">
                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="id_project" id="work">
                    <option selected>-</option>
                    @foreach ($work as $item)
                        <option value="{{$item['kode_pekerjaan']}}">{{$item['nama_pekerjaan']}}</option>
                    @endforeach
                </select>
                <div class="form-row mt-2 mb-4">
                    <div class="col-2">
                        <input type="radio" name="jenis" value="all" id="radio" onclick="check(1)"><span class="ml-3"checked="checked" >Semua</span>
                    </div>
                    <div class="col-2">
                        <input type="radio" name="jenis" value="notall" id="radio" onclick="check(0)"><span class="ml-3">Periode</span>
                    </div>
                </div>
                <div class="form-row mt-2 mb-4">
                    <div class="col-6">
                        <label>Periode Awal</label>
                        <input type="date" name="start" id="start" class="form-control">
                    </div>
                    <div class="col-6">
                        <label>Periode Ahkir</label>
                        <input type="date" name="end" id="end" class="form-control" >
                    </div>
                </div>
                @error('work')
                <div class="err">
                    {{$message}}
                </div>
                @enderror
            </div>
        </span>
        <div class="form-group text-right">
            <button type="submit" class="btn btn-info">Laporan</button>
        </div>

    </form>
</div>
<script>
    check(1);
    function check(id){
        if(id==1){
            $('#start').attr('readonly','readonly');
            $('#end').attr('readonly','readonly');
        }
        else{
            $('#start').removeAttr('readonly','readonly');
            $('#end').removeAttr('readonly','readonly');
        }
    }
</script>
@endsection

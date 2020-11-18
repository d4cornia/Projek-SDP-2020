@extends('kontraktor.navbar')

@section('content')
<script>
</script>
<script>
    function disable() {
        var komisi = document.getElementById("type2");
        var deal = document.getElementById("dealPrice");
        if(komisi.checked == true){
            deal.value = "";
            document.getElementById("dealPrice").disabled = true;
        }else{
            document.getElementById("dealPrice").disabled = false;
        }
    }
</script>
<h1>Tambah Pekerjaan</h1>
<hr>
<form method="POST" action="/kontraktor/submitAddWork" class="option needs-validation" novalidate>
    @csrf
    <div class="form-group">
        <label for="name">Nama Perkejaan</label>
        <input type="text" class="form-control" name="name" id="name" value="@if(isset($bef)){{$bef['name']}}@else{{old('name')}}@endif">
        @error('name')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="nc">Nama Client</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="nc" id="nc">
                <option selected>-</option>
                @isset($listClient)
                    @foreach ($listClient as $item)
                        <option value="{{$item}}" @isset($bef) @if ($bef['nc'] == $item)
                                selected
                            @endif
                        @endisset @if(old('nc') == $item) selected @endif>{{$item}}</option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="nm">Nama Mandor</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="nm" id="nm">
                <option selected>-</option>
                @isset($listMandor)
                    @foreach ($listMandor as $item)
                        <option value="{{$item['username_mandor']}}" @isset($bef) @if ($bef['nm'] == $item['username_mandor'])
                                selected
                            @endif
                        @endisset @if(old('nm') == $item['username_mandor']) selected @endif>{{$item['nama_mandor'].' - '.$item['username_mandor']}}</option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="na">Nama Admin</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="na" id="na">
                <option selected>-</option>
                @isset($listAdmin)
                    @foreach ($listAdmin as $item)
                        <option value="{{$item['username_admin']}}" @isset($bef) @if ($bef['na'] == $item['username_admin'])
                                selected
                            @endif
                        @endisset @if(old('na') == $item['username_admin']) selected @endif>{{$item['nama_admin'].' - '.$item['username_admin']}}</option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="address">Alamat</label>
        <input type="text" class="form-control" name="address" id="address" value="@if(isset($bef)){{$bef['address']}}@else{{old('address')}}@endif" >
        @error('address')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="specAgreement">Perjanjian Khusus</label>
        <textarea class="form-control" name="specAgreement" id="specAgreement" rows="8">@if(isset($bef)){{$bef['specAgreement']}}@else{{old('specAgreement')}}@endif</textarea>
    </div>
    <div class="form-group">
        <label for="inlineRadio1" class="">Jenis Pekerjaan</label>
        <span class="col-6">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="type1" value="0" @if(isset($bef)) @if ($bef['type'] == '0')
                    checked
                @endif @endif onclick="disable()">
            <label class="form-check-label" for="inlineRadio1">Harga Fix Di Depan</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="type2" value="1" onclick="disable()" @if(isset($bef)) @if ($bef['type'] == '1')
                checked
            @endif @endif>
                <label class="form-check-label" for="inlineRadio2">Komisi</label>
            </div>
        </span>
    </div>
    <div class="form-group">
        <label for="dealPrice">Harga Deal</label>
        <input type="number" class="form-control" name="dealPrice" id="dealPrice" value="@if(isset($bef)){{$bef['dealPrice']}}@else{{old('dealPrice')}}@endif" id="dealPrice" @if(isset($bef)) @if ($bef['type'] == 1)
        disabled
    @endif @endif>
        @error('dealPrice')
        <div class="err">
            {{$message}}
        </div>
        @enderror
    </div>
    <hr class="option">
    <div class="option padd">
        <h3>Pekerjaan Khusus</h3>
        <div class="option table-responsive">
            <table id="tabel-spWork" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Keterangan Pekerjaan Khusus</th>
                    <th scope="col">Total Harga</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="">
                @isset($listSpWork)
                    @foreach ($listSpWork as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item['ketPK']}}</td>
                            <td>Rp. {{number_format($item['sumJasa'])}}</td>
                            <td>
                                <a href="/kontraktor/delSpWorkRow/{{encrypt($loop->iteration)}}" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Keterangan Pekerjaan Khusus</th>
                    <th scope="col">Total Harga</th>
                    <th scope="col">Aksi</th>
                </tr>
            </tfoot>
            </table>
        </div>
            <div class="form-group">
                <label for="ketPK">Keterangan Perkejaan Khusus</label>
                <textarea class="form-control" name="ketPK" id="ketPK" value="{{old('ketPK')}}" rows="10"></textarea>
                @error('ketPK')
                    <div class="err">
                        {{$message}}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="sumJasa">Ongkos Kerja</label>
                <input type="number" class="form-control" name="sumJasa" id="sumJasa" value="{{old('sumJasa')}}">
                @error('sumJasa')
                    <div class="err">
                        {{$message}}
                    </div>
                @enderror
            </div>
            <button type="submit" name="addSpWork" value="spW" class="btn btn-info">Tambah Pekerjaan Khusus</button>
    </div>
    <button type="submit" name="addWork" value="sp" class="option btn btn-primary">Tambah Pekerjaan</button>
</form>
@endsection

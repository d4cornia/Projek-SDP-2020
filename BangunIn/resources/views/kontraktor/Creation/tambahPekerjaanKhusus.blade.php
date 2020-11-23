@extends('kontraktor.navbar')

@section('content')
<h1>Tambah Pekerjaan Khusus</h1>
<hr>
<form method="POST" action="/kontraktor/submitAddSpecWork" novalidate>
    @csrf
    <div class="form-group">
        <label for="nc">Nama Pekerjaan</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="kode" id="kode">
                <option selected>-</option>
                @if($listWork !== null)
                    @foreach ($listWork as $item)
                        <option value="{{$item['kode_pekerjaan']}}" @if ($work[0]['nama_pekerjaan'] == $item['nama_pekerjaan'])
                            selected
                        @endif>{{$item['nama_pekerjaan']}}</option>
                    @endforeach
                @endif
            </select>
            @error('kode')
                <div class="err">
                    {{$message}}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <label for="ketPK">Keterangan Perkejaan Khusus</label>
        <textarea class="form-control" name="ketPK" id="ketPK" rows="10">{{old('ketPK')}}</textarea>
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
    <input type="hidden" name="kode_pekerjaan" value="{{$work[0]['kode_pekerjaan']}}">
    <button type="submit" class="btn btn-primary">Tambah</button>
    <a class="btn btn-secondary" href="/kontraktor/iSpWork">Kembali</a>
</form>
@endsection

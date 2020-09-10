@extends('kontraktor.navbar')

@section('content')
<form method="POST" action="/kontraktor/updSpWork" novalidate>
    @csrf
    <div class="form-group">
        <label for="nc">Nama Pekerjaan</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="work" id="work">
                <option selected>-</option>
                @foreach ($listWork as $item)
                    <option value="{{$item['kode_pekerjaan']}}" @if ($spWork[0]['kode_pekerjaan'] == $item['kode_pekerjaan'])
                    selected
                    @endif>{{$item['nama_pekerjaan']}}</option>
                @endforeach
            </select>
            @error('work')
                <div class="err">
                    {{$message}}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <label for="ketPK">Keterangan Perkejaan Khusus</label>
        <textarea class="form-control" name="ketPK" id="ketPK" value="{{$spWork[0]['keterangan_pk']}}" rows="10"></textarea>
        @error('ketPK')
            <div class="err">
                {{$message}}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="sumJasa">Ongkos Kerja</label>
        <input type="number" class="form-control" name="sumJasa" id="sumJasa" value="{{$spWork[0]['total_jasa'])}}">
        @error('sumJasa')
            <div class="err">
                {{$message}}
            </div>
        @enderror
    </div>
    <input type="hidden" name="id" value="{{$spWork[0]['kode_pk']}}">
    <button type="submit" class="btn btn-primary">Tambah</button>
</form>
@endsection

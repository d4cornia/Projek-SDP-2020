@extends('kontraktor.navbar')

@section('content')
<form method="POST" action="/kontraktor/submitAddSpecWork" novalidate>
    @csrf
    <div class="form-group">
        <label for="nc">Nama Pekerjaan</label>
        <div class="my-1">
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="work" id="work">
                <option selected>-</option>
                @foreach ($listWork as $item)
                    <option value="{{$item['kode_pekerjaan']}}">{{$item['nama_pekerjaan']}}</option>
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
    <button type="submit" class="btn btn-primary">Tambah</button>
</form>
@endsection

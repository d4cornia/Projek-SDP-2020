@extends('kontraktor.navbar')

@section('content')

<script>
    function disable(ctr) {
        var cb = document.getElementById("t" + ctr);
        if(cb.val == "-"){
            document.getElementById("i" + ctr).disabled = true;
        }else{
            document.getElementById("i" + ctr).disabled = false;
        }
    }
</script>


    @if ($listSpWork !== null)
    <h1>Daftar Pekerjaan Khusus</h1>
    <form action="/mandor/searchSpWork" method="post">
        <div class="row-first" style=" margin:80px 0px 50px 0px;">
                @csrf
                <div class="form-group">
                    <label for="work">Nama Pekerjaan</label>
                    <div class="my-1">
                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="work" id="work">
                            <option selected>-</option>
                            @if ($listWork !== null)
                                @foreach ($listWork as $item)
                                    <option value="{{$item['kode_pekerjaan']}}" @if ($item['kode_pekerjaan'] == $current['kode_pekerjaan'])
                                        selected
                                    @endif>{{$item['nama_pekerjaan']}}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('work')
                        <div class="err">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
    <form action="/assignSpWork" method="post">
        <div class="row-second">
                <div class="table-responsive">
                <table id="tabel-work" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Keterangan Pekerjaan Khusus</th>
                        <th scope="col">Tukang</th>
                    </tr>
                </thead>
                <tbody id="">
                    @if ($mode == 1)
                        @foreach ($listSpWork as $item)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$item->keterangan_pk}}</td>
                                    <td>
                                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="tukang" id="tukang" readonly>
                                            <option selected>-</option>
                                            @if ($listTukang !== null)
                                                @foreach ($listTukang as $tuk)
                                                    <option value="{{$tuk['kode_tukang']}}" @if ($tuk['kode_tukang'] == $item['kode_tukang'])
                                                        selected
                                                    @endif>{{$tuk['nama_tukang']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                </tr>
                        @endforeach
                    @else
                            @foreach ($listSpWork as $item)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$item->keterangan_pk}}</td>
                                        <td>
                                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="tukang[]" id="t{{$loop->iteration}}" onchange="disable({{$loop->iteration}})">
                                                <option selected>-</option>
                                                @if ($listTukang !== null)
                                                    @foreach ($listTukang as $tuk)
                                                        <option value="{{$tuk['kode_tukang']}}" @if ($tuk['kode_tukang'] == $item['kode_tukang'])
                                                            selected
                                                        @endif>{{$tuk['nama_tukang']}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                    </tr>
                                    <input type="hidden" name="id[]" id="i{{$loop->iteration}}" value="{{$item['kode_pk']}}">
                            @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Keterangan Pekerjaan Khusus</th>
                        <th scope="col">Tukang</th>
                    </tr>
                </tfoot>
                </table>
                </div>
        </div>
        <div class="row-three">
            @if ($mode == 1)
                <a class="btn btn-secondary" href="/mandor/editSpWork">Ubah</a>
            @else
                <button type="submit" class="btn btn-primary">Simpan</button>
            @endif
        </div>
    </form>
    @else
    <h1>Daftar Pekerjaan Khusus</h1>
    <div class="row-first">
        <form action="/mandor/searchSpWork" method="post">
            @csrf
            <span class="form-group">
                <label for="work">Nama Pekerjaan</label>
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
            </span>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-work").DataTable();
    } );
    </script>
@endsection

@extends('mandor.navbar')

@section('content')

<script>
    function disable(ctr) {
        document.getElementById("t" + ctr).disabled = false;
    }
</script>

<style>
    img {
      border: 1px solid #ddd; /* Gray border */
      border-radius: 4px;  /* Rounded border */
      padding: 5px; /* Some padding */
      width: 120px; /* Set a small width */
      height: 100px;
    }

    /* Add a hover effect (blue shadow) */
    img:hover {
      box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
    }
</style>

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
    <form action="/mandor/assignSpWork" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
        @csrf
        <div class="row-second">
                <div class="table-responsive">
                <table id="tabel-work" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Keterangan Pekerjaan Khusus</th>
                        <th scope="col">Tukang</th>
                        <th scope="col">Bukti</th>
                        <th scope="col">Jumlah dana</th>
                        <th scope="col">Status Selesai</th>
                    </tr>
                </thead>
                <tbody id="">
                    @if ($mode == 1)
                        @foreach ($listSpWork as $item)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$item->keterangan_pk}}</td>
                                    <td>
                                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="tukang" id="tukang" disabled>
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
                                    <td>
                                        @if ($item->pk_dana !== null)
                                        <a target="_blank" href="/assets/bukti_dana_pk/{{$item->pk_dana->bukti_tsf_dana}}" alt="/assets/default_tukang.png">
                                            <img src="/assets/bukti_dana_pk/{{$item->pk_dana->bukti_tsf_dana}}"  alt="/assets/default_tukang.png">
                                        </a>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->pk_dana !== null)
                                            Rp. {{number_format($item->pk_dana->dana)}}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        <input style="width: 25%; margin: auto" class="form-control" type="checkbox" @if ($item->status_selesai == 1)
                                        checked
                                    @endif  disabled>
                                    </td>
                                </tr>
                        @endforeach
                    @else
                            @foreach ($listSpWork as $item)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$item->keterangan_pk}}</td>
                                        <td>
                                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="tukang[]" id="t{{$loop->iteration}}">
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
                                        <td>
                                            @if ($item->pk_dana !== null)
                                                <a target="_blank" href="/assets/bukti_dana_pk/{{$item->pk_dana->bukti_tsf_dana}}" alt="/assets/default_tukang.png">
                                                    <img src="/assets/bukti_dana_pk/{{$item->pk_dana->bukti_tsf_dana}}"  alt="/assets/default_tukang.png">
                                                </a>
                                            @else
                                                <input type='file' name='bukti_dana[]' onchange="disable({{$loop->iteration}})"/>
                                                <input type="hidden" name="type_file[]" id="t{{$loop->iteration}}" value="{{$loop->iteration - 1}}" disabled>
                                                @error('bukti_dana')
                                                <div class="err">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->pk_dana !== null)
                                                <input type="number" name="dana[]" value="{{$item->pk_dana->dana}}" id="">
                                                <input type="hidden" name="idpkd[]" value="{{$item->pk_dana->kode_pk_dana}}">
                                                <input type="hidden" name="upd[]" value="{{$loop->iteration - 1}}">
                                            @else
                                                <input type="number" name="dana[]" value="0" id="">
                                            @endif
                                        </td>
                                        <td>
                                            <input style="width: 25%; margin: auto" class="form-control" name="status[]"
                                            @if ($item->status_selesai == 1)
                                                checked
                                            @endif value="{{$loop->iteration - 1}}" type="checkbox">
                                        </td>
                                        <input type="hidden" name="id[]" value="{{$item['kode_pk']}}">
                                    </tr>
                            @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Keterangan Pekerjaan Khusus</th>
                        <th scope="col">Tukang</th>
                        <th scope="col">Bukti</th>
                        <th scope="col">Jumlah dana</th>
                        <th scope="col">Status Selesai</th>
                    </tr>
                </tfoot>
                </table>
                </div>
        </div>
        <div class="row-three">
            @if ($mode == 1)
                <a class="btn btn-info" href="/mandor/editSpWork">Ubah</a>
            @else
                <button type="submit" class="btn btn-success">Simpan</button>
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

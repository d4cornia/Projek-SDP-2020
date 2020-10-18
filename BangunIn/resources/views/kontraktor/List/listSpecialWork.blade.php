@extends('kontraktor.navbar')

@section('content')
    @if ($listSpWork !== null)
    <h1>Daftar Pekerjaan Khusus</h1>
    <div class="option" style="float: right; margin:5px 0px 40px 0px;">
        <a class="btn btn-primary" href="/kontraktor/aSpWork/{{$current['kode_pekerjaan']}}">Tambah Pekerjaan Khusus</a>
        <a class="btn btn-secondary" href="/kontraktor/sSpDelWork/{{$current['kode_pekerjaan']}}">Lihat Pekerjaan Khusus Yang Dihapus</a>
    </div>
        <div class="row-first" style=" margin:80px 0px 50px 0px;">
            <form action="/kontraktor/search" method="post">
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
            </form>
        </div>
        <div class="row-second">
            <div class="table-responsive">
            <table id="tabel-work" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Keterangan Pekerjaan Khusus</th>
                    <th scope="col">Total Bahan</th>
                    <th scope="col">Total Jasa</th>
                    <th scope="col">Total Keseluruhan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody id="">
                @foreach ($listSpWork as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->keterangan_pk}}</td>
                            <td>{{$item->total_bahan}}</td>
                            <td>{{$item->total_jasa}}</td>
                            <td>{{$item->total_keseluruhan}}</td>
                            <td>
                                <a href="/kontraktor/detSpWorkMenu/{{encrypt($item->kode_pk)}}" class="btn btn-success">Detail</a>
                                <a href="/kontraktor/delSpWorkMenu/{{encrypt($item->kode_pk)}}" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Keterangan Pekerjaan Khusus</th>
                    <th scope="col">Total Bahan</th>
                    <th scope="col">Total Jasa</th>
                    <th scope="col">Total Keseluruhan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </tfoot>
            </table>
            </div>
        </div>
    @else
    <h1>Daftar Pekerjaan Khusus</h1>
    <div class="row-first">
        <form action="/kontraktor/search" method="post">
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

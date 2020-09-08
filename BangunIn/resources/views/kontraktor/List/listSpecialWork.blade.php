@extends('kontraktor.navbar')

@section('content')
    @if ($listSpWork !== null)
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
                    </div>
                </span>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <div class="row-second"><div class="table-responsive">
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
                                <a href="/kontraktor/detSpWork/{{$item->kode_pk}}" class="btn btn-success">Detail</a>
                                <a href="/kontraktor/delSpWork/{{$item->kode_pk}}" class="btn btn-danger">Hapus</a>
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
                    </div>
                </span>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-work").DataTable();
    } );
    </script>
@endsection

@extends('kontraktor.navbar')

@section('content')
    @if (count($listSpWork) > 0)
        <div class="row">
            <form action="/search" method="post">
                @csrf
                <span class="form-group">
                    <label for="exampleInputEmail1">Nama Pekerjaan</label>
                    <input type="text" class="form-control" name="search" value="{{old('username')}}">
                    @error('search')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </span>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <div class="row"><div class="table-responsive">
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
                                <a href="/kontraktor/detSpWork/{{$item->kode_pk}}}" class="btn btn-success">Detail</a>
                                <a href="/kontraktor/delSpWork/{{$item->kode_pk}}}" class="btn btn-danger">Hapus</a>
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
            <form action="/search" method="post">
                @csrf
                <span class="form-group">
                    <label for="exampleInputEmail1">Nama Pekerjaan</label>
                    <input type="text" class="form-control" name="search" value="{{old('username')}}">
                    @error('search')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
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

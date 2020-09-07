@extends('mandor.navbar')

@section('content')
    @if (count($listTukang) > 0)
        <div class="table-responsive">
            <table id="tabel-tukang" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama Tukang</th>
                    <th scope="col">Jenis Tukang</th>
                    <th scope="col">Gaji</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Email</th>
                    <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listTukang as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->username_tukang}}</td>
                            <td>{{$item->nama_tukang}}</td>
                            @foreach ($listJenis as $item2)
                                @if ($item->kode_jenis == $item2->kode_jenis)
                                    <td>{{$item2->nama_jenis}}</td>
                                @endif
                            @endforeach
                            <td>{{$item->gaji_pokok_tukang}}</td>
                            <td>{{$item->no_hp_tukang}}</td>
                            <td>{{$item->email_tukang}}</td>
                            <td>
                                <a href="/mandor/detTukang/{{$item->kode_tukang}}}" class="btn btn-success">Detail</a>
                                <a href="/mandor/delTukang/{{$item->kode_tukang}}}" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama Tukang</th>
                    <th scope="col">Jenis Tukang</th>
                    <th scope="col">Gaji</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Email</th>
                    <th scope="col">Aksi</th>
                </tr>
              </tfoot>
            </table>
            </div>
    @else
        <h1>Tidak Ada Tukang!</h1>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-tukang").DataTable();
    } );
    </script>
@endsection
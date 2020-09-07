@extends('kontraktor.navbar')

@section('content')
    @if (count($listAdmin) > 0)
        <div class="table-responsive">
            <table id="tabel-admin" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama Admin</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Email</th>
                    <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listAdmin as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->username_admin}}</td>
                            <td>{{$item->nama_admin}}</td>
                            <td>{{$item->no_hp_admin}}</td>
                            <td>{{$item->email_admin}}</td>
                            <td>
                                <a href="/kontraktor/detAdmin/{{$item->kode_admin}}}" class="btn btn-success">Detail</a>
                                <a href="/kontraktor/delAdmin/{{$item->kode_admin}}}" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama Admin</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Email</th>
                    <th scope="col">Aksi</th>
                </tr>
              </tfoot>
            </table>
            </div>
    @else
        <h1>Tidak Ada Admin!</h1>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-admin").DataTable();
    } );
    </script>
@endsection

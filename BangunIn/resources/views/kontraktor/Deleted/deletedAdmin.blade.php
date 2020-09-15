@extends('kontraktor.navbar')

@section('content')
    @if (count($listDelAdmin) > 0)
        <h1>List Admin</h1>
        <div class="table-responsive">
            <table id="tabel-admin" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama Admin</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">Email</th>
                    <th scope="col">Gaji Admin</th>
                    <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listDelAdmin as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->username_admin}}</td>
                            <td>{{$item->nama_admin}}</td>
                            <td>{{$item->no_hp_admin}}</td>
                            <td>{{$item->email_admin}}</td>
                            <td>Rp. {{number_format($item->gaji_admin)}}</td>
                            <td>
                                <a href="/kontraktor/rollbackAdmin/{{encrypt($item->kode_admin)}}" class="btn btn-info">Pulihkan</a>
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
                    <th scope="col">Gaji Admin</th>
                    <th scope="col">Aksi</th>
                </tr>
              </tfoot>
            </table>
            </div>
            <div class="option">
                <a class="btn btn-secondary" href="/kontraktor/lAdmin">Kembali</a>
            </div>
    @else
        <h1>Tidak Ada Admin Yang Dihapus!</h1>
        <div class="option">
            <a class="btn btn-secondary" href="/kontraktor/lAdmin">Kembali</a>
        </div>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-admin").DataTable();
    } );
    </script>
@endsection

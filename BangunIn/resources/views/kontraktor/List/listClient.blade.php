@extends('kontraktor.navbar')

@section('content')
<div class="tombol" style="float:right">
    <a href="/kontraktor/addClient" class="btn btn-primary">Tambah Client</a>
    <a class="btn btn-secondary" href="/kontraktor/listDeleteClient">Lihat Client Yang Dihapus</a>
</div>
<br><br>
    @if (count($listClients) > 0)
        <div class="table-responsive">
            <table id="tabel-client" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Client</th>
                    <th>Nomor Telepon</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listClients as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->nama_client}}</td>
                            <td>{{$item->no_hp_client}}</td>
                            <td>
                                <a href="/kontraktor/detClient/{{encrypt($item->kode_client)}}" class="btn btn-success">Detail</a>
                                <a href="/kontraktor/delClient/{{encrypt($item->kode_client)}}" class="btn btn-danger delete">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>No</th>
                    <th>Nama Client</th>
                    <th>Nomor Telepon</th>
                    <th>Action</th>
                </tr>
              </tfoot>
            </table>
            </div>
    @else
        <h1>Tidak Ada Client!</h1>
        <hr>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-client").DataTable();
    } );
    </script>
@endsection


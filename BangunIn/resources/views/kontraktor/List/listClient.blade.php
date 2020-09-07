@extends('kontraktor.navbar')

@section('content')
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
                                <a href="/kontraktor/detClient/{{$item->kode_client}}}" class="btn btn-success">Detail</a>
                                <a href="/kontraktor/delClient/{{$item->kode_client}}}" class="btn btn-danger">Hapus</a>
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
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-client").DataTable();
    } );
    </script>
@endsection


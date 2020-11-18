@extends('kontraktor.navbar')

@section('content')
    @if (count($listDataDeleteClient) > 0)
        <div class="table-responsive">
            <table id="tabel-delete" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Client</th>
                    <th>Nomor Telepon</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listDataDeleteClient as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->nama_client}}</td>
                            <td>{{$item->no_hp_client}}</td>
                            <td>
                                <a href="/kontraktor/resClient/{{encrypt($item->kode_client)}}" class="btn btn-danger delete">Batal Hapus</a>
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
        <h1>Tidak Ada Client yang dihapus!</h1>
        <hr>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-delete").DataTable();
    } );
    </script>
@endsection


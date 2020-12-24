@extends('kontraktor.navbar')

@section('content')
<h1>Daftar Client Yang Dihapus</h1>
<hr>
<br>
<div class="tombol" style="float:right">
    <a class="btn btn-info" href="/kontraktor/lihatClient">Kembali</a>
</div>
<br><br>
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
                                <a href="/kontraktor/resClient/{{encrypt($item->kode_client)}}" class="btn btn-secondary delete">Batal Hapus</a>
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
        <h2>Tidak Ada Client yang dihapus!</h2>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-delete").DataTable();
    } );
    </script>
@endsection


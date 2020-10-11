@extends('admin.navbar')

@section('content')
    <h1>Toko Bangunan</h1>
    <div class="option" style="float:right">
        <a class="btn btn-primary"  href="/admin/tambahToko">Tambah Toko Bangunan</a>
    </div>
    <br>
    @if (count($listToko) > 0)
        <div class="table-responsive" style='margin-top:50px'>
            <table id="tabel-toko" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Toko</th>
                    <th>Alamat Toko</th>
                    <th>No Telp Toko</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listToko as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->nama_toko}}</td>
                            <td>{{$item->alamat_toko}}</td>
                            <td>{{$item->no_hp_toko}}</td>
                            <td>
                                <a href="/admin/editToko/{{$item->id_kerjasama}}" class="btn btn-success">Detail</a>
                            </td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>No</th>
                    <th>Nama Toko</th>
                    <th>Alamat Toko</th>
                    <th>No Telp Toko</th>
                    <th>Action</th>
                </tr>
              </tfoot>
            </table>
            </div>

    @else
        <h4>Tidak Ada Toko Bangunan!</h4>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-toko").DataTable();
    } );
    </script>
@endsection


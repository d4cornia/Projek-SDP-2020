@extends('admin.navbar')

@section('content')
    <label for="exampleInputEmail1">Nama Toko</label>
    <input type="text" class="form-control" name="name" value="{{$toko[0]["nama_toko"]}}" disabled='disabled'>

    @if (count($listBahan) > 0)
        <div class="table-responsive" style='margin-top:50px'>
            <table id="tabel-toko" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Bahan</th>
                    <th>Harga Bahan</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($listBahan as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->nama_bahan}}</td>
                            <td>{{$item->harga_satuan}}</td>
                            <td>
                                <a href="/admin/veditBahan/{{$item->id_bahan}}/{{$item->id_kerjasama}}" class="btn btn-warning">Edit</a>
                                <a href="/admin/deleteBahan/{{$item->id_bahan}}/{{$item->id_kerjasama}}" onclick="return confirm('Yakin Hapus?')"class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>No</th>
                    <th>Nama Bahan</th>
                    <th>Harga Bahan</th>
                    <th>Action</th>
                </tr>
              </tfoot>
            </table>
            </div>

    @else
        <h4>Tidak Bahan!</h4>
    @endif
    @if($msg = Session::get('success'))
    <script>
        swal('Berhasil!', "{{Session::get('success')}}", "success");
    </script>
@endif
    <script>
        $(document).ready(function() {
            $("#tabel-toko").DataTable();
    } );
    </script>
@endsection

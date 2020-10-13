@extends('admin.navbar')

@section('content')
    <h2>Update Barang</h2>
    <form style='margin-top:50px' method="POST" action="/admin/editBahan?idbahan={{$idbahan}}&&idkerjasama={{$id}}" class="needs-validation" novalidate>
        @csrf
        <label for="exampleInputEmail1">Nama Toko</label>
        <input type="text" class="form-control" name="name" value="{{$toko[0]["nama_toko"]}}" disabled='disabled'>
        <div class="form-group">
            <label for="exampleInputEmail1">Nama Bahan</label>
            <input type="text" class="form-control" value="{{$bahan["nama_bahan"]}}" name="nmbahan" required>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Harga Bahan</label>
            <input type="number" class="form-control" value="{{$bahan["harga_satuan"]}}"  min="0" name="hargabahan" required step="500">
        </div>
        <button type="submit" class="btn btn-warning">Update Bahan</button>
    </form>
@endsection

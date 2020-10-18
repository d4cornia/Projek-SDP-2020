@extends('admin.navbar')

@section('content')
    <h1>Bon Pembelian Bahan</h1>
    <div class="option" style="float:right;margin-bottom:10px">
        <a class="btn btn-primary"  href="/admin/vpembelianNota">Input Pembelian Bahan</a>
    </div>
    <br>
    <br>
    @if (count($pembelian) > 0)
        <div class="table-responsive">
            <table id="tabel-nota" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Toko Bangunan</th>
                    <th>Pekerjaan</th>
                    <th>Total Pembelian</th>
                    <th>Tanggal Pembelian</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody id="">
                @foreach ($pembelian as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            @php
                                $namatoko="";
                            @endphp
                            @foreach ($toko as $item2)
                                @if ($item2->id_kerjasama==$item->id_kerjasama)
                                    @php
                                        $namatoko=$item2->nama_toko;
                                    @endphp
                                @endif
                            @endforeach
                            <td>{{$namatoko}}</td>
                            @foreach ($pekerjaan as $item2)
                                @if ($item2->kode_pekerjaan == $item->kode_pekerjaan)
                                    @php
                                        $namapek = $item2->nama_pekerjaan;
                                    @endphp
                                @endif
                            @endforeach
                            <td>{{$namapek}}</td>
                            <td align="right">Rp. {{number_format($item->total_pembelian)}}</td>
                            <td>{{$item->tanggal_beli}}</td>
                            <td>
                                <a href="/admin/detnotabeli/{{$item->id_pembelian}}" class="btn btn-success">Detail</a>
                            </td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>No</th>
                    <th>Toko Bangunan</th>
                    <th>Pekerjaan</th>
                    <th>Total Pembelian</th>
                    <th>Tanggal Pembelian</th>
                    <th>Action</th>
                </tr>
              </tfoot>
            </table>
            </div>

    @else
        <h4>Tidak Ada Bon Pembelian Bahan!</h4>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-nota").DataTable();
    } );
    </script>
@endsection


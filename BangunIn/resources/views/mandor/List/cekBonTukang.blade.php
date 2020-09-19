@extends('mandor.navbar')

@section('content')
    <h1>Detail Bon : {{$nama}}</h1>
    <div class="option" style="color:red;">
        @php
            $jumbon=0;
        @endphp
        @foreach ($listBon as $item)
            @php
            $jumbon+=$item->sisa_bon;
        @endphp
        @endforeach
        <h3>Kekurangan Pembayaran Bon : Rp @php
            echo number_format($jumbon);
        @endphp</h3>
    </div>
    @php
        $mypath = "/mandor/tambahBonTukangX/".$kode;
    @endphp
        <input type='hidden' name='kodetkg' value={{$kode}}>
            <div class="option" style="margin-left:84%">
            <a class="btn btn-primary"  href={{$mypath}}>Tambah Bon Tukang</a>
        </div>
    <br>

    @if (count($listBon) > 0)
        <div class="table-responsive">
            <table id="tabel-bon" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Jumlah Bon</th>
                    <th>Sisa Bon</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody id="">
                  @php
                      $jumbon=0;
                  @endphp
                    @foreach ($listBon as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            @php
                                $tahun = substr($item->tanggal_pengajuan,0,4);
                                $bulan = substr($item->tanggal_pengajuan,5,2);
                                $tanggal = substr($item->tanggal_pengajuan,8);
                            @endphp
                            <td>{{$tanggal}}-{{$bulan}}-{{$tahun}}</td>
                            <td>Rp. {{number_format($item->jumlah_bon)}}</td>
                            <td>Rp. {{number_format($item->sisa_bon)}}</td>
                            <td>{{$item->keterangan_bon}}</td>
                            <td>
                                <a href="/mandor/detailPembayaranBon/{{$item->kode_bon}}" class="btn btn-info">Detail Pembayaran</a>
                            </td>
                        </tr>

                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Jumlah Bon</th>
                    <th>Sisa Bon</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                </tr>
              </tfoot>
            </table>

            </div>
    @else
        <h1>Tidak Ada Bon!</h1>
    @endif
    <a class="btn btn-secondary" href="/mandor/lihatBon">Kembali</a>
    <script>
        $(document).ready(function() {
            $("#tabel-bon").DataTable();
    } );
    </script>
@endsection


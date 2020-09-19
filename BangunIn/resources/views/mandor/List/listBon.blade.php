@extends('mandor.navbar')

@section('content')
    <h1>Bon Tukang</h1>
    <h3>Mandor : {{$mandor}}</h3>
    @php
        $jumbon=0;
    @endphp
    @foreach ($listBon as $item)
        @php
            $jumbon+=$item->sisa_bon;
        @endphp
    @endforeach
    <h3 style="color:red;">Bon yang belum terbayar : Rp
        @php
            echo number_format($jumbon);
        @endphp
    </h3>
    <div class="option" style="margin-left:76%">
        <a class="btn btn-primary"  href="/mandor/tambahBon">Tambah Bon</a>
        <a class="btn btn-secondary"  href="/mandor/tambahPembayaranBon">Pembayaran Bon</a>
    </div>
    <br>
    @if (count($listBon) > 0)
    <div class="table-responsive">
        <table id="tabel-tukang" class="table table-bordered table-striped">
          <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Tukang</th>
                <th scope="col">Jenis Tukang</th>
                <th scope="col">Tanggal Pengajuan Pertama</th>
                <th scope="col">Bon</th>
                <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody id="">
            @foreach ($listTukang as $item)
                <tr>
                    @php
                        $jumbon=0;
                        $tgl=date('Y-m-d');
                        $thn = substr($tgl,0,4);
                        $thn+=2;
                        $lanjut=substr($tgl,4);
                        $tgl=$thn.$lanjut;
                    @endphp
                    @foreach ($listBon as $bon)
                        @if ($bon->kode_tukang==$item->kode_tukang)
                            @php
                                $jumbon+=$bon->sisa_bon;
                            @endphp
                            @if ($bon->tanggal_pengajuan<$tgl)
                                @php
                                    $tgl=$bon->tanggal_pengajuan;
                                @endphp
                            @endif
                        @endif
                    @endforeach
                    @if ($jumbon!=0)
                    <th scope="row">{{$loop->iteration}}</th>
                    <td>{{$item->nama_tukang}}</td>
                    @foreach ($listJenis as $item2)
                        @if ($item->kode_jenis == $item2->kode_jenis)
                            <td>{{$item2->nama_jenis}}</td>
                        @endif
                        @php
                                $tahun = substr($tgl,0,4);
                                $bulan = substr($tgl,5,2);
                                $tanggal = substr($tgl,8);
                        @endphp
                    @endforeach
                    <td>{{$tanggal}}-{{$bulan}}-{{$tahun}}</td>
                    <td>@php echo "Rp.". number_format($jumbon);@endphp</td>
                    <td>
                        <a href="/mandor/cekBonTukang/{{$item->kode_tukang}}" class="btn btn-info">Detail Bon</a>
                    </td>
                    @endif
                </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Tukang</th>
                <th scope="col">Jenis Tukang</th>
                <th scope="col">Tanggal Pengajuan Pertama</th>
                <th scope="col">Bon</th>
                <th scope="col">Aksi</th>
            </tr>
          </tfoot>
        </table>
        </div>
    @else
        <h1>Tidak Ada Bon!</h1>
    @endif
    <script>
        $(document).ready(function() {
            $("#tabel-bon").DataTable();
    } );
    </script>
@endsection


@extends('mandor.navbar')

@section('content')
    <h1>Pembayaran Bon Tukang <a class="btn btn-primary"  href="/mandor/tambahPembayaranBon" style="margin-left:40%">Tambah Pembayaran Bon</a></h1>
    <hr>
    <h3>Mandor : {{$mandor}}</h3>
    <div class="option">
        <form action="/mandor/filterRincianBon" method='post' class="needs-validation" novalidate>
            @csrf
            <div style="width:100%">
                <label for="exampleInputEmail1" style="float:left;margin-top:1%;"><h6>Tanggal Pembayaran</h6></label>
                <input type="date" class="form-control" name="tanggalbayar" value="{{old('tanggalbayar')}}" style='width:20%;float:left;margin-left:2%' required>&nbsp;
                <button type='submit' class="btn btn-primary" style="float:left;margin-left:2%">Lihat Pembayaran</button>
                <div class="invalid-feedback" style="clear:both;float:left;">
                    Kolom Tanggal belum diisi!
                </div>
                @error('tanggalbayar')
                <div class="err" style="clear:both;float:left;">
                    {{$message}}
                </div>
                @enderror
                <a class="btn btn-secondary"  href="/mandor/lihatRincianPembayaran">Lihat Semua Pembayaran Bon</a>
            </div>
        </form>
    </div><br><br><br>
    @if (count(json_decode($arrtgl)) > 0)
        @foreach (json_decode($arrtgl) as $item)
            <h3>Tanggal Penerimaan : {{$item->tanggal}}</h3>
            <h2>Total Penerimaan : Rp. {{number_format($item->total)}}</h3>
                @php
                    $ctr=1;
                @endphp
                <div class="table-responsive">
                    <table id="tabel-tukang" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Tukang</th>
                            <th scope="col">Bon</th>
                            <th scope="col">Jumlah</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach (json_decode($arrbon) as $bon)
                            @if ($bon->tanggal==$item->tanggal)
                                @foreach ($listBon as $bontukang)
                                    @if ($bon->kode_bon==$bontukang->kode_bon)
                                        @foreach ($listTukang as $tukang)

                                            @if ($bontukang->kode_tukang==$tukang->kode_tukang)
                                                <tr>
                                                <th scope="row">{{$ctr}}</th>
                                                <td>{{$tukang->nama_tukang}}</td>
                                                <td>{{$bontukang->keterangan_bon}}</td>
                                                <td>Rp. {{number_format($bon->jumlah)}}</td>
                                                </tr>
                                                @php
                                                    $ctr++;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Tukang</th>
                            <th scope="col">Bon</th>
                            <th scope="col">Jumlah</th>
                        </tr>
                      </tfoot>
                    </table>
                </div>
                <br>
        @endforeach
    @else
        <h1>Tidak Ada Pembayaran Bon!</h1>
    @endif
@endsection


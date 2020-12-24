@extends('mandor.navbar')

@section('content')
    <h1>Detail Bon : {{$tukang}}</h1>
    <hr>
    <div class="option" style="color:red;">
        @php
            $sisa=0;
        @endphp
        @foreach ($bon as $item)
            @php
            $sisa=$item->sisa_bon;
        @endphp
        @endforeach
        <h3>Kekurangan Pembayaran Bon : Rp @php
            echo number_format($sisa);
        @endphp</h3>
    </div>
    <h5>Diterima Mandor : {{$mandor}}</h5>

        <div class="option">
            <form action="/mandor/tambahBayarKhusus" method='post' class="needs-validation" novalidate>
                @csrf
                <input type='hidden' name='kodebon' value={{$kdbon}}>
                <div style="width:100%">
                    <label for="exampleInputEmail1" style="float:left;margin-top:1%;"><h6>Jumlah Tambahan Pembayaran</h6></label>
                    <input type="text" class="form-control" name="jumlah" value="{{old('jumlah')}}" style='width:20%;float:left;margin-left:2%' required>&nbsp;
                    <button type='submit' class="btn btn-primary" style="float:left;margin-left:2%">Tambah Pembayaran</button>
                    <div class="invalid-feedback" style="clear:both;float:left;">
                        Kolom Jumlah hanya berisi angka!
                    </div>
                    @error('jumlah')
                    <div class="err" style="clear:both;float:left;">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </form>
        </div><br><br><br>
    @if (count($listBayar) > 0)
        <div class="table-responsive">
            <table id="tabeldetbyr" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Jumlah Bon</th>
                </tr>
              </thead>
              <tbody id="">
                    @foreach ($listBayar as $item)
                        @foreach ($listKodeBayar as $item2)
                            @if ($item->kode_pembayaran_bon==$item2->kode_pembayaran_bon)
                                @php
                                    $tgl = $item2->tanggal_pembayaran_bon;
                                @endphp
                            @endif
                        @endforeach
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            @php
                                $tahun = substr($tgl,0,4);
                                $bulan = substr($tgl,5,2);
                                $tanggal = substr($tgl,8);
                            @endphp
                            <td>{{$tanggal}}-{{$bulan}}-{{$tahun}}</td>
                            <td>Rp. {{number_format($item->jumlah_pembayaran_bon)}}</td>
                        </tr>
                    @endforeach
              </tbody>
              <tfoot>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Jumlah Bon</th>
                </tr>
              </tfoot>
            </table>

            </div>
    @else
        <h1>Belum Ada Pembayaran!</h1>
    @endif
    @php
        $mypath="/mandor/lihatBonTukang/".$kode;
    @endphp
    <a class="btn btn-secondary" href="{{$mypath}}">Kembali</a>
    <script>
        $(document).ready(function() {
            $("#tabeldetbyr").DataTable();
    } );
    </script>
@endsection


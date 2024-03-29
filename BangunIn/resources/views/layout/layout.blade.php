@if(!session()->has('kode'))
    <script>
        window.location.href = '{{url("/")}}';
    </script>
@endif
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{session()->get('status')}}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/general/navbar.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="icon"
    type="image/png"
    href="assets/homepage/logo.png">

    <style>
        .err{
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
            color: #dc3545;
        }
        .row-first , .row-second{
            margin-bottom: 40px;
        }

        .option{
            margin-top: 30px;
        }

        .succ, .kon{
            width: 100%;
            margin-top: .25rem;
            font-size: 85%;
            color: #28a745;
            border: 1px solid #28a745;
            border-radius: 2rem;
            margin: 15px 20px 10px 0px;
            padding: 15px;
            width: fit-content;
        }

        .padd{
            padding: 40px;
            border: solid black 1px;
            border-radius: 1rem;
        }

        #content{
            overflow-y:auto;
            margin-left: 15%;
        }

        #side-nav{
            position: fixed; /* Set the navbar to fixed position */
            left: 0;
        }
    </style>
</head>
<body>
    <div class="col-12 d-lg-none">
        @yield('mob-navbar')
    </div>
   <div class="row">
        <div class="col-lg-2 col-md-2 pl-2 d-none d-lg-block" id="side-nav" style="box-shadow:10px 0px 20px rgb(233, 233, 233);height:100%">
            @yield('side-navbar')
        </div>
        <div class="col-lg-10 col-md-12 p-5 d-none d-lg-block" id="content">
            <div class="pl-5">
                @yield('content')
            </div>
        </div>
        <div class="col-lg-10 col-md-12 pl-5 pb-5 pr-5 d-lg-none d-sm-block d-md-block "  style="padding-top: 20%">
            @yield('content')
        </div>
   </div>
</body>
</html>


{{-- berhasil/gagal tambah --}}
@if(session()->get('error') != null)
<script>
    swal("Tukang belum melakukan absen di minggu ini!", "", "error");
</script>
@endif

@isset($error)

    @if ($error == 21)
    <script>
        swal("Berhasil Melakukan Pembayaran!", "", "success");
        myVar = setTimeout(() => {
            document.getElementById("succ").style.display = "none";
        }, 5000);
    </script>
    @endif
    @if ($error == 20)
    <script>
        swal("Berhasil Request Dana!", "Request Dana berhasil!","success");
    </script>
    @endif
    @if ($error == 19)
    <script>
        swal("Berhasil Melunasi Bon Bahan!", "Pembayaran Bon Bahan berhasil!","success");
    </script>
    @endif
    @if ($error == 18)
    <script>
        swal("Gagal delete tagihan!", "Pembayaran dengan tagihan tersebut masih ada!","error");
    </script>
    @endif
    @if ($error == 17)
    <script>
        swal("Berhasil input pembayaran!", "Pembayaran komisi berhasil!","success");
    </script>
    @endif
    @if ($error == 16)
    <script>
        swal("Berhasil input pembayaran!", "Pembayaran berhasil!","success");
    </script>
    @endif
    @if ($error == 15)
    <script>
        swal("Berhasil input tagihan!", "Tagihan berhasil!","success");
    </script>
    @endif
    @if ($error == 14)
    <script>
        swal("Gagal Menghapus Tukang!", "Tukang masih memiliki hutang yang belum dibayarkan!","error");
    </script>
    @endif
    @if ($error == 13)
    <script>
        swal("Bon Telah Lunas!", "", "success");
    </script>
    @endif
    @if ($error == 12)
    <script>
        swal("Berhasil Menambah Bon Tukang!", "", "success");
    </script>
    @endif
    @if ($error == 11)
    <script>
        swal("Berhasil Update Password Tukang!", "", "success");
    </script>
    @endif
    @if ($error == 10)
    <script>
        swal("Berhasil Mengembalikan Jenis Tukang!", "", "success");
    </script>
    @endif
    @if ($error == 9)
    <script>
        swal("Berhasil Ubah!", "", "success");
    </script>
    @endif
    @if ($error == 8)
    <script>
        swal("Gagal Ubah!", "Belum memilih Jenis Tukang untuk Tukang ini!","error");
    </script>
    @endif
    @if ($error == 7)
    <script>
        swal("Gagal Tambah!", "Belum memilih Tukang untuk Bon ini!","error");
    </script>
    @endif
    @if ($error == 6)
    <script>
        swal("Gagal Tambah!", "Belum memilih Jenis Tukang untuk Tukang ini!","error");
    </script>
    @endif
    @if ($error == 5)
    <script>
        swal("Gagal Tambah!", "Nama Jenis telah terdaftar!", "error");
    </script>
    @endif
    @if ($error == 4)
    <script>
        swal("Gagal Tambah!", "Belum memilih Mandor untuk pekerjaan ini!", "error");
    </script>
    @endif
    @if ($error == 2)
    <script>
        swal("Gagal Tambah!", "Belum memilih Admin untuk pekerjaan ini!", "error");
    </script>
    @endif
    @if ($error == 3)
    <script>
        swal("Gagal Tambah!", "Belum memilih Client untuk pekerjaan ini!", "error");
    </script>
    @endif
    @if ($error == 0)
    <script>
        swal("Berhasil Tambah!", "", "success");
        myVar = setTimeout(() => {
            document.getElementById("succ").style.display = "none";
        }, 5000);
    </script>
    @endif
    @if ($error == 1)
    <script>
        swal("Gagal Tambah!", "Username sudah terpakai!", "error");
    </script>
    @endif
@endisset
@isset($fail)
<script>
    swal("Gagal Hapus!", "{{$fail}}", "error");
</script>
@endisset
@isset($upd)
    <script>
        swal("Berhasil Ubah!", "{{$upd}}", "success");
    </script>
@endisset
@if(session()->has('upd'))
    <script>
        swal("Berhasil Ubah!", "{{session()->get('upd')}}", "success");
    </script>
@php
    session()->forget('upd')
@endphp
@endif
@if(session()->has('done'))
    <script>
        swal("Berhasil!", "{{session()->get('done')}}", "success");
    </script>
@php
    session()->forget('done')
@endphp
@endif
@if(session()->has('err'))
    <script>
        swal("Gagal!", "{{session()->get('err')}}", "error");
    </script>
@php
    session()->forget('err')
@endphp
@endif
@isset($del)
    <script>
        swal("Berhasil Hapus!", "{{$del}}", "success");
    </script>
@endisset
@isset($roll)
    <script>
        swal("Berhasil Mengembalikan!", "{{$roll}}", "success");
    </script>
@endisset
@isset($err)
    <script>
        swal("Berhasil input tagihan!", "success");
    </script>
@endisset
@isset($succ)
    <script>
        swal("Berhasil Absen","{{$succ}}" , "success");
        myVar = setTimeout(() => {
            document.getElementById("succ").style.display = "none";
        }, 5000);
    </script>
@endisset

@isset($succInputNota)
    <script>
        swal("Berhasil!","{{$succInputNota}}" , "success");
    </script>
@endisset
@isset($errAbsen)
    <script>
        swal("Gagal","{{$errAbsen}}" , "error");
    </script>
@endisset
@isset($kon)
    <script>
        swal("Berhasil Konfirmasi Absen","{{$kon}}" , "success");
        myVar = setTimeout(() => {
            document.getElementById("kon").style.display = "none";
        }, 5000);
    </script>
@endisset
@if (isset($pesan))
    <script>
        swal("Berhasil!", "{{$pesan}}","success");
    </script>
@endif



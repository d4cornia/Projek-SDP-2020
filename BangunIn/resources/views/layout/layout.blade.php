<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{session()->get('status')}}</title>
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
    </style>
</head>
<body>
   <div class="row">
    <div class="col-lg-2 col-md-2 p-5">
        @yield('side-navbar')
    </div>
    <div class="col-lg-10 col-md-10 p-5">
        @yield('content')
    </div>
   </div>
</body>
</html>


{{-- berhasil/gagal tambah --}}
@isset($error)
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
    </script>
    @endif
    @if ($error == 1)
    <script>
        swal("Gagal Tambah!", "Username sudah terpakai!", "error");
    </script>
    @endif
@endisset
@isset($upd)
    <script>
        swal("Berhasil Ubah!", "{{$upd}}", "success");
    </script>
@endisset

@isset($del)
    <script>
        swal("Berhasil Hapus!", "{{$del}}", "success");
    </script>
@endisset

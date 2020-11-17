<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bangun.in</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pushbar.js@1.0.0/src/pushbar.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/pushbar.js@1.0.0/src/pushbar.min.css" rel="stylesheet">
    <link rel="icon"
      type="image/png"
      href="assets/homepage/logo.png">
    <style>
        html,body{
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }
        .header{
            font-family: 'Bebas Neue', cursive;
            color:white;
        }
        #nav li{
            list-style-type: none;
            display: inline;
            font-family: 'Bebas Neue', cursive;
            color:#4c4c4c;
            margin-left: 5%;
            color:white;
        }
        #nav li:hover{
            text-decoration: underline;
        }
        .nav-item{
            margin-right: 5%;
        }
        .nav-pills .nav-link {
            border-radius: 200px;
        }
        .heading{
            font-family: 'Oswald', sans-serif;
        }
        .card{
            box-shadow: 0 6px 10px rgba(0,0,0,.08), 0 0 6px rgba(0,0,0,.05);
            transition: 3s transform cubic-bezier(.155,1.105,.295,1.12),.3s box-shadow,.3s -webkit-transform cubic-bezier(.155,1.105,.295,1.12);
            cursor: pointer;
            color:
        }

        .card:hover{
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
        }
        .dropdowns{
                background-color: #2d3338;
                color:white;
                text-align: center;
                padding: 20px;
            }
            .dropdowns:hover{
                background-color: #2d3338;
                color:white;
            }
            .but:{
                border: 2px solid white;
            }

    </style>
</head>
<body >

    <div class="container d-none d-md-block d-lg-block" id="home">
        <div class="w-100 " style="position: fixed;z-index:2;">
            <div class="row tops pt-4 pb-2" id="nav">
                <span><img src="assets/homepage/logo.png" width="35vh" style="margin-top: 15%"></span>
                <div class="col-2 my-auto">

                    <h4 class="header menu my-auto" style="padding-top: 4.5%">Bangun.in</h4>
                </div>
                <div class="col-6 my-auto text-right">
                    <ul class="my-auto">
                        <a href="#home"><li class="menu">Beranda</li></a>
                        <a href="#fitur"><li class="menu">Fitur</li></a>
                        <a href="#contact"><li class="menu">Contact Us</li></a>
                        <a href="/vlogin"><li><button type="button" id="masuk" class="btn btn-outline-dark" style="border-radius: 200px;width:15%">Masuk</button></li></a>
                    </ul>
                </div>
            </div>
        </div>

    </div>
        <div class="pos-f-t d-lg-none d-md-none fixed-top">
            <div class="w-100 text-center">
                <nav class="navbar navbar-dark bg-dark" >
                    <div class="row w-100">
                        <div class="col-9">
                                <h4 class="header menu " style="text-align: left"><span><img src="assets/homepage/logo.png" width="35vh" class="mr-2"></span>Bangun.in</h4>
                        </div>
                        <div class="col-3 pl-5">
                            <button class="navbar-toggler mr-auto" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="panel-collapse collapse" id="navbarToggleExternalContent">
                        <a href="#home" class="dropdown-item dropdowns">Beranda</a>
                        <a href="#fitur" class="dropdown-item dropdowns">Fitur</a>
                        <a href="#contact" class="dropdown-item dropdowns">Contact Us</a>
                        <a href="/vlogin" class="dropdown-item dropdowns">Login</a>
                </div>
              </div>
          </div>
    </div>
    <section class="w-100" style="background-color:#1e88e5; height:100vh" id="tentang">
        <div class="container pt-3" >
            <div class="row">
                <div class="col-lg-5 col-sm-12">
                    <h1 class="header" style="margin-top: 25vh;font-size:7vh">Atur semua <br>Project pembangunan <br>dalam satu web</h1>
                    <a href="/register"><button type="button" class="btn btn-outline-light w-50 mt-3" style="border-radius: 200px">Daftar Sekarang</button><br></a>
                    <img src="/assets/homepage/shadow.png" class="mt-5"style="width: 30vh">
                </div>
                <div class="col-7 d-none d-md-block d-lg-block">
                    <img src="/assets/homepage/home.png" style="width: 100vh;margin-top:20%;margin-right:5% ">
                </div>
            </div>
        </div>
    </section>
    <div class="col-12 d-none d-md-block d-lg-block" style="position: sticky;width:100%;height:80px;background-color:#1e88e5;top: 0;color:#4c4c4c;z-index:1"></div>
    <section  class="w-100 " id="fitur" style="height:auto;padding-top:10%;margin-bottom:5%;">
        <div class="container">
            <h2 class=" heading text-center mb-3"  style="color:#1e88e5">Fitur Bangun.in</h2>
            <hr class="text-center" style="width: 20%">
            <ul class="nav nav-pills mb-3 text-center"  style="padding-left:30%;" id="pills-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Kontraktor</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Mandor</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-tukang" role="tab" aria-controls="pills-tukang" aria-selected="false">Tukang</a>
                </li>
            </ul>
            <div class="tab-content mx-auto" id="pills-tabContent" style="padding:5%;color:#1e88e5;padding-top:2%">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row">
                        <div class="col-lg-3 col-sm-12">
                            <div class="card text-center heading hoverable" >
                                <div class="col-12">
                                    <ion-icon name="person-add-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                </div>
                                <div class="card-body pt-2">
                                    <h6 class="card-title" ><b>Menambah Client</b></h6>
                                    <p class="card-text" style="font-size: 2vh">Kontraktor dapat menambah data client baru</p>
                                </div>
                            </div>
                            <div class="card text-center heading hoverable mt-2 pt-4 pb-3" >
                                <div class="col-12">
                                    <ion-icon name="briefcase-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                </div>
                                <div class="card-body pt-2">
                                    <h6 class="card-title" ><b>Menambah Admin</b></h6>
                                    <p class="card-text" style="font-size: 2vh">Kontraktor dapat menambah data Project baru</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="card text-center heading hoverable" >
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="col-12">
                                            <ion-icon name="folder-open-outline" class="pt-4" style="font-size: 5vh;"></ion-icon>
                                         </div>
                                        <div class="card-body pt-2">
                                            <h6 class="card-title" ><b>Menambah Pekerjaan</b></h6>
                                            <p class="card-text" style="font-size: 2vh">Kontraktor dapat menambah data Pekerjaan baru</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="col-12">
                                            <ion-icon name="albums-outline" class="pt-4" style="font-size: 5vh;"></ion-icon>
                                        </div>
                                        <div class="card-body pt-2">
                                            <h6 class="card-title" ><b>Menambah Pekerjaan Khusus</b></h6>
                                            <p class="card-text" style="font-size: 2vh">Kontraktor dapat menambah data Pekerja Khusus pada setiap pekerjaan </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card text-center heading hoverable mt-3 pt-4 pb-3" >
                                        <div class="col-12">
                                            <ion-icon name="bar-chart-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                        </div>
                                        <div class="card-body pt-2">
                                            <h6 class="card-title" ><b>Mendapat Laporan</b></h6>
                                            <p class="card-text" style="font-size: 2vh">Kontraktor dapat melihat laporan - laporan mengenai project tersebut</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card text-center heading hoverable mt-3 pt-4 pb-3" >
                                        <div class="col-12">
                                            <ion-icon name="eye-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                        </div>
                                        <div class="card-body pt-2">
                                            <h6 class="card-title" ><b>Mengecek Konfirmasi Mandor untuk Absen</b></h6>
                                            <p class="card-text" style="font-size: 2vh">Kontraktor dapat melihat laporan - laporan mengenai project tersebut</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="card text-center heading hoverable" >
                                <div class="col-12">
                                    <ion-icon name="wallet-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                </div>
                                <div class="card-body pt-2">
                                    <h6 class="card-title" ><b>Mencatat Pembayaran Client</b></h6>
                                    <p class="card-text" style="font-size: 2vh">Kontraktor dapat mencatat segala pemasukan/pembayaran dari client</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="card text-center heading hoverable mt-2 pt-4 pb-3" >
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12" style="border-right: 2px solid gray;">
                                        <div class="col-12">
                                            <ion-icon name="construct-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                        </div>
                                        <div class="card-body pt-2">
                                            <h6 class="card-title" ><b>Menambah Tukang</b></h6>
                                            <p class="card-text" style="font-size: 2vh">Mandor dapat menambah data tukang baru</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="col-12">
                                            <ion-icon name="build-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                        </div>
                                        <div class="card-body pt-2">
                                            <h6 class="card-title" ><b>Menambah Jenis Tukang</b></h6>
                                            <p class="card-text" style="font-size: 2vh">Mandor dapat membagi bagi tukang sesuai dengan pekjerjaannya</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card text-center heading hoverable mt-2 pt-4 pb-3" >
                                        <div class="col-12">
                                            <ion-icon name="cash-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                        </div>
                                        <div class="card-body pt-2">
                                            <h6 class="card-title" ><b>Mencatat Pembayaran Bon Tukang</b></h6>
                                            <p class="card-text" style="font-size: 2vh">Mandor dapat mencatat pembayaran bon tukang/p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="card text-center heading hoverable mt-2 pt-4 pb-3" >
                                        <div class="col-12">
                                            <ion-icon name="newspaper-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                        </div>
                                        <div class="card-body pt-2">
                                            <h6 class="card-title" ><b>Mencatat Bon Tukang</b></h6>
                                            <p class="card-text" style="font-size: 2vh">Mandor dapat mencatat bon tukang</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="card text-center heading hoverable mt-2 pt-4 pb-3" >
                                <div class="col-12">
                                    <ion-icon name="checkmark-done-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                </div>
                                <div class="card-body pt-2">
                                    <h6 class="card-title" ><b>Mengubah Status Pekerjaan Menjadi Selesai</b></h6>
                                    <p class="card-text" style="font-size: 2vh">Mandor dapat mengubah status Pekerjaan menjadi selesai ketika project yang di tangani selesai</p>
                                </div>
                            </div>
                            <div class="card text-center heading hoverable mt-2 pt-4 pb-3" >
                                <div class="col-12">
                                    <ion-icon name="document-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                </div>
                                <div class="card-body pt-2">
                                    <h6 class="card-title" ><b>Upload Nota Pembelian</b></h6>
                                    <p class="card-text" style="font-size: 2vh">Mandor dapat mengupload nota pembelian untuk suatu project </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="card text-center heading hoverable mt-2 pt-4 pb-3" >
                                <div class="col-12">
                                    <ion-icon name="calendar-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                </div>
                                <div class="card-body pt-2">
                                    <h6 class="card-title" ><b>Memantau Absensi Tukang</b></h6>
                                    <p class="card-text" style="font-size: 2vh">Mandor dapat memantau absensi harian tukang pada suatu project</p>
                                </div>
                            </div>
                            <div class="card text-center heading hoverable mt-2 pt-4 pb-3" >
                                <div class="col-12">
                                    <ion-icon name="cash-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                </div>
                                <div class="card-body pt-2">
                                    <h6 class="card-title" ><b>Request Dana</b></h6>
                                    <p class="card-text" style="font-size: 2vh">Mandor dapat merequest dana untuk sebuah project </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="row">
                        <div class="col-lg-3 col-sm-12">
                            <div class="card text-center heading hoverable mt-2 pt-4 pb-3" >
                                <div class="col-12">
                                    <ion-icon name="home-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                </div>
                                <div class="card-body pt-2">
                                    <h6 class="card-title" ><b>Menambah Toko Bangunan</b></h6>
                                    <p class="card-text" style="font-size: 2vh">Admin dapat menambah data mengenai toko bangunan yang baru</p>
                                </div>
                            </div>


                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="card text-center heading hoverable mt-2 pt-4 pb-3" >
                                <div class="col-12">
                                    <ion-icon name="document-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                </div>
                                <div class="card-body pt-2">
                                    <h6 class="card-title" ><b>Mengarsip Pembelihan Bahan Bangunan</b></h6>
                                    <p class="card-text" style="font-size: 2vh">Admin Dapat merekap untuk setiap pembelihan bahan bangunan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="card text-center heading hoverable mt-2 pt-4 pb-3" >
                                <div class="col-12">
                                    <ion-icon name="cube-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                </div>
                                <div class="card-body pt-2">
                                    <h6 class="card-title" ><b>Menambah Bahan Bangunan</b></h6>
                                    <p class="card-text" style="font-size: 2vh">Admin Dapat merekap untuk stok bahan bangunan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-tukang" role="tabpanel" aria-labelledby="pills-profile-tukang">
                    <div class="row">
                        <div class="col-lg-3 col-sm-12">
                            <div class="card text-center heading hoverable mt-2 pt-4 pb-3" >
                                <div class="col-12">
                                    <ion-icon name="calendar-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                </div>
                                <div class="card-body pt-2">
                                    <h6 class="card-title" ><b>Absensi Tukang</b></h6>
                                    <p class="card-text" style="font-size: 2vh">Tukang dapat  absensi harian tukang</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="card text-center heading hoverable mt-2 pt-4 pb-3" >
                                <div class="col-12">
                                    <ion-icon name="checkmark-done-outline" class="pt-3" style="font-size: 5vh;"></ion-icon>
                                </div>
                                <div class="card-body pt-2">
                                    <h6 class="card-title" ><b>Konfirmasi Gaji</b></h6>
                                    <p class="card-text" style="font-size: 2vh">Tukang dapat konfirmasi gaji telah diterima ketika mendapat gaji</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="col-12" style="position: sticky;width:100%;height:80px;background-color:#1e88e5;top: 0;color:#4c4c4c;z-index:1"></div>
    <section style="height:auto;padding-top:10%;background-color:#1e88e5;" id="contact">
        <div class="container" style="padding-top: 1%;padding-bottom: 2%;box-shadow: 0px 0px 20px #145d9c;margin-top:1%;">
            <div class="col-lg-12 col-sm-12" style="padding-bottom: 5%;">
                <h1 class="text-center header" style="margin-top: 6%">Segera Daftarkan Perusahaan anda</h1>
                <form action="/register" method="get" class="mt-5">
                    @csrf
                    <div class="row">
                        <div class="col-lg-1 col-sm-0 mr-5"></div>
                        <div class="col-lg-4 col-sm-2 mb-2">
                            <input type="text" name="nm" class="form-control" placeholder="Nama Perusahaan">
                        </div>
                        <div class="col-lg-4 col-sm-2 mb-2">
                            <input type="text" name="no" class="form-control" placeholder="Nomer Perusahaan">
                        </div>
                        <div class="col-lg-2">
                            <input type="submit" class="btn btn-outline-light" value="Daftarkan">
                        </div>
                    </div>
                </form>
                <div class="row" style="margin-top:10%">
                    <div class="col text-center" style="border-right: 2px solid white">
                        <h1 class="header">{{$kontraktor}}</h1>
                        <h4 class="heading" style="color:white">Kontraktor</h4>
                    </div>
                    <div class="col text-center" style="border-right: 2px solid white">
                        <h1 class="header">{{$mandor}}</h1>
                        <h4 class="heading" style="color:white">Mandor</h4>
                    </div>
                    <div class="col text-center" style="border-right: 2px solid white">
                        <h1 class="header">{{$admin}}</h1>
                        <h4 class="heading" style="color:white">Admin</h4>
                    </div>
                    <div class="col text-center">
                        <h1 class="header">{{$tukang}}</h1>
                        <h4 class="heading" style="color:white">Tukang</h4>
                    </div>
                </div>
            </div>

        </div>
        <br>
        <div class="container">
            <div class="row mt-5"  >
                <div class="col-4 text-center">
                    <a href="https://wa.link/up3zrp"><ion-icon name="logo-whatsapp" style="font-size: 5vh;color:black" class="mb-3"></ion-icon></a>
                    <p clas="mt-5 heading" style="color:white;">087851713100</p>
                </div>
                <div class="col-4 text-center"  style="color:white">
                    <a href="https://www.google.com/maps/place/Institut+Sains+dan+Teknologi+Terpadu+Surabaya+(iSTTS)/@-7.2913007,112.756635,17z/data=!3m1!4b1!4m5!3m4!1s0x2dd7fbb476048727:0x5f5f7cf736ae643e!8m2!3d-7.291306!4d112.758829"><ion-icon name="location-outline" style="font-size: 5vh;" class="mb-3"></ion-icon></a>
                    <p clas="mt-5 heading" style="color:white;">Jl.Mawar no 49</p>
                </div>
                <div class="col-4 text-center" >
                    <ion-icon name="logo-instagram" style="font-size: 5vh;" class="mb-3"></ion-icon>
                    <p clas="mt-5 heading" style="color:white;">Bangun.in</p>
                </div>
                <div class="col"></div>
            </div>
        </div>
    </section>
</body>
</html>
<script>
    var tentang = $('#tentang').height();
    var top = $('#fitur').height();
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        console.log('ok');
    }
</script>
<script type="text/javascript">
    new Pushbar({
    blur: true,
    verlay: true,
    });
    </script>

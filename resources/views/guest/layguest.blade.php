@php

use GuzzleHttp\Client;
// kategori
$client = new Client();
$response = $client->get('{{ $imgUrl }}/jurnal/navbar');
$responseBody = $response->getBody()->getContents();
$data = json_decode($responseBody);

if ($data !== null) {
if (property_exists($data, 'kategori')) {
$katee = $data->kategori;
$mainArray = $katee;
$peristiwaDaerahArray = collect($mainArray)->where('nama_kategori', 'Peristiwa Daerah')->toArray();
$peristiwaInternasionalArray = collect($mainArray)->where('nama_kategori', 'Peristiwa Internasional')->toArray();

$mainArray = collect($mainArray)->reject(function ($item) {
return $item->nama_kategori == 'Peristiwa Daerah' || $item->nama_kategori == 'Peristiwa Internasional';
})->toArray();

} else {
dd('Properti "kategori" tidak ditemukan dalam respons JSON.');
}

if (property_exists($data, 'navbar')) {
$navatas = $data->navbar;
} else {
dd('Properti "kategori" tidak ditemukan dalam respons JSON.');
}

if (property_exists($data, 'footer')) {
$footbawah = $data->footer;
} else {
dd('Properti "kategori" tidak ditemukan dalam respons JSON.');
}

if (property_exists($data, 'iklanTinggiKanan')) {
$iklanTKa = $data->iklanTinggiKanan;
} else {
dd('Properti "iklanTinggi" tidak ditemukan dalam respons JSON.');
}

if (property_exists($data, 'iklanTinggiKiri')) {
$iklanTKi = $data->iklanTinggiKiri;
} else {
dd('Properti "iklanTinggi" tidak ditemukan dalam respons JSON.');
}

if (property_exists($data, 'iklanPanjang')) {
$iklanP = $data->iklanPanjang;
} else {
dd('Properti "iklanPanjang" tidak ditemukan dalam respons JSON.');
}
} else {
dd('Gagal menguraikan JSON.');
}

@endphp

<!doctype html>
<html lang="en">

<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!---->
    <meta content="Jurnal Nusa - Segala berita, isu, & kejadian seputar nusantara indonesia" name="description">
    <meta content="Jurnal Nusa" name="keywords">
    <meta name="keywords" content="@yield('meta_keywords')">
    <meta name="thumbnailUrl" content="{{ asset('Log2.ico') }}" itemprop="thumbnailUrl">
    <meta content="#FFC310" name="theme-color" />

    {{-- robot --}}

    <!---->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <!-- Option 1: Include in HTML -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('Log2.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('Log2.ico') }}">
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('asset/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- sweetalert -->
    <script src="{{('/dist/jquery.min.js')}}"></script>
    <script src="{{('/dist/sweetalert2.all.min.js')}}"></script>
</head>

<body style="background-color: #fff;">
    @if (Session::has('success'))
    @php
    $escapedMessage = addslashes(Session::get('success'));
    @endphp
    <script>
        Swal.fire({
            width: 400,
            position: 'center',
            icon: 'success',
            title: '<?= $escapedMessage ?>',
            showConfirmButton: false,
            timer: 2000
        })
    </script>
    {{ Session::forget('success') }}
    @endif
    @if (Session::has('info'))
    @php
    $escapedMessage = addslashes(Session::get('info'));
    @endphp
    <script>
        Swal.fire({
            width: 400,
            position: 'center',
            icon: 'info',
            title: '<?= $escapedMessage ?>',
            showConfirmButton: false,
            timer: 2000
        })
    </script>
    {{ Session::forget('info') }}
    @endif

    @if (Session::has('error'))
    @php
    $escapedMessage = addslashes(Session::get('error'));
    @endphp
    <script>
        Swal.fire({
            width: 400,
            position: 'center',
            icon: 'error',
            title: '<?= $escapedMessage ?>',
            showConfirmButton: false,
        })
    </script>
    {{ Session::forget('error') }}
    @endif
    <header class="shadow-sm sticky-top">
        {{-- top --}}
        <nav class="navbar navbar-expand navbar-dark p-0 bg-creamX navbar1 " style="z-index: 1050">
            <div class="container col-lg-8">
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav d-flex align-items-center fs-14">
                        <li class="nav-item d-flex align-items-center">
                            @php

                            $today = Carbon\Carbon::now()
                            ->locale('id_ID')
                            ->isoFormat('dddd, DD MMMM YYYY');
                            @endphp
                            <a class="nav-link text-light d-flex align-items-center" href="#"><i class="ri-calendar-fill me-1 fs-6"></i> {{ $today }}
                            </a>
                        </li>
                        @forelse ($navatas as $item)
                        <li class="nav-item d-none d-lg-flex">
                            <a class="nav-link text-light" href="/informasi#tab{{$item->id_page}}">{{$item->judul}} </a>
                        </li>
                        @empty

                        @endforelse
                    </ul>
                </div>
            </div>
        </nav>
        {{-- end --}}
        {{-- desktop --}}
        <nav class="navbar navbar-light bg-white py-2 d-none d-md-block " style="z-index: 1050">
            <div class="container col-lg-8">
                <div class="start d-flex">
                    <button id="navbarDesktopToggleBtn" class="btn rounded-circle p-0 d-flex align-items-center me-3 bg-cream" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                        <i id="navbarDesktopIcon" class="ri-menu-line text-light d-flex align-items-center px-2 py-1 fs-5"></i>
                    </button>
                </div>
                <div class="">
                    @if(session('user'))
                    @php $user = session('user'); @endphp
                    <div class="row" style="display: inline;">
                        <span style="display: inline;">Hai, {{ strstr($user->nama_pengunjung, ' ', true) }}</span>
                        <a href="/logout" class="btn btn-outline-cream rounded-pill fw-semibold fs-14 text-capitalize" style="display: inline;">logout</a>
                    </div>


                    @else
                    <button class="btn btn-outline-cream rounded-pill fw-semibold fs-14" data-bs-target="#modlogin" data-bs-toggle="modal">Masuk / Daftar</button>
                    @endif
                </div>
            </div>
        </nav>
        {{-- end desktop --}}
        {{-- mobile --}}
        <nav class="navbar navbar-light bg-light py-2 d-md-none d-block " style="z-index: 1050">
            <div class="container col-lg-8 col-md-8">
                <div class="row align-items-center ">
                    <div class="col-2">
                        <button id="navbarMobileToggleBtn" class="btn rounded-pill p-0 d-flex align-items-center me-3 bg-cream" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                            <i id="navbarMobileIcon" class="ri-menu-line text-light d-flex align-items-center px-2 py-1 fs-5"></i>
                        </button>
                    </div>
                    <div class="col-8 text-center">
                        <a href="/">
                            <img src="{{ asset('jurnal.jpeg') }}" class="w-50 img-fluid rounded-1" alt="">
                        </a>
                    </div>
                    <div class="col-2">
                        <!-- <button class="navbar-toggler border-0"><i class="ri-search-2-line"></i></button> -->
                        <button type="button" class="btn btn-cream rounded-circle bg-red" data-bs-toggle="modal" data-bs-target="#basicModal">
                            <i class="ri-search-2-line"></i>
                        </button>

                    </div>
                </div>
                <!-- End Basic Modal-->
            </div>
        </nav>
        {{-- end mobile --}}
        {{-- --}}
        <nav class="navbar navbar-expand navbar-dark p-0 bg-white d-none navbar2 border-top border-3 border-warning shadow-lg" id="header-content7" style="z-index: 1050">
            <div class="container col-md-8">
                <div class="d-none d-md-block">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('logo/Logo1.png') }}" alt="Logo" width="130" height="50" class="d-inline-block align-text-top">
                    </a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav d-flex align-items-center fs-14 fw-bold">
                        <li class="nav-item">
                            <a class="as  {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Beranda </a>
                        </li>
                        <li class="nav-item">
                            <a class="as  {{ Request::is('daerahan*') ? 'active' : '' }}" href="{{ route('daerahan') }}">Daerah</a>
                        </li>
                        <li class="nav-item">
                            <a class="as  {{ Request::is('e-jurnal*') ? 'active' : '' }}" href="{{ route('e-jurnal') }}">e-Jurnal </a>
                        </li>
                        <li class="nav-item">
                            <a class="as {{ Request::is('kategori/politik*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'politik']) }}">Politik</a>
                        </li>
                        <li class="nav-item">
                            <a class="as {{ Request::is('kategori/pemerintahan*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'pemerintahan']) }}">Pemerintahan</a>
                        </li>
                        <li class="nav-item">
                            <a class="as {{ Request::is('kategori/hukum*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'hukum']) }}">Hukum</a>
                        </li>

                        <li class="nav-item">
                            <a class="as {{ Request::is('kategori/olahraga*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'olahraga']) }}">Olahraga</a>
                        </li>
                        <li class="nav-item">
                            <a class="as {{ Request::is('kategori/ekonomi*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'ekonomi']) }}">Ekonomi</a>
                        </li>
                        <li class="nav-item">
                            <a class="as {{ Request::is('kategori/lifestyle*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'lifestyle']) }}">Lifestyle</a>
                        </li>
                        <li class="nav-item">
                            <a class="as {{ Request::is('kategori/opini*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'opini']) }}">Opini</a>
                        </li>


                    </ul>
                </div>
            </div>
        </nav>

        {{-- offcanvas desktop & mobile--}}
        <div class="offcanvas offcanvas-start rounded-right bg-white border border-info border-start-0" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="top: 90px">
            <div class="offcanvas-header pt-5 border-bottom">
                @if(session('user'))
                @php $user = session('user'); @endphp
                <p class="offcanvas-title fw-bold text-capitalize" id="offcanvasNavbarLabel">Hai, {{$user->nama_pengunjung}}</p>
                <a href="/logout" class="btn btn-outline-warning">Logout</a>
                @else
                <p class="offcanvas-title fw-bold" id="offcanvasNavbarLabel">Pengunjung</p>
                <button type="button" class="btn btn-outline-warning" data-bs-target="#modlogin" data-bs-toggle="modal"> Login</button>
                @endif



            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link ps-2 rounded fw-bold {{ Request::is('/') ? 'active bg-light  border-bottom border-warning-subtle' : '' }}" href="{{ route('home') }}">Beranda </a>
                    </li>
                    <li class="nav-item ps-2 pt-2">
                        <p class=" fw-bold mb-1">Kategori</p>
                        @forelse ($mainArray as $item)
                        <a href="/kategori/{{$item->slug}}" class="p-1 btn btn-sm rounded-pill shadow-sm m-1  {{ Request::is('kategori/'.$item->slug) ? 'btn-warning active' : 'btn-light ' }}">
                            {{$item->nama_kategori}}
                        </a>
                        @empty
                        @endforelse
                    </li>
                    <li class="nav-item mt-1">
                        <p class="ps-2 fw-bold mb-1">Peristiwa</p>
                        @forelse ($peristiwaDaerahArray as $item)
                        <a href="/kategori/{{$item->slug}}" class="p-2 btn btn-light btn-sm rounded-pill shadow-sm m-1  {{ Request::is('kategori/'.$item->slug) ? 'btn-warning active' : 'btn-light ' }}">
                            {{$item->nama_kategori}}
                        </a>
                        @empty
                        @endforelse
                        @forelse ($peristiwaInternasionalArray as $item)
                        <a href="/kategori/{{$item->slug}}" class="p-2 btn btn-light btn-sm rounded-pill shadow-sm m-1  {{ Request::is('kategori/'.$item->slug) ? 'btn-warning active' : 'btn-light ' }}">
                            {{$item->nama_kategori}}
                        </a>
                        @empty

                        @endforelse
                    </li>
                </ul>
            </div>
        </div>
        {{-- end --}}
    </header>
    {{-- form --}}
    <div class="modal fade" id="modlogin" aria-hidden="true" aria-labelledby="modloginLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body p-3 pt-0">

                        <div class="text-center">
                            <img class="mb-3" src="{{ asset('logo/Logo1.png') }}" alt="..." style="height: 70px">
                            <div class="subheading-1 mb-5">Silahkan masuk untuk menggunakan fitur pengguna</div>
                        </div>

                        <div class="text-center mb-3">
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <a href="{{route('login.google')}}" class="btn btn-light">
                                    <img src="{{ asset('img/g.png') }}" alt="Gambar" width="30" height="30">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end --}}


    <main class="m-0 p-0">
        <div class="row d-flex justify-content-center m-0 p-0">
           
            <!-- content -->
            <div class="col col-lg-8" id="myText">

                @yield('contents')

            </div>
            <!-- end content -->

        </div>
    </main>

    <!-- Footer -->
    <footer class=" text-lg-start text-muted" style="background-color: rgb(248, 248, 248);">
        <!-- Section: Links  -->
        <hr style="color: #d38900;">
        <section class="d-flex justify-content-center justify-content-lg-between p-2 border-bottom container">
            <div class="container text-md-start mt-md-3 mt-sm-1">
                <!-- Grid row -->
                <div class="row mt-3">
                    <div class="row col-12 col-lg-8 col-md-8 mx-2">
                        <div class="col-4 mr-0 d-flex justify-content-end">
                            <img src="{{ asset('log5.png') }}" alt="Logo" width="auto" height="100" class="d-inline-block align-text-top">

                        </div>
                        <div class="col-8">
                            <p><b>JurnalNusa</b> - Berita Positif Terbaru dan Terkini</p>
                            <p class="fw-medium fs-13">Portal berita positif yang menyajikan informasi terkini tentang peristiwa, cek fakta, e-jurnal, politik, entertainment, kuliner, gaya hidup, dan wisata</p>
                        </div>
                    </div>
                    <div class="row col-12 col-lg-4 col-md-4">
                        <p class="fs-15 fw-bold">sosial media :</p>
                        <ul class="list-inline text-start">
                            <li class="list-inline-item">
                                <a href="https://instagram.com/" target="_blank" class=" text-decoration-none text-dark">
                                    <i class="ri-instagram-fill" aria-hidden="true"></i> @jurnalnusa
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://facebook.com/" target="_blank" class=" text-decoration-none text-dark">
                                    <i class="ri-facebook-fill" aria-hidden="true"></i> jurnalnusa
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://twitter.com/" target="_blank" class=" text-decoration-none text-dark">
                                    <i class="ri-twitter-fill" aria-hidden="true"></i> @jurnalnusa
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://www.youtube.com/=" target="_blank" class=" text-decoration-none text-dark">
                                    <i class="ri-youtube-fill" aria-hidden="true"></i> @jurnalnusa
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Grid row -->
            </div>
            <!---->
            <!---->
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <section class="d-flex justify-content-center justify-content-lg-between p-2 border-bottom container-fluid" style="background-color:  #FFC310;">
            <div class="container">
                <!-- Grid row -->
                <div class="row mt-3 text-center">
                    <div class="col-lg-7 col-12">
                        <ul class="list-inline text-capitalize">
                            @forelse ($footbawah as $item)
                            <li class="list-inline-item">
                                <a href="/informasi#tab{{$item->id_page}}" class="fw-bold fs-13 text-decoration-none text-dark" title="{{$item->judul}}">{{$item->judul}}</a>
                            </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                    <div class="col-lg-4 col-12 text-dark fw-bolder fs-12">
                        Design & Development By <a href="https://wa.me/6281233422006" class="text-decoration-none"><img src="{{ asset('log22.png') }}" class="ms-1 w-25 rounded-1" alt=""></a>
                    </div>
                    <div class="col-12 text-dark mt-3 fs-12">Copyright © 2023 - {{ now()->year }} <a class="text-reset fw-bold text-decoration-none" href="/">jurnalnusa.com</a></div>
                </div

                <!-- Grid row -->
            </div>
            <!---->
            <!---->
        </section>

        <!-- Copyright -->
    </footer>
    <!-- end Footer -->

    <!-- ads bottom -->

    <!-- end ads bottom -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ads -->
    <script src="{{ asset('asset/ads.js') }}"></script>

</body>

</html>

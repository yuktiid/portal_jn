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
    <!--ads-->

    <!---->
    
    <meta content="Jurnal Nusa - Segala berita, isu, & kejadian seputar nusantara indonesia" name="description">
    <meta content="Jurnal Nusa" name="keywords">
    <meta name="keywords" content="@yield('meta_keywords')">
    <meta name="thumbnailUrl" content="{{ asset('favicon.ico') }}" itemprop="thumbnailUrl">
    <meta content=" #005555" name="theme-color" />

    <!---->
    <meta property="og:title" content="@yield('meta_title')">
    <meta property="og:description" content="@yield('meta_description')">
    <meta property="og:type" content="@yield('meta_type')">
    <meta property="og:url" content="@yield('meta_url')">
    <meta property="og:image" content="{{ asset('img/ico.png') }}">
    <meta property="og:image:width" content="650">
    <meta property="og:image:height" content="366">
    <meta property="og:site_name" content="@yield('meta_site_name')">
    <meta name="copyright" content="jurnalnusa" itemprop="dateline">
    <meta name="pubdate" content="@yield('pubdate')" itemprop="datePublished">
    {{--  --}}
    <meta property="fb:app_id" content="">
    <meta property="fb:admins" content="">
    <meta property="article:author" content="https://www.facebook.com/" itemprop="author">
    <meta property="article:publisher" content="https://www.facebook.com/">

    {{-- robot --}}

    <!---->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <!-- Option 1: Include in HTML -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">
    <!-- back to top -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('assets-owl/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-owl/owl.theme.default.min.css') }}">
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('asset/style.css') }}">
    <!---->
    <script type="application/ld+json">
    {
        "@context" : "https://schema.org",
        "@type" : "Organization",
        "name" : "Jurnalnusa.com",
        "url" : "https://www.jurnalnusa.com/",
        "sameAs" : [
            "https://www.facebook.com/",
            "https://twitter.com/",
            "https://www.instagram.com/"
        ],
        "logo": "{{ asset('favicon.ico') }}"
    }
    </script>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "url": "https://www.jurnalnusa.com/",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "https://www.jurnalnusa.com/search/searchall?query={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>


</head>

<body style="background-color: #fff;">

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
                            <a class="nav-link text-light d-flex align-items-center" href="#"><i
                                    class="ri-calendar-fill me-1 fs-6"></i> {{ $today }}
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
                    <button id="navbarDesktopToggleBtn" class="btn rounded-circle p-0 d-flex align-items-center me-3 bg-cream" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                        aria-label="Toggle navigation">
                        <i id="navbarDesktopIcon" class="ri-menu-line text-light d-flex align-items-center px-2 py-1 fs-5"></i>
                    </button>
                    <form class="d-flex" role="search" action="/search">
                        <input class="form-control me-2 rounded-pill" name="keyword" type="search" placeholder="Search" aria-label="Search" value="@yield('search')">
                    </form>
                </div>
                @if(session('user'))
                @php $user = session('user'); @endphp
                <a href="" class="btn btn-outline-cream rounded-pill fw-semibold fs-14 text-capitalize">Hai, {{$user->nama_pengunjung}}</a>
                @else
                <button class="btn btn-outline-cream rounded-pill fw-semibold fs-14" data-bs-target="#modlogin" data-bs-toggle="modal">Masuk / Daftar</button>
                @endif
            </div>
        </nav>
        {{-- end desktop --}}
        {{-- mobile --}}
        <nav class="navbar navbar-light bg-light py-2 d-md-none d-block " style="z-index: 1050">
            <div class="container col-lg-8">
                <div class="row align-items-center ">
                    <div class="col-2">
                        <button id="navbarMobileToggleBtn" class="btn rounded-pill p-0 d-flex align-items-center me-3 bg-cream" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                            aria-label="Toggle navigation">
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
                        <button type="button" class="btn btn-cream rounded-circle bg-red" data-bs-toggle="modal"
                            data-bs-target="#basicModal">
                            <i class="ri-search-2-line"></i>
                        </button>

                    </div>
                </div>
                {{-- <div class="modal fade" id="basicModal" tabindex="-1" style="top: 117px; z-index: 1050;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="">
                                    <div class="row justify-content-center">
                                        <div class="col">
                                            <form class="input-group">
                                                <input type="search" class="form-control" placeholder="Search"
                                                    aria-label="Search">
                                                <button class="btn btn-cream" type="submit"><i
                                                        class="ri-search-2-line"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- End Basic Modal-->
            </div>
        </nav>
        {{-- end mobile --}}
        {{--  --}}
        <nav class="navbar navbar-expand navbar-dark p-0 bg-white d-none navbar2 border-top border-3 border-warning shadow-lg" id="header-content7" style="z-index: 1050">
            <div class="container col-lg-8">
                <div class="d-none d-lg-block">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('img/ico1.png') }}" alt="Logo" width="130" height="50"
                            class="d-inline-block align-text-top">
                    </a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav d-flex align-items-center fs-14 fw-bold">
                        <li class="nav-item">
                            <a class="as  {{ Request::is('/') ? 'active' : '' }}"
                                href="{{ route('home') }}">Beranda </a>
                        </li>
                        <li class="nav-item">
                            <a class="as  {{ Request::is('daerahan*') ? 'active' : '' }}"
                                href="{{ route('daerahan') }}">Daerah</a>
                        </li>
                        <li class="nav-item">
                            <a class="as  {{ Request::is('e-jurnal*') ? 'active' : '' }}"
                                href="{{ route('e-jurnal') }}">e-Jurnal </a>
                        </li>
                        <li class="nav-item">
                            <a class="as {{ Request::is('kategori/politik*') ? 'active' : '' }}"
                               href="{{ route('kategori', ['kategorislug' => 'politik']) }}">Politik</a>
                        </li>
                        <li class="nav-item">
                            <a class="as {{ Request::is('kategori/pemerintahan*') ? 'active' : '' }}"
                               href="{{ route('kategori', ['kategorislug' => 'pemerintahan']) }}">Pemerintahan</a>
                        </li>
                        <li class="nav-item">
                            <a class="as {{ Request::is('kategori/hukum*') ? 'active' : '' }}"
                               href="{{ route('kategori', ['kategorislug' => 'hukum']) }}">Hukum</a>
                        </li>

                        <li class="nav-item">
                            <a class="as {{ Request::is('kategori/olahraga*') ? 'active' : '' }}"
                               href="{{ route('kategori', ['kategorislug' => 'olahraga']) }}">Olahraga</a>
                        </li>
                        <li class="nav-item">
                            <a class="as {{ Request::is('kategori/ekonomi*') ? 'active' : '' }}"
                               href="{{ route('kategori', ['kategorislug' => 'ekonomi']) }}">Ekonomi</a>
                        </li>
                        <li class="nav-item">
                            <a class="as {{ Request::is('kategori/lifestyle*') ? 'active' : '' }}"
                               href="{{ route('kategori', ['kategorislug' => 'lifestyle']) }}">Lifestyle</a>
                        </li>
                        <li class="nav-item">
                            <a class="as {{ Request::is('kategori/opini*') ? 'active' : '' }}"
                               href="{{ route('kategori', ['kategorislug' => 'opini']) }}">Opini</a>
                        </li>


                    </ul>
                </div>
            </div>
        </nav>

        {{-- offcanvas desktop & mobile--}}
            <div class="offcanvas offcanvas-start rounded-right bg-white border border-info border-start-0" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="top: 90px">
                    <div class="offcanvas-header pt-5 border-bottom">
                        <p class="offcanvas-title fw-bold" id="offcanvasNavbarLabel">Pengunjung</p>
                        <button type="button" class="btn btn-outline-warning"  data-bs-target="#modlogin" data-bs-toggle="modal"> Login</button>

                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link ps-2 rounded fw-bold {{ Request::is('/') ? 'active bg-light  border-bottom border-warning-subtle' : '' }}" href="{{ route('home') }}">Beranda </a>
                            </li>
                            <li class="nav-item ps-2 pt-2">
                                <p class=" fw-bold mb-1">Kategori</p>
                                @forelse ($katee as $item)
                                    <a href="/kategori/{{$item->slug}}" class="p-1 btn btn-sm rounded-pill shadow-sm m-1  {{ Request::is('kategori/'.$item->slug) ? 'btn-warning active' : 'btn-light ' }}">
                                        {{$item->nama_kategori}}
                                    </a>
                                @empty
                                @endforelse
                            </li>
                            <li class="nav-item mt-1">
                                <p class="ps-2 fw-bold mb-1">Peristiwa</p>

                                    <a href="/" class="p-2 btn btn-light btn-sm rounded-pill shadow-sm m-1">
                                        Peristiwa Daerah
                                    </a>
                                    <a href="/" class="p-2 btn btn-light btn-sm rounded-pill shadow-sm m-2">
                                        Peristiwa Nasional
                                    </a>
                            </li>
                        </ul>
                        <form class="d-flex mt-3 ps-2" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search"
                                aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
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
                        <img class="mb-3" src="{{ asset('img/ico.png') }}" alt="..." style="height: 70px">
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

    {{-- search mobile --}}
    <div class="modal fade" id="basicModal" tabindex="-1" style="top: 117px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="">
                        <div class="row justify-content-center">
                            <div class="col">
                                <form class="input-group">
                                    <input type="search" class="form-control" placeholder="Search"
                                        aria-label="Search">
                                    <button class="btn btn-cream" type="submit"><i
                                            class="ri-search-2-line"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- End Basic Modal-->
    {{-- end --}}

    <main class="m-0 p-0">
        <div class="row d-flex justify-content-center m-0 p-0">
            <!-- banner left -->
            <div class="col-lg-2 d-none d-lg-block">
                <div class="sticky-top m-0" style="top: 115px; z-index: 0;" id="sticky-bottom-ad2">
                    <div class="container">
                        <div class="position-relative">
                            <a href="#" target="_blank">
                                    <img src="{{ $imgUrl }}/iklans/img/{{ $iklanTKa->gambar }}" class="w-100 " alt="">
                            </a>
                            <button type="button"
                                class="btn btn-outline-cream border-2 position-absolute top-0 right-0 rounded-circle d-flex align-items-center justify-content-center p-2"
                                style="width: 25px; height: 25px;" id="close-ad-button1">
                                <span class="fw-semibold fs-12">X</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end banner left -->

            <!-- content -->
            <div class="col col-lg-8">
                
                <!-- header content -->
                <section class="my-2 navbar3">
                    <div class="container">
                        <div class="row d-flex align-items-center justify-content-center ">
                            
                            <div class="col-lg-4 d-none d-lg-block">
                                <a href="/">
                                    <img src="{{ asset('img/ico1.png') }}" class="w-100 rounded-1" alt="">
                                </a>
                            </div>
                            
                            <div class="col-lg-8 text-end">
                                <img src="{{ $imgUrl }}/iklans/img/{{ $iklanP->gambar }}" class="w-75 rounded-1" alt="">
                            </div>
                            
                            <div class="col-lg-12 mt-2">
                                <nav class=" justify-content-between rounded-1 bg-creamX nav-3" id="header-content6">
                                    <a class="as text-light fw-semibold {{ Request::is('/') ? 'active' : '' }}"
                                        href="{{ route('home') }}">Beranda </a>
                                    <a class="as text-light fw-semibold {{ Request::is('daerahan*') ? 'active' : '' }}"
                                        href="{{ route('daerahan') }}">Daerah </a>
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/e-jurnal*') ? 'active' : '' }}"
                                        href="{{ route('e-jurnal') }}">e-Jurnal </a>
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/politik*') ? 'active' : '' }}"
                                        href="{{ route('kategori', ['kategorislug' => 'politik']) }}">Politik</a>
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/pemerintahan*') ? 'active' : '' }}"
                                        href="{{ route('kategori', ['kategorislug' => 'pemerintahan']) }}">Pemerintahan</a>
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/hukum*') ? 'active' : '' }}"
                                        href="{{ route('kategori', ['kategorislug' => 'hukum']) }}">Hukum</a>
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/olahraga*') ? 'active' : '' }}"
                                        href="{{ route('kategori', ['kategorislug' => 'olahraga']) }}">Olahraga</a>
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/ekonomi*') ? 'active' : '' }}"
                                        href="{{ route('kategori', ['kategorislug' => 'ekonomi']) }}">Ekonomi</a>
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/lifestyle*') ? 'active' : '' }}"
                                        href="{{ route('kategori', ['kategorislug' => 'lifestyle']) }}">Lifestyle</a>
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/opini*') ? 'active' : '' }}}"
                                        href="{{ route('kategori', ['kategorislug' => 'opini']) }}">Opini</a>
                                </nav>
                            </div>
                            
                        </div>
                    </div>
                </section>
                <!-- end header content -->
                <div class="d-block d-md-none text-center my-2">
                                <img src="{{ $imgUrl }}/iklans/img/{{ $iklanP->gambar }}" class="w-100 rounded-1" alt="">
                </div>
                <!-- end header content -->
                @yield('content')

            </div>
            <!-- end content -->
            
            <!-- banner left -->
            <div class="col-lg-2 d-none d-lg-block ">
                <div class="sticky-top m-0" style="top: 115px; z-index: 0;" id="sticky-bottom2">
                    <div class="container">
                        <div class="position-relative">
                            <a href="#" target="_blank">
                                <img src="{{ $imgUrl }}/iklans/img/{{ $iklanTKi->gambar }}" class="w-100 " alt="">
                            </a>
                            <button type="button"
                                class="btn btn-outline-cream border-2 position-absolute top-0 right-0 rounded-circle d-flex align-items-center justify-content-center p-2"
                                style="width: 25px; height: 25px;" id="close-button2">
                                <span class="fw-semibold fs-12">X</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end banner left -->
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
                    <div class="row col-12 col-lg-8 col-md-8">
                        <div class="col-4 mr-0 d-flex justify-content-end">
                             <img src="{{ asset('img/footico.png') }}" alt="Logo" width="auto" height="100" class="d-inline-block align-text-top">
                             
                        </div>
                        <div class="col-8"><p><b>JurnalNusa</b> - Berita Positif Terbaru dan Terkini</p>
                        <p class="fw-medium fs-13">Portal berita positif yang menyajikan informasi terkini tentang peristiwa, cek fakta, e-jurnal, politik, entertainment, kuliner, gaya hidup, dan wisata</p></div>
                    </div>
                    <div class="row col-12 col-lg-4 col-md-4">
                            <p class="fs-15 fw-bold">sosial media</p>
                            <ul class="list-inline">
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
        
        <div class="text-center p-4 border-top-white" style="background-color:  #FFC310;">
            <div class="row mt-0">
                <div class="col-lg-8 col-12">
                    <ul class="list-inline text-capitalize">
                        @forelse ($footbawah as $item)
                      <li class="list-inline-item">
                        <a href="/informasi#tab{{$item->id_page}}" class="fw-bold fs-15 text-decoration-none text-dark" title="{{$item->judul}}">{{$item->judul}}</a>
                      </li>
                         @empty
                        @endforelse
                    </ul>
                </div>
            </div>
            Copyright ©{{ now()->year }} <a class="text-reset fw-bold" href="/">jurnalnusa.com</a> All
            right reserved
            {{-- <a class="text-reset fw-bold" href="/">TM</a> --}}
        </div>
        <!-- Copyright -->
    </footer>
    <!-- end Footer -->

    <!-- back to top -->
    <button onclick="scrollToTop()" id="back-to-top" class="btn btn-warning bg-cream border-white rounded-circle"
        title="Back to top"><i class="ri-arrow-up-s-line fw-bold fs-4"></i></button>

    <!-- ads bottom -->

    <!-- end ads bottom -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- post -->
    <script src="{{ asset('asset/post.js') }}"></script>
    <!-- ads -->
    <script src="{{ asset('asset/ads.js') }}"></script>
    <!-- back to top -->
    <script src="{{ asset('asset/backtop.js') }}"></script>
    <!-- owl carousel -->
    <script src="{{ asset('assets-owl/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets-owl/owl.js') }}"></script>
    {{-- share --}}
    <script async src="https://static.addtoany.com/menu/page.js"></script>
    <script>
        // Navbar mobile
        const navbarMobileToggleBtn = document.getElementById('navbarMobileToggleBtn');
        const navbarMobileIcon = document.getElementById('navbarMobileIcon');

        navbarMobileToggleBtn.addEventListener('click', function () {
            if (navbarMobileIcon.classList.contains('ri-menu-line')) {
                // Change icon to close
                navbarMobileIcon.classList.remove('ri-menu-line');
                navbarMobileIcon.classList.add('ri-close-line');
            } else {
                // Change icon to menu
                navbarMobileIcon.classList.remove('ri-close-line');
                navbarMobileIcon.classList.add('ri-menu-line');
            }
        });

        // Navbar desktop
        const navbarDesktopToggleBtn = document.getElementById('navbarDesktopToggleBtn');
        const navbarDesktopIcon = document.getElementById('navbarDesktopIcon');

        navbarDesktopToggleBtn.addEventListener('click', function () {
            if (navbarDesktopIcon.classList.contains('ri-menu-line')) {
                // Change icon to close
                navbarDesktopIcon.classList.remove('ri-menu-line');
                navbarDesktopIcon.classList.add('ri-close-line');
            } else {
                // Change icon to menu
                navbarDesktopIcon.classList.remove('ri-close-line');
                navbarDesktopIcon.classList.add('ri-menu-line');
            }
        });
    </script>
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-95WF0SGR1G"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-95WF0SGR1G');
</script>

</body>

</html>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    
    <meta name="google-adsense-account" content="ca-pub-4918078179726425">
    <meta content="Jurnal Nusa - Segala berita, isu, & kejadian seputar nusantara indonesia" name="description">
    <meta content="Jurnal Nusa" name="keywords">
    <meta name="keywords" content="@yield('meta_keywords')">
    <meta name="thumbnailUrl" content="{{ asset('crop1.ico') }}" itemprop="thumbnailUrl">
    <meta content="#d38900" name="theme-color" />

    <meta property="og:title" content="@yield('meta_title')">
    <meta property="og:description" content="@yield('meta_description')">
    <meta property="og:type" content="@yield('meta_type')">
    <meta property="og:url" content="@yield('meta_url')">
    <meta property="og:image" content="@yield('meta_image')">
    <meta property="og:image:width" content="650">
    <meta property="og:image:height" content="366">
    <meta property="og:site_name" content="@yield('meta_site_name')">
    <meta name="copyright" content="jurnalnusa" itemprop="dateline">
    <meta name="pubdate" content="@yield('pubdate')" itemprop="datePublished">
    
    <meta property="article:author" content="https://www.facebook.com/" itemprop="author">
    <meta property="article:publisher" content="https://www.facebook.com/">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('crop1.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('crop1.ico') }}">
    
    <link rel="stylesheet" href="{{ asset('assets-owl/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-owl/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/style.css') }}">

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4918078179726425" crossorigin="anonymous"></script>
    
    <script type="application/ld+json">
    {
        "@context" : "https://schema.org",
        "@type" : "Organization",
        "name" : "Jurnalnusa.com",
        "url" : "https://www.jurnalnusa.com/",
        "logo": "{{ asset('crop1.ico') }}"
    }
    </script>
    
    <style>
    #loading-spinner-overlay {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        z-index: 9999;
    }
    #loading-spinner {
        text-align: center;
        background: transparent;
        border-radius: 4px;
        padding: 20px;
    }
    #loading-spinner img {
        max-width: 100px;
    }
    </style>
</head>

<body style="background-color: #fff;">
    
    <div id="loading-spinner-overlay">
        <div id="loading-spinner">
            <img loading="lazy" src="{{ asset('ball.gif') }}" alt="Loading...">
        </div>
    </div>

    <header class="shadow-sm sticky-top">
        {{-- Top Nav --}}
        <nav class="navbar navbar-expand navbar-dark p-0 bg-creamX navbar1" style="z-index: 1050">
            <div class="container col-lg-8">
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav d-flex align-items-center fs-14">
                        <li class="nav-item d-flex align-items-center">
                            @php
                                $today = \Carbon\Carbon::now()->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY');
                            @endphp
                            <a class="nav-link text-light d-flex align-items-center" href="#">
                                <i class="ri-calendar-fill me-1 fs-6"></i> {{ $today }}
                            </a>
                        </li>
                        {{-- Loop Nav Atas dari Provider --}}
                        @forelse ($navatas as $item)
                        <li class="nav-item d-none d-lg-flex">
                            <a class="nav-link text-light" href="/informasi#tab{{$item->id_page}}">{{$item->judul}}</a>
                        </li>
                        @empty
                        {{-- Kosong tidak masalah --}}
                        @endforelse
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Desktop Nav --}}
        <nav class="navbar navbar-light bg-white py-2 d-none d-md-block" style="z-index: 1050">
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
                <div class="end d-flex justify-content-between align-items-center">
                    <a href="/author/{{ $user->email }}" title="dashboard" class="text-dark text-decoration-none fw-bold"><p class="me-2 mb-0">Hai, {{ strstr($user->nama_pengunjung, ' ', true) }}</p></a>
                    <a href="/logout" class="btn btn-outline-cream rounded-pill fw-semibold fs-14 text-capitalize">Logout</a>
                </div>
                @else
                <button class="btn btn-outline-cream rounded-pill fw-semibold fs-14" data-bs-target="#modlogin" data-bs-toggle="modal">Masuk / Daftar</button>
                @endif
            </div>
        </nav>

        {{-- Mobile Nav --}}
        <nav class="navbar navbar-light bg-light py-2 d-md-none d-block" style="z-index: 1050">
            <div class="container col-lg-8">
                <div class="row align-items-center">
                    <div class="col-2">
                        <button id="navbarMobileToggleBtn" class="btn rounded-pill p-0 d-flex align-items-center me-3 bg-cream" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                            aria-label="Toggle navigation">
                            <i id="navbarMobileIcon" class="ri-menu-line text-light d-flex align-items-center px-2 py-1 fs-5"></i>
                        </button>
                    </div>
                    <div class="col-8 text-center">
                        <a href="/">
                            <img loading="lazy" src="{{ asset('crop1nobg.png') }}" class="w-50 img-fluid rounded-1" alt="">
                        </a>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-cream rounded-circle bg-red" data-bs-toggle="modal" data-bs-target="#basicModal">
                            <i class="ri-search-2-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Main Menu Bar (Sticky) --}}
        <nav class="navbar navbar-expand navbar-dark p-0 bg-white d-none navbar2 border-top border-3 border-warning shadow-lg" id="header-content7" style="z-index: 1050">
            <div class="container col-lg-8">
                <div class="d-none d-lg-block">
                    <a class="navbar-brand" href="/">
                        <img loading="lazy" src="{{ asset('crop1.jpeg') }}" alt="Logo" width="auto" height="50" class="d-inline-block align-text-top p-2">
                    </a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav d-flex align-items-center fs-14 fw-bold">
                        <li class="nav-item"><a class="as {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
                        <li class="nav-item"><a class="as {{ Request::is('daerahan*') ? 'active' : '' }}" href="{{ route('daerahan') }}">Daerah</a></li>
                        <li class="nav-item"><a class="as {{ Request::is('e-jurnal*') ? 'active' : '' }}" href="{{ route('e-jurnal') }}">e-Jurnal</a></li>
                        
                        {{-- Menu Hardcoded (Bisa diganti dynamic jika perlu) --}}
                        <li class="nav-item"><a class="as {{ Request::is('kategori/politik*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'politik']) }}">Politik</a></li>
                        <li class="nav-item"><a class="as {{ Request::is('kategori/pemerintahan*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'pemerintahan']) }}">Pemerintahan</a></li>
                        <li class="nav-item"><a class="as {{ Request::is('kategori/hukum*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'hukum']) }}">Hukum</a></li>
                        <li class="nav-item"><a class="as {{ Request::is('kategori/olahraga*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'olahraga']) }}">Olahraga</a></li>
                        <li class="nav-item"><a class="as {{ Request::is('kategori/ekonomi*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'ekonomi']) }}">Ekonomi</a></li>
                        <li class="nav-item"><a class="as {{ Request::is('kategori/lifestyle*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'lifestyle']) }}">Lifestyle</a></li>
                        <li class="nav-item"><a class="as {{ Request::is('kategori/opini*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'opini']) }}">Opini</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Offcanvas Menu --}}
        <div class="offcanvas offcanvas-start rounded-right bg-white border border-info border-start-0" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" style="top: 90px">
            <div class="offcanvas-header pt-5 border-bottom">
                @if(session('user'))
                    @php $user = session('user'); @endphp
                    <p class="offcanvas-title fw-bold" id="offcanvasNavbarLabel">Hai, {{ $user->nama_pengunjung}}</p>
                    <a href="/logout" class="btn btn-outline-cream rounded-pill fw-semibold fs-14 text-capitalize">Logout</a>
                @else
                    <p class="offcanvas-title fw-bold" id="offcanvasNavbarLabel">Pengunjung</p>
                    <button type="button" class="btn btn-outline-warning" data-bs-target="#modlogin" data-bs-toggle="modal"> Login</button>
                @endif
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link ps-2 rounded fw-bold {{ Request::is('/') ? 'active bg-light border-bottom border-warning-subtle' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item ps-2 pt-2">
                        <p class="fw-bold mb-1">Kategori</p>
                        {{-- Menggunakan variabel $mainArray dari Provider --}}
                        @forelse ($mainArray as $item)
                            <a href="/kategori/{{$item->slug}}" class="p-1 btn btn-sm rounded-pill shadow-sm m-1 {{ Request::is('kategori/'.$item->slug) ? 'btn-warning active' : 'btn-light' }}">
                                {{$item->nama_kategori}}
                            </a>
                        @empty
                            <span class="text-muted small">Kategori tidak tersedia</span>
                        @endforelse
                    </li>
                    <li class="nav-item mt-1">
                        <p class="ps-2 fw-bold mb-1">Peristiwa</p>
                        @forelse ($peristiwaDaerahArray as $item)
                            <a href="/kategori/{{$item->slug}}" class="p-1 btn btn-sm rounded-pill shadow-sm m-1 {{ Request::is('kategori/'.$item->slug) ? 'btn-warning active' : 'btn-light' }}">
                                {{$item->nama_kategori}}
                            </a>
                        @empty
                        @endforelse

                        @forelse ($peristiwaInternasionalArray as $item)
                            <a href="/kategori/{{$item->slug}}" class="p-1 btn btn-sm rounded-pill shadow-sm m-1 {{ Request::is('kategori/'.$item->slug) ? 'btn-warning active' : 'btn-light' }}">
                                {{$item->nama_kategori}}
                            </a>
                        @empty
                        @endforelse
                    </li>
                    @if(session('user'))
                    @php $user = session('user'); @endphp
                    <li class="nav-item mt-3">
                        <p class="ps-2 fw-bold mb-1">Kontribusi Anda</p>
                        <a class="nav-link ps-2 rounded fw-bold {{ Request::is('/author/' . $user->email) ? 'active bg-light text-dark border-bottom border-warning-subtle' : 'text-dark bg-warning' }}" href="/author/{{ $user->email }}">Mulai Menulis</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </header>

    {{-- Modal Login --}}
    <div class="modal fade" id="modlogin" aria-hidden="true" aria-labelledby="modloginLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body p-3 pt-0">
                        <div class="text-center">
                            <img loading="lazy" class="mb-3" src="{{ asset('log2.png') }}" alt="..." style="height: 70px">
                            <div class="subheading-1 mb-5">Silahkan masuk untuk menggunakan fitur pengguna</div>
                        </div>
                        <div class="text-center mb-3">
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <a href="{{route('login.google')}}" class="btn btn-light">
                                    <img loading="lazy" src="{{ asset('img/g.png') }}" alt="Gambar" width="30" height="30">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Search Mobile Modal --}}
    <div class="modal fade" id="basicModal" tabindex="-1" style="top: 117px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col">
                            <form class="input-group" role="search" action="/search">
                                <input class="form-control" name="keyword" type="search" placeholder="mau cari berita apa?" aria-label="Search" value="@yield('search')">
                                <button class="btn btn-cream" type="submit"><i class="ri-search-2-line"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="m-0 p-0">
        <div class="row d-flex justify-content-center m-0 p-0">
            <div class="col-lg-2 d-none d-lg-block">
                <div class="sticky-top m-0" style="top: 115px; z-index: 0;" id="sticky-bottom-ad2">
                    <div class="container">
                        <div class="position-relative">
                            <a href="{{ $iklanTKi->link }}" target="_blank">
                                <img loading="lazy" src="https://pro1v1jn.jurnalnusa.com/iklans/img/{{ $iklanTKi->gambar }}" class="w-100" alt="">
                            </a>
                            <button type="button" class="btn btn-outline-cream border-2 position-absolute top-0 right-0 rounded-circle d-flex align-items-center justify-content-center p-2"
                                style="width: 25px; height: 25px;" id="close-ad-button1">
                                <span class="fw-semibold fs-12">X</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col col-lg-8">
                <section class="my-2 navbar3">
                    <div class="container">
                        <div class="row d-flex align-items-center justify-content-center">
                            
                            <div class="col-lg-4 d-none d-lg-block">
                                <a href="/">
                                    <img loading="lazy" src="{{ asset('crop1nobg.png') }}" class="w-100 rounded-1" alt="">
                                </a>
                            </div>
                            
                            <div class="col-lg-8 text-end">
                                <a href="{{ $iklanP->link }}" target="_blank">
                                    <img loading="lazy" src="https://pro1v1jn.jurnalnusa.com/iklans/img/{{ $iklanP->gambar }}" class="w-75 rounded-1" alt="">
                                </a>
                            </div>
                            
                            <div class="col-lg-12 mt-2">
                                <nav class="justify-content-between rounded-1 bg-creamX nav-3" id="header-content6">
                                    <a class="as text-light fw-semibold {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                                    <a class="as text-light fw-semibold {{ Request::is('daerahan*') ? 'active' : '' }}" href="{{ route('daerahan') }}">Daerah</a>
                                    <a class="as text-light fw-semibold {{ Request::is('e-jurnal*') ? 'active' : '' }}" href="{{ route('e-jurnal') }}">e-Jurnal</a>
                                    
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/politik*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'politik']) }}">Politik</a>
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/pemerintahan*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'pemerintahan']) }}">Pemerintahan</a>
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/hukum*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'hukum']) }}">Hukum</a>
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/olahraga*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'olahraga']) }}">Olahraga</a>
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/ekonomi*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'ekonomi']) }}">Ekonomi</a>
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/lifestyle*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'lifestyle']) }}">Lifestyle</a>
                                    <a class="as text-light fw-semibold {{ Request::is('kategori/opini*') ? 'active' : '' }}" href="{{ route('kategori', ['kategorislug' => 'opini']) }}">Opini</a>
                                </nav>
                            </div>
                            
                        </div>
                    </div>
                </section>
                
                <div class="d-block d-md-none text-center my-2">
                    <a href="{{ $iklanP->link }}" target="_blank">
                        <img loading="lazy" src="https://pro1v1jn.jurnalnusa.com/iklans/img/{{ $iklanP->gambar }}" class="w-100 rounded-1 px-5 py-2" alt="">
                    </a>
                </div>

                @yield('content')

            </div>
            
            <div class="col-lg-2 d-none d-lg-block">
                <div class="sticky-top m-0" style="top: 115px; z-index: 0;" id="sticky-bottom2">
                    <div class="container">
                        <div class="position-relative">
                            <a href="{{ $iklanTKa->link }}" target="_blank">
                                <img loading="lazy" src="https://pro1v1jn.jurnalnusa.com/iklans/img/{{ $iklanTKa->gambar }}" class="w-100" alt="">
                            </a>
                            <button type="button" class="btn btn-outline-cream border-2 position-absolute top-0 right-0 rounded-circle d-flex align-items-center justify-content-center p-2"
                                style="width: 25px; height: 25px;" id="close-button2">
                                <span class="fw-semibold fs-12">X</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-lg-start text-muted" style="background-color: rgb(248, 248, 248);">
        <hr style="color: #d38900;">
        <section class="d-flex justify-content-center justify-content-lg-between p-2 border-bottom container">
            <div class="container text-md-start mt-md-3 mt-sm-1">
                <div class="row mt-3 ms-2">
                    <div class="row col-12 col-lg-8 col-md-8">
                        <div class="col-4 d-flex justify-content-end">
                             <img loading="lazy" src="{{ asset('jurnal.png') }}" alt="Logo" width="auto" height="100" class="d-inline-block align-text-top">
                        </div>
                        <div class="col-8">
                            <p><b>JurnalNusa</b> – Spectrum positif jurnalism</p>
                            <p class="fw-medium fs-13">Media online proyeksi nasional berbasis positif jurnalism, akuntable dan edukatif hadir dengan perspektif baru media pers</p>
                        </div>
                    </div>
                    <div class="row col-12 col-lg-4 col-md-4">
                        <p class="ms-0 fs-15 fw-bold">Sosial Media</p>
                        <ul class="list-inline">
                            <li class="list-inline-item fs-13"><a href="#" class="text-decoration-none text-dark"><i class="ri-instagram-fill"></i> @jurnalnusa</a></li>
                            <li class="list-inline-item fs-13"><a href="#" class="text-decoration-none text-dark"><i class="ri-facebook-fill"></i> jurnalnusa</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="d-flex justify-content-center justify-content-lg-between p-2 border-bottom container-fluid" style="background-color: #FFC310;">
            <div class="container">
                <div class="row mt-3 text-center">
                    <div class="col-lg-7 col-12">
                        <ul class="list-inline text-capitalize">
                            @forelse ($footbawah as $item)
                            <li class="list-inline-item">
                                <a href="/informasi#tab{{$item->id_page}}" class="fw-bold fs-13 text-decoration-none text-dark">{{$item->judul}}</a>
                            </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                    <div class="col-lg-4 col-12 text-dark fw-bolder fs-12">
                        Design & Development By 
                        <a href="https://wa.me/6281233422006" class="text-decoration-none" target="_blank">
                            <img loading="lazy" src="{{ asset('log22.png') }}" class="ms-1 w-25 rounded-1" alt="Yukti Web">
                        </a>
                    </div>
                    <div class="col-12 text-dark mt-3 fs-12">Copyright © 2023 - {{ now()->year }} <a class="text-reset fw-bold text-decoration-none" href="/">jurnalnusa.com</a></div>
                </div>
            </div>
        </section>
    </footer>

    <button onclick="scrollToTop()" id="back-to-top" class="btn btn-warning bg-cream border-white rounded-circle" title="Back to top">
        <i class="ri-arrow-up-s-line fw-bold fs-4"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <script src="{{ asset('asset/post.js') }}"></script>
    <script src="{{ asset('asset/ads.js') }}"></script>
    <script src="{{ asset('asset/backtop.js') }}"></script>
    <script src="{{ asset('assets-owl/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets-owl/owl.js') }}"></script>
    <script async src="https://static.addtoany.com/menu/page.js"></script>

    <script>
        // 1. Hilangkan Loading Spinner SEGERA
        window.addEventListener("load", function() {
            var overlay = document.getElementById('loading-spinner-overlay');
            if(overlay) overlay.style.display = 'none';
        });

        // 2. Navbar Logic (Safe Mode)
        var offcanvasNavbar = document.getElementById('offcanvasNavbar');
        var navbarDesktopToggleBtn = document.getElementById('navbarDesktopToggleBtn');
        var navbarDesktopIcon = document.getElementById('navbarDesktopIcon');

        if (offcanvasNavbar && navbarDesktopIcon) {
            offcanvasNavbar.addEventListener('shown.bs.offcanvas', function () {
                navbarDesktopIcon.classList.remove('ri-menu-line');
                navbarDesktopIcon.classList.add('ri-close-line');
            });

            offcanvasNavbar.addEventListener('hidden.bs.offcanvas', function () {
                navbarDesktopIcon.classList.remove('ri-close-line');
                navbarDesktopIcon.classList.add('ri-menu-line');
            });
        }
    </script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-95WF0SGR1G"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-95WF0SGR1G');
    </script>

</body>
</html>
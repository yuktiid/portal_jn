@extends('lay.layout')
@section('title', $koran->judul)
{{--  --}}
@section('meta_title', $koran->judul)
@section('meta_description',$koran->judul)
@section('meta_type', 'article')
@section('meta_url', url()->current() )
@section('meta_image', $link . $koran->gambar)
@section('meta_keywords', 'e-jurnal , e-koran , jurnal')
@section('meta_site_name', 'jurnalnusantara')
@section('pubdate', \Carbon\Carbon::parse($koran->createdAt)->format('Y-m-d\TH:i:s\Z'))
{{-- robot --}}
@section('robots', 'index, follow')
{{-- end --}}
@section('content')
@php
use Carbon\Carbon;
use Carbon\CarbonInterface;

// Set lokal ke bahasa Indonesia
                                // Mengonversi format waktu dari database ke format 'Y-m-d H:i:s.u'
                                $waktuUpload = Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $koran->createdAt, 'UTC');

                                // Set zona waktu ke "Asia/Jakarta" (Waktu Indonesia Barat)
                                $waktuUpload->setTimezone('Asia/Jakarta');

                                // Waktu sekarang dengan zona waktu yang sama
                                $waktuSekarang = Carbon::now('Asia/Jakarta');

                                // Menghitung selisih waktu
                                $selisih = $waktuUpload->diff($waktuSekarang);

                                $hasil = '';

                                if ($selisih->days > 0) {
                                    if ($selisih->days > 1) {
                                        // Jika selisih lebih dari 1 hari, tampilkan format tanggal
                                        $hasil = $waktuUpload->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY');
                                    } else {
                                        $hasil = '1 hari yang lalu';
                                    }
                                } elseif ($selisih->h > 0) {
                                    $hasil = $selisih->h . ' jam yang lalu';
                                } elseif ($selisih->i > 0) {
                                    $hasil = $selisih->i . ' menit yang lalu';
                                } else {
                                    $hasil = $selisih->s . ' detik yang lalu';
                                }
                                @endphp
{{-- font awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
{{-- fancy css --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
{{--  --}}
<section class="my-4 p-3 d-none d-md-block">
    <div class="bg-light p-4 mb-3 rounded">
        {{--  --}}
        <div class="d-none d-md-inline-flex admin row d-flex justify-content-between align-items-center my-1">
            <h2 class="text-center fw-bold">{{$koran->judul}}</h2>
            <div class=" col-7 col-md-6">
                <div class="row g-2 d-flex align-items-end">
                    <div class="col-2 wrapper">
                        <img src="{{$imgadmin}}{{$koran->author->foto}}" class="rounded-circle img2" alt="admin">
                    </div>
                    <div class="col-9 py-2 px-0" style="line-height: 5px;">
                        <p class="fw-bold  fs-15"><a href="/writer/{{$koran->author->email}}" class=" text-decoration-none text-danger">{{$koran->author->nama_akun}}</a></p>
                        
                        <p class="fs-12 fw-semibold mb-0">
                            {{ \Carbon\Carbon::parse($koran->createdAt)
                            ->locale('id_ID')
                            ->isoFormat('dddd, DD MMMM YYYY') }}
                        </p>

                    </div>
                </div>

            </div>
            <div class="col-3 d-flex align-items-center justify-content-center">
                <!--<p class=" text-center fw-semibold rounded-1 py-2 mb-0 fs-13"><i class="ri-eye-line me-1"></i>1.2K dilihat</p>-->
                <a class="a2a_dd text-secondary text-decoration-none ms-2 fw-semibold" href="https://www.addtoany.com/share"><i class="ri-share-fill"> Bagikan</i></a>
            </div>
        </div>
        {{--  --}}
    </div>
    <!-- end admin -->
    <div id="carouselExampleInterval" class="carousel slide rounded" data-bs-ride="carousel" style="background-color: #3C486B;">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="5000">
                <a data-fancybox="gallery" href="{{$link}}{{ $koran->gambar }}">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{$link}}{{ $koran->gambar }}" class="d-block w-50" alt="...">
                    </div>
                </a>
            </div>
            @forelse ($koran->additionalImages as $item)

            <div class="carousel-item " data-bs-interval="5000">
                <a data-fancybox="gallery" href="{{$link}}{{ $item->gambar }}">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{$link}}{{ $item->gambar }}" class="d-block w-50" alt="...">
                    </div>
                </a>
            </div>
            @empty

            @endforelse
          <!-- Tambahkan carousel items lainnya di sini -->
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!--<div class="tags mt-2 bg-light p-3 rounded">-->
    <!--    <h5 class="mb-3 fw-semibold">Tags</h5>-->
    <!--    <span class="btn btn-outline-secondary me-2 rounded-pill">ekoran</span>-->
    <!--    <span class="btn btn-outline-secondary me-2 rounded-pill">epaper</span>-->
    <!--    <span class="btn btn-outline-secondary me-2 rounded-pill">korandigital</span>-->
    <!--    <span class="btn btn-outline-secondary me-2 rounded-pill">jurnalnusantara</span>-->
    <!--</div>-->
    <div class="share my-2">
        <p style="font-size: 13px;">Anda sedang membaca: <span class="fw-semibold">{{$koran->judul}}</span></p>
        <!--<div class="shr">-->
        <!--    <h5 class="border d-flex align-items-center px-2 py-3 justify-content-end rounded-1 ">Share <i class="ri-arrow-right-line"></i> <i class="fs-2 ri-facebook-fill"></i> <i class="fs-2 ri-twitter-fill"></i> <i class="fs-2 ri-whatsapp-fill"></i> <i class="fs-2 ri-telegram-fill"></i></h5>-->
        <!--</div>-->
    </div>
</section>
{{--  --}}
<section class="my-4 p-1 d-block d-md-none">
    <div class="bg-light p-2 mb-3 rounded text-center">
        <div class="title">
            <h6 class="fw-semibold fw-bold">{{$koran->judul}}</h6>
        </div>
        <div class="admin row d-flex justify-content-between align-items-end my-1">
            <div class="col-12">
                <div class="row g-2 d-flex align-items-end">
                    <div class="col-12 py-2" style="line-height: 5px;">
                        <p class="fs-12 d-inline">{{$hasil}}</p>
                    </div>
                    <div class="col-12 py-2" style="line-height: 5px;">
                        <p class="fs-12 d-inline"><i class="ri-eye-line me-1"></i>Dilihat 1.2K |</p>
                        <a class="a2a_dd text-secondary text-decoration-none d-inline fs-12" href="https://www.addtoany.com/share"><i class="ri-share-fill"> share</i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end admin -->
    <div id="carouselExampleInterval" class="carousel slide rounded" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="5000">
                <a data-fancybox="gallery" href="{{$link}}{{ $koran->gambar }}">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{$link}}{{ $koran->gambar }}" class="d-block w-50" alt="...">
                    </div>
                </a>
            </div>
            @forelse ($koran->additionalImages as $item)
            <div class="carousel-item " data-bs-interval="5000">
                <a data-fancybox="gallery" href="{{$link}}{{ $item->gambar }}">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{$link}}{{ $item->gambar }}" class="d-block w-50" alt="...">
                    </div>
                </a>
            </div>
            @empty

            @endforelse

            <!-- Tambahkan carousel items lainnya di sini -->
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="tags mt-2 bg-light p-3 rounded">
        <h5 class="mb-3 fw-semibold">Tags</h5>
        <span class="btn btn-outline-secondary me-1 mb-1 rounded-pill fs-12">ekoran</span>
        <span class="btn btn-outline-secondary me-1 mb-1  rounded-pill fs-12">epaper</span>
        <span class="btn btn-outline-secondary me-1 mb-1  rounded-pill fs-12">korandigital</span>
        <span class="btn btn-outline-secondary me-1 mb-1  rounded-pill fs-12">jurnalnusantara</span>
        <span class="btn btn-outline-secondary me-1 mb-1  rounded-pill fs-12">malang</span>
    </div>
    <div class="share my-2">
        <p style="font-size: 13px;">Anda sedang membaca: <span class="fw-semibold">{{$koran->judul}}</span></p>

    </div>
</section>
  {{-- fancy js --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
  {{-- font awesome --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
  @endsection

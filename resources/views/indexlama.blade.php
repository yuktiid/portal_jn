@extends('lay.layout')
@section('title', 'Beranda - Jurnal Nusa')
{{-- meta --}}
@section('meta_title','Jurnal Nusa - Beranda')
@section('meta_keywords', 'jurnal nusa, jurnal nusa, jurnalnusa')
@section('meta_description', 'Jurnalnusa.com -Spectrum positif jurnalism')
@section('meta_type', 'article')
@section('meta_url', url()->current() )
@section('meta_image', asset('Log2.png') )

@section('meta_site_name', 'Jurnalnusa.com')
{{-- robot --}}
@section('robots', 'index, follow')
{{-- end --}}
@section('content')
@php

use Carbon\Carbon;
use Carbon\CarbonInterface;

use Illuminate\Support\Str;
$jumlahKata = 150;


@endphp

    <!-- content-top -->
    <section class=" mt-3">
        <div class="container">
            <div class="row d-flex">
                @forelse ($acak1 as $item)
                    <div class="col-6 col-lg-3">
                        <div class="card border-0 d-flex align-items-center bg-transparent">
                            <div class="wrapper">
                                <img src="{{ $imgUrl }}/posts/img/{{ $item->foto }}"
                                    class="w-100 rounded img" alt="{{ $item->keterangan_foto }}" title="{{ $item->keterangan_foto }}">
                            </div>
                            <div class="card-body p-2">
                                @forelse ($item->Kategoris as $katt)

                                <a href="/berita/{{$katt->slug}}/{{ $item->slug }}"
                                class="d-inline-block link-a stretched-link fw-bolder fs-12 text-darks" title="{{ $item->judul }}"
                                style="font-size: 12px; color: black;">{{ $item->judul }}</a>
                                @empty

                                @endforelse

                            </div>
                        </div>
                    </div>

                @empty
                @endforelse

                {{-- <div class="col-6 col-lg-3">
                    <div class="card border-0 d-flex align-items-center bg-transparent">
                        <div class="wrapper">
                            <img src="{{ asset('img/1x91x1.jpg') }}" class="w-100 rounded img" alt="">
                        </div>
                        <div class="card-body p-2">
                            <a href="#" class="d-inline-block link-a stretched-link fw-bolder" title="Not Found 404"
                                style="font-size: 12px; color: black;">Not Found 404</a>


                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
    </section>
    <!-- end content top -->

    <!-- content first -->
    <section class="my-3 d-flex justify-content-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <!-- left -->
                <div class=" col-md-8">
                    <!-- large -->
                    <div class="row my-0 ">
                        <div class="col ">
                            <style>
                                .owl-carousel .owl-dots {
                                    display: none;
                                }
                            </style>
                            <div class="owl-carousel" id="carousel1">
                                @forelse ($acak2 as $item)
                                @php
                                        // Mengonversi format waktu dari database ke format 'Y-m-d H:i:s'
                                        $waktuUpload = Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $item->createdAt, 'UTC');

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
                                            $hasil = $selisih->h . ' jam yang lalu ';
                                        } elseif ($selisih->i > 0) {
                                            $hasil = $selisih->i . ' menit yang lalu';
                                        } else {
                                            $hasil = $selisih->s . ' detik yang lalu';
                                        }
                                    @endphp
                                    <div class="item p-0 ">
                                        <div class="card border-0 shadow m-2">
                                            <div class="wrapper rounded-1 ">
                                                <img src="{{ $imgUrl }}/posts/img/{{ $item->foto }}"
                                                    class="img rounded-top" alt="{{ $item->keterangan_foto }}">
                                            </div>
                                            <div class="mt-2">
                                                @forelse ($item->Kategoris as $katt)
                                                    <a href="/berita/{{$katt->slug}}/{{ $item->slug }}"
                                                    class="card-title link-a d-block fw-bolder text-start fs-5 stretched-link px-3"
                                                    title="{{ $item->judul }}">{{ $item->judul }}</a>
                                                @empty
                                                @endforelse


                                                {{-- <div class="row fs-12 cb p-0 m-0"> --}}
                                                {{-- <div class="col d-flex align-items-center p-0 m-0"> --}}
                                                <p class="ms-3 text-capitalize"><i class="ri-calendar-fill me-1 fs-6"></i>{{ $hasil }}</p>
                                                {{-- </div> --}}
                                                {{-- </div> --}}
                                            </div>
                                            <div class="card-body">
                                                <p class="fs-13 cb">{{ $item->keterangan_foto }}</p>
                                                {{-- <p class="d-flex align-items-center fs-13 ">Selengkapnya >></p> --}}
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                @endforelse

                            </div>

                        </div>
                    </div>
                    <!-- end large -->

                    <!-- ads -->
                    <div class="row">
                        @isset($tengah->gambar)
                            <div class="ads border-top border-bottom py-3">
                                <div class="card border-0 bg-light">
                                    <a href="{{ $tengah->link }}">
                                        <img src="{{ $imgUrl }}/iklans/img/{{ $tengah->gambar }}" class="w-100 rounded-1" alt="">
                                    </a>
                                    <span class="card-title text-center" style="font-size: 10px;">ADVERTISEMENT</span>
                                </div>
                            </div>
                        @endisset
                    </div>

                    <!-- end ads -->

                    <!-- e-jurnal -->
                    <div class="row my-3 bg-creamX p-3 rounded">
                        <div class="title pb-2">
                            <h4 class="fw-semibold "># E-Jurnal</h4>
                            <h5>Berlangganan Gratis</h5>
                        </div>
                        <div id="carouselExampleInterval" class="carousel slide mb-2" data-bs-ride="carousel">
                            <div class="carousel-inner border">
                                @forelse ($gambarArray->data as $gambar)
                                    <div class="carousel-item @if($gambar->id_ekoran == $gambarArray->data[0]->id_ekoran) active @endif" data-bs-interval="2000">
                                        <a href="e-jurnal/{{$gambar->slug}}" class="stretched-link">
                                            <img src="{{$gambarArray->link}}{{$gambar->gambar}}" class="d-block w-100" alt="{{$gambar->gambar}}">
                                        </a>
                                        <div class="carousel-caption ">

                                            <h5>{{$gambar->judul}}</h5>
                                        </div>
                                    </div>
                                @empty
                                    <div class="carousel-item active" data-bs-interval="2000">
                                        <img src="{{ asset('error.png') }}" class="d-block w-100" alt="Default Image">
                                        <div class="carousel-caption">
                                            <h3>Default Image</h3>
                                            <p>No description available</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <!-- end e-jurnal -->
                    
                    <!-- advertisment 4x4 atas -->
                        <div class="d-block d-md-none d-lg-none card border-0  bg-transparent">

                            <div class="container mt-1">
                                <div id="carousel4x4mob" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                    @forelse($kotak as $index => $item)
                                        <div class="carousel-item{{ $index == 0 ? ' active' : '' }}" data-bs-interval="3000">
                                            <a href="{{ $item->link }}" target="_blank">
                                                <img src="{{ $imgUrl }}/iklans/img/{{ $item->gambar }}" class="d-block w-100 rounded-top" alt="...">
                                            </a>
                                        </div>
                                    @empty
                                    @endforelse
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel4x4mob" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel4x4mob" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <p class="p-0 m-0 text-center bg-light rounded-bottom" style="font-size: 10px;">
                                    ADVERTISEMENT</p>
                            </div>
                        </div>
                        <!-- end advertisment -->

                    <!-- news new 1-->
                    <div class="news-new-1 border rounded p-2">
                        <div class="row post-container gx-5">
                            <div class="title my-3">
                                <h4 class="fw-semibold">Berita Terbaru</h4>
                            </div>
                            <div class="col-12 col-md-12 post">

                                @forelse ($berita as $item)
                                @php // Set lokal ke bahasa Indonesia
                                // Mengonversi format waktu dari database ke format 'Y-m-d H:i:s.u'
                                $waktuUpload = Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $item->createdAt, 'UTC');

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

                                    <div class="card border-0 m-1 px-2">
                                        <div class="row fs-14 cb">
                                            <div class="col-5 col-lg-4 d-flex align-items-center">
                                                <img src="{{ $imgUrl }}/posts/img/{{ $item->foto }}"
                                                    class="rounded thumbnails border" alt="{{ $item->keterangan_foto }}">
                                            </div>
                                            <div class="col-7 col-lg-8 p-0 d-flex align-items-center">
                                                <div class="col-12 col-lg-12 p-0">
                                                    <div class="d-flex flex-column terbaru">
                                                        <!-- Judul Berita -->
                                                        @forelse ($item->Kategoris as $katt)
                                                        <a href="/berita/{{$katt->slug}}/{{ $item->slug }}" class="mb-2 cb link-a fs-15 fw-bold"
                                                            title="{{ $item->judul }}">{{ $item->judul }}</a>


                                                        <!-- Informasi Tambahan -->
                                                        <div class="mt-0">
                                                            <div class="col d-flex mb-0">
                                                                <!--<p class="">{{$katt->nama_kategori}}</p>-->
                                                                <a href="/kategori/{{$katt->slug}}" class="fw-bold cb link-a tex-c">
                                                                    {{$katt->nama_kategori}}
                                                                </a>
                                                                
                                                            </div>
                                                            <div class="row mt-0">
                                                                <div class="col d-flex fs-12">
                                                                <p class="me-2">
                                                                    @if(isset($item->id_author) && isset($item->id_author->email))
                                                                        <a href="/writer/{{$item->id_author->email}}" class="text-dark text-decoration-none fw-bold">{{$item->id_author->nama_akun}}</a>
                                                                    @elseif(isset($item->idPengunjung) && isset($item->idPengunjung->email))
                                                                        <a href="/writer/{{$item->idPengunjung->email}}" class="text-dark text-decoration-none fw-bold">{{$item->idPengunjung->nama_pengunjung}}</a>
                                                                    @endif
                                                                </p>|
                                                                <p class="ms-1">{{ $hasil }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @empty
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                @empty
                                @endforelse



                            </div>


                        </div>
                        <div class="text-center d-grid tombolload">
                            <button id="loadMoreBtn" class="btn btn-cream border-0 rounded-pill "
                                aria-disabled="true">
                                <span id="loadingSpinner" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Memuat...
                                </span>
                                <span id="loadMoreText">Tampilkan Selanjutnya</span>
                            </button>
                        </div>
                    </div>
                    <!-- end news new 1-->
                                                                    
                    <!-- news-1 -->

                            @php // Set lokal ke bahasa Indonesia
                                // Mengonversi format waktu dari database ke format 'Y-m-d H:i:s.u'
                                $waktuUpload = Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $data1->createdAt, 'UTC');

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

                        @forelse ($data1->Kategoris as $katt)
                            <div class="news-1 my-3 border-bottom p-0">
                                <div class="card border-0 m-0 p-0">
                                    <div class="card-header border-0 my-0 p-1">
                                        <a href="/berita/{{$katt->slug}}/{{$data1->slug}}"
                                            class="card-title link-a d-block fw-bolder text-start text-md-center fs-5 stretched-link px-3"
                                            title="{{$data1->judul}}">{{$data1->judul}}</a>
                                        <div class="row fs-12 cb p-0 m-0">
                                            <div class="col d-flex align-items-center p-0 m-0">
                                                <p class="fw-bolder text-uppercase bad-c py-0 align-items-center mx-2 ">{{$katt->nama_kategori}}</p>
                                                <p>{{ $hasil }} - </p>
                                                <p>Oleh <span class="text-warning fs-13 mx-1">
                                                    @if(isset($data1->id_author))
                                                                    <a href="/writer/{{$data1->id_author->email}}" class="text-dark text-decoration-none fw-bold">{{$data1->id_author->nama_akun}}</a>
                                                                    @elseif(isset($data1->idPengunjung))
                                                                    <a href="/writer/{{$data1->idPengunjung->email}}" class="text-dark text-decoration-none fw-bold">{{$data1->idPengunjung->nama_pengunjung}}</a>
                                                                    @else
                                                                    @endif
                                                </span></p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper rounded-1 ">
                                        <img src="{{ $imgUrl }}/posts/img/{{ $data1->foto }}" class="rounded-1 img " alt="">
                                    </div>
                                    @php
                                        $deskripsi = $data1->deskripsi;
                                        // Membagi teks menjadi array kata-kata
                                        $kataKata = explode(' ', $deskripsi);
                                        // Mengambil potongan array kata-kata setelah dua kata
                                        $potonganKata = implode(' ', array_slice($kataKata, 3));
                                        // Memastikan jumlah kata-kata tidak melebihi batas
                                        $potonganKata = Str::limit($potonganKata, $jumlahKata);
                                        @endphp
                                    <div class="card-body">
                                        <p class="fs-14 cb">{!! $potonganKata !!}</p>
                                        <p class="d-flex align-items-center fs-13">Baca Selengkapnya >></p>
                                    </div>
                                </div>

                            </div>
                        @empty
                        @endforelse


                    <!-- end news-1 -->
                    <!-- news new 2-->
                    <div class="news-new-2">
                        <div class="row gx-5">
                            @forelse ($data2 as $item)
                            <div class="col-md-6 ">
                                @php // Set lokal ke bahasa Indonesia
                                // Mengonversi format waktu dari database ke format 'Y-m-d H:i:s.u'
                                $waktuUpload = Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $item->createdAt, 'UTC');

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
                                @forelse ($item->Kategoris as $katt)
                                    <div class="card border-0 p-0 m-0">
                                        <div class="row ">
                                            <div class="col d-flex justify-content-between align-items-center fs-13 cb">
                                                <span
                                                    class="fw-bolder text-uppercase bad-c py-0 align-items-center">{{$katt->nama_kategori}}</span>
                                                <span class=" align-items-center"><i class="ri-eye-line me-1"></i>{{$item->views}}</span>
                                            </div>
                                        </div>
                                        <div class="content cb">
                                            <a href="/berita/{{$katt->slug}}/{{$item->slug}}"
                                                class="mb-0 fw-bolder stretched-link cb link-a fs-14"
                                                title="{{$item->judul}}">{{$item->judul}}</a>
                                            <p class=" my-2 fs-13">{{ $hasil }}</p>
                                            <p class="d-flex align-items-center fs-13">Baca Selengkapnya >></p>
                                        </div>
                                    </div>
                                @empty
                                @endforelse


                            </div>
                            @empty

                            @endforelse


                        </div>
                    </div>
                    <!-- end news new 2-->
                </div>
                <!-- end left -->
                <!-- right -->
                <div class="col-md-4">
                    <aside class="my-3">
                        <!-- advertisment 4x4 atas -->
                        <div class="card border-0 d-none d-md-block d-lg-block bg-transparent">
                        <div class="container mt-1">
                            <div id="carousel4x4atas" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                @forelse($kotak as $index => $item)
                                    <div class="carousel-item{{ $index == 0 ? ' active' : '' }}" data-bs-interval="3000">
                                        <a href="{{ $item->link }}" target="_blank">
                                            <img src="{{ $imgUrl }}/iklans/img/{{ $item->gambar }}" class="d-block w-100 rounded-top" alt="...">
                                        </a>
                                    </div>
                                @empty
                                @endforelse
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel4x4atas" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel4x4atas" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            <p class="p-0 m-0 text-center bg-light rounded-bottom" style="font-size: 10px;">
                                ADVERTISEMENT</p>
                        </div>
                    </div>
                        <!-- end advertisment -->
                        <!-- populer -->
                        <div class="news-top container px-0 bg-white rounded-bottom mb-2">
                        <h5 class="card-title fw-semibold text-center bg-creamX p-2 rounded-top"> Berita Populer
                        </h5>
                            <ul class="list-group list-group-flush p-2 border rounded-bottom shadow">
                                 @forelse ($view as $item)
                                    @php
                                            // Mengonversi format waktu dari database ke format 'Y-m-d H:i:s'
                                            $waktuUpload = Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $item->createdAt, 'UTC');
    
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
                                                $hasil = $selisih->h . ' jam yang lalu ';
                                            } elseif ($selisih->i > 0) {
                                                $hasil = $selisih->i . ' menit yang lalu';
                                            } else {
                                                $hasil = $selisih->s . ' detik yang lalu';
                                            }
                                        @endphp
                                
                                <li class="list-group-item px-2">
                                    <div class="row fs-12 cb">
                                        <div class="col-4 col-lg-5 d-flex align-items-center">
                                            <img src="{{ $imgUrl }}/posts/img/{{ $item->foto }}" class="rounded thumbnails"
                                                alt="{{ $item->keterangan_foto }}">
                                        </div>
                                        <div class="col-8 col-lg-7 p-0 ">
                                            @foreach ($item->Kategoris as $kategori)
                                            <div class="row mb-1">
    
                                                    <div class="col d-flex justify-content-between align-items-center me-3">
                                                        <span
                                                            class="fw-bolder text-uppercase bad-c py-0 align-items-center">{{$kategori->nama_kategori}}
                                                        </span>
                                                        <span
                                                            class=" py-0 align-items-center">
                                                            <i class="ri-eye-line me-1"></i>{{$item->views}}
                                                        </span>
                                                    </div>
    
                                            </div>
                                            <a href="/berita/{{$kategori->slug}}/{{ $item->slug }}"
                                                class="mb-0 fw-bolder stretched-link cb link-a"
                                                title="{{$item->judul}}">{{$item->judul}}</a>
                                            <p class="" style="font-size:9px;">{{ $hasil }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                                 @empty
                                @endforelse
                            </ul>
                        </div>
                        <!-- end populer -->
                        <hr>
                        <!-- advertisment -->
                        <!--<div class="card border-0 d-none d-lg-block bg-transparent">-->
                        <!--    <h5 class="p-0 m-0 text-center text-uppercase" style="font-size: 10px;">Advertisment</h5>-->
                        <!--    <div class="container mt-1">-->
                        <!--        <div id="carousel4x6bawah" class="carousel slide" data-bs-ride="carousel">-->
                        <!--            <div class="carousel-inner">-->
                        <!--                <div class="carousel-item active" data-bs-interval="3000">-->
                        <!--                    <img src="{{ asset('img/iklan4x6.jpeg') }}" class="d-block w-100 rounded"-->
                        <!--                        alt="...">-->
                        <!--                </div>-->
                        <!--                <div class="carousel-item" data-bs-interval="3000">-->
                        <!--                    <img src="{{ asset('img/iklan4x6.jpeg') }}" class="d-block w-100 rounded"-->
                        <!--                        alt="...">-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--            <button class="carousel-control-prev" type="button" data-bs-target="#carousel4x6bawah" data-bs-slide="prev">-->
                        <!--            <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
                        <!--            <span class="visually-hidden">Previous</span>-->
                        <!--            </button>-->
                        <!--            <button class="carousel-control-next" type="button" data-bs-target="#carousel4x6bawah" data-bs-slide="next">-->
                        <!--                <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
                        <!--                <span class="visually-hidden">Next</span>-->
                        <!--            </button>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!-- end advertisment -->
                        
                    </aside>
                    <!-- rekomendasi -->
                    <div class="news-top container px-0 bg-white rounded-bottom mb-2 sticky-div">
                        <h5 class="card-title fw-semibold text-center bg-creamX p-2 rounded-top">Rekomendasi
                        </h5>
                        <ul class="list-group list-group-flush p-2 border rounded-bottom shadow">
                            @forelse ($acak as $item)
                            <li class="list-group-item px-2">
                                <div class="row fs-12 cb">
                                    <div class="col-4 col-lg-5 d-flex align-items-center">
                                        <img src="{{ $imgUrl }}/posts/img/{{ $item->foto }}" class="rounded thumbnails"
                                            alt="{{ $item->keterangan_foto }}">
                                    </div>
                                    <div class="col-8 col-lg-7 p-0 ">
                                        @foreach ($item->Kategoris as $kategori)
                                        <div class="row mb-1">

                                                <div class="col d-flex justify-content-between align-items-center me-3">
                                                    <span
                                                        class="fw-bolder text-uppercase bad-c py-0 align-items-center">{{$kategori->nama_kategori}}
                                                    </span>
                                                </div>

                                        </div>
                                        <a href="/berita/{{$kategori->slug}}/{{ $item->slug }}"
                                            class="mb-0 fw-bolder stretched-lin cb link-a"
                                            title="{{$item->judul}}">{{$item->judul}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                            @empty

                            @endforelse


                        </ul>
                    </div>
                    <!-- end rekomendasi -->
                </div>
                <!-- end right -->
            </div>
        </div>
    </section>
    <!-- end content first -->

@endsection

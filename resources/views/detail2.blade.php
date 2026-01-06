@extends('lay.layout')
@section('title', $kate->nama_kategori )
@section('content')
@php

use Carbon\Carbon;
use Carbon\CarbonInterface;

use Illuminate\Support\Str;
$jumlahKata = 150;

@endphp
<section class="my-3 d-flex justify-content-center">
    <div class="container">
        {{-- <nav class="" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/">Beranda</a></li>
              <li class="breadcrumb-item"><a href="/">Kategori</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{$kate->nama_kategori}}</li>
            </ol>
        </nav> --}}
        <div class="row d-flex justify-content-center">
            <!-- left -->
            <div class="col-md-8">

                <!-- news new 1-->
                <div class="news-new-1">
                    <div class="row post-detail gy-3">

                        @forelse ($data as $d4)
                        @php
                                        // Mengonversi format waktu dari database ke format 'Y-m-d H:i:s'
                                        $waktuUpload = Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $d4->createdAt, 'UTC');

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
                                                $hasil = $waktuUpload->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY, HH:mm [WIB]');
                                                $hasilm = $selisih->days > 1 ? $selisih->days . ' hari yang lalu' : $hasil;
                                            } else {
                                                $hasil = '1 hari yang lalu';
                                                $hasilm = '1 hari yang lalu';
                                            }
                                        } elseif ($selisih->h > 0) {
                                            $hasil = $selisih->h . ' jam yang lalu ';
                                            $hasilm = $selisih->h . ' jam yang lalu ';
                                        } elseif ($selisih->i > 0) {
                                            $hasil = $selisih->i . ' menit yang lalu';
                                            $hasilm = $selisih->i . ' menit yang lalu';
                                        } else {
                                            $hasil = $selisih->s . ' detik yang lalu';
                                            $hasilm = $selisih->s . ' detik yang lalu';
                                        }
                                    @endphp
                    <div class="col-12 col-md-6">
                        <div class="post mb-4">
                            <div class="card border-0 bg-light p-0">
                                <span class="badge text-bg-info position-absolute rounded-0 mt-3 px-2 d-none d-md-inline">{{$kate->nama_kategori}}</span>
                                <div class=" wrapper card-header border-0 rounded-top bg-transparent p-0 pb-1">
                                    <img src="{{ $imgUrl }}/posts/img/{{$d4->foto}}" class="rounded-1 w-100" style="height: 200px; object-fit: cover;" alt="">
                                </div>
                                <div class="ps-3 bg-light">
                                    <a href="/berita/{{$kate->slug}}/{{$d4->slug}}" class="cb link-a fw-bolder fs-6 fw-bolder" title="{{$d4->judul}}">{{$d4->judul}}</a>

                                </div>
                                <div class="card-body">
                                    {{-- <p class="fs-13 cb">{!! Str::limit($d4->deskripsi, $jumlahKata) !!}</p> --}}
                                    @php
                                        $deskripsi = $d4->deskripsi;
                                        // Membagi teks menjadi array kata-kata
                                        $kataKata = explode(' ', $deskripsi);
                                        // Mengambil potongan array kata-kata setelah dua kata
                                        $potonganKata = implode(' ', array_slice($kataKata, 3));
                                        // Memastikan jumlah kata-kata tidak melebihi batas
                                        $potonganKata = Str::limit($potonganKata, $jumlahKata);
                                        @endphp
                                    <p class="fs-13 cb d-none d-md-block">
                                        {!! $potonganKata !!}
                                    </p>
                                    <p class="text-capitalize d-none d-md-block"><i class="ri-calendar-fill me-1" style="font-size:12px;"> {{$hasil}}</i></p>

                                    <ul class="list-inline d-block d-md-none " style="font-size: 14px;">
                                        <li class="list-inline-item fw-bold">{{$kate->nama_kategori}}</li>
                                        <li class="list-inline-item">-</li>
                                        <li class="list-inline-item">{{$hasilm}}</li>
                                      </ul>
                                </div>
                            </div>
                        </div>
                    </div>




                        @empty
                        @endforelse
                    </div>
                    <div class="text-center d-grid mt-5">
                        <button id="loadMoreBtn2" class="btn btn-cream rounded-pill" data-slug="{{$kate->slug}}">
                            <span id="loadingSpinner" style="display: none;">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Memuat...
                            </span>
                            <span id="loadMoreText">Tampilkan Selanjutnya</span>
                        </button>
                    </div>
                </div>
                <!-- end news new 1-->
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

            </div>
            <!-- end left -->

            <!-- right -->
            <div class="col-md-4">
                <aside class="my-3">
                    <!-- advertisment 4x4 atas -->
                    <div class="card border-0 d-none d-lg-block bg-transparent">
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
                    <hr>
                    
                </aside>
                <!-- popular -->
                    <div class="news-top container px-0 bg-white rounded-bottom mb-2 sticky-div">
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
                                            <p class="fs-10">{{ $hasil }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                                 @empty
                                @endforelse
                            </ul>
                        </div>
                <!-- end popular -->

            </div>
            <!-- end right -->
        </div>
    </div>
</section>
@endsection

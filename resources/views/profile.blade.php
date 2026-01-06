@extends('lay.layout')
@php
use Carbon\Carbon;
use Carbon\CarbonInterface;
@endphp
@section('content')
<section class="section">
    <div class="row d-flex justify-content-center">
        <div class="col-12">
            <section class="section profile">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="card border-0 shadow-sm ">
                            <div class="card-body ">
                                <a href="/" class="text-dark">Beranda</a> / <a href="/" class="text-dark">Writer</a> / <span>{{$data->nama_akun}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card border-0 shadow-sm bg-cream py-0">
                            <div class="card-body my-0 d-flex align-items-center">
                                <div class="row d-flex align-items-center">
                                    <div class="col-2 col-md-1">
                                        <img src="{{$linkA}}{{$data->foto}}" alt="Profile" class="w-100 rounded-circle">
                                    </div>
                                    <div class="col-10 col-md-11">
                                        <h6>{{$data->nama_akun}}</h6>
                                        <p class="mb-0">{{$data->email}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-8">
                        <div class="news-new-1 border rounded p-2">
                            <div class="row post-container gx-5">

                                <div class="col-12 col-md-12 post-a">

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
                                            <div class="col-4 col-md-4 d-flex align-items-center">
                                                <img src="{{$linkP}}{{ $item->foto }}" class="rounded thumbnails border" alt="{{ $item->keterangan_foto }}">
                                            </div>
                                            <div class="col-8 col-md-8 p-0 ">
                                                <div class="col-12 col-md-12 p-0">
                                                    <div class="d-flex flex-column terbaru">
                                                        <!-- Judul Berita -->
                                                        @forelse ($item->Kategoris as $katt)
                                                        <a href="/berita/{{$katt->slug}}/{{ $item->slug }}" class="mb-2 cb link-a fs-15 fw-bold" title="{{ $item->judul }}">{{ $item->judul }}</a>


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
                                                                    <p class="me-2">admin</p>|
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
                                <button id="loadMoreAuthor" class="btn btn-cream border-0 rounded-pill " data-slug="{{$data->email}}" aria-disabled="true">
                                    <span id="loadingSpinner" style="display: none;">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Memuat...
                                    </span>
                                    <span id="loadMoreText">Tampilkan Selanjutnya</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <aside>
                            <!-- advertisment -->
                            <div class="card border-0 d-none d-lg-block bg-transparent">

                                <div class="container mt-1">
                                    <div id="carousel4x4atas" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @forelse ($iklan->iklanKotak as $item)
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="2500">
                                                <img src="{{ $imgUrl }}/iklans/img/{{ $item->gambar }}" class="d-block w-100 rounded-top" alt="ads">
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
                                    <p class="p-0 m-0 text-center bg-light rounded-bottom" style="font-size: 10px;">ADVERTISEMENT</p>
                                </div>
                            </div>
                            <!-- end advertisment -->
                            <!-- popular -->
                            <div class="news-top container px-0 bg-white rounded-bottom mb-2">
                                <h5 class="card-title fw-semibold text-center bg-creamX p-2 rounded-top"># Berita Terpopuler
                                </h5>
                                <ul class="list-group list-group-flush p-1 border rounded-bottom shadow">
                                    @forelse ($populer as $item)
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
                                        <div class="row font">
                                            <div class="col-4 col-md-5 col-lg-4 d-flex align-items-center px-0 mx-2">
                                                <img src="{{ $imgUrl }}/posts/img/{{ $item->foto }}" class="rounded thumbnails" alt="{{ $item->keterangan_foto }}">
                                            </div>
                                            <div class="col-7 col-md-7 col-lg-7 p-0 pe-1">
                                                @foreach ($item->Kategoris as $kategori)
                                                <div class="row ">
                                                    <div class="col d-flex justify-content-between align-items-center me-3 py-1">
                                                        <span class=" text-capitalize bad-c align-items-center">{{$kategori->nama_kategori}}</span>
                                                        <span class="align-items-center"><i class="ri-eye-line"></i>{{$item->views}}</span>
                                                    </div>

                                                </div>
                                                <a href="/berita/{{$kategori->slug}}/{{ $item->slug }}" class="mb-0 fw-bolder stretched-lin cb link-a" title="{{ $item->judul }}">{{ $item->judul }}</a>
                                                <p class="my-0 time">{{ $hasil }}</p>
                                                @endforeach
                                            </div>

                                        </div>
                                    </li>
                                    @empty

                                    @endforelse


                                </ul>


                            </div>
                            <!-- end popular -->
                            <!-- advertisment -->
                            <div class="card border-0 d-none d-lg-block bg-transparent">

                                <div class="container mt-1">
                                    <div id="carousel4x4atas" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @forelse ($iklan->iklanKotak as $item)
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="2500">
                                                <img src="{{ $imgUrl }}/iklans/img/{{ $item->gambar }}" class="d-block w-100 rounded-top" alt="ads">
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
                                    <p class="p-0 m-0 text-center bg-light rounded-bottom" style="font-size: 10px;">ADVERTISEMENT</p>
                                </div>
                            </div>
                            <!-- end advertisment -->
                            <!-- advertisment 4x4 atas -->
                            <div class="d-block d-md-none d-lg-none card border-0  bg-transparent mb-1">

                                <div class="container mt-1">
                                    <div id="carousel4x4top" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @forelse ($iklan->iklanKotak as $item)
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="2500">
                                                <img src="{{ $imgUrl }}/iklans/img/{{ $item->gambar }}" class="d-block w-100 rounded-top" alt="ads">
                                            </div>
                                            @empty
                                            @endforelse
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel4x4top" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carousel4x4top" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                    <p class="p-0 m-0 text-center bg-light rounded-bottom" style="font-size: 10px;">
                                        ADVERTISEMENT</p>
                                </div>
                            </div>
                            <!-- end advertisment -->
                        </aside>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<script>
    /* post author */
        $(document).ready(function() {
            var offset = 2; // Jumlah postingan yang sudah ditampilkan secara awal
            var limit = 2; // Jumlah postingan yang ingin ditampilkan setiap kali tombol diklik
            var isLoading = false; // Status apakah sedang memuat atau tidak

            $("#loadMoreAuthor").click(function () {
                if (isLoading) {
                    return; // Jika sedang memuat, abaikan klik tombol
                }

                isLoading = true; // Set status memuat menjadi true
                $("#loadMoreText").hide(); // Sembunyikan teks "Tampilkan Selanjutnya"
                $("#loadingSpinner").show(); // Tampilkan animasi loading
                var slug = $(this).data("slug");
                $.ajax({
                    url: "/load-more-author",
                    type: "GET",
                    data: {
                        offset: offset,
                        limit: limit,
                        data: slug,
                    },
                    success: function (response) {
                        // Menambahkan postingan tambahan ke dalam tampilan
                        $(".post-a").append(response);

                        // Menambahkan offset
                        offset += limit;

                        // Menyembunyikan animasi loading dan menampilkan tombol jika tidak ada postingan lagi
                        if (response.trim().length === 0) {
                            $("#loadMoreAuthor").hide();
                        } else {
                            $("#loadMoreAuthor").show();
                        }

                        isLoading = false; // Set status memuat menjadi false
                        $("#loadMoreText").show(); // Tampilkan kembali teks "Tampilkan Selanjutnya"
                        $("#loadingSpinner").hide(); // Sembunyikan animasi loading setelah data dimuat
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);

                        isLoading = false; // Set status memuat menjadi false
                        $("#loadMoreText").show(); // Tampilkan kembali teks "Tampilkan Selanjutnya"
                        $("#loadingSpinner").hide(); // Sembunyikan animasi loading jika terjadi kesalahan
                    },
                });
            });
        });
        /* end post author */
</script>
@endsection

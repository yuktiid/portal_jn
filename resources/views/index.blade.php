@extends('lay.layout')
@section('title', 'Beranda - Jurnal Nusa')

{{-- meta --}}
@section('meta_title', 'Jurnal Nusa - Beranda')
@section('meta_keywords', 'jurnal nusa, jurnal nusa, jurnalnusa')
@section('meta_description', 'Jurnalnusa.com -Spectrum positif jurnalism')
@section('meta_type', 'article')
@section('meta_url', url()->current())
@section('meta_image', asset('Log2.png'))
@section('meta_site_name', 'Jurnalnusa.com')
{{-- robot --}}
@section('robots', 'index, follow')
{{-- end --}}

@section('content')
    @php
        use Carbon\Carbon;
        use Illuminate\Support\Str;
    @endphp

    <section class="mt-3">
        <div class="container">
            <div class="row d-flex">
                @forelse ($data5 as $item)
                    <div class="col-6 col-lg-3">
                        <div class="card border-0 d-flex align-items-center bg-transparent">
                            <div class="wrapper">
                                <img loading="lazy" src="{{ $imgUrl }}/posts/img/{{ $item->foto }}"
                                    class="w-100 rounded img" alt="{{ $item->keterangan_foto }}"
                                    title="{{ $item->keterangan_foto }}">
                            </div>
                            <div class="card-body p-2">
                                @foreach ($item->Kategoris as $katt)
                                    <a href="/berita/{{ $katt->slug ?? 'umum' }}/{{ $item->slug }}"
                                        class="d-inline-block link-a stretched-link fw-bolder fs-12 text-darks"
                                        title="{{ $item->judul }}"
                                        style="font-size: 12px; color: black;">{{ $item->judul }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Kosong --}}
                @endforelse
            </div>
        </div>
    </section>
    <section class="my-3 d-flex justify-content-center">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="row my-0">
                        <div class="col">
                            <style>
                                .owl-carousel .owl-dots {
                                    display: none;
                                }
                            </style>
                            <div class="owl-carousel" id="carousel1">
                                @forelse ($acak1 as $item)
                                    @php
                                        // OPTIMASI: Menggunakan diffForHumans() jauh lebih cepat daripada hitung manual
                                        $waktu = Carbon::parse($item->createdAt)->locale('id')->diffForHumans();
                                    @endphp
                                    <div class="item p-0">
                                        <div class="card border-0 shadow m-2">
                                            <div class="wrapper rounded-1">
                                                <img loading="lazy"
                                                    src="{{ $imgUrl }}/posts/img/{{ $item->foto }}"
                                                    class="img rounded-top" alt="{{ $item->keterangan_foto }}">
                                            </div>
                                            <div class="mt-2 px-3">
                                                @foreach ($item->Kategoris as $katt)
                                                    <a href="/berita/{{ $katt->slug ?? 'umum' }}/{{ $item->slug }}"
                                                        class="card-title link-a d-block fw-bolder text-start fs-5 stretched-link"
                                                        title="{{ $item->judul }}">{{ $item->judul }}</a>
                                                @endforeach
                                                <p class="text-capitalize mt-1" style="font-size: 12px;">
                                                    <i class="ri-calendar-fill me-1"></i>{{ $waktu }}
                                                </p>
                                            </div>
                                            <div class="card-body">
                                                <p class="fs-13 cb">{{ Str::limit($item->keterangan_foto, 100) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if (isset($tengah) && isset($tengah->gambar))
                            <div class="ads border-top border-bottom py-3">
                                <div class="card border-0 bg-light">
                                    <a href="{{ $tengah->link ?? '#' }}">
                                        <img loading="lazy"
                                            src="{{ $imgUrl }}/iklans/img/{{ $tengah->gambar }}"
                                            class="w-100 rounded-1" alt="Iklan">
                                    </a>
                                    <span class="card-title text-center" style="font-size: 10px;">ADVERTISEMENT</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row my-3 bg-creamX p-3 rounded">
                        <div class="title pb-2">
                            <h4 class="fw-semibold"># E-Jurnal</h4>
                            <h5>Berlangganan Gratis</h5>
                        </div>
                        <div id="carouselExampleInterval" class="carousel slide mb-2" data-bs-ride="carousel">
                            <div class="carousel-inner border">
                                @if (isset($gambarArray) && isset($gambarArray->data))
                                    @forelse ($gambarArray->data as $index => $gambar)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}" data-bs-interval="2000">
                                            <a href="/e-jurnal/{{ $gambar->slug }}/#gallery-1" class="stretched-link">
                                                
                                                {{-- PERUBAHAN ADA DI SINI --}}
                                                <img loading="lazy" 
                                                    src="{{ $gambarArray->link ?? '' }}{{ $gambar->gambar }}"
                                                    class="d-block w-100" 
                                                    alt="{{ $gambar->gambar }}"
                                                    style="width: 100%; aspect-ratio: 3/4; object-fit: cover;">
                                                {{-- END PERUBAHAN --}}

                                            </a>
                                            <div class="carousel-caption">
                                                <h5 class="bg-dark bg-opacity-50 p-1 rounded">{{ $gambar->judul }}</h5>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="carousel-item active">
                                            <div class="d-flex align-items-center justify-content-center" style="height: 500px; background-color: #f0f0f0;">
                                                <p class="text-center">Tidak ada E-Jurnal</p>
                                            </div>
                                        </div>
                                    @endforelse
                                @endif
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
                    <div class="news-new-1 border rounded p-2">
                        <div class="row post-container gx-5">
                            <div class="title my-3">
                                <h4 class="fw-semibold">Berita Terbaru</h4>
                            </div>
                            <div class="col-12 col-md-12 post">
                                @forelse ($berita as $item)
                                    @php
                                        // OPTIMASI TANGGAL
                                        $waktu = Carbon::parse($item->createdAt)->locale('id')->diffForHumans();
                                    @endphp
                                    <div class="card border-0 m-1 px-2">
                                        <div class="row fs-14 cb">
                                            <div class="col-5 col-lg-4 d-flex align-items-center">
                                                <img loading="lazy"
                                                    src="{{ $imgUrl }}/posts/img/{{ $item->foto }}"
                                                    class="rounded thumbnails border"
                                                    alt="{{ $item->keterangan_foto }}">
                                            </div>
                                            <div class="col-7 col-lg-8 p-0 d-flex align-items-center">
                                                <div class="col-12 col-lg-12 p-0">
                                                    <div class="d-flex flex-column terbaru">
                                                        @foreach ($item->Kategoris as $katt)
                                                            <a href="/berita/{{ $katt->slug ?? 'umum' }}/{{ $item->slug }}"
                                                                class="mb-2 cb link-a fs-15 fw-bold"
                                                                title="{{ $item->judul }}">{{ $item->judul }}</a>
                                                            <div class="mt-0">
                                                                <div class="col d-flex mb-0">
                                                                    <a href="/kategori/{{ $katt->slug ?? 'umum' }}"
                                                                        class="fw-bold cb link-a tex-c">
                                                                        {{ $katt->nama_kategori }}
                                                                    </a>
                                                                </div>
                                                                <div class="row mt-0">
                                                                    <div class="col d-flex fs-12">
                                                                        <p class="me-2">
                                                                            @if (isset($item->id_author->email))
                                                                                <a href="/writer/{{ $item->id_author->email }}"
                                                                                    class="text-dark text-decoration-none fw-bold">{{ $item->id_author->nama_akun }}</a>
                                                                            @elseif(isset($item->idPengunjung->email))
                                                                                <a href="/writer/{{ $item->idPengunjung->email }}"
                                                                                    class="text-dark text-decoration-none fw-bold">{{ $item->idPengunjung->nama_pengunjung }}</a>
                                                                            @endif
                                                                        </p>|
                                                                        <p class="ms-1">{{ $waktu }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                @empty
                                    <p class="text-center">Belum ada berita terbaru.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="text-center d-grid tombolload">
                            <button id="loadMoreBtn" class="btn btn-cream border-0 rounded-pill " aria-disabled="true">
                                <span id="loadingSpinner" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Memuat...
                                </span>
                                <span id="loadMoreText">Tampilkan Selanjutnya</span>
                            </button>
                        </div>
                    </div>
                    @if ($data1)
                        @php
                            $waktuData1 = Carbon::parse($data1->createdAt)->locale('id')->diffForHumans();
                            $deskripsiClean = strip_tags($data1->deskripsi); // Bersihkan HTML tags dulu
                            $potonganKata = Str::words($deskripsiClean, 30, '...'); // Ambil 30 kata pertama
                        @endphp

                        @foreach ($data1->Kategoris as $katt)
                            <div class="news-1 my-3 border-bottom p-0">
                                <div class="card border-0 m-0 p-0">
                                    <div class="card-header border-0 my-0 p-1">
                                        <a href="/berita/{{ $katt->slug ?? 'umum' }}/{{ $data1->slug }}"
                                            class="card-title link-a d-block fw-bolder text-start text-md-center fs-5 stretched-link px-3"
                                            title="{{ $data1->judul }}">{{ $data1->judul }}</a>
                                        <div class="row fs-12 cb p-0 m-0">
                                            <div class="col d-flex align-items-center p-0 m-0 justify-content-center">
                                                <p class="fw-bolder text-uppercase bad-c py-0 align-items-center mx-2 ">
                                                    {{ $katt->nama_kategori }}</p>
                                                <p>{{ $waktuData1 }} - </p>
                                                <p>Oleh <span class="text-warning fs-13 mx-1">
                                                        @if (isset($data1->id_author->nama_akun))
                                                            {{ $data1->id_author->nama_akun }}
                                                        @elseif(isset($data1->idPengunjung->nama_pengunjung))
                                                            {{ $data1->idPengunjung->nama_pengunjung }}
                                                        @endif
                                                    </span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wrapper rounded-1 ">
                                        <img loading="lazy"
                                            src="{{ $imgUrl }}/posts/img/{{ $data1->foto }}"
                                            class="rounded-1 img " alt="">
                                    </div>
                                    <div class="card-body">
                                        <p class="fs-14 cb">{{ $potonganKata }}</p>
                                        <p class="d-flex align-items-center fs-13">Baca Selengkapnya >></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div class="news-new-2">
                        <div class="row gx-5">
                            @forelse ($data2 as $item)
                                @php
                                    $waktu = Carbon::parse($item->createdAt)->locale('id')->diffForHumans();
                                @endphp
                                <div class="col-md-6 ">
                                    @foreach ($item->Kategoris as $katt)
                                        <div class="card border-0 p-0 m-0">
                                            <div class="row ">
                                                <div
                                                    class="col d-flex justify-content-between align-items-center fs-13 cb">
                                                    <span
                                                        class="fw-bolder text-uppercase bad-c py-0 align-items-center">{{ $katt->nama_kategori }}</span>
                                                    <span class=" align-items-center"><i
                                                            class="ri-eye-line me-1"></i>{{ $item->views }}</span>
                                                </div>
                                            </div>
                                            <div class="content cb">
                                                <a href="/berita/{{ $katt->slug ?? 'umum' }}/{{ $item->slug }}"
                                                    class="mb-0 fw-bolder stretched-link cb link-a fs-14"
                                                    title="{{ $item->judul }}">{{ $item->judul }}</a>
                                                <p class=" my-2 fs-13">{{ $waktu }}</p>
                                                <p class="d-flex align-items-center fs-13">Baca Selengkapnya >></p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                    </div>
                    <div class="col-md-4">
                        <aside class="my-3">
                            
                            <div class="card border-0 d-none d-md-block d-lg-block bg-transparent">
                                <div class="container mt-1">
                                    
                                    @if (isset($kotak) && count($kotak) > 0)
                                        <div id="carousel4x4atas" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach ($kotak as $index => $item)
                                                    <div class="carousel-item{{ $index == 0 ? ' active' : '' }}" data-bs-interval="3000">
                                                        <a href="{{ $item->link ?? '#' }}" target="_blank">
                                                            <img loading="lazy"
                                                                src="{{ $imgUrl }}/iklans/img/{{ $item->gambar }}"
                                                                class="d-block w-100 rounded-top" 
                                                                alt="Iklan"
                                                                style="min-height: 300px; object-fit: cover;"> 
                                                        </a>
                                                    </div>
                                                @endforeach
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

                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light rounded shadow-sm text-secondary" 
                                            style="height: 320px; width: 100%; border: 1px dashed #ccc;">
                                            <div class="text-center">
                                                <div class="spinner-border spinner-border-sm mb-2" role="status"></div>
                                                <p style="font-size: 12px;">Memuat Iklan...</p>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            
                            <hr>
                        </aside>

                        <div class="news-top container px-0 bg-white rounded-bottom mb-2">
                            <h5 class="card-title fw-semibold text-center bg-creamX p-2 rounded-top"> Berita Populer</h5>
                            <ul class="list-group list-group-flush p-2 border rounded-bottom shadow">
                                @forelse ($view as $item)
                                    @php
                                        $waktu = Carbon::parse($item->createdAt)->locale('id')->diffForHumans();
                                    @endphp
                                    <li class="list-group-item px-2">
                                        <div class="row fs-12 cb">
                                            <div class="col-4 col-lg-5 d-flex align-items-center">
                                                <img loading="lazy"
                                                    src="{{ $imgUrl }}/posts/img/{{ $item->foto }}"
                                                    class="rounded thumbnails" alt="{{ $item->keterangan_foto }}">
                                            </div>
                                            <div class="col-8 col-lg-7 p-0 ">
                                                @foreach ($item->Kategoris as $kategori)
                                                    <div class="row mb-1">
                                                        <div class="col d-flex justify-content-between align-items-center me-3">
                                                            <span class="fw-bolder text-uppercase bad-c py-0 align-items-center">{{ $kategori->nama_kategori }}</span>
                                                            <span class=" py-0 align-items-center">
                                                                <i class="ri-eye-line me-1"></i>{{ $item->views }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <a href="/berita/{{ $kategori->slug ?? 'umum' }}/{{ $item->slug }}"
                                                        class="mb-0 fw-bolder stretched-link cb link-a"
                                                        title="{{ $item->judul }}">{{ $item->judul }}</a>
                                                    <p class="" style="font-size:9px;">{{ $waktu }}</p>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>

                        <div class="news-top container px-0 bg-white rounded-bottom mb-2 sticky-div">
                            <h5 class="card-title fw-semibold text-center bg-creamX p-2 rounded-top">Rekomendasi</h5>
                            <ul class="list-group list-group-flush p-2 border rounded-bottom shadow">
                                @forelse ($acak as $item)
                                    <li class="list-group-item px-2">
                                        <div class="row fs-12 cb">
                                            <div class="col-4 col-lg-5 d-flex align-items-center">
                                                <img loading="lazy"
                                                    src="{{ $imgUrl }}/posts/img/{{ $item->foto }}"
                                                    class="rounded thumbnails" alt="{{ $item->keterangan_foto }}">
                                            </div>
                                            <div class="col-8 col-lg-7 p-0 ">
                                                @foreach ($item->Kategoris as $kategori)
                                                    <div class="row mb-1">
                                                        <div class="col d-flex justify-content-between align-items-center me-3">
                                                            <span class="fw-bolder text-uppercase bad-c py-0 align-items-center">{{ $kategori->nama_kategori }}</span>
                                                        </div>
                                                    </div>
                                                    <a href="/berita/{{ $kategori->slug ?? 'umum' }}/{{ $item->slug }}"
                                                        class="mb-0 fw-bolder stretched-lin cb link-a"
                                                        title="{{ $item->judul }}">{{ $item->judul }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
        </div>
    </section>
    @endsection
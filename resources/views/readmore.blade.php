@extends('lay.layout') 

@section('title', $data->judul)

{{-- meta --}}
@section('meta_title', $data->judul)
@section('meta_description',$data->keterangan_foto)
@section('meta_type', 'article')
@section('meta_url', url()->current() )
@section('meta_image', $imgUrl . '/posts/img/' . $data->foto)
@section('meta_keywords')@php $tags = []; foreach ($data->Tags as $item) { $tags[] = $item->nama_tag; } $keywords = implode(',', $tags); echo trim($keywords); @endphp
@endsection
@section('meta_site_name', 'jurnalnusantara')
@section('pubdate', \Carbon\Carbon::parse($data->createdAt)->format('Y-m-d\TH:i:s\Z'))
{{-- robot --}}
@section('robots', 'index, follow')
{{-- end --}}

@section('content')
@php
use Carbon\Carbon;
        use Carbon\CarbonInterface;
        
@endphp

<section class="my-3 mx-0">
    <div class="container mx-0">
        
        <div class="row">
            <div class="d-none d-md-block">
                <nav  style="--bs-breadcrumb-divider: '>';font-size: 13px;" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none fw-bold text-dark">Beranda</a></li>
                    @forelse ($data->Kategoris as $item)
                    <li class="breadcrumb-item"><a href="/kategori/{{$item->slug}}" class="text-decoration-none fw-bold text-dark">{{$item->nama_kategori}}</a></li>
                    @empty
                    @endforelse
                    <li class="breadcrumb-item active">{{$data->judul}}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-8">
                
                <div class="card border-0 p-3 pt-0">
                    {{-- desktop --}}
                    <div class="d-none d-md-inline-flex admin row d-flex justify-content-between align-items-center my-3">
                        <h2 class="text-center fw-bold mb-2">{{$data->judul}}</h2>
                        <div class=" col-7 col-md-7">
                            <div class="row g-2 d-flex align-items-end">
                                <div class="col-2 wrapper">
                                    <img loading="lazy" src="{{ asset('img/d.jpg') }}" class="w-100 rounded-circle img2" alt="admin">
                                </div>
                                <div class="col-9 py-2 " style="line-height: 5px;">
                                    <p>
                                    @if(isset($data->id_author))
                                        <a href="/writer/{{$data->id_author->email}}" class="text-dark text-decoration-none fw-bold">{{$data->id_author->nama_akun}}</a>
                                    @elseif(isset($data->idPengunjung))
                                        <a href="/writer/{{$data->idPengunjung->email}}" class="text-dark text-decoration-none fw-bold">{{$data->idPengunjung->nama_pengunjung}}</a>
                                    @else
                                    @endif
                                    </p>

                                    <!--<p class="fw-semibold text-warning fs-14">admin</p>-->
                                    <p class="fs-13 mb-0">
                                        {{ \Carbon\Carbon::parse($data->createdAt)
                                        ->locale('id_ID')
                                        ->isoFormat('dddd, DD MMMM YYYY - HH:mm') }}
                                    </p>

                                </div>
                            </div>

                        </div>
                        <div class="col-4 d-flex align-items-center justify-content-center">
                            <span class="me-1"><i class="ri-eye-line me-1"></i>{{$data->views}}</span> | 
                            <a class="a2a_dd text-secondary text-decoration-none ms-1" href="https://www.addtoany.com/share"><i class="ri-share-fill"></i> Bagikan</a>
                        </div>
                    </div>
                    {{-- mobile --}}
                    <div class="d-block d-md-none card border-0  p-3">
                        <div class="text-center">
                        <h3 class=" fw-bold">{{$data->judul}}</h3>
                        @forelse ($data->Kategoris as $item)
                        <p class="mb-1 fs-14 fw-bold">
                                    @if(isset($data->id_author))
                                        <a href="/writer/{{$data->id_author->email}}" class="text-dark text-decoration-none fw-bold">{{$data->id_author->nama_akun}}</a>
                                    @elseif(isset($data->idPengunjung))
                                        <a href="/writer/{{$data->idPengunjung->email}}" class="text-dark text-decoration-none fw-bold">{{$data->idPengunjung->nama_pengunjung}}</a>
                                    @else
                                    @endif
                            - <a href="/#" class="text-danger text-decoration-none">{{$item->nama_kategori}}</a></p>
                        @empty
                        @endforelse
                        <p class="fs-12 mb-2">{{ \Carbon\Carbon::parse($data->createdAt)
                            ->locale('id_ID')
                            ->isoFormat('dddd, DD MMMM YYYY  -  HH:mm') }} | <i class="ri-eye-line me-1"></i>{{$data->views}}</p>
                        </div>
                    </div>
                    
                    <!-- end admin -->
                    <div class="wrapper">
                        <img loading="lazy" src="{{ $imgUrl }}/posts/img/{{ $data->foto }}" class="w-100 rounded img" alt="">
                        <p class="cb fs-13 fst-italic">{{$data->keterangan_foto}}</p>
                    </div>
                    <div class="content ">
                    @php
                        // Pecah deskripsi menjadi array paragraf
                        $paragrafArray = preg_split('/<\/p>/', $data->deskripsi, -1, PREG_SPLIT_NO_EMPTY);
                        
                        // Hitung jumlah paragraf
                        $jumlahParagraf = count($paragrafArray);
                        
                        // Tentukan di mana akan disisipkan bagian "Baca Juga"
                        $posisiSisip = min(3, $jumlahParagraf); // Sisip setelah 2 atau 3 paragraf
                    @endphp
                    
                        @foreach(array_slice($paragrafArray, 0, $posisiSisip) as $paragraf)
                            <p style="font-size: 18px;">{!! $paragraf !!}</p>
                        @endforeach
                        
                        <style>
                            figure img,
                            p img {
                              width: 100%;
                              height: auto; /* Menjaga aspek rasio gambar */
                            }

                        </style>

                        <!-- Baca Juga Section -->
                        <table class="linksisip fs-15">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="lihatjg">
                                            <strong>Baca juga: </strong>
                                            <br>
                                            <a data-label="List Berita" data-action="Berita Pilihan" data-category="Detil Artikel" href="{{$baca->slug}}" class="text-decoration-none color">{{$baca->judul}}</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <style>
                            .linksisip {
                                        position: relative;
                                        margin: 8px 0;
                                        border-left: 5px solid #d38900;
                                    }
                            .linksisip .lihatjg {
                                        padding-left: 20px;
                                    }
                        </style>
                        
                        @foreach(array_slice($paragrafArray, $posisiSisip) as $paragraf)
                            <p style="font-size: 18px;">{!! $paragraf !!}</p>
                        @endforeach
                        <!--<p style="font-size: 18px;">{!! substr($data->deskripsi, strlen($data->deskripsi)/2) !!}</p>-->

                        
                        <div class="text-center">
                            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4918078179726425"
                                 crossorigin="anonymous"></script>
                            <ins class="adsbygoogle"
                                 style="display:block; text-align:center;"
                                 data-ad-layout="in-article"
                                 data-ad-format="fluid"
                                 data-ad-client="ca-pub-4918078179726425"
                                 data-ad-slot="6385914176"></ins>
                            <script>
                                 (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>
                        </div>
                        
                        <div class="tags">
                            <h5 class="mb-3 fw-semibold">Tags</h5>
                            {{-- @forelse (json_decode($d->tag) as $t) --}}
                            @forelse ($data->Tags as $item)
                             <a href="/tag/{{$item->slug}}" class="btn btn-outline-secondary me-2 rounded-pill my-1 tagsf">{{$item->nama_tag}}</a>
                            
                            @empty

                            @endforelse

                            {{-- @empty

                            @endforelse --}}
                        </div>
                        
                        <div class="share mt-2">
                            <h5 class="mb-3 fw-semibold">Komentar</h5>
                            {{-- --}}
                            <div id="komentar-container">
                                <!-- Tampilkan komentar yang sudah ada di sini -->
                            </div>
                            <hr>
                            <div class="border p-2 rounded">
                                <form id="form-komentar">
                                    @csrf
                                    @if(session('user'))
                                    @php $user = session('user'); @endphp
                                    <div class="form-group mb-1">
                                    
                                        <div class="d-flex justify-content-start align-items-center">
                                         <input type="text" id="naman" class="form-control visually-hidden" value="{{$user->id_pengunjung}}">
                                            <div class="me-2">
                                                <img loading="lazy" src="{{$user->foto}}" class="rounded-pill" alt="User Avatar" style="width:40px;">
                                            </div>
                                            <div class="">
                                                <h6 class="fw-bold">{{ strstr($user->nama_pengunjung, ' ', true) }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-1">
                                        <textarea class="form-control" id="comment" rows="2" placeholder="Komentar"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-warning">Kirim</button>
                                    @else
                                    <div class="form-group mb-1">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="me-2">
                                                <img loading="lazy" src="{{ asset('img/d.jpg') }}" class="rounded-pill" alt="User Avatar" style="width:40px;">
                                            </div>
                                            <div class="">
                                                <h6 class="fw-bold">anonim</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-1">
                                        <textarea class="form-control" rows="2" placeholder="login terlebih dahulu"></textarea>
                                    </div>
                                    <button data-bs-target="#modlogin" data-bs-toggle="modal" class="btn btn-warning text-capitalize" >login</button>
                                    @endif

                                </form>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    
                                    $('#form-komentar').on('submit', function(e) {
                                        e.preventDefault();
                                        var id_pengunjung = $('#naman').val();
                                        var id_post = '<?= $data->id_post ?>';
                                        var commentText = $('#comment').val();
                                        console.log(id_post);
                                        console.log(commentText);
                                        $.ajax({
                                            type: 'POST',
                                            url: '{{ route("comment.store") }}',
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                                id_post: id_post,
                                                comment: commentText,
                                                id_pengunjung: id_pengunjung,
                                            },
                                            success: function(data) {
                                                console.log(data);
                                                // Buat HTML untuk komentar baru
                                                var commentHtml = `
                                                    <div class="media-body border p-2 rounded my-1">
                                                        <div class="d-flex justify-content-start align-items-center">
                                                            <div class="me-2">
                                                                <img loading="lazy src="" class="rounded-pill" alt="User Avatar" style="width:40px;">
                                                            </div>
                                                            <div class="">
                                                                <h6 class="fw-bold">${data.idPengunjung}</h6>
                                                                <p style="font-size: 13px;">${data.komentar}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                `;
                                                // Tambahkan komentar baru ke #komentar-container
                                                $('#komentar-container').append(commentHtml);
                                                // Bersihkan formulir
                                                $('#comment').val('');
                                            
                                                // Muat ulang komentar secara manual
                                                loadComments();
                                            }
                                        });
                                    });
                                
                                    // Fungsi untuk memuat komentar
                                    function loadComments() {
                                        $.ajax({
                                            type: 'GET',
                                            url: '{{ $imgUrl }}/komentars/' + '<?= $data->id_post ?>',
                                            success: function (response) {
                                                var comments = response.data;
                                                $('#komentar-container').empty();
                                
                                                for (var i = 0; i < comments.length; i++) {
                                                    var comment = comments[i];
                                                    var commentHtml = `
                                                        <div class="media-body border p-2 rounded my-1">
                                                            <div class="d-flex justify-content-start align-items-center">
                                                                <div class="me-2">
                                                                    <img loading="lazy src="${comment.idPengunjung.foto}" class="rounded-pill" alt="User Avatar" style="width:40px;">
                                                                </div>
                                                                <div class="">
                                                                    <h6 class="fw-bold">${comment.idPengunjung.nama_pengunjung}</h6>
                                                                    <p style="font-size: 13px;">${comment.komentar}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    `;
                                                    $('#komentar-container').append(commentHtml);
                                                }
                                            }
                                        });
                                    }
                                
                                    // Panggil fungsi memuat komentar saat halaman dimuat
                                    loadComments();
                                    
                                    setInterval(function() {
                                        loadComments();
                                    }, 10000);
                                });

                            </script>


                            {{-- --}}
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- end details -->
            <!-- right -->
            <div class="col-md-4">
                <aside class="sticky-div">
                    <!-- advertisment -->
                    <div class="card border-0 d-none d-lg-block bg-transparent ">

                        <div class="container mt-1">
                            <div id="carousel4x4atas" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                @forelse($kotak as $index => $item)
                                    <div class="carousel-item{{ $index == 0 ? ' active' : '' }}" data-bs-interval="3000">
                                        <a href="{{ $item->link }}" target="_blank">
                                            <img loading="lazy" src="{{ $imgUrl }}/iklans/img/{{ $item->gambar }}" class="d-block w-100 rounded-top" alt="...">
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
                            <p class="p-0 m-0 text-center bg-light rounded-bottom" style="font-size: 10px;">ADVERTISEMENT</p>
                        </div>
                    </div>
                    <!-- end advertisment -->
                    <!-- popular -->
                    <div class="news-top container px-0 bg-white rounded-bottom my-2">
                        <h5 class="card-title fw-semibold text-center bg-creamX p-2 rounded-top"># Berita Terpopuler
                        </h5>
                        <ul class="list-group list-group-flush p-2">
                            @forelse ($data1 as $item)
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
                                        <img loading="lazy" src="{{ $imgUrl }}/posts/img/{{ $item->foto }}" class="rounded thumbnails" alt="{{$item->keterangan_foto}}">
                                    </div>
                                    <div class="col-8 col-lg-7 p-0 ">
                                        @forelse ($item->Kategoris as $kate)
                                        <div class="row ">
                                            <div class="col d-flex justify-content-between align-items-center me-3">

                                                <span class="fw-bolder text-uppercase bad-c py-0 align-items-center">{{$kate->nama_kategori}}</span>

                                                <span class=" align-items-center"><i class="ri-eye-line me-1"></i>{{$item->views}}</span>
                                            </div>
                                        </div>
                                        <a href="/berita/{{$kate->slug}}/{{$item->slug}}" class="mb-0 fw-bolder stretched-link cb link-a" title="{{$item->judul}}">{{$item->judul}}</a>
                                        @empty
                                        @endforelse
                                        <p class="my-0">{{$hasil}}</p>
                                    </div>

                                </div>
                            </li>
                            @empty
                            @endforelse
                        </ul>


                    </div>
                    <!-- end popular -->
                </aside>
            </div>
            <!-- end right -->
        </div>
    </div>
    <div class="d-block d-md-none container bg-warning sticky-bottom d-flex justify-content-center py-3 shadow-lg rounded  my-3 mx-0 " style="z-index: 100;">
                            <div class="a2a_kit a2a_kit_size_32 a2a_default_style d-flex pe-3 align-items-center">
                                <a class="text-dark text-decoration-none me-1">Bagikan</a>
                                <a class="a2a_button_x"></a>
                                <a class="a2a_button_facebook"></a>
                                <a class="a2a_button_whatsapp"></a>
                                <a class="a2a_button_telegram"></a>
                                <a class="a2a_button_copy_link"></a>
                            </div>
                    </div>
</section>
@endsection

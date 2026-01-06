@extends('lay.layout')
@section('title', $data->judul)


@section('content')
@php
use Illuminate\Support\Str;
$jumlahKata = 7;
@endphp
<section class="my-5">
    <div class="container">
        <div class="row">
            <div class="kategori">
                <p class="d-flex align-items-center bg-cream p-1 ps-2 rounded-1"><i class="ri-user-line me-1"></i> Kategori</p>
            </div>
            <div class="col-md-8">
                <div class="card border-0  p-3">
                    <h2 class="text-center fw-bold">{{$data->judul}}</h2>

                    <div class="admin row d-flex justify-content-between align-items-center my-1">
                        <div class="col-7 col-md-4">
                            <div class="row g-2 d-flex align-items-end">
                                <div class="col-3 wrapper">
                                    <img src="{{ asset('img/d.jpg') }}" class="w-100 rounded-circle img2" alt="">
                                </div>
                                <div class="col-9 py-2" style="line-height: 5px;">
                                    <p class="fw-semibold text-warning ">Admin</p>
                                    <p class="fs-13 mb-0">07 Juni 2023 16:03</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-3 ">
                            <p class=" text-center border rounded-1 py-2 mb-0 fs-13"><i class="ri-eye-line me-1"></i>1.2K dilihat</p>
                        </div>
                    </div>
                    <div class="wrapper">
                        <img src="{{ $imgUrl }}/posts/img/{{$data->foto}}" class="w-100 rounded img" alt="">
                        <p class="cb fs-13">{{$data->keterangan_foto}}</p>
                    </div>
                    <div class="content ">
                        <p style="font-size: 18px;">{!! $data->deskripsi !!}</p>
                        <div class="tags">
                            <h5 class="mb-3 fw-semibold">Tags</h5>
                            @forelse ($data->Tags as $t)
                            <span class="btn btn-outline-secondary me-2 rounded-pill">{{$t->nama_tag}}</span>
                            @empty

                            @endforelse
                        </div>
                        <div class="share my-2">
                            <p style="font-size: 13px;">Anda sedang membaca: <span class="fw-semibold">{{$data->judul}}</span></p>
                            <div class="shr">
                                <h5 class="border d-flex align-items-center p-3 justify-content-end rounded-1 ">Share <i class="ri-arrow-right-line"></i> <i class="fs-2 ri-facebook-fill"></i> <i class="fs-2 ri-twitter-fill"></i> <i class="fs-2 ri-whatsapp-fill"></i> <i class="fs-2 ri-telegram-fill"></i></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end details -->
            <!-- right -->
            <div class="col-md-4">
                <aside>
                    <!-- advertisment -->
                    <div class="card border-0">
                        <p class="p-0 m-0 text-center">Advertisment</p>
                        <img src="{{asset('img/ads.jpg')}}" class="w-100 rounded" alt="">
                    </div>
                    <!-- end advertisment -->
                    <!-- popular -->
                    <div class="news-top my-2">
                        <h5 class="card-title fw-semibold">Terpopuler
                        </h5>
                        <ul class="list-group list-group-flush m-0 p-0">
                            @forelse ($data2 as $dt)
                            @php
                            $potonganTeksr = Str::words($dt->judul, $jumlahKata, '...');
                            @endphp
                            <li class="list-group-item px-0">
                                <div class="row fs-12 cb">
                                    <div class="col-5 d-flex align-items-center">
                                        <img src="{{$dt->gambar}}" class="rounded thumbnails" alt="">
                                    </div>
                                    <div class="col-7 p-0 ">
                                        <div class="row ">
                                            <div class="col d-flex justify-content-between align-items-center">
                                                <span class="fw-bolder text-uppercase bad-c py-0 align-items-center">Berita</span>
                                                <span class=" align-items-center"><i class="ri-eye-line me-1"></i>1.2K</span>
                                            </div>
                                        </div>
                                        <a href="{{$dt->url}}" class="mb-0 fw-bolder stretched-link cb link-a" title="{{$dt->judul}}">{{$potonganTeksr}}</a>
                                        <p class="my-0">14 Juni 2023</p>
                                    </div>

                                </div>
                            </li>
                            @empty
                            @endforelse
                        </ul>


                    </div>
                    <!-- end popular -->
                    <!-- advertisment -->
                    <div class="card border-0">
                        <p class="p-0 m-0 text-center">Advertisment</p>
                        <img src="{{asset('img/ads.jpg')}}" class="w-100 rounded mb-2" alt="">
                        <img src="{{asset('img/ads.jpg')}}" class="w-100 rounded" alt="">
                    </div>
                    <!-- end advertisment -->
                </aside>
            </div>
            <!-- end right -->
        </div>
    </div>
</section>
@endsection

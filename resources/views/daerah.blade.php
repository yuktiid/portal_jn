@extends('lay.layout')
@section('title', 'Daerah - Jurnal Nusa')
{{-- meta --}}
@section('meta_title','Jurnal Nusa - Daerah')
@section('meta_keywords', 'jurnal nusa, jurnal nusa, jurnalnusa')
@section('meta_description', 'Jurnalnusa.com -Spectrum positif jurnalism seputar daerah')
@section('meta_type', 'article')
@section('meta_url', url()->current() )
@section('meta_image', asset('Log2.png') )

@section('meta_site_name', 'jurnalnusa.com')
{{-- robot --}}
@section('robots', 'index, follow')
{{-- end --}}
@section('content')
<section>
    <div class="container">
        <div class="card border-0 bg-cream text-light text-center py-3">
            <h2 class="fw-bolder">Suara Network</h2>
            <p class="fs-13 fst-italic">informasi dalam genggaman</p>
        </div>
    </div>
</section>
<style>
    .image-container {
        width: 100%; /* Atur lebar sesuai kebutuhan */
        height: 200px; /* Atur tinggi sesuai kebutuhan */
        overflow: hidden;
    }

    .image-container img {
        object-fit: cover; /* Memastikan gambar terpotong dan sesuai dengan container */
        width: 100%;
        height: 100%;
    }
</style>
<section class="my-3">
    <div class="container">
        <div class="card p-3">
            <div class="row g-3">
                @forelse ($daerah as $item)
                <div class="col-lg-4 ">
                    <div class="card border-0 py-4" style="background-image: url('{{ $imgUrl }}/zonaDaerah/imgzd/{{$item->foto}}'); background-size: cover; background-position: center center;">
                        <p class="fw-bolder text-uppercase text-center text-light fs-4">
                            <a href="/daerahan/{{$item->slug}}" class="link-a text-white p-2">{{$item->nama_wilayah}}</a>
                        </p>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
        <hr>
        {{-- <div class="mt-3 p-2">
            <div class="owl-carousel owl-theme" id="carousel3">
                <div class="card">
                    <div class="item">
                        <div class="image-container">
                            <img src="{{asset('img/bert.jpeg')}}" alt="">
                        </div>
                        <div class="p-2">
                            <a href="#"><span class="badge rounded-pill text-bg-info text-capitalize mb-1">kota batu</span></a>
                            <a href="#"c class="text-decoration-none"><h6 class="text-capitalize fw-bold text-dark">Kebakaran hutan lereng arjuno diduga ada kesengajaan</h6></a>
                            <p class="fw-lighter" style="font-size: 13px;">31/08/2023 - 19:09</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</section>
@endsection

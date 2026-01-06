@extends('lay.layout')
@section('title', 'E-Jurnal - Jurnal Nusa')
{{-- meta --}}
@section('meta_title','Jurnal Nusa - E-Jurnal')
@section('meta_keywords', 'jurnal nusa, jurnal nusa, jurnalnusa, E-jurnal')
@section('meta_description', 'Jurnalnusa.com - Elektronik Jurnal seputar indonesia')
@section('meta_type', 'article')
@section('meta_url', url()->current() )
@section('meta_image', asset('Log2.png') )

@section('meta_site_name', 'jurnalnusa.com')
{{-- robot --}}
@section('robots', 'index, follow')
{{-- end --}}
@section('content')


<section>
    <div class="container" >
        <div class="card border-0 bg-cream text-light text-center py-3">
            <h2 class="fw-bolder">E-Jurnal Network</h2>
            <p class="fs-13 fst-italic">E-Jurnal Nusantara</p>
        </div>
    </div>
</section>
<section class="my-3">
    <div class="container">
        <div class="card p-3">
            <div class="row g-4">
                @forelse ($data as $d)

                <div class="col-lg-4 ">
                    <div class="card text-center rounded-1 p-1" style="background-color: #343A40">
                        <img src="{{$link}}{{ $d->gambar }}" class="card-img-top w-100" alt="...">

                        <div class="card-body" style="background-color: #343A40">
                            <a href="{{ route('e-jurnal.detail', ['id'=>$d->slug]) }}" class="stretched-link text-light link-a" style="font-size: 14px">{{ $d->judul }}</a>

                            <p class="text-light"></p>
                        </div>
                      </div>
                </div>
                @empty

                @endforelse

            </div>
        </div>
    </div>
</section>
@endsection

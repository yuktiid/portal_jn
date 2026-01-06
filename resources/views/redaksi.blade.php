@extends('lay.layout')

@section('title', 'Informasi')

{{-- meta --}}

{{-- robot --}}
@section('robots', 'index, follow')
{{-- end --}}

@section('content')
@php
use Carbon\Carbon;
        use Carbon\CarbonInterface;
        
@endphp

<div class="container mt-4">
    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        @foreach($data as $item)
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab{{$item->id_page}}-tab" data-bs-toggle="tab" href="#tab{{$item->id_page}}" role="tab" aria-controls="tab{{$item->id_page}}" aria-selected="{{ $item->id_page == $data[0]->id_page ? 'true' : 'false' }}">{{$item->judul}}</a>
        </li>
        @endforeach
    </ul>
    <div class="tab-content mt-3" id="myTabsContent">
        @foreach($data as $item)
        <div class="tab-pane fade" id="tab{{$item->id_page}}" role="tabpanel" aria-labelledby="tab{{$item->id_page}}-tab">
            <!-- Konten untuk setiap tab -->
            <p class="fs-14 fw-medium">{!! $item->deskripsi !!}</p>
        </div>
        @endforeach
    </div>
</div>

<script>
    $(document).ready(function() {
        // Ambil hash dari URL
        var hash = window.location.hash;

        // Periksa apakah hash sesuai dengan ID tab
        if (hash && $(hash).length) {
            // Aktifkan tab sesuai dengan hash
            $('a[href="' + hash + '"]').tab('show');
        }
    });
</script>



@endsection

@extends('lay.layout')
@section('title', $data->slug)

@section('content')
@php

use Carbon\Carbon;
use Carbon\CarbonInterface;

use Illuminate\Support\Str;
$jumlahKata = 150;

@endphp
<section class="my-3 d-flex justify-content-center">
    <div class="container">

        <div class="row d-flex justify-content-center">
            <!-- left -->
            <div class="col-md-12">

                <!-- news new 1-->
                <div class="news-new-1">
                    <div class="row post-detail gy-3">
                    
                    @forelse ($data->Posts as $item)
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
                        @forelse($item->Kategoris as $kate)
                    <div class="col-12 col-md-4">
                        <div class="post mb-4">
                            <div class="card border-0 bg-light p-0">
                                <span class="badge text-bg-info position-absolute rounded-0 mt-3 px-2 d-none d-md-inline">{{$kate->nama_kategori}}</span>
                                <div class=" wrapper card-header border-0 rounded-top bg-transparent p-0 pb-1">
                                    <img src="{{ $imgUrl }}/posts/img/{{$item->foto}}" class="rounded-1 w-100" style="height: 200px; object-fit: cover;" alt="{{$item->judul}}">
                                </div>
                                <div class="ps-3 bg-light">
                                    <a href="/berita/{{$kate->slug}}/{{$item->slug}}" class="cb link-a fw-bolder fs-6 fw-bolder" title="{{$item->judul}}">{{$item->judul}}</a>

                                </div>
                                <div class="card-body">
                                    {{-- <p class="fs-13 cb">{!! Str::limit($item->deskripsi, $jumlahKata) !!}</p> --}}
                                    @php
                                        $deskripsi = $item->deskripsi;
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
                                </div
                                </div>
                            </div>
                        </div>
                        

                    </div>@empty
            
                        @endforelse
                    @empty
        
                    @endforelse
                </div>
                <!-- end news new 1-->

            </div>
        </div>
    </div>
</section>

@endsection

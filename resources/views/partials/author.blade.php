@php
use Carbon\Carbon;
use Carbon\CarbonInterface;

use Illuminate\Support\Str;
$jumlahKata = 150;
@endphp
<div class="col-12 col-md-12 post-a">

    @forelse ($posts as $item)
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
            <div class="col-4 col-lg-4 d-flex align-items-center">
                <img src="{{ $imgUrl }}/posts/img/{{ $item->foto }}" class="rounded thumbnails border" alt="{{ $item->keterangan_foto }}">
            </div>
            <div class="col-8 col-lg-8 p-0 ">
                <div class="col-12 col-lg-12 p-0">
                    <div class="d-flex flex-column terbaru">
                        <!-- Judul Berita -->
                        @forelse ($item->Kategoris as $katt)
                        <a href="/berita/{{$katt->slug}}/{{ $item->slug }}" class="mb-2 cb link-a fs-14 fw-bold" title="{{ $item->judul }}">{{ $item->judul }}</a>

                        <!-- Informasi Tambahan -->
                        <div class="mt-0">
                            <div class="col d-flex fs-12 mb-0">
                                <p class="fw-bold tex-c">{{$katt->nama_kategori}}</p>

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

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Gunakan style bootstrap untuk pagination
        Paginator::useBootstrap();

        // 1. Share URL Config ke semua view
        // Pastikan di .env atau config/services.php sudah ada setting jurnalnusa
        $imgUrl = config('services.jurnalnusa.base_url');
        View::share('imgUrl', $imgUrl);

        // 2. VIEW COMPOSER
        // Mengirim data ke SEMUA view ('*')
        View::composer('*', function ($view) {
            
            // CACHING: Simpan data selama 1 jam (3600 detik).
            // Key cache diganti ke 'layout_data_final' untuk memastikan data fresh.
            $data = Cache::remember('layout_data_final', 3600, function () {
                try {
                    // TIMEOUT: Saya naikkan jadi 10 detik.
                    // Jika koneksi lambat, dia akan menunggu maks 10 detik.
                    // Jika lebih dari 10 detik, baru dia menyerah (return null) agar web tidak hang.
                    $response = Http::timeout(10) 
                                    ->get('https://pro1v1jn.jurnalnusa.com/jurnal/navbar');

                    // Jika status 200 OK, ambil datanya.
                    return $response->successful() ? $response->object() : null;
                    
                } catch (\Exception $e) {
                    // Jika gagal total, catat error di log tapi jangan matikan web.
                    Log::error('API Error (AppServiceProvider): ' . $e->getMessage());
                    return null;
                }
            });

            // --- DATA HANDLING (PENCEGAHAN ERROR) ---
            
            // 1. Handle Kategori & Navbar
            // Pakai Null Coalescing Operator (??) untuk set nilai default array kosong
            $rawKategori = $data->kategori ?? [];
            $navatas     = $data->navbar ?? [];
            $footbawah   = $data->footer ?? [];
            
            // 2. Handle Iklan
            // Buat object dummy default agar tidak error saat dipanggil di view
            $defaultIklan = (object) [
                'link' => '#', 
                'gambar' => 'default.jpg' // Pastikan gambar ini ada atau biarkan saja (broken image lebih baik daripada crash)
            ];

            $iklanTKa = $data->iklanTinggiKanan ?? $defaultIklan;
            $iklanTKi = $data->iklanTinggiKiri ?? $defaultIklan;
            $iklanP   = $data->iklanPanjang   ?? $defaultIklan;

            // 3. Logic Filtering (Logika Bisnis)
            
            // Ambil Peristiwa Daerah
            $peristiwaDaerah = collect($rawKategori)
                ->where('nama_kategori', 'Peristiwa Daerah')
                ->toArray();
                
            // Ambil Peristiwa Internasional
            $peristiwaInternasional = collect($rawKategori)
                ->where('nama_kategori', 'Peristiwa Internasional')
                ->toArray();
            
            // Filter Menu Utama (Kecualikan Daerah & Internasional)
            $mainArray = collect($rawKategori)->reject(function ($item) {
                // Cek apakah property nama_kategori ada, lalu cek isinya
                return isset($item->nama_kategori) && in_array($item->nama_kategori, ['Peristiwa Daerah', 'Peristiwa Internasional']);
            })->toArray();

            // 4. Kirim variabel ke View
            $view->with([
                'navatas'                   => $navatas,
                'footbawah'                 => $footbawah,
                'iklanTKa'                  => $iklanTKa,
                'iklanTKi'                  => $iklanTKi,
                'iklanP'                    => $iklanP,
                'mainArray'                 => $mainArray,
                'peristiwaDaerahArray'      => $peristiwaDaerah,
                'peristiwaInternasionalArray' => $peristiwaInternasional
            ]);
        });
    }
}
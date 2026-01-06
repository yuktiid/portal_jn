<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils; // Pastikan baris ini ada (Bawaan Laravel 8)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    /**
     * Konfigurasi Client Terpusat
     * verify => false adalah kunci mengatasi Error cURL 35
     */
    private function getClient()
    {
        return new Client([
            'base_uri' => config('services.jurnalnusa.base_url'), 
            'timeout'  => 30,    // Waktu tunggu maksimal 30 detik
            'http_errors' => false,
            'verify' => false,   // PENTING: Bypass SSL agar tidak error handshake
        ]);
    }

    /**
     * FUNGSI PENGHEMAT WAKTU (Shared Data)
     * Mengambil Iklan & Populer sekali saja setiap 15 menit.
     * Disimpan di Cache agar halaman lain tidak perlu request ulang ke API.
     */
    private function getSidebarData()
    {
        // Cache selama 900 detik (15 menit)
        return Cache::remember('global_sidebar_data', 900, function () { 
            $client = $this->getClient();
            
            // Menggunakan Async untuk mengambil data Iklan & Posts secara bersamaan (Paralel)
            $promises = [
                'iklan' => $client->getAsync('jurnal/iklanKotak'),
                'posts' => $client->getAsync('jurnal/posts'),
            ];

            try {
                // Tunggu kedua request selesai
                $responses = Utils::unwrap($promises);
                
                $dataIklan = json_decode($responses['iklan']->getBody()->getContents());
                $allPosts  = json_decode($responses['posts']->getBody()->getContents());

                // Filter 5 berita populer
                $populer = collect($allPosts)->sortByDesc('views')->take(5);

                return [
                    'kotak'   => $dataIklan->iklanKotak ?? null,
                    'panjang' => $dataIklan->iklanPanjang ?? null,
                    'tengah'  => $dataIklan->iklanPanjangTengah ?? null,
                    'populer' => $populer
                ];
            } catch (\Exception $e) {
                // Jika error, catat di log dan kembalikan array kosong agar web tetap jalan
                Log::error("Gagal load Sidebar: " . $e->getMessage());
                return [
                    'kotak' => null, 'panjang' => null, 'tengah' => null, 'populer' => []
                ];
            }
        });
    }

    public function index()
    {
        // Cache halaman utama selama 5 menit (300 detik)
        $data = Cache::remember('home_page_full', 300, function () {
            $client = $this->getClient();

            // Request Paralel: Menembak 3 API sekaligus (hemat waktu 50-70%)
            $promises = [
                'iklan' => $client->getAsync('jurnal/iklanKotak'),
                'koran' => $client->getAsync('ekorans'),
                'posts' => $client->getAsync('jurnal/posts'),
            ];

            try {
                $responses = Utils::unwrap($promises);

                $dataIklan = json_decode($responses['iklan']->getBody()->getContents());
                $koran     = json_decode($responses['koran']->getBody()->getContents());
                $posts     = json_decode($responses['posts']->getBody()->getContents());

                return [
                    'iklan' => $dataIklan,
                    'koran' => $koran,
                    'posts' => $posts
                ];

            } catch (\Exception $e) {
                Log::error("Gagal load Index Async: " . $e->getMessage());
                return null;
            }
        });

        // Jika API mati total & cache kosong
        if (!$data) {
            return abort(500, 'Mohon maaf, server berita sedang sibuk.');
        }

        // Unpack Data
        $posts = $data['posts'];
        $dataIklan = $data['iklan'];
        $koran = $data['koran'];

        // Manipulasi Data (Menggunakan Collection Laravel)
        $collection = collect($posts);
        
        return view('index', [
            'data5'       => $collection->shuffle()->take(4),
            'data1'       => $collection->shuffle()->first(),
            'data2'       => $collection->shuffle()->take(4),
            'berita'      => $collection->take(6),
            'gambarArray' => $koran,
            'kotak'       => $dataIklan->iklanKotak ?? null,
            'panjang'     => $dataIklan->iklanPanjang ?? null,
            'tengah'      => $dataIklan->iklanPanjangTengah ?? null,
            'view'        => $collection->sortByDesc('views')->take(5), // Populer
            'acak'        => $collection->shuffle()->take(4),
            'acak1'       => $collection->shuffle()->take(4)
        ]);
    }

    public function readmore($kategori, $url)
    {
        $client = $this->getClient();

        try {
            // 1. Ambil Sidebar dari Cache (SANGAT CEPAT)
            $sidebar = $this->getSidebarData();

            // 2. Request Detail Berita (Satu-satunya request ke API)
            $response = $client->get('jurnal/detail/'.$kategori.'/'.$url);
            $dataDetail = json_decode($response->getBody()->getContents());
            
            if (isset($dataDetail->message) && $dataDetail->message === "Berita tidak ditemukan") {
                return abort(404);
            }

            $contentBerita = $dataDetail->send;
            $bacaJuga = $dataDetail->bacaJuga2;
            $randomPost = collect($bacaJuga->Posts ?? [])->random();

            return view('readmore', [
                'data'    => $contentBerita, 
                'baca'    => $randomPost, 
                // Data Sidebar dari Cache
                'data1'   => $sidebar['populer'] ?? [], 
                'kotak'   => $sidebar['kotak'] ?? null, 
                'panjang' => $sidebar['panjang'] ?? null, 
                'tengah'  => $sidebar['tengah'] ?? null
            ]);

        } catch (\Exception $e) {
            return response()->view('404', ['error' => $e->getMessage()]);
        }
    }

    public function detail($kategorislug)
    {
        $client = $this->getClient();

        try {
            // 1. Ambil Sidebar dari Cache
            $sidebar = $this->getSidebarData();

            // 2. Ambil Kategori dari API
            $response = $client->get('posts/kategori/'.$kategorislug);
            $dataKategori = json_decode($response->getBody()->getContents());
            
            $collection = collect($dataKategori->Posts ?? []);
            
            if ($collection->isEmpty()) {
                return view('404');
            }

            return view('detail2', [
                'data'    => $collection->sortByDesc('createdAt')->take(2),
                'kate'    => $dataKategori, 
                // Data Sidebar dari Cache
                'kotak'   => $sidebar['kotak'] ?? null,
                'panjang' => $sidebar['panjang'] ?? null,
                'tengah'  => $sidebar['tengah'] ?? null,
                'view'    => $sidebar['populer'] ?? []
            ]);

        } catch (\Exception $e) {
            return view('404');
        }
    }

    public function getwilayah($wilayah_slug)
    {
        $client = $this->getClient();
        
        try {
            // 1. Ambil Sidebar dari Cache
            $sidebar = $this->getSidebarData();

            // 2. Ambil Wilayah dari API
            $response = $client->get('jurnal/daerah/'.$wilayah_slug);
            $dataWilayah = json_decode($response->getBody()->getContents());
            
            if (isset($dataWilayah->message) && $dataWilayah->message === "Kategori Tidak ditemukan") {
                return view('404');
            }

            $des = collect($dataWilayah->posts ?? [])->sortByDesc('createdAt')->take(6);
            
            return view('detailwilayah', [
                'data'    => $des, 
                'nam'     => $dataWilayah,
                // Data Sidebar dari Cache
                'kotak'   => $sidebar['kotak'] ?? null,
                'panjang' => $sidebar['panjang'] ?? null,
                'tengah'  => $sidebar['tengah'] ?? null,
                'view'    => $sidebar['populer'] ?? []
            ]);
        } catch (\Exception $e) {
            return view('404');
        }
    }
    
    // --- FUNGSI STANDAR LAINNYA ---
    
    public function search(Request $request) 
    {
        $client = $this->getClient();
        try {
            $response = $client->get('jurnal/search?keyword='.$request->keyword);
            $data = json_decode($response->getBody()->getContents());
            return view('search', ['data'=> $data]);
        } catch (\Exception $e) { return view('404'); }
    }
    
    public function tag($slug_tag) 
    {
        $client = $this->getClient();
        try {
            $response = $client->get('jurnal/tags/'.$slug_tag);
            $responsebody = json_decode($response->getBody()->getContents());
            return view('tag', ['data'=> $responsebody->data ?? []]);
        } catch (\Exception $e) { return view('404'); }
    }

    public function loadMorePosts(Request $request)
    {
        $client = $this->getClient();
        $response = $client->get('jurnal/posts');
        $data = json_decode($response->getBody()->getContents());
        $collection = collect($data)->slice($request->input('offset'), $request->input('limit'));
        return view('partials.post', ['posts'=> $collection]);
    }
    
    public function loadMoreDetail(Request $request)
    {
        $client = $this->getClient();
        $response = $client->get('posts/kategori/'.$request->input('data'));
        $data = json_decode($response->getBody()->getContents());
        $collection = collect($data->Posts)->sortByDesc('createdAt')->slice($request->input('offset'), $request->input('limit'));
        return view('partials.detail2', ['data' => $collection, 'kate' => $data]);
    }

    public function daerah() {
        $client = $this->getClient();
        $response = $client->get('jurnal/daerah');
        return view('daerah', ['daerah'=>json_decode($response->getBody()->getContents())->data]);
    }
    
    public function loadMoreDaerah(Request $request) {
        $client = $this->getClient();
        $response = $client->get('jurnal/daerah/'.$request->input('data'));
        $data = json_decode($response->getBody()->getContents());
        return view('partials.detail1', ['data' => collect($data->posts)->sortByDesc('createdAt')->slice($request->input('offset'), $request->input('limit')), 'kate' => $data]);
    }

    public function koran() {
        $client = $this->getClient();
        $data = json_decode($client->get('ekorans')->getBody()->getContents());
        return view('e-koran', ['data'=>$data->data, 'link'=>$data->link]);
    }

    public function dkoran(Request $request, $id) {
        try {
            $data = json_decode($this->getClient()->get('ekorans/' . $id)->getBody()->getContents());
            return view('dkoran', ['koran' => $data->data, 'link' => $data->link, 'imgadmin'=>$data->IMGADMIN]);
        } catch (\Exception $e) { return view('404'); }
    }
    
    public function author($email) {
        $client = $this->getClient();
        // Gunakan Cache Sidebar di sini juga
        $sidebar = $this->getSidebarData(); 
        
        try {
            $dataAuthor = json_decode($client->get('jurnal/author/'.$email)->getBody()->getContents());
            return view('profile', [
                'iklan'=> (object)['iklanKotak' => $sidebar['kotak'], 'iklanPanjang' => $sidebar['panjang']], 
                'populer'=>$sidebar['populer'], 
                'berita'=> collect($dataAuthor->data->posts ?? [])->take(2), 
                'data'=> $dataAuthor->data, 
                'linkP'=>$dataAuthor->IMGPOST, 
                'linkA'=> $dataAuthor->IMGADMIN 
            ]);
        } catch (\Exception $e) { return view('404'); }
    }
    
    public function loadMoreAuthor(Request $request) {
        $client = $this->getClient();
        $data = json_decode($client->get('jurnal/author/'. $request->input('data'))->getBody()->getContents());
        return view('partials.author', [ 'posts' => collect($data->data->posts)->slice($request->input('offset'), $request->input('limit')), 'linkP' => $data->IMGPOST]);
    }
    
    public function informasi(Request $request) {
        $client = $this->getClient();
        $data = json_decode($client->get('jurnal/navbar')->getBody()->getContents());
        return view('redaksi', ['data'=> $data->footer ?? null, 'id_page' => $request->query('tab')]);
    }
}
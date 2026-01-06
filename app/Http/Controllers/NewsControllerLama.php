<?php

namespace App\Http\Controllers;


use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private function getClient()
    {
        return new Client([
            'base_uri' => config('services.jurnalnusa.base_url'), 
            'timeout'  => 30,    // Waktu tunggu maksimal 30 detik
            'http_errors' => false,
            'verify' => false,   // PENTING: Bypass SSL agar tidak error handshake
        ]);
    }
     public function informasi (Request $request)
    {
        $id_page = $request->query('tab');
        
        $client = $this->getClient();
        $response = $client->get('jurnal/navbar');
        $responsebody = $response->getBody()->getContents();
        $data = json_decode($responsebody);
        $data = $data->footer;
            return view('redaksi', ['data'=> $data, 'id_page' => $id_page]);
    }
    
    public function search(Request $request) {
        $keyword = $request->keyword;
        $client = $this->getClient();
        $response = $client->get('jurnal/search?keyword='.$keyword);
        $responsebody = $response->getBody()->getContents();
        $data = json_decode($responsebody);
        // dd($data);
        return view('search', ['data'=> $data]);
    }
    
    public function tag($slug_tag) {
        $keyword = $slug_tag;
        // dd($keyword);
        $client = $this->getClient();
        $response = $client->get('jurnal/tags/'.$keyword);
        $responsebody =  json_decode($response->getBody()->getContents());
        $data = $responsebody->data;
        // dd($data);
        return view('tag', ['data'=> $data]);
    }
    
    public function index()
    {
        $client2 = $this->getClient();
        $response2 = $client2->get('jurnal/iklanKotak');
        $responseBody2 = $response2->getBody()->getContents();
        $data2 = json_decode($responseBody2);
        $kotak = $data2->iklanKotak;
        $panjang = $data2->iklanPanjang;
        $tengah = $data2->iklanPanjangTengah;
        // 
        $client1 = $this->getClient();
        $response1 = $client1->get('jurnal/ekorans');
        $responseBody1 = $response1->getBody()->getContents();
        $koran = json_decode($responseBody1);
        //
        $client = $this->getClient();
        $response = $client->get('jurnal/posts');
        $responsebody = $response->getBody()->getContents();
        $data = json_decode($responsebody);

        $collection = collect($data);

        $collection6 = collect($data)->take(6);

        $collection4 = collect($data)->take(4);
        
        // populer
        $sorted = $collection->sortByDesc('views');
        $view = $sorted->take(5);
        
        // acak
        $acak = $collection->shuffle()->take(4);
        $acak1 = $collection->shuffle()->take(4);
        $acak2 = $collection->shuffle()->take(4);
        

        // first berita sendiri
        $sortedCollection = $collection->shuffle();
        $data1 = $sortedCollection->first(); // Mengambil data paling terbaru
        $data2 = $collection->shuffle()->take(4); // Mengambil dua data baru setelah data paling terbaru
        
        // end berita sendiri

        return view('index', [
            'data5' => $collection4,
            'data1' => $data1,
            'data2' => $data2,
            'berita' => $collection6,
            'gambarArray' => $koran,
            'kotak'=> $kotak,
            'panjang' => $panjang,
            'tengah' => $tengah,
            'view' => $view,
            'acak' => $acak,
            'acak1' => $acak1,
            'acak2' => $acak2
        ]);

    }

    public function loadMorePosts(Request $request)
    {
        $offset = $request->input('offset');
        $limit = $request->input('limit');

        $client = $this->getClient();
        $response = $client->get('jurnal/posts');
        $responseBody = $response->getBody()->getContents();
        $data = json_decode($responseBody);
        $collection = collect($data)->slice($offset, $limit);

        return view('partials.post', ['posts'=> $collection]);
    }

    // kategori coba

    public function readmore($kategori, $url)
    {
        try {
            // Membuat instance Guzzle HTTP client untuk permintaan pertama
            $client1 = $this->getClient();
            $response1 = $client1->get('jurnal/posts');
            $responsebody1 = $response1->getBody()->getContents();
            $data1 = json_decode($responsebody1);
            

            // Membuat instance Guzzle HTTP client untuk permintaan kedua
            $client2 = $this->getClient();
            $response2 = $client2->get('jurnal/detail/'.$kategori.'/'.$url);
            $responsebody2 = $response2->getBody()->getContents();
            $data2 = json_decode($responsebody2);
            $data4 = $data2->send;
            $data5 = $data2->bacaJuga2;
            $randomPost = collect($data5->Posts)->random();
            
            // 
            $client3 = $this->getClient();
            $response3 = $client3->get('jurnal/iklanKotak');
            $responseBody3 = $response3->getBody()->getContents();
            $data3 = json_decode($responseBody3);
        
            $kotak = $data3->iklanKotak;
            $panjang = $data3->iklanPanjang;
            $tengah = $data3->iklanPanjangTengah;
            
            
            // Periksa pesan dari API pada kedua permintaan
            if (
                (isset($data1->message) && $data1->message === "Berita tidak ditemukan") ||
                (isset($data2->message) && $data2->message === "Berita tidak ditemukan")
            ) {
                // Jika salah satu permintaan memiliki pesan "Berita tidak ditemukan," kembalikan halaman 404
                return abort(404);
            }
            

            // Menggunakan data dari permintaan pertama
            $collection2 = collect($data1)->sortByDesc('views')->take(5);

            return view('readmore', ['data' => $data4, 'baca' => $randomPost, 'data1' => $collection2, 'kotak' => $kotak, 'panjang' => $panjang, 'tengah' => $tengah]);
        } catch (RequestException $e) {
            // Handle kesalahan permintaan HTTP
            $errorMessage = $e->getMessage();

            // Atur kode status HTTP 500 (Internal Server Error) atau sesuai kebutuhan
            // $statusCode = 500;

            // Mengembalikan tampilan error dengan pesan kesalahan dan kode status
            return response()->view('404', ['error' => $errorMessage]);
        } catch (\Exception $e) {
            // Handle kesalahan umum
            $errorMessage = $e->getMessage();

            // Atur kode status HTTP 500 (Internal Server Error) atau sesuai kebutuhan
            // $statusCode = 500;

            // Mengembalikan tampilan error dengan pesan kesalahan dan kode status
            return response()->view('404', ['error' => $errorMessage]);
        }
    }



    // end kategori

    // detail
    public function detail($kategorislug)
    {
        $kategorislug = $kategorislug; // katgeoi yang Anda cari

        $client = $this->getClient();
        $apiUrl = 'posts/kategori/';

        try {
            $response = $client->get($apiUrl.$kategorislug);

            $responseBody = $response->getBody()->getContents();
            $data = json_decode($responseBody);
            $collection = collect($data->Posts);
            $sorted = $collection->sortByDesc('createdAt');
            $collection6 = collect($sorted)->take(2);
            
            // 
            $client2 = $this->getClient();
            $response2 = $client2->get('jurnal/iklanKotak');
            $responseBody2 = $response2->getBody()->getContents();
            $data2 = json_decode($responseBody2);
            $kotak = $data2->iklanKotak;
            $panjang = $data2->iklanPanjang;
            $tengah = $data2->iklanPanjangTengah;
            
            // 
            $client3 = $this->getClient();
            $response3 = $client3->get('jurnal/posts');
            $responsebody3 = $response3->getBody()->getContents();
            $pop = json_decode($responsebody3);
            $collection = collect($pop);
            $sorted = $collection->sortByDesc('views');
            $view = $sorted->take(4);
            // 

            // Periksa pesan dari API
            if ($collection6 === null || empty($collection6)) {
                return view('404');
            }

            // Jika tidak ada pesan "Berita tidak ditemukan" atau pesan tidak ada, lanjutkan
            
            return view('detail2', [
                'data' => $collection6,
                'kate' => $data, 
                'kotak'=> $kotak,
                'panjang' => $panjang,
                'tengah' => $tengah,
                'view' => $view
                ]);
        } catch (\Exception $e) {
            // Handle kesalahan jika terjadi
            return view('404');
        }
    }



    public function loadMoreDetail(Request $request)
    {
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $slug = $request->input('data');
        
        $client = $this->getClient();
        $response = $client->get('posts/kategori/'.$slug);
        $responseBody = $response->getBody()->getContents();
        $data = json_decode($responseBody);
        
        $collection = collect($data->Posts)->sortByDesc('createdAt')->slice($offset, $limit);
        return view('partials.detail2', ['data' => $collection, 'kate' => $data]);
    }
    // end detail


    // daerah
    function daerah()
    {
        $client = $this->getClient();
        $response = $client->get('jurnal/daerah');
        $responsebody =  json_decode($response->getBody()->getContents());
        $data =$responsebody->data;
        return view('daerah', ['daerah'=>$data]);
    }
    // end daerah
    // e-koran
    function koran()
    {
        $client = $this->getClient();
        $response = $client->get('ekorans');
        $responseBody = $response->getBody()->getContents();
        $data = json_decode($responseBody);

        return view('e-koran', ['data'=>$data->data, 'link'=>$data->link]);

    }
    public function dkoran(Request $request, $id)
    {
        try {
            $client = $this->getClient();
            $response = $client->get('ekorans/' . $id);
            $responseBody = $response->getBody()->getContents();
            $data = json_decode($responseBody);
            // dd($data);

            return view('dkoran', ['koran' => $data->data, 'link' => $data->link, 'imgadmin'=>$data->IMGADMIN]);
        } catch (RequestException $e) {
            // Tangani pengecualian jika terjadi kesalahan dalam permintaan HTTP
            // Misalnya, jika tidak dapat terhubung ke server atau ada kesalahan lain
            return view('404'); // Gantilah dengan halaman kesalahan yang sesuai
        } catch (\Exception $e) {
            // Tangani pengecualian lainnya di sini
            return view('404'); // Gantilah dengan halaman kesalahan yang sesuai
        }
    }


    // end e-koran


    //
    public function getwilayah($wilayah_slug)
    {
    $wilayah = $wilayah_slug; // Wilayah yang Anda cari

    $client = $this->getClient();
    $apiUrl = 'jurnal/daerah/';

        try {
            $response = $client->get($apiUrl.$wilayah);

            $responseBody = $response->getBody()->getContents();
            $data = json_decode($responseBody);
            $collection = collect($data->posts);
            $sorted = $collection->sortByDesc('createdAt');
            $des = $sorted->take(6);
            // dd($data);
            // 
            $client2 = $this->getClient();
            $response2 = $client2->get('jurnal/iklanKotak');
            $responseBody2 = $response2->getBody()->getContents();
            $data2 = json_decode($responseBody2);
            $kotak = $data2->iklanKotak;
            $panjang = $data2->iklanPanjang;
            $tengah = $data2->iklanPanjangTengah;
            
            // 
            $client3 = $this->getClient();
            $response3 = $client3->get('jurnal/posts');
            $responsebody3 = $response3->getBody()->getContents();
            $pop = json_decode($responsebody3);
            $collection = collect($pop);
            $sorted = $collection->sortByDesc('views');
            $view = $sorted->take(4);
            // 

            // Periksa pesan dari API
            if (isset($data->message) && $data->message === "Kategori Tidak ditemukan") {
                // Jika pesan adalah "Berita tidak ditemukan," kembalikan halaman 404
                return view('404');
            }

            // Jika tidak ada pesan "Berita tidak ditemukan" atau pesan tidak ada, lanjutkan
            return view('detailwilayah', [
                'data' => $des, 
                'nam' => $data,
                'kotak'=> $kotak,
                'panjang' => $panjang,
                'tengah' => $tengah,
                'view' => $view]);
        } catch (\Exception $e) {
            // Handle kesalahan jika terjadi
            return view('404');
        }
    }

function author($email) {
        $client2 = $this->getClient();
        $response2 = $client2->get('jurnal/iklanKotak');
        $responseBody2 = $response2->getBody()->getContents();
        $iklan = json_decode($responseBody2);

        $client = $this->getClient();
        $response = $client->get('jurnal/posts');
        $responsebody = $response->getBody()->getContents();
        $data = json_decode($responsebody);
        // dd($data);
        $collection1 = collect($data);
        $sortedData = $collection1->sortByDesc('views');
        $populer = $sortedData->take(4);

        $resA = $client->get('jurnal/author/'.$email);
        $resB = json_decode($resA->getBody()->getContents());
        $colec = collect($resB->data->posts)->take(2);
        // dd($colec);
        return view('profile', ['iklan'=> $iklan, 'populer'=>$populer, 'berita'=> $colec, 'data'=> $resB->data, 'linkP'=>$resB->IMGPOST, 'linkA'=> $resB->IMGADMIN ]);
    }

    function loadMoreAuthor(Request $request){
        $offset = $request->input('offset');
        $limit = $request->input('limit');
        $email = $request->input('data');
        $client = $this->getClient();
        $resA = $client->get('jurnal/author/'. $email);
        $resB = json_decode($resA->getBody()->getContents());
        $colec = collect($resB->data->posts)->slice($offset, $limit);
        return view('partials.author', [ 'posts' => $colec,'linkP' => $resB->IMGPOST]);
    }

}
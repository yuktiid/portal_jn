<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class inputController extends Controller
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

    function data($email)
    {
        $client = $this->getClient();
        $response= $client->get('jurnal/pengunjung/'.$email);
        // $response = $client->get('https://pro1v1jn.jurnalnusa.com/jurnal/pengunjung/'.$email);
        $data = json_decode($response->getBody()->getContents());
        return view('guest.data', ['publis' => $data->publis, 'pending' => $data->pending, 'tolak' => $data->tolak, 'link' => $data->IMGPOST]);
    }

    function addNews()
    {
        $client = $this->getClient();
        $response = $client->get('kategoris');
        $kategori = json_decode($response->getBody()->getContents(), true);

        $response3 = $client->get('zonaDaerah');
        $zona = json_decode($response3->getBody()->getContents(), true);

        $response2 = $client->get('tags');
        $tags = json_decode($response2->getBody()->getContents(), true);
        // dd($kategori, $zona, $tags);
        return view('guest.add-news', ['kategori' => $kategori, 'zona' => $zona["data"], 'tags' => $tags]);
    }
    function updateNews($slug)
    {
        $client = $this->getClient();
        $user = session('user');
        $rd = $client->get('jurnal/pengunjung/'.$user->id_pengunjung.'/' . $slug);
        $data = json_decode($rd->getBody()->getContents());

        $response = $client->get('kategoris');
        $kategori = json_decode($response->getBody()->getContents(), true);

        $response3 = $client->get('zonaDaerah');
        $zona = json_decode($response3->getBody()->getContents(), true);

        $response2 = $client->get('tags');
        $tags = json_decode($response2->getBody()->getContents(), true);
        return view('guest.update-news', ['data' => $data->data, 'link' => $data->IMGPOST, 'kategori' => $kategori, 'zona' => $zona["data"], 'tags' => $tags]);
    }

    function send(Request $request)
    {
        $judul = $request->judul;
        $slug = Str::slug($judul, '-');
        $file = $request->file('foto');
        $id_kategori = json_encode($request->id_kategori);
        if ($id_kategori == 'null') {
            Session::flash('info', "Kategori tidak boleh kosong!");
            return redirect()->back();
        }
        $tags = explode(",", $request->tags);
        $tags = array_map('trim', $tags);
         $tags = array_filter($tags, function($tag) {
            return $tag !== '';
        });
        $tag = json_encode($tags);
        $user = session('user');
        $data = [
            [
                'name' => 'id_pengunjung',
                'contents' => $user->id_pengunjung,
            ],
            [
                'name' => 'id_wilayah',
                'contents' => $request->id_wilayah,
            ],
            [
                'name' => 'judul',
                'contents' => $judul,
            ],
            [
                'name' => 'slug',
                'contents' => $slug,
            ],
            [
                'name' => 'deskripsi',
                'contents' => $request->deskripsi,
            ],
            [
                'name' => 'foto',
                'contents' => fopen($file->getRealPath(), 'r'),
                'filename' => $file->getClientOriginalName(),
            ],
            [
                'name' => 'keterangan_foto',
                'contents' => $request->keterangan_foto,
            ],
            [
                'name' => 'id_kategori', // Tambahkan id_kategori ke data
                'contents' => $id_kategori,
            ],
            [
                'name' => 'tags', // Tambahkan tags ke data
                'contents' => $tag,
            ]
        ];
        // dd($data);
        $client = $this->getClient();

        try {
            $token = session('jwt_token');

            $response = $client->post('posts/add-from-peng', [
                'multipart' => $data,
                'headers' => [
                    'Authorization' => $token,
                    'Accept' => 'application/json',
                ],
            ]);
            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody()->getContents(), true);
            // dd($responseData);
            $message = $responseData["message"];

            if ($statusCode === 201) {
                Session::flash('success', $message);
            } else {
                Session::flash('info', $message);
                return redirect()->route('dashboard',['email'=> $user->email]);
            }
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
        }
        return redirect()->route('dashboard',['email'=> $user->email]);
    }

    function PupdateNews(Request $request, $id)
    {
        $user = session('user');
        $judul = $request->judul;
        $slug = Str::slug($judul, '-');
        $file = $request->file('foto');
        $id_kategori = json_encode($request->id_kategori);
        if ($id_kategori == 'null') {
            Session::flash('info', "Kategori tidak boleh kosong!");
            return redirect()->route('dashboard');
        }
        $tags = explode(",", $request->tags);
        $tags = array_map('trim', $tags);
        $tags = array_filter($tags, function($tag) {
            return $tag !== '';
        });
        $tag = json_encode($tags);
        if ($file) {
            $data = [
                [
                    'name' => 'id_pengunjung',
                    'contents' => $user->id_pengunjung,
                ],
                [
                    'name' => 'id_wilayah',
                    'contents' => $request->id_wilayah,
                ],
                [
                    'name' => 'judul',
                    'contents' => $judul,
                ],
                [
                    'name' => 'slug',
                    'contents' => $slug,
                ],
                [
                    'name' => 'deskripsi',
                    'contents' => $request->deskripsi,
                ],
                [
                    'name' => 'keterangan_foto',
                    'contents' => $request->keterangan_foto,
                ],
                [
                    'name' => 'id_kategori', // Tambahkan id_kategori ke data
                    'contents' => $id_kategori,
                ],
                [
                    'name' => 'tags', // Tambahkan tags ke data
                    'contents' => $tag,
                ],
                [
                    'name'     => 'foto',
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName(),
                ],
            ];
        } else {
            $data = [
                [
                    'name' => 'id_pengunjung',
                    'contents' => $user->id_pengunjung,
                ],
                [
                    'name' => 'id_wilayah',
                    'contents' => $request->id_wilayah,
                ],
                [
                    'name' => 'judul',
                    'contents' => $judul,
                ],
                [
                    'name' => 'slug',
                    'contents' => $slug,
                ],
                [
                    'name' => 'deskripsi',
                    'contents' => $request->deskripsi,
                ],
                [
                    'name' => 'keterangan_foto',
                    'contents' => $request->keterangan_foto,
                ],
                [
                    'name' => 'id_kategori', // Tambahkan id_kategori ke data
                    'contents' => $id_kategori,
                ],
                [
                    'name' => 'tags', // Tambahkan tags ke data
                    'contents' => $tag,
                ],
            ];
        }
        $client = $this->getClient();
        try {
            $token = session('jwt_token');
            $response = $client->put('posts/update-from-peng/' . $id, [
                'multipart' => $data,
                'headers' => [
                    'Authorization' => $token,
                    'Accept' => 'application/json',
                ],

            ]);
            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody()->getContents(), true);
            // dd($responseData);
            $message = $responseData["message"];

            if ($statusCode === 201) {
                Session::flash('success', $message);
            } else {
                Session::flash('info', $message);
            }
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
        }
        return redirect()->route('dashboard',['email'=> $user->email]);
    }

    function deletePosts($id)
    {
        $client = $this->getClient();
        try {
            $token = session('jwt_token');
            $response = $client->delete('posts/' . $id, [
                'headers' => [
                    'Authorization' => $token,
                    'Accept' => 'application/json',
                ],
            ]);
            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody()->getContents(), true);
            $message = $responseData["message"];

            if ($statusCode === 201) {
                Session::flash('success', $message);
            } else {
                Session::flash('info', $message);
            }
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
        }
        return redirect()->back();
    }

    function komentar(Request $request)
    {
        $id_post = $request->id_post;
        $komentar = $request->comment;
        $id_pengunjung = $request->id_pengunjung;
        $data = ["id_post" => $id_post, "id_pengunjung" => $id_pengunjung, "komentar" => $komentar];
        $client = $this->getClient();
        $token = session('jwt_token');
        $response = $client->post('komentars/add-komentar', [
            'json'=> $data,
            'headers' => [
                'Authorization' => $token,
                'Accept' => 'application/json',
            ],
        ]);
        $responseData = json_decode($response->getBody()->getContents());

        return response()->json($responseData);
    }
}

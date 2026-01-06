<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthLoginController extends Controller
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
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $client = $this->getClient();
        // try {
        $user = Socialite::driver('google')->user();
        $data = [
            'google_id' => $user->id,
            'nama_pengunjung' => $user->name,
            'email' => $user->email,
            'foto' => $user->avatar,
        ];
        // dd($data);
        $apiUrl = 'pengunjung/add-data';


        $response = $client->post($apiUrl, [
            'json' => $data,
        ]);
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody()->getContents());
        session(['jwt_token' => $responseBody->jwt_token]);
        session(['user' => $responseBody->user_data]);
        
        return redirect()->route('home');
        /*   } catch (\Throwable $th) {
            dd($th);
            // Tangani kesalahan jika terjadi
            // return redirect('auth/google');
        } */
    }

    function logout(Request $request) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

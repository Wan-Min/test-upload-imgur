<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class UploadImageController extends Controller
{
    public function getAccessToken(Request $request){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.imgur.com/oauth2/token', [
            'form_params' => [
                'refresh_token' => $request->refresh_token,
                'client_id' => 'a8eb9e66cecd8f3',
                'client_secret' => '15653139c4d046a66d1e877d20261610a2ec841a',
                'grant_type' => "refresh_token",
            ],
        ]);
        $data = response()->json(json_decode(($response->getBody()->getContents())))->getData();
        return response()->json(['accessToken' => $data->access_token, 'refreshToken' => $data->refresh_token]);
    }
    
    /** 
     * @param $Album 相簿ID
     * @return boolean
    */
    public function getAlbum(Request $request){
        $this->getAccessToken($request);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.imgur.com/3/album/'.$request->album, [
            'headers' => [
                'authorization' => 'Bearer '.$request->access_token,
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        ]);
        if(response()->json(json_decode(($response->getBody()->getContents())))->getData()->status == 200) return true;
        else return false;
    }

    private function getAllAlbum(Request $request){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.imgur.com/3/account/wwwanMin/albums/', [
            'headers' => [
                'authorization' => 'Bearer '.$request->access_token,
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        // logger(json_encode(response()->json(json_decode(($response->getBody()->getContents())))->getData()));
        // getData() is a array list
        // 可能用到的參數 response: id,title,link
    } 

    public function upload(Request $request){
        // $this->getAccessToken();
        // $this->getAlbum($request->album);
        // $file = $request->file('file');
        // $file_path = $file->getPathName();
        // $client = new \GuzzleHttp\Client();
        // $response = $client->request('POST', 'https://api.imgur.com/3/image', [
        //     'headers' => [
        //         // 'authorization' => 'Client-ID ' . '41c6d272b446bd4',
        //         'authorization' => 'Bearer df270bd47f10d3c58b0b4fd272733ae6a0e0108d',
        //         'content-type' => 'application/x-www-form-urlencoded',
        //     ],
        //     'form_params' => [
        //         'image' => base64_encode(file_get_contents($request->file('file')->path($file_path)))
        //     ],
        // ]);
        // $data['file'] = data_get(response()->json(json_decode(($response->getBody()->getContents())))->getData(), 'data.link');
        // logger($data['file']);
    }
}

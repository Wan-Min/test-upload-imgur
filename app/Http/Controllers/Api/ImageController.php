<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Arr;
class ImageController extends Controller
{
    /**
     * 取得指定 Access Token
     */
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
     * 取得指定 Album
     */
    public function getAlbum(Request $request){
        // $this->getAccessToken($request);
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

    /**
     * 上傳 image to imgur, 可指定 album ID
     */
    public function upload(Request $request){
        $file = $request->file('file');
        $file_path = $file->getPathName();
        $bodyArray = [
            'image' => base64_encode(file_get_contents($request->file('file')->path($file_path)))
        ];

        if(!is_null($request->album)){
            $this->getAlbum($request);
            $bodyArray = [
                'album' => $request->album,
                'image' => base64_encode(file_get_contents($request->file('file')->path($file_path)))
            ];
        }
        
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.imgur.com/3/image', [
            'headers' => [
                'authorization' => 'Bearer '.$request->access_token,
                'content-type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => $bodyArray,
        ]);
        $data['file'] = data_get(response()->json(json_decode(($response->getBody()->getContents())))->getData(), 'data.link'); 
        return response()->json($data);
    }

    /**
     * 取得所有 Album, getData() is a array list,可能用到的參數 response: id,title,link
     */
    private function getAllAlbum(Request $request){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.imgur.com/3/account/wwwanMin/albums/', [
            'headers' => [
                'authorization' => 'Bearer '.$request->access_token,
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        ]);
        logger(json_encode(response()->json(json_decode(($response->getBody()->getContents())))->getData()));
    } 

    /**
     * 取得指定 image
     */
    private function getImage($id, $access_token){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.imgur.com/3/image/'.$id, [
            'headers' => [
                'authorization' => 'Bearer '.$access_token,
                'content-type' => 'application/x-www-form-urlencoded',
            ]
        ]);
        return data_get(response()->json(json_decode(($response->getBody()->getContents())))->getData(), 'data.link');
    }
}

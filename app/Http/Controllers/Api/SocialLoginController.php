<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;

class SocialLoginController extends Controller
{
    //Line授權
    public function line(){
        return Socialite::with('line')->redirect();
    }

    //Line callback
    public function lineCallback(){
        try {
            $socialUser = Socialite::driver('line')->stateless()->user();
            $checkUser = User::where('email',$socialUser->getEmail())->orWhere('lineID',$socialUser->getId())->first();
            if(is_null($checkUser)) $checkUser = $this->createSocialUser($socialUser, 'line');
            else{
                $checkUser->update([
                    'lineID' => $socialUser->getId()
                ]);
            }

            Auth::login($checkUser);
            return redirect()->to('dashboard');
        } catch (\Throwable $e) {
            logger(json_encode($e->getMessage()));
        }
    }

    //Google授權
    public function google(){
        return Socialite::with('google')->redirect();
    }

    //Google callback
    public function googleCallback(){
        try {
            $socialUser = Socialite::driver('google')->stateless()->user();
            $checkUser = User::where('email',$socialUser->getEmail())->orWhere('googleID',$socialUser->getId())->first();
            if(is_null($checkUser)){
                $checkUser = $this->createSocialUser($socialUser, 'google');
            }
            else{
                $checkUser->update([
                    'googleID' => $socialUser->getId()
                ]);
            }
            Auth::loginUsingId($checkUser->id);
            return redirect()->to('dashboard');
        } catch (\Throwable $e) {
            logger(json_encode($e->getMessage()));
        }
    }

     //Facebook授權
     public function facebook(){
        return Socialite::with('facebook')->redirect();
    }

    //Facebook callback
    public function facebookCallback(){
        try {
            $socialUser = Socialite::driver('facebook')->stateless()->user();
            $checkUser = User::where('email',$socialUser->getEmail())->orWhere('facebookID',$socialUser->getId())->first();
            if(is_null($checkUser)){
                $checkUser = $this->createSocialUser($socialUser, 'facebook');
            }
            else{
                $checkUser->update([
                    'facebookID' => $socialUser->getId()
                ]);
            }

            Auth::login($checkUser);
            return redirect()->to('dashboard');
        } catch (\Throwable $e) {
            logger(json_encode($e->getMessage()));
        }
    }

    private function createSocialUser($data, $driver){
        switch ($driver) {
            case 'line':
                return User::create([
                    'name' => $data->getName(),
                    'email' => $data->getEmail(),
                    'password' => bcrypt('123456'),
                    'lineID' => $data->getId(),
                ]);
                break;
            case 'google':
                return User::create([
                    'name' => $data->getName(),
                    'email' => $data->getEmail(),
                    'password' => bcrypt('123456'),
                    'googleID' => $data->getId(),
                ]);
                break;
            case 'facebook':
                return User::create([
                    'name' => $data->getName(),
                    'email' => $data->getEmail(),
                    'password' => bcrypt('123456'),
                    'facebookID' => $data->getId(),
                ]);
                break;
            default:
                # code...
                break;
        }
    }

    

    
}

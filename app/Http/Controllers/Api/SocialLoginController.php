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
        $socialUser = Socialite::driver('line')->stateless()->user();
        $checkUser = User::where('email',$socialUser->getEmail())->orWhere('lineID',$socialUser->getId())->first();
        if(is_null($checkUser)){
            $checkUser = $this->createSocialUser($socialUser, 'line');
            // $LineUser = User::where('lineID',$socialUser->getId())->first();
        }
        else{
            $checkUser->update([
                'lineID' => $socialUser->getId()
            ]);
        }

        Auth::login($checkUser);
        return redirect()->to('dashboard');
    }

    //Google授權
    public function google(){
        return Socialite::with('google')->redirect();
    }

    //Google callback
    public function googleCallback(){
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
        logger("check google login");
        logger(json_encode($checkUser));
        logger(json_encode(Auth::loginUsingId($checkUser->id)));
        Auth::loginUsingId($checkUser->id);
        // Auth::login($checkUser);
        return redirect()->to('dashboard');
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
            default:
                # code...
                break;
        }
    }

    

    
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialLoginController extends Controller
{
    //Line授權
    public function line()
    {
        return Socialite::with('line')->redirect();
    }

    //Line callback
    public function callback()
    {
        $socialUser = Socialite::driver('line')->stateless()->user();
        logger(json_encode($socialUser));
        $User = User::where('lineID',$socialUser->getId())->first();
        if($User == null){
            $User = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => Hash::make(Str::random(8)),
            ]);
        }

        //do user login in web
    }
}

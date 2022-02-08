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
    public function __construct(){
		$this->middleware('guest:web', ['except'=>['logout']]);
	}

    //Line授權
    public function line(){
        return Socialite::with('line')->redirect();
    }

    //Line callback
    public function callback(){
        $socialUser = Socialite::driver('line')->stateless()->user();
        $LineUser = User::where('lineID',$socialUser->getId())->first();

        if($LineUser == null){
            $LineUser = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => Hash::make('2r1631'),
                // 'password' => Hash::make(Str::random(8)),
                'lineID' => $socialUser->getId(),
            ]);
        }

        try {
            Auth::loginUsingId($LineUser->id);
            return view('social');
        } catch (\Throwable $e) {
           logger(json_encode($e->getMessage()));
        }
    }

    public function login(Request $request){
        logger(json_encode($request->all()));
        $User = User::where('email',$request->email)->first();
        if($User != null && Hash::check($request->passwor,$User->password)){
            try {
                Auth::loginUsingId($User->id);
                return view('social');
            } catch (\Throwable $e) {
               logger(json_encode($e->getMessage()));
            }
        }
    }

    public function logout(){
        Auth::logout();
        return view('social');
    }

    public function dashboard(){
        return view('social');
    }
}

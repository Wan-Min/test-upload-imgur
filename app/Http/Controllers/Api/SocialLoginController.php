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
    public function callback(){
        $socialUser = Socialite::driver('line')->stateless()->user();
        $LineUser = User::where('lineID',$socialUser->getId())->first();

        if($LineUser == null){
            $LineUser = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => $this->setPasswordAttribute('123456'),
                'lineID' => $socialUser->getId(),
            ]);
        }

        Auth::login($LineUser);
        return redirect()->to('dashboard');
    }

    /**
     * Always encrypt the password when it is updated.
     *
     * @param $value
    * @return string
    */
    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }

    

    
}

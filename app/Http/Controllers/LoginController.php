<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class LoginController extends Controller
{
    public function __construct(){
		$this->middleware('guest:web', ['except'=>['logout','dashboard']]);
	}

    public function loginPage(){
        return view('social');
    }

    public function login(Request $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(!Auth::validate($credentials)):
            logger("validate error");
            return redirect()->to('login')
                ->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        Auth::login($user);
        return $this->authenticated($request, $user);
    }

    protected function authenticated(Request $request, $user) {
        return redirect()->to('dashboard');
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }

    public function dashboard(){
        return view('dashboard');
    }
}

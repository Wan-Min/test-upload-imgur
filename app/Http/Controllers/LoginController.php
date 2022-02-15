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

    public function registerPage(){
        return view('register');
    }

    public function register(Request $request){

        $check = User::where('email',$request->email)->first();
        if(!is_null($check)){
            return redirect()->route('login')->withErrors('此信箱已經註冊過，請直接登入或嘗試第三方登入');
        }
        else{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            Auth::login($user);
            return $this->authenticated($request, $user);
        }
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

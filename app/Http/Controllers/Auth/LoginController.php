<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function login(Request $request)
    {
        $user = User::where(['username' => $request->username, 'active' => '1'])->first();
        if ($user) {
            Auth::login($user);
            if($user->role_id == 1){
                return redirect('/home');
            }else {
                return redirect('/pendaftaran');
            }
        } else{
            return redirect('/login');
        }
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
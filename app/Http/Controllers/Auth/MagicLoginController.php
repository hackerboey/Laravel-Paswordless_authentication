<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\UsersToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Auth\MagicAuthentication;
use App\Http\Requests;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class MagicLoginController extends Controller
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



   public function show()
    {
    	return view('auth.magic.login');

    }


    public function sendToken(Request $request,MagicAuthentication $auth) //passing request to extract  email
    {
    	
    	$this->validateLogin($request);

    	$auth->requestLink();

        return redirect()->back();
        
    }

    public function validateToken(Request $request, UsersToken $token)
    {

        $token->delete();

        if ($token->isExpired()) {
                return redirect('/login/magic')->with('error','That Magic Link has expired');
            }    

        Auth::login($token->user,$request->remember);

        return redirect()->intended();
    }

    protected function validateLogin(Request $request)
    {

    	$this->validate($request,[

    		'email'=>'required|email|max:255|exists:users,email'
    	]);

    }
}

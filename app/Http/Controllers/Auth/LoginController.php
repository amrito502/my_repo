<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Traits\General;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;


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
    use General;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        /*
        role 1 = admin
        role 2 = instructor
        role 3 = student
        -----------------
        status 1 = Approved
        status 2 = Blocked
        status 0 = Pending
        */
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == 3 && Auth::user()->student->status == 2){
                Auth::logout();
                $this->showToastrMessage('error', 'Your account has been blocked!');
                return redirect("login");
            }
            if(!empty(Auth::user()->student)){
                if (Auth::user()->student->status == 2 ){
                    Auth::logout();
                    $this->showToastrMessage('error', 'Your account has been blocked!');
                    return redirect("login");
                }
            }
            if(!empty(Auth::user()->instructor)){
                if (Auth::user()->instructor->status == 2 ){
                    Auth::logout();
                    $this->showToastrMessage('error', 'Your account has been blocked!');
                    return redirect("login");
                }
            }
            
            if (!empty(Auth::user()->email))
            {
               return redirect(route('dashboard'));
            } 
        }
        $this->showToastrMessage('error', 'Ops! You have entered invalid credentials');
        return redirect("login");
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}

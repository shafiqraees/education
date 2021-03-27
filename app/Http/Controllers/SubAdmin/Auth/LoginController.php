<?php

namespace App\Http\Controllers\SubAdmin\Auth;

use App\Http\Controllers\Controller;
use App\Models\SubAdmin;
use App\Models\Teacher;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{
    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/subadmin';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:subadmin')->except('logout');
    }
    public function showLoginForm(){
        return view('subadmin.auth.login');
    }

    public function subAdminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        $subadmin = SubAdmin::whereEmail($request->email)->whereNotNull('email_verified_at')->first();
        if ($subadmin) {
            if (Auth::guard('subadmin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                return redirect()->intended('/subadmin');
            } else {
                $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);
                return Redirect::back()->withErrors($errors)->withInput($request->only('email', 'remember'));
            }
        } else {
            $errors = new MessageBag(['Verify' => ['Please check your email and verify your account.']]);
            return Redirect::back()->withErrors($errors)->withInput($request->only('email', 'remember'));
        }
    }
    public function logout(Request $request)
    {

        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('subadmin.login');
    }

    protected function guard()
    {
        return Auth::guard('subadmin');
    }
}

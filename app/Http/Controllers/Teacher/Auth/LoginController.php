<?php

namespace App\Http\Controllers\Teacher\Auth;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
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

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/teacher';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:teacher')->except('logout');
    }
    public function showLoginForm(){
        return view('teacher.auth.login');
    }

    public function TeacherLogin(Request $request)
    {
        $this->validate($request, [
            'email' => ['required'],
            'password' => ['required'],
        ]);
        $teacher = Teacher::whereEmail($request->email)->whereNotNull('email_verified_at')->first();
        if ($teacher) {
            if (Auth::guard('teacher')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                return redirect()->intended('/teacher');
            } else {
                $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);
                return Redirect::back()->withErrors($errors)->withInput($request->only('email', 'remember'));
            }
        } else {
            $errors = new MessageBag(['Verify' => ['Please check your email and verify your account.']]);
            return Redirect::back()->withErrors($errors)->withInput($request->only('email', 'remember'));
        }

        //return back()->withInput($request->only('email', 'remember'));


    }
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('teacher.login');
    }

    protected function guard()
    {
        return Auth::guard('teacher');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginUserRequest;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Login user via credentials
     * 
     * @param \App\Http\Requests\LoginUserRequest $request
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->remember ? true : false;
        $user = User::where('email', $credentials['email'])->first();

        if(!$user) {
            return back()->withErrors([
                'email' => 'Пользольвателя с таким email адресом не найдено.'
            ])->withInput([
                'email' => $request->email
            ]);
        }

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            return redirect()->route('home');
        } else {
            return back()->withErrors([
                'password' => 'Введен неверный пароль.'
            ])->withInput([
                'email' => $request->email
            ]);
        }
    }
}

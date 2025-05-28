<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Setelah login berhasil, redirect ke sini.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Konstruktor, middleware hanya untuk guest kecuali logout.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override validasi login untuk menambahkan validasi captcha.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ], [
            'captcha.captcha' => 'Captcha salah, coba lagi.',
        ]);
    }
}

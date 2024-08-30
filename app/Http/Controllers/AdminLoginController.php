<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class AdminLoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = 'menus';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Affiche le formulaire de connexion admin
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }



    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');    }
    protected function credentials(Request $request)
    {
        return[
            'mail'=>$request->get('email'),
            'password'=>$request->get('password'),

        ];
    }


}

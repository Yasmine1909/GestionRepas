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

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $authorizedEmails = [
            'ykhatib@m2mgroup.com',
            'admin@example.com',
            'admin2@example.com',
        ];
        $email = strtolower($request->email);

        if (!in_array($email, $authorizedEmails)) {
            return redirect()->back()->withErrors(['email' => 'Cet utilisateur n\'a pas accès à l\'interface admin.']);
        }


        if (Auth::attempt($this->credentials($request))) {
            return redirect()->intended($this->redirectTo);
        }


        return redirect()->back()->withErrors(['email' => 'Identifiants incorrects.']);
    }



    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');

    }
    protected function credentials(Request $request)
    {
        return[
            'mail'=>$request->get('email'),
            'password'=>$request->get('password'),

        ];
    }


}

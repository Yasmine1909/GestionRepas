<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/'; // Redirige après connexion réussie
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended('/'); // ou la route de ton choix
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showLoginForm()
    {

      return redirect('/connexion');
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/connexion');


    }
    protected function credentials(Request $request)
    {
        return[
            'mail'=>$request->get('email'),
            'password'=>$request->get('password'),

        ];
    }

}


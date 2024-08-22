<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/'; // Redirige après connexion réussie

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Affiche le formulaire de connexion
    public function showLoginForm()
    {
      return redirect('/connexion');
    }

    // Gère la déconnexion
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/connexion'); // Redirige vers la page de connexion après déconnexion
    }
}


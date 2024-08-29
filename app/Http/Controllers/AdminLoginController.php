<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Affiche le formulaire de connexion admin
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    // Gère la connexion admin
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Rediriger vers le tableau de bord admin
            return redirect()->route('menus');
        }

        return back()->withInput($request->only('email', 'remember'))
                     ->withErrors(['email' => 'Ces identifiants ne correspondent pas à nos enregistrements.']);
    }

    // Gère la déconnexion admin
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }



}

<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        // Valider les informations de connexion
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Convertir l'email en minuscules pour une comparaison cohérente
        $credentials['email'] = strtolower($credentials['email']);

        // Afficher pour déboguer
        Log::info('Login attempt', $credentials);

        // Vérifier si l'email existe dans la table des administrateurs
        $admin = Admin::whereRaw('LOWER(email) = ?', [strtolower($credentials['email'])])->first();

        if ($admin) {
            // Authentifier avec LDAP en utilisant les informations fournies
            if (Auth::guard('admin')->attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password']
            ])) {
                return redirect()->intended('admin/menus'); // Ajustez le chemin selon vos besoins
            } else {
                return back()->withErrors([
                    'email' => 'Erreur dans les informations d\'authentification.',
                ]);
            }
        } else {
            return back()->withErrors([
                'email' => 'Cet email n\'est pas associé à un compte administrateur.',
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}

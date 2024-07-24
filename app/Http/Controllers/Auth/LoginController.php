<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // Uncomment cette ligne si vous souhaitez définir une redirection par défaut
    // protected $redirectTo = '/';

    /**
     * Handle the post-authentication redirection.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        // Rediriger vers la page d'accueil
        return redirect('/');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.connexion'); // Utiliser votre vue personnalisée
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    protected function credentials(Request $request)
    {
        return [
            'uid'=> $request->get('username'),
            'password'=> $request->get('password'),
        ];
    }
    public function username()
    {
        return 'username';
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // afficher le formulaire
    public function showRegister(){
        return view('auth.register');
    }
    //traiter les donner
    public function register(Request $request){
        //valider les doner
        $request->validate([
            'nom' => 'required|min:3',
            'prenom' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        //inserer les doner
        $user = User::create([
                'nom' => $request->nom,
                'email' => $request->email,
                'prenom' => $request->prenom,
                'password' => $request->password
            ]);

        //connexion
        auth()->login($user);

        //envoie du mail
        $user->sendEmailVerificationNotification();

        //redirection
        return redirect("/email/verify");
    }

    //affichege du formulaire
    public function showLogin(){
        return view('auth.login');
    }
    //connexion
    public function login(Request $request){
        //valider les doner
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            if(!Auth::user()->hasVerifiedEmail()){
                return redirect('/email/verify');
            }

            $request->session()->regenerate();
            return redirect('/dashboard');
        };

        return redirect('/login')->withErrors(['email' => 'email ou mot de passe incorrecte!, veiller reesaiyer svp!']);
    }

    public function logout(Request $request){
        //decoonexion
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');

    }
}

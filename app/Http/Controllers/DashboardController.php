<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commentaire; 
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();

        
        if (!$user->hasVerifiedEmail()){
            return redirect('/email/verify');
        }

       
        if ($user->role === 'admin') {
            $totalUser = User::count();
            $totalPost = Commentaire::whereNull('parent_id')->count();
            $totalComment = Commentaire::whereNotNull('parent_id')->count();
            $totalVerifiedEmail = User::whereNotNull('email_verified_at')->count();

            $userWhoPosted = Commentaire::distinct('user_id')->count('user_id');
            $engagement = $totalUser > 0 ? round(($userWhoPosted / $totalUser) * 100, 1) : 0;

            $users = User::latest()->paginate(5);// On prend les 5 derniers pour l'aperçu
            $UserWeek = User::where('created_at', '>=', now()->subDays(7))->count();

            return view('Dash.dash', compact(
                'totalUser', 'totalPost', 'totalComment', 'totalVerifiedEmail',
                'engagement', 'users', 'user', 'UserWeek'
            ));
        }

        $publicationCount = Commentaire::where('user_id', $user->id)->whereNull('parent_id')->count();
        $commentsCount = Commentaire::where('user_id', $user->id)->count();
        $followerCount = 0; // À implémenter plus tard

        return view('dashboard', compact('user', 'publicationCount', 'commentsCount', 'followerCount'));
    }

    
    public function user()
    {
        if (Auth::user()->role !== 'admin') return redirect('/');

        $users = User::latest()->paginate(10);
        return view('Dash.user', compact('users'));
    }

    public function editUsers($id)
    {
        if (Auth::user()->role !== 'admin') return redirect('/dashboard');
        
        $user = User::findOrFail($id);
        return view('Dash.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') return redirect('/');
        
        $user = User::findOrFail($id);
        $request->validate([
            'nom' => 'required|min:3',
            'prenom' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:user,admin'
        ]);

        $user->update($request->only('nom', 'prenom', 'email', 'role'));

        return redirect()->route('dashboard.user')->with('success', 'Utilisateur mis à jour');
    }

    public function destroyUser($id)
    {
        if (Auth::user()->role !== 'admin') return redirect('/');
        
        User::findOrFail($id)->delete();
        return redirect()->route('dashboard.user')->with('success', 'Utilisateur supprimé');
    }
}
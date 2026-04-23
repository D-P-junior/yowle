<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
ROUTES PUBLIQUES
*/

Route::get('/', function () {
    $commentaires = Commentaire::whereNull('parent_id')
                    ->with(['user', 'likes', 'dislikes'])
                    ->withCount(['likes', 'dislikes'])
                    ->latest()
                    ->get();

    return view('welcome', compact('commentaires'));
})->name('home');


Route::get('/post/{id}', [CommentaireController::class, 'show'])->name('commentaires.show');


/*
 AUTHENTIFICATION & VÉRIFICATION D'EMAIL
*/

// Inscription
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Connexion / Déconnexion
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Logique de vérification d'email 
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/login')->with('success', 'Email vérifié !');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Email renvoyé !');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


/*
ROUTES PROTÉGÉES (AUTH & VERIFIED)

*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- DASHBOARD (ADMIN) ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/user', [DashboardController::class, 'user'])->name('dashboard.user');
    Route::get('/dashboard/user/{id}/edit', [DashboardController::class, 'editUsers'])->name('dashboard.user.edit');
    Route::put('/dashboard/user/{id}', [DashboardController::class, 'updateUser'])->name('dashboard.user.update');
    Route::delete('/dashboard/user/{id}', [DashboardController::class, 'destroyUser'])->name('dashboard.user.destroy');

    // --- GESTION DES PUBLICATIONS & COMMENTAIRES ---
    Route::post('/commentaires', [CommentaireController::class, 'store'])->name('commentaires.store');
    Route::put('/commentaires/{id}', [CommentaireController::class, 'update'])->name('commentaires.update');
    Route::delete('/commentaires/{id}', [CommentaireController::class, 'destroy'])->name('commentaires.destroy');

    // --- SYSTÈME DE RÉACTIONS (LIKE / DISLIKE) ---
    Route::post('/commentaires/{id}/like', [CommentaireController::class, 'like'])->name('commentaires.like');
    Route::post('/commentaires/{id}/dislike', [CommentaireController::class, 'dislike'])->name('commentaires.dislike');

    // --- GESTION DES UTILISATEURS / PROFIL ---
    Route::resource('users', UserController::class);
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
});
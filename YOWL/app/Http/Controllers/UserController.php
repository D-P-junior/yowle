<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function show(User $user)
    {
        
        return view('users.show', compact('user'));
    }

    public function index()
    {
        $users = User::paginate(20);
        return view('users.index', compact('users'));
    }

    public function store(StoreUserRequest $request)
    {
        User::create([
            ...$request->validated(),
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('users.index')    
                         ->with('success', 'Utilisateur crée avec succès !');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        if ($request->hasFile('avatar')) {
            if ($user->avatar){
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)
                         ->with('success', 'Ton profil à été mis à jour  avec succès !');
    }
   
        
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
                         ->with('success', 'Utilisateur supprimé avec succès !');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
}

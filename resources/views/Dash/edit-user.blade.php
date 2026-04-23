@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="md:p-6 max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('dashboard.user') }}" class="text-sm text-slate-500 hover:text-primary flex items-center gap-1">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
        <h1 class="text-2xl font-bold text-dark mt-2">Modifier l'utilisateur : {{ $user->prenom }}</h1>
    </div>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-600 p-4 rounded-xl mb-6 text-sm">
            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('dashboard.user.update', $user->id) }}" class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:border-primary outline-none bg-slate-50">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nom</label>
                <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:border-primary outline-none bg-slate-50">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Adresse Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:border-primary outline-none bg-slate-50">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Rôle sur la plateforme</label>
            <select name="role" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:border-primary outline-none bg-slate-50">
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Utilisateur standard</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
            </select>
        </div>

        <div class="pt-4 flex gap-4">
            <button type="submit" class="flex-1 bg-primary text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-primary/20">
                Sauvegarder les modifications
            </button>
            <a href="{{ route('dashboard.user') }}" class="flex-1 border border-slate-200 text-slate-600 font-bold py-3 rounded-xl hover:bg-slate-50 transition text-center">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
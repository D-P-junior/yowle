@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.7/dist/iconify-icon.min.js"></script>

<div class="md:p-6 w-full space-y-8">
    
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-dark mb-2">Gestion des Utilisateurs</h1>
            <p class="text-slate-500">Administrez les membres de la communauté YOWL.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="text-dark text-lg font-semibold">{{ $users->total() }} membres inscrits</h3>
            
            <div class="relative w-full sm:w-72">
                <iconify-icon icon="solar:magnifer-linear" class="absolute left-3 top-3 text-slate-400" width="16"></iconify-icon>
                <input type="text" placeholder="Rechercher..." class="pl-10 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-primary w-full">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100 text-xs uppercase text-slate-400 font-semibold">
                        <th class="px-6 py-4">Utilisateur</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Rôle</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/60 border-b border-slate-50 last:border-0 transition-colors">
                            <td class="px-6 py-4 font-medium text-dark">{{ $u->prenom }} {{ $u->nom }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $u->email }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs {{ $u->role == 'admin' ? 'bg-rose-100 text-rose-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst($u->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($u->email_verified_at)
                                    <span class="text-emerald-600 flex items-center gap-1"><iconify-icon icon="solar:verified-check-linear"></iconify-icon> Vérifié</span>
                                @else
                                    <span class="text-slate-400">Non vérifié</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('dashboard.user.edit', $u->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('dashboard.user.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                        @csrf @method('DELETE')
                                        <button class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-10 text-center text-slate-400">Aucun utilisateur trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-50">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
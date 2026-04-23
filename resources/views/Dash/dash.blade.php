@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.7/dist/iconify-icon.min.js"></script>

<div class="md:p-6 w-full space-y-8 text-slate-600">

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-dark mb-2">Tableau de Bord Admin</h1>
            <p class="text-slate-500">Aperçu global de l'activité sur YOWL.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                <iconify-icon icon="solar:users-group-two-rounded-linear" width="24"></iconify-icon>
            </div>
            <h3 class="text-slate-400 text-sm font-medium mb-1">Total Users</h3>
            <p class="text-dark text-2xl font-bold">{{ number_format($totalUser, 0, ',', ' ') }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-4">
                <iconify-icon icon="solar:pen-new-round-linear" width="24"></iconify-icon>
            </div>
            <h3 class="text-slate-400 text-sm font-medium mb-1">Total Posts</h3>
            <p class="text-dark text-2xl font-bold">{{ number_format($totalPost, 0, ',', ' ') }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                <iconify-icon icon="solar:chat-round-dots-linear" width="24"></iconify-icon>
            </div>
            <h3 class="text-slate-400 text-sm font-medium mb-1">Nouveaux (7j)</h3>
            <p class="text-dark text-2xl font-bold">{{ $UserWeek }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
                <iconify-icon icon="solar:verified-check-linear" width="24"></iconify-icon>
            </div>
            <h3 class="text-slate-400 text-sm font-medium mb-1">Vérifiés</h3>
            <p class="text-dark text-2xl font-bold">{{ $totalVerifiedEmail }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center mb-4">
                <iconify-icon icon="solar:graph-up-linear" width="24"></iconify-icon>
            </div>
            <h3 class="text-slate-400 text-sm font-medium mb-1">Engagement</h3>
            <p class="text-dark text-2xl font-bold">{{ $engagement }}%</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mt-8">
        <div class="p-6 border-b border-slate-50">
            <h3 class="text-dark text-lg font-bold">Derniers Utilisateurs</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr class="text-xs uppercase text-slate-400">
                        <th class="px-4 py-3">Utilisateur</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Rôle</th>
                        <th class="px-4 py-3">Statut</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($users as $user)
                    <tr>
                        <td class="px-4 py-3 fw-bold">{{ $user->prenom }} {{ $user->nom }}</td>
                        <td class="px-4 py-3 text-muted">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-primary' }} rounded-pill">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($user->email_verified_at)
                                <span class="text-success"><i class="bi bi-check-circle-fill"></i> Vérifié</span>
                            @else
                                <span class="text-muted">En attente</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-50">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
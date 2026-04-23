<!DOCTYPE html>
<html lang="en">
<head>
    <title>Listes des utilisateur - YOWL</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            padding: 30px; 
            background-color: #f8f9fa;
        }
        h1 { 
            color: #333; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white; 
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0, 1); 
            border-radius: 8px; 
            overflow: hidden;
        }
        th, td { 
            padding: 15px; 
            text-align: left; 
            border-bottom: 1px solid #eee; 
        }
        th { 
            background-color: #3490dc; 
            color: white; 
            text-transform: uppercase; 
            font-size: 0.85rem; 
        }
        tr:hover { 
            background-color: #f1f7fd; 
        }
        .badge { 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 0.75rem; 
            font-weight: bold; 
        }
        .badge-admin { 
            background: #fed7d7; 
            color: #9b2c2c;
        }
        .actions { 
            display: flex; 
            gap: 8px; 
        }
        .btn { 
            text-decoration: none; 
            padding: 6px 12px; 
            border-radius: 4px; 
            color: white; 
            font-size: 0.8rem; 
            border: none; 
            cursor: pointer; 
        }
        .btn-view { 
            background-color: #38c172; 
        }
        .btn-edit { 
            background-color: #3490dc; 
        }
        .btn.delete { 
            background-color: #e3342f; 
        }
        .pagination { 
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Gestion des utilisateurs</h1>
    @if(session('success'))
    <div style="background: #d4edda; color:#155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
        {{session('success')}}
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom Complet</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>#{{ $user->id }}</td>
                <td><strong>{{ $user->prenom}} {{ $user->nom }}</strong></td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="badge {{ $user->role == 'admin' ? 'badge-admin' : 'badge-user' }}">
                        {{ strtoupper($user->role) }}
                    </span>
                </td>
                <td class="actions">
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-view">Voir</a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-edit">Modifier</a>

                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 30px; color:#777;">
                    Aucun utilisateur trouvé. <br>
                    <small>Inscrivez-vous via la page register pour apparaître ici.</small>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">
        {{ $users->links() }}
    </div>
</body>
</html>
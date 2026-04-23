<!DOCTYPE html>
<html lang="en">
<head>
    <title>Détail utilisateur - {{$user->nom}}</title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6; padding: 40px;
            background-color: #f8f9fa;
        }
        .profile-card {
            background: white;
            padding: 30px; border-radius: 12px;
            max-width: 600px; margin: auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0, 1);
        }
        .avatar.container {
            text-align: center;
            margin-bottom: 20px;
        }
        .avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #3490dc;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0, 1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        th {
            color:#777;
            width: 35%;
            font-weight: 600;
        }
        .actions {
            margin-top: 30px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .btn-edit {
            background: #3490dc;
            color: white;
            padding: 10px 25px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .btn-delete {
            background: #e3342f;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-edit:hover {
            background: #2779bd;
        }
    </style>
</head>
<body>
<div class="profile-card">
    <div class="avatar-container">
      @if($user->avatar)
            <img src="{{asset('storage/' . $user->avatar) }}" alt="photo de profil" alt="profile-avatar" width="150" height="150" class="avatar">
       @else
            <img src="{{ asset('images/default-avatar.png')}}" alt="photo par défaut" class="profile-avatar">
       @endif
    </div>

     <h1>Profill de {{ $user->prenom }} {{ $user->nom }}</h1>
     <a href="{{ route('dashboard.user') }}">Retour à la liste</a>
     <table>
         <tr>
            <th>Statut</th>
            <td><span style="background: #ebf8ff; color: #2b6cb0; padding: 4px 8px; border-radius: 4px; font-size: 0.9em;">{{ ucfirst($user->role) }}</span></td>
        </tr>
         <tr>
            <th>Identité</th>
            <td>{{ $user->prénom }} {{ $user->nom }} </td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
         </tr>
         <tr>
             <th>Téléphone</th>
             <td>{{ $user->phone ?? 'Non renseigné' }}</td>
        </tr>
        <tr>
            <th>Biographie</th>
            <td>{{ $user->bio ?? 'Aucune biographie redigée.' }}</td>
        </tr>
         <tr>
            <th>Membre depuis</th>
            <td>{{ $user->created_at->format('d/m/Y à H:i') }}</td>
        </tr>
     </table>

        <div class="actions">
            <a href="{{ route('users.edit', $user->id) }}" class="btn-edit">Modifier le profil</a>

            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression définitive du compte ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete">Supprimer</button>
            </form>

        </div>
</div>

</body>
</html>

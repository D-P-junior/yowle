<!DOCTYPE html>
<html lang="en">
<head>
    <title>Modifier mon profil YOWL</title>
</head>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f7f6;
            padding: 40px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0, 1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px; solid #3490dc;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="email"], textarea {
             width: 100%;
             padding: 10px;
             border: 1px solid #ddd;
             border-radius: 6px;
             box-sizing: border-box;
            }
        .avatar-preview {
            text-align: center;
            margin-bottom: 20px;
        }
        .avatar-preview img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #3490dc;
            margin-bottom: 10px;
        }
        .btn-save {
            background-color: #3490dc;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: 0.3s;
        }
        .btn-save:hover {
            background-color: #2779bd;
        }
        .error.msg { color: #e3342f;
            font-size: 0.85rem;
            margin-top: 5px;
        }
    </style>

<body>
<div class="container">
             <h2>Modifier mon profil</h2>

             <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="avatar-preview">
            @if($user->avatar)
            <img src="{{asset('storage/' . $user->avatar) }}" alt="Avatar">
            @else
            <img src="https://ui-avatars.com/api/?nme={{$user->prenom }}+{{ $user->nom}}&background=3490dc&color=fff" alt="Default Avatar">
            @endif
            <div class="form-group">
                <label for="avatar">Changer ma photo de profil</label>
                <input type="file" name="avatar" id="avatar" accept="image/*">
                @error('avatar') <div class="error-msg">{{ $message }}</div>@enderror
            </div>
        </div>


        <div class="form-group">
            <label>nom</label>
            <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" required>
        </div>
        <div class="form-group">
            <label>prénom</label>
            <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="form-group">
            <label>Ma Bio</label>
            <textarea name="bio" rows="4" placeholder="Parlez-nous de vous...">{{ old('bio', $user->bio)}}</textarea>
        </div>
        <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required>
        </div>

        <button type="submit" class="btn-save">Enregister les modifications</button>
    </form>
    <p style="text-align: center; margin-top: 15px;">
        <a href="{{ route('users.show', $user->id) }}" style="color: #777; text-decoration: none;">Annuler et retourner au profil</a>
    </p>
</div>
</body>
</html>


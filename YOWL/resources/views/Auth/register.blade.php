<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <title>Yowl — Inscription</title>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-9 col-11">

                <div class="card">
                    <div class="card-body">

                        <div class="logo">Yowl</div>
                        <p class="subtitle">Créez votre compte gratuitement</p>

                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="/register">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input
                                    type="text"
                                    name="nom"
                                    class="form-control"
                                    placeholder="Votre nom"
                                    value="{{ old('nom') }}"
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Prenom</label>
                                <input
                                    type="text"
                                    name="prenom"
                                    class="form-control"
                                    placeholder="Votre prenom"
                                    value="{{ old('prenom') }}"
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="exemple@gmail.com"
                                    value="{{ old('email') }}"
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="********"
                                >
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Confirmer le mot de passe</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="********"
                                >
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Créer mon compte
                            </button>

                        </form>

                        <div class="divider">ou</div>

                        <p class="register-link">
                            Déjà un compte ?
                            <a href="/login">Se connecter</a>
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>

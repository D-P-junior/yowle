<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yowl - Social Network</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
   
    <style>
        .flex-grow-1 {
            min-width: 0; 
        }
    </style>
</head>
<body class="bg-light">

    <div class="d-flex">
        <nav class="bg-white border-end vh-100 sticky-top" style="width: 280px;">
            <div class="p-4">
            
                <a href="{{ route('home') }}" class="text-decoration-none logo-yowl">
                    YOWL<i class="bi bi-wifi yowl-waves"></i>
                </a>

                <ul class="nav flex-column gap-2 mt-5">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : 'text-dark' }}">
                            <i class="bi bi-house-door me-2"></i> Home
                        </a>
                    </li>
                    
                    @auth
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'text-dark' }}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item mt-3">
                            <span class="text-muted small fw-bold px-3 text-uppercase" style="font-size: 0.7rem;">Administration</span>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.user') }}" class="nav-link {{ request()->routeIs('dashboard.user*') ? 'active' : 'text-dark' }}">
                                <i class="bi bi-person-gear me-2"></i> Gérer Users
                            </a>
                        </li>
                    @endif

                    <li class="nav-item mt-2">
                        <span class="text-muted small fw-bold px-3 text-uppercase" style="font-size: 0.7rem;">Personnel</span>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('users.show', Auth::user()->id) }}" class="nav-link {{ request()->is('users/'.Auth::user()->id) ? 'active' : 'text-dark' }}">
                            <i class="bi bi-person-circle me-2"></i> Mon Profil
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>

            @auth
            <div class="mt-auto p-3 border-top position-absolute bottom-0 w-100 bg-white">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start px-3">
                        <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                    </button>
                </form>
            </div>
            @endauth
        </nav>

        <div class="flex-grow-1">
            <header class="bg-white border-bottom p-3 d-flex justify-content-between align-items-center sticky-top">
                <div class="input-group w-50">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control bg-light border-0" placeholder="Rechercher sur Yowl...">
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    @auth
                        <div class="text-end d-none d-sm-block">
                            <span class="small fw-bold d-block">{{ Auth::user()->prenom }}</span>
                            <span class="text-muted" style="font-size: 0.75rem;">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                        <a href="{{ route('users.show', Auth::user()->id) }}">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.Auth::user()->prenom.'&background=5802f7&color=fff' }}" 
                                 class="rounded-circle border shadow-sm" width="40" height="40" style="object-fit: cover;">
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill btn-sm px-4">Connexion</a>
                        <a href="{{ route('register') }}" class="btn btn-primary rounded-pill btn-sm px-4">Inscription</a>
                    @endauth
                </div>
            </header>

            <main class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
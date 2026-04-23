<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yowl - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
   <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
</head>
<body class="bg-light">

    <div class="d-flex">
        <nav class="bg-white border-end vh-100 sticky-top" style="width: 280px;">
            <div class="p-3">
                <h3 class="fw-bold mb-4">Logo</h3>
                <ul class="nav flex-column gap-2">
                    <li class="nav-item"><a href="/" class="nav-link text-dark"><i class="bi bi-house-door me-2"></i> Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-secondary"><i class="bi bi-star me-2"></i> Saved <span class="badge bg-light text-dark float-end">24</span></a></li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark fw-bold"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                        <ul class="nav flex-column ms-4 small">
                            <li><a href="#" class="nav-link text-secondary">Trends</a></li>
                            <li><a href="#" class="nav-link text-secondary">Analytics</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a href="#" class="nav-link text-secondary"><i class="bi bi-plus-square me-2"></i> New post</a></li>
                </ul>
            </div>
            <div class="mt-auto p-3 border-top position-absolute bottom-0 w-100">
                <a href="#" class="nav-link text-secondary"><i class="bi bi-gear me-2"></i> Settings</a>
            </div>
        </nav>

        <div class="flex-grow-1">
            <header class="bg-white border-bottom p-3 d-flex justify-content-between align-items-center sticky-top">
                <div class="input-group w-50">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control bg-light border-0" placeholder="Search">
                </div>
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-bell fs-5"></i>
                    @auth
                        <span class="small fw-bold">{{ Auth::user()->prenom }}</span>
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->prenom }}" class="rounded-circle" width="35">
                    @endauth
                </div>
            </header>

            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
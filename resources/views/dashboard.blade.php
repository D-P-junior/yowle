@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="post-card shadow-sm p-5 bg-white rounded-4 border-0">
        <div class="text-center">
            <div class="mb-4">
                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.Auth::user()->prenom.'&background=0D8ABC&color=fff&size=128' }}" 
                     class="rounded-circle shadow" width="120" height="120" style="object-fit: cover;">
            </div>
            <h2 class="fw-bold text-dark">Bienvenue, {{ Auth::user()->prenom }} !</h2>
            <p class="text-muted">Ravi de vous revoir sur votre espace YOWL.</p>

            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="p-3 border rounded-4 bg-light">
                        <h3 class="fw-bold text-primary">{{ $publicationCount }}</h3>
                        <span class="text-muted small uppercase">Publications</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded-4 bg-light">
                        <h3 class="fw-bold text-success">{{ $commentsCount }}</h3>
                        <span class="text-muted small uppercase">Interactions</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded-4 bg-light">
                        <h3 class="fw-bold text-info">{{ $followerCount ?? 0 }}</h3>
                        <span class="text-muted small uppercase">Abonnés</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-5 d-flex justify-content-center gap-3">
                <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-house-door me-2"></i>Flux Yowl
                </a>
                <a href="{{ route('users.edit', Auth::user()->id) }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-pencil me-2"></i>Modifier profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
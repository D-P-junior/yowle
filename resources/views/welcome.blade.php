@extends('layouts.app')

@section('content')
<div class="feed-container">
  
    @auth
    <div class="post-card mb-4 shadow-sm p-4">
        <h5 class="fw-bold mb-3 text-dark">Partager un nouveau lien</h5>
        <form action="{{ route('commentaires.store') }}" method="POST">
            @csrf
            <input type="url" name="lien" class="form-control mb-3 shadow-sm border-0 bg-light" style="border-radius: 12px;" placeholder="https://..." required>
            <textarea name="content" class="form-control mb-3 shadow-sm border-0 bg-light" style="border-radius: 12px; height: 100px;" placeholder="Qu'en pensez-vous ?"></textarea>
            <button class="btn btn-primary rounded-pill px-5 fw-bold">Propulser sur YOWL</button>
        </form>
    </div>
    @endauth

    @foreach($commentaires as $commentaire)
    <div class="post-card mb-4 shadow-sm" id="comment-{{ $commentaire->id }}">
        <div class="post-header p-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('users.show', $commentaire->user->id) }}">
                    <img src="{{ $commentaire->user->avatar ? asset('storage/' . $commentaire->user->avatar) : 'https://ui-avatars.com/api/?name='.$commentaire->user->prenom.'&background=0D8ABC&color=fff' }}" 
                         class="rounded-circle shadow-sm" width="45" height="45" style="object-fit: cover;">
                </a>
                <div class="post-info">
                    <strong class="d-block text-dark">{{ $commentaire->user->prenom }} {{ $commentaire->user->nom }}</strong>
                    <span class="text-muted small">{{ $commentaire->created_at->diffForHumans() }}</span>
                </div>
            </div>

            @if(auth()->check() && auth()->id() === $commentaire->user_id)
            <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST" onsubmit="return confirm('Supprimer ce post ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-link text-danger p-0 shadow-none"><i class="bi bi-trash3 fs-5"></i></button>
            </form>
            @endif
        </div>

        <div class="px-4 pb-4">
            <p class="text-secondary mb-3">{{ $commentaire->content }}</p>

            @if($commentaire->lien)
            <div class="border rounded-4 p-3 bg-light mt-2 mb-3 shadow-sm link-embed">
                <a href="{{ route('commentaires.show', $commentaire->id) }}" class="text-decoration-none d-flex align-items-center gap-3">
                    <img src="https://www.google.com/s2/favicons?domain={{ $commentaire->lien }}&sz=64" width="32" class="rounded">
                    <div class="overflow-hidden">
                        <span class="d-block text-dark fw-bold small text-truncate">{{ $commentaire->lien }}</span>
                        <span class="text-primary fw-bold" style="font-size: 0.7rem;">Voir l'aperçu complet <i class="bi bi-arrow-right"></i></span>
                    </div>
                </a>
            </div>
            @endif

            <div class="post-footer d-flex gap-4 pt-3 border-top">
               
                <div class="d-flex align-items-center gap-2">
                    <button class="btn-like border-0 bg-transparent text-muted"><i class="bi bi-arrow-up-circle fs-5"></i></button>
                    <span class="small fw-bold text-muted">0</span>
                    <button class="btn-dislike border-0 bg-transparent text-muted"><i class="bi bi-arrow-down-circle fs-5"></i></button>
                </div>

                <button class="border-0 bg-transparent text-muted"><i class="bi bi-share fs-5"></i></button>
                
                <a href="{{ route('commentaires.show', $commentaire->id) }}" class="text-decoration-none text-muted d-flex align-items-center gap-1 ms-auto">
                    <i class="bi bi-chat-left-text fs-5"></i>

                    <span class="small fw-bold">{{ $commentaire->total_comments_count }}</span>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
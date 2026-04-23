@extends('layouts.app')

@section('content')
<div class="feed-container mt-4">
    
    <div class="post-card shadow-sm mb-4 p-4 border-0 bg-white rounded-4">
        <div class="d-flex align-items-center gap-3 mb-3">
            <img src="{{ $post->user->avatar ? asset('storage/' . $post->user->avatar) : 'https://ui-avatars.com/api/?name='.$post->user->prenom.'&background=0D8ABC&color=fff' }}" 
                 class="rounded-circle shadow-sm" width="50" height="50" style="object-fit: cover;">
            
            <div>
                <strong class="d-block text-dark">{{ $post->user->prenom }} {{ $post->user->nom }}</strong>
                <span class="small text-muted">{{ $post->created_at->diffForHumans() }}</span>
            </div>
        </div>
        
        <p class="fs-5 text-dark mb-4">{{ $post->content }}</p>

        @if($embedData)
        <div class="link-preview-card border rounded-4 overflow-hidden shadow-sm bg-light mb-3">
            <a href="{{ $embedData->url }}" target="_blank" class="text-decoration-none">
                <div class="row g-0">
                    @if($embedData->image)
                    <div class="col-md-4">
                        <img src="{{ $embedData->image }}" class="img-fluid h-100 w-100" style="object-fit: cover; min-height: 200px;">
                    </div>
                    @endif
                    <div class="{{ $embedData->image ? 'col-md-8' : 'col-12' }} p-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            @if($embedData->favicon) <img src="{{ $embedData->favicon }}" width="16"> @endif
                            <span class="text-primary small fw-bold text-uppercase">{{ $embedData->providerName ?? parse_url($embedData->url, PHP_URL_HOST) }}</span>
                        </div>
                        <h4 class="text-dark fw-bold mb-2">{{ $embedData->title }}</h4>
                        <p class="text-muted small mb-0">{{ Str::limit($embedData->description, 200) }}</p>
                    </div>
                </div>
            </a>
        </div>
        @elseif($post->lien)
            <div class="alert alert-light border rounded-4 mb-3">
                <i class="bi bi-link-45deg"></i> <a href="{{ $post->lien }}" target="_blank">{{ $post->lien }}</a>
            </div>
        @endif

        <div class="d-flex align-items-center gap-4 text-muted border-top pt-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-emoji-smile fs-5 cursor-pointer"></i>
                <span class="small fw-bold">{{ ($post->likes_count ?? 0) + ($post->dislikes_count ?? 0) }}</span>
            </div>
            <i class="bi bi-share fs-5 cursor-pointer"></i>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-chat fs-5"></i>
                <span class="small fw-bold">{{ $post->total_comments_count ?? 0 }}</span>
            </div>
        </div>
    </div>

    @auth
    <div class="post-card mb-4 border-start border-primary border-5 p-4 shadow-sm bg-white rounded-4">
        <h6 class="fw-bold mb-3 d-flex justify-content-between">
            <span><i class="bi bi-reply-fill me-2"></i>Laisser un commentaire</span>
            <span class="badge bg-light text-dark">{{ $post->total_comments_count }} commentaires</span>
        </h6>
        
        <form action="{{ route('commentaires.store') }}" method="POST">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $post->id }}">
            <input type="hidden" name="lien" value="{{ $post->lien }}">
            <div class="d-flex gap-2">
                <input type="text" name="content" class="form-control rounded-pill border-light bg-light px-4" placeholder="Votre commentaire..." required>
                <button type="submit" class="btn btn-primary rounded-circle"><i class="bi bi-send-fill"></i></button>
            </div>
        </form>
    </div>
    @endauth

    <div class="replies-tree">
        @foreach($post->replies as $reply)
            @include('partials.comment-item', ['comment' => $reply, 'level' => 0])
        @endforeach
    </div>
</div>
@endsection
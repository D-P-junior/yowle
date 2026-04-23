<div id="comment-{{ $comment->id }}" class="comment-thread mt-3" style="margin-left: {{ $level * 40 }}px; position: relative;">
    {{-- Arborescence visuelle --}}
    @if($level > 0)
        <div style="position: absolute; left: -25px; top: -15px; width: 20px; height: 40px; border-left: 2px solid #dee2e6; border-bottom: 2px solid #dee2e6; border-bottom-left-radius: 15px;"></div>
    @endif

    <div class="d-flex gap-3">
       
        <img src="{{ $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : 'https://ui-avatars.com/api/?name='.$comment->user->prenom.'&background=0D8ABC&color=fff' }}" 
             class="rounded-circle shadow-sm" width="45" height="45" style="object-fit: cover;">
        
        <div class="p-3 rounded-4 shadow-sm flex-grow-1" style="background: #f8f9fa; border: 1px solid #eee;">
            <div class="d-flex justify-content-between">
                <strong class="small text-primary fw-bold">{{ $comment->user->prenom }} {{ $comment->user->nom }}</strong>
                
                @if(auth()->check() && auth()->id() === $comment->user_id)
                <div class="d-flex gap-2">
                    <button class="btn btn-sm p-0 text-muted" onclick="document.getElementById('edit-form-{{ $comment->id }}').classList.toggle('d-none')">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="{{ route('commentaires.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm p-0 text-danger"><i class="bi bi-trash3"></i></button>
                    </form>
                </div>
                @endif
            </div>

            <p class="mb-2 small text-dark mt-1">{{ $comment->content }}</p>

            <div class="d-flex align-items-center justify-content-between mt-2">
                <small class="fw-bold cursor-pointer text-muted" style="font-size: 0.75rem;" onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('d-none')">
                    Repondre
                </small>
                
                <div class="d-flex gap-3 text-muted align-items-center">
                 
                    <form action="{{ route('commentaires.like', $comment->id) }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 text-muted text-decoration-none d-flex align-items-center gap-1">
                            <i class="bi bi-hand-thumbs-up fs-6"></i>
                            <span class="small">{{ $comment->likes_count ?? 0 }}</span>
                        </button>
                    </form>

                    <form action="{{ route('commentaires.dislike', $comment->id) }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 text-muted text-decoration-none d-flex align-items-center gap-1">
                            <i class="bi bi-hand-thumbs-down fs-6"></i>
                            <span class="small">{{ $comment->dislikes_count ?? 0 }}</span>
                        </button>
                    </form>
                </div>
            </div>

            <form id="reply-form-{{ $comment->id }}" action="{{ route('commentaires.store') }}" method="POST" class="mt-2 d-none">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <input type="hidden" name="lien" value="{{ $comment->lien ?? '#' }}"> 
                <div class="input-group">
                    <input type="text" name="content" class="form-control form-control-sm rounded-pill px-3" placeholder="Votre réponse..." required>
                    <button type="submit" class="btn btn-sm btn-primary rounded-circle ms-1"><i class="bi bi-send-fill"></i></button>
                </div>
            </form>
        </div>
    </div>

    @if($comment->replies->count() > 0)
        @foreach($comment->replies as $subReply)
            @include('partials.comment-item', ['comment' => $subReply, 'level' => $level + 1])
        @endforeach
    @endif
</div>
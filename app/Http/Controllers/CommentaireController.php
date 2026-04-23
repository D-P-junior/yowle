<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;
use Embed\Embed;

class CommentaireController extends Controller
{
    public function show($id)
    {
    
        $post = Commentaire::with([
                'user', 
                'replies' => function($query) {
                    $query->withCount(['likes', 'dislikes']);
                },
                'replies.user',
                'allReplies' => function($query) {
                    $query->withCount(['likes', 'dislikes']);
                },
                'allReplies.user'
            ])
            ->withCount(['likes', 'dislikes']) 
            ->findOrFail($id);

        $embedData = null;
        if ($post->lien) {
            try {
                $embed = new \Embed\Embed();
                $embedData = $embed->get($post->lien);
            } catch (\Exception $e) {
                
            }
        }

        return view('commentaires.show', compact('post', 'embedData'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'lien' => 'nullable|url',
            'parent_id' => 'nullable|exists:commentaires,id', 
        ]);

        $commentaire = Commentaire::create([
            'content' => $validated['content'],
            'user_id' => auth()->id(), 
            'parent_id' => $request->parent_id, 
            'lien' => $request->lien ?? '',
        ]);

        return redirect(url()->previous() . '#comment-' . $commentaire->id)
               ->with('success', 'Publié !');
    }

    public function update(Request $request, $id)
    {
        $commentaire = Commentaire::findOrFail($id);
        if (auth()->id() !== $commentaire->user_id) return back();

        $validated = $request->validate(['content' => 'required|string|max:1000']);
        $commentaire->update(['content' => $validated['content']]);

        return back()->with('success', 'Modifié !');
    }

    public function destroy($id)
    {
        $commentaire = Commentaire::findOrFail($id);
        if (auth()->id() !== $commentaire->user_id) return back();
        
        $commentaire->delete();
        return back()->with('success', 'Supprimé !');
    }

public function like($id)
{
    \App\Models\CommentLike::updateOrCreate(
        ['user_id' => auth()->id(), 'commentaire_id' => $id],
        ['is_like' => true]
    );
    return back();
}

public function dislike($id)
{
    \App\Models\CommentLike::updateOrCreate(
        ['user_id' => auth()->id(), 'commentaire_id' => $id],
        ['is_like' => false]
    );
    return back();
}
}
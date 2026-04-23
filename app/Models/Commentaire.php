<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'parent_id', 
        'content', 
        'lien' 
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function replies() {
        return $this->hasMany(Commentaire::class, 'parent_id')->latest();
    }

    public function allReplies() {
        return $this->replies()->with('allReplies');
    }

    public function getTotalCommentsCountAttribute() {
        $count = $this->replies->count();
        foreach ($this->replies as $reply) {
            $count += $reply->total_comments_count;
        }
        return $count;
    }

    public function parent() {
        return $this->belongsTo(Commentaire::class, 'parent_id');
    }

public function likes() {
    return $this->hasMany(CommentLike::class)->where('is_like', true);
}

public function dislikes() {
    return $this->hasMany(CommentLike::class)->where('is_like', false);
}
}
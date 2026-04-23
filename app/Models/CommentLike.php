<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    
    protected $fillable = ['user_id', 'commentaire_id', 'is_like'];

    public function commentaire()
    {
        return $this->belongsTo(Commentaire::class);
    }


public function likes() {
    return $this->hasMany(CommentLike::class)->where('is_like', true);
}

public function dislikes() {
    return $this->hasMany(CommentLike::class)->where('is_like', false);
}
}
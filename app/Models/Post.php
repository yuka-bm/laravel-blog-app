<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    # a post belongs to a user
    # get the owner of a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    # retrieves all comments from a post
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    //post belongs to user
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    //post has many category_posts
    public function categoryPosts(){
        return $this->hasMany(CategoryPost::class);
    }

    //post has many comments
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    //post has many likes
    public function likes(){
        return $this->hasMany(Like::class);
    }

    //return true if post is liked
    public function isLiked(){
       return $this->likes()->where('user_id', Auth::user()->id)->exists();
       // $this-> = calling object (the post)
       // likes() = get all likes of the post
       // where() = in those likes, which one is logged-in user?
       //exists() = return true if where() has found a record

    }
}

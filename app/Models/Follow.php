<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    public $timestamps = false;

    //follow belongs to user (paired with follows())
    public function user(){
        return $this->belongsTo(User::class, 'followed_id')->withTrashed();
    }

    //follow belongs to user (paired with followers())
    public function follower(){
        return $this->belongsTo(User::class, 'follower_id')->withTrashed();
    }
}

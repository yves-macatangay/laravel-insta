<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;
    public $timestamps = false; //no timestamp columns
    protected $table = "category_post";
    protected $fillable = ['category_id', 'post_id']; //to be used for create( function)

    //categoryPost belongs to category
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //categoryPost belongs to post (not going to be used)
    public function post(){
        return $this->belongsTo(Post::class);
    }
}

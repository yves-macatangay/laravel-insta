<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    protected $table = "category_post";
    //because the table name is singular, indicate the table name
    public $timestamps = false; //do not save timestamps
    protected $fillable = ['category_id', 'post_id'];
    //list of columns to save, when using create() function

    //category_post belongs to category
    public function category(){
        return $this->belongsTo(Category::class);
    }
}

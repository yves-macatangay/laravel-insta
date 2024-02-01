<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
    private $category;
    private $post;

    public function __construct(Category $category, Post $post){
        $this->category = $category; // $this->category = new Category
        $this->post = $post;
    }

    public function index(){
        $all_categories = $this->category->orderBy('name')->paginate(10);

        $all_posts = $this->post->all();
        $uncategorized_count = 0;
        foreach($all_posts as $p){
            if($p->categoryPosts->count() == 0){
                $uncategorized_count++; //add 1 to uncategorized_count
            }
        }

        return view('admin.categories.index')
            ->with('all_categories', $all_categories)
            ->with('uncategorized_count', $uncategorized_count);
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|max:50|unique:categories,name'
        ]);

        $this->category->name = $request->name;
        $this->category->save();

        return redirect()->route('admin.categories');
    }

    public function destroy($id){
        $this->category->destroy($id);

        return redirect()->back();
    }

    public function update(Request $request, $id){

        $request->validate([
            'categ_name'.$id => 'required|max:50|unique:categories,name,'.$id
        ],[
            'categ_name'.$id.'.required' => 'Name cannot be blank',
            'categ_name'.$id.'.max' => 'Name must be up to 50 characters only',
            'categ_name'.$id.'.unique' => 'Name must be unique'
            //name.rule
        ]);

        $categ = $this->category->findOrFail($id);

        $categ->name = $request->input('categ_name'.$id);
        $categ->save();

        return redirect()->back();
    }
}

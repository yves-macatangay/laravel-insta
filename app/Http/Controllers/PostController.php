<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Post $post, Category $categ){
        $this->post = $post;
        $this->category = $categ;
    }

    public function create(){

        $all_categories = $this->category->all();

        return view('user.posts.create')
            ->with('all_categories', $all_categories);
    }

    public function store(Request $request){

        //validation rules
        $request->validate([
            'description' => 'required|max:1000',
            'image' => 'required|max:1048|mimes:jpeg,jpg,png,gif',
            'category_id' => 'required|array|between:1,3'
            //between = min and max items in the array
        ]);

        $this->post->description = $request->description;
        $this->post->user_id = Auth::user()->id; //$_SESSION[]
        $this->post->image = 'data:image/'.$request->image->extension().
                            ';base64,'.base64_encode(file_get_contents($request->image));
                               //convert image to longtext
        $this->post->save();

        //save categorypost
        $category_post = []; //empty array
        foreach($request->category_id as $categ_id){
            $category_post[] = ['category_id' => $categ_id];
        }
        // $category_post = [
        //     [
        //         'category_id' => 1,
        //         'post_id' =>
        //     ],
        //     [
        //         'category_id' => 2,
        //         'post_id' =>
        //     ],
        // ];
        $this->post->categoryPosts()->createMany($category_post);

        //go back to index
        return redirect()->route('index');
    }

    public function show($id){
        $post_a = $this->post->findOrFail($id);
        //SELECT * FROM posts WHERE id=$id

        return view('user.posts.show')->with('post', $post_a);
    }

    public function edit($id){
        //data of post
        $post_a = $this->post->findOrFail($id);

        //list of all categories
        $all_categories = $this->category->all();

        //list of selected categories
        $selected_categories = [];
        foreach($post_a->categoryPosts as $category_post){
            $selected_categories[]= $category_post->category_id;
        }

        return view('user.posts.edit')
                ->with('post', $post_a)
                ->with('all_categories', $all_categories)
                ->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id){

        //validation
        $request->validate([
            'description' => 'required|max:1000',
            'image' => 'max:1048|mimes:jpeg,jpg,png,gif',
            'category_id' => 'required|array|between:1,3'
        ]);

        //find the record to update
        $post_a = $this->post->findOrFail($id);

        $post_a->description = $request->description;
        //check if form has new image update
        if($request->image){
            $post_a->image = 'data:image/'.$request->image->extension().
                            ';base64,'.base64_encode(file_get_contents($request->image));
        }
        $post_a->save();

        //delete categoryPosts
        $post_a->categoryPosts()->delete();

        //add categoryPosts
        $category_posts = [];
        foreach($request->category_id as $categ_id){
            $category_posts[]= ['category_id' => $categ_id];
        }
        // $category_posts = [
        //     [
        //         'category_id' => 1
        //     ],
        //     [
        //         'category_id' => 2
        //     ]
        // ];
        $post_a->categoryPosts()->createMany($category_posts);

        //go to post show
        return redirect()->route('post.show', $id);
    }

    public function destroy($id){
        //$this->post->destroy($id);
        // OR
        // $post_a = $this->post->findOrFail($id);
        // $post_a->delete();

        $post_a = $this->post->findOrFail($id);
        $post_a->forceDelete();

        return redirect()->route('index');
    }
}

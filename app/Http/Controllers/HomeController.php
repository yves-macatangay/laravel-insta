<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        // $this->middleware('auth');
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->search){
            //search data
            $home_posts = $this->post->where('description', 'LIKE', '%'.$request->search.'%')->get();
            //SELECT * FROM posts WHERE description LIKE '%farm%'
            //regex/regular expressions

        }else{
            $all_posts = $this->post->latest()->get();
            // all posts ordered by latest

            $home_posts = [];
            foreach($all_posts as $p){
                if($p->user_id == Auth::user()->id || $p->user->isFollowed()){
                    $home_posts []= $p;
                }
            }
        }
        $suggested_users = array_slice($this->suggested_users(), 0, 10);

        return view('user.index')->with('all_posts', $home_posts)
                                ->with('suggested_users', $suggested_users)
                                ->with('search', $request->search);
    }

    private function suggested_users(){
        $suggested_users = [];

        //get all users except logged-in user
        $all_users = $this->user->all()->except(Auth::user()->id);

        foreach($all_users as $u){
            if(!$u->isFollowed()){
                $suggested_users []= $u;
            }
        }

        return $suggested_users;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function show($id){
        $user_a = $this->user->findOrFail($id);

        return view('user.profile.show')->with('user', $user_a);
    }

    public function edit(){
        return view('user.profile.edit');
    }

    public function update(Request $request){

        //validation
        $request->validate([
            'avatar' => 'max:1048|mimes:jpeg,jpg,png,gif',
            'name' => 'required|max:50',
            'introduction' => 'max:100',
            'email' => 'required|max:50|email|unique:users,email,'.Auth::user()->id
            //users,email,1  | [table name], [column name], [id]
            //use exception (id) when updating, but not when creating new record
            //(when creating > unique:users,email)
        ]);

        //ACTIVITY: update profile
        //1. finish validation (validation in view)
        //2. update profile 
        //    - avatar - image convert to longtext
        //3. after updating, redirect to profile page (show profile)

        $user_a = $this->user->findOrFail(Auth::user()->id);

        if($request->avatar){ //if form has submitted new avatar
            $user_a->avatar = 'data:image/'.$request->avatar->extension().
                                ';base64,'.base64_encode(file_get_contents($request->avatar));
        }
        $user_a->name = $request->name;
        $user_a->email = $request->email;
        $user_a->introduction = $request->introduction;
        
        $user_a->save();

        return redirect()->route('profile.show', Auth::user()->id);

    }

    public function following($id){ //user id
        $user_a = $this->user->findOrFail($id);

        return view('user.profile.following')->with('user', $user_a);
    }

    public function followers($id){ //user id
        $user_a = $this->user->findOrFail($id);

        return view('user.profile.followers')->with('user', $user_a);
    }

    public function updatePassword(Request $request){

        // * That is not your current password.
        $user_a = $this->user->findOrFail(Auth::user()->id);
        if(!Hash::check($request->old_password, $user_a->password)){ //if not current password
            //send error message  
            return redirect()->back()->with('incorrect_password_error', 'That is not your current password.'); 
        }

        // * New password cannot be the same as current password.
        if($request->old_password == $request->new_password){
            //send error message
            return redirect()->back()->with('same_password_error', 'New password cannot be the same as current password.');
        }

        // * New password does not match
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed'
            //confirmed - matches 2 inputs with similar names (x and x_confirmation)
        ]);

        $user_a->password = Hash::make($request->new_password);
        $user_a->save();

        return redirect()->back()->with('password_change_success', 'Changed password successfully!');
    }
}

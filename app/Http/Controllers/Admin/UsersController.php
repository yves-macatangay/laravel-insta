<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(Request $request){

        if($request->search){
            $all_users = $this->user->orderBy('name')
                                    ->where('name', 'LIKE', '%'.$request->search.'%')
                                    ->withTrashed()->paginate(10);
        }else{
            $all_users = $this->user->orderBy('name')->withTrashed()->paginate(10); //get all users, ordered by name
        //get() -> gets all data
        //paginate(n) -> gets data of page with n no. of items
        //withTrashed() -> includes soft-deleted records to a list, etc.
        }
        return view('admin.users.index')->with('all_users', $all_users)
                                        ->with('search', $request->search);
    }

    public function deactivate($id){
        $this->user->destroy($id);

        return redirect()->back(); //go back to previous page (even with pagination)
    }

    public function activate($id){
        //restore() -> undo a soft-delete
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        //onlyTrashed() - only return soft-deleted records

        return redirect()->back();
    }
}

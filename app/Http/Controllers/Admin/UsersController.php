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
            $all_users = $this->user->where('name', 'LIKE', '%'.$request->search.'%')
                            ->orderBy('name')->withTrashed()->paginate(10);
        }else{
            //all users ordered by name
            $all_users = $this->user->orderBy('name')->withTrashed()->paginate(10);
            //get() - return all data
            //paginate(n) - return n number of data
            //withTrashed() - include soft-deleted records in the list
        }

        return view('admin.users.index')->with('all_users', $all_users)
                                        ->with('search', $request->search);
    }

    public function deactivate($id){
        $this->user->destroy($id);

        return redirect()->back();
    }

    public function activate($id){
        //activate or restore a soft-deleted record
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        //onlyTrash - get only inactive records
        //restore() - restores inactive record

        return redirect()->back();
    }
}

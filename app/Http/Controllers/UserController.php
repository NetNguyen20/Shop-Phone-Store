<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\Else_;

class UserController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    
    public function index(){
        $admin = Admin::with('roles')->orderBy('admin_id','DESC')->paginate(5);
        return view('admin.users.all_users')->with(compact('admin'));
    }
    
    public function add_users(){
        return view('admin.users.add_users');

    }

    public function assign_roles(Request $request){
        if(Auth::id()==$request->admin_id){
            return redirect()->back()->with('message','Do not assign role yourself!!!');
        }

        
        $user = Admin::where('admin_email',$request['admin_email'])->first();
        $user->roles()->detach();
        if($request['admin_roles']){
            $user->roles()->attach(Roles::where('name','admin')->first());
        }
        if($request['staff_roles']){
            $user->roles()->attach(Roles::where('name','staff')->first());
        }
        if($request['user_roles']){
            $user->roles()->attach(Roles::where('name','user')->first());
        }

        return redirect()->back()->with('message','Assign roles success');
    }

    public function store_users(Request $request){
        $data = $request->all();
        $admin = new Admin();
        $admin->admin_name = $data['admin_name'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_password = md5($data['admin_password']);
        $admin->save();
        $admin->roles()->attach(Roles::where('name','user')->first());
        Session::put('message','Add users success');
        return Redirect::to('users');

    }

    public function delete_users_roles($admin_id){
        if(Auth::id()==$admin_id){
            return redirect()->back()->with('message','Do not delete yourself!!!');
        }
        $admin = Admin::find($admin_id);

        if($admin){
            $admin->roles()->detach();
            $admin->delete();
        }
        return redirect()->back()->with('message','Delete user success');

    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;

class AuthController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function register_auth(){
        return view('admin.auth.register');
    }

    public function register(Request $request){
        $this->validation($request);
        $data = $request->all();
        
        $admin = new Admin();
        $admin->admin_name = $data['admin_name'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_password = md5($data['admin_password']);

        $admin -> save();
        return redirect('/register-auth')->with('message','Register account Auth success');
    }

    public function validation($request){
        return $this->validate($request,[
            'admin_name' => 'required|max:255',
            'admin_phone' => 'required|max:255',
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|max:255',

        ]);
    }

    public function admin(Request $request){
        return view('admin.auth.login');
    }

    public function login(Request $request){
        $this->validate($request,[
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|max:255',

        ]);
        // $data = $request->all();
        if(Auth::attempt(['admin_email'=> $request->admin_email,'admin_password'=> $request->admin_password])){
            return redirect('/dashboard');
        }else{
            return redirect('/admin')->with('message','Password or account is wrong. Please re-enter');
        }
    }

    public function logout_auth(){
        Auth::logout();
        return redirect('/admin')->with('message','Successful logout');
    }

}

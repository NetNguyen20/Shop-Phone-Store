<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\MenuPost;

class MenuPostController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_menu_post(){
        $this->AuthLogin();
    	return view('admin.post.add_menu_post');
    }

    public function all_menu_post(){
        $this->AuthLogin();
        $all_menu_post = MenuPost::orderBy('menu_post_id','DESC')->paginate(5);

    	return view('admin.post.list_menu_post')->with(compact('all_menu_post'));

    }

    public function save_menu_post(Request $request){
        $this->AuthLogin();
    	$data = $request->all();

        $menu_post = new MenuPost();
        $menu_post->menu_post_name = $data['menu_post_name'];
        $menu_post->menu_post_desc = $data['menu_post_desc'];
        $menu_post->menu_post_slug = $data['menu_post_slug'];
        $menu_post->menu_post_status = $data['menu_post_status'];
        $menu_post->save();


    	Session::put('message','Add successful menu post');
    	return Redirect()->back();
    }
   
    public function edit_menu_post($menu_post_id){
        $this->AuthLogin();
        $edit_menu_post =  MenuPost::find($menu_post_id);

        return view('admin.post.edit_menu_post')->with(compact('edit_menu_post'));
    }

    public function update_menu_post(Request $request, $menu_post_id){
        $data = $request->all();

        $update_nemu_post = MenuPost::find($menu_post_id);
        $update_nemu_post->menu_post_name = $data['menu_post_name'];
        $update_nemu_post->menu_post_desc = $data['menu_post_desc'];
        $update_nemu_post->menu_post_slug = $data['menu_post_slug'];
        $update_nemu_post->menu_post_status = $data['menu_post_status'];
        $update_nemu_post->save();

        Session::put('message','Update successful menu post');
        return redirect('/all-menu-post');
    }
  
    public function delete_menu_post($menu_post_id){
        $update_nemu_post = MenuPost::find($menu_post_id);
        $update_nemu_post->delete();

        Session::put('message','Delete successful menu post');
        return redirect()->back();
    }
    public function danh_muc_menu_post($menu_post_slug){

    }
}

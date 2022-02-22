<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\MenuPost;
use App\Models\Post;

class PostController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Auth::id();
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function add_post()
    {
        $this->AuthLogin();
        $menu_post = MenuPost::orderBy('menu_post_id','DESC')->get();


        return view('admin.post.add_post')->with(compact('menu_post'));
    }

    public function all_post()
    {
        $this->AuthLogin();
        $all_post = Post::with('menu_post')->orderby('post_id')->paginate(5);
            
        return view('admin.post.list_post')->with(compact('all_post', $all_post));
    }

    public function save_post(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $post = new Post();
        
        $post->post_title = $data['post_title'];
        $post->post_slug = $data['post_slug'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_meta_desc = $data['post_meta_desc'];
        $post->post_meta_keywords = $data['post_meta_keywords'];
        $post->post_status = $data['post_status'];
        $post->menu_post_id = $data['menu_post_id'];

        $get_image = $request->file('post_image');

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName(); //get image name
            $name_image = current(explode('.', $get_name_image)); //get the first name of the image ex:current(anh1) end(.jpg)
            $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); //random from 0 to 99 OriginalExtension duoi mo rong
            $get_image->move('public/uploads/post', $new_image); //di toi cho luu anh do
            $post->post_image = $new_image; //luu ten moi vao co so du lieu
            $post->save();
            Session::put('message', 'Add successful post');
            return redirect()->back();

        }else{

            Session::put('message', 'Please add image post!!!');
            return redirect()->back();
        }

    }


    public function edit_product($product_id)
    {
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();

        $edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();

        $manager_product  = view('admin.product.edit_product')->with('edit_product', $edit_product)->with('cate_product', $cate_product)->with('brand_product', $brand_product);

        return view('admin_layout')->with('admin.product.all_product', $manager_product);
    }

    public function update_post(Request $request, $post_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $post = Post::find($post_id);
        
        $post->post_title = $data['post_title'];
        $post->post_slug = $data['post_slug'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_meta_desc = $data['post_meta_desc'];
        $post->post_meta_keywords = $data['post_meta_keywords'];
        $post->post_status = $data['post_status'];
        $post->menu_post_id = $data['menu_post_id'];

        $get_image = $request->file('post_image');

        if ($get_image) {
            //delete image old
            $post_image_old = $post->post_image;
            $delete = 'public/uploads/post/'.$post_image_old;
            unlink($delete);
            
            //update image new
            $get_name_image = $get_image->getClientOriginalName(); //get image name
            $name_image = current(explode('.', $get_name_image)); //get the first name of the image ex:current(anh1) end(.jpg)
            $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); //random from 0 to 99 OriginalExtension duoi mo rong
            $get_image->move('public/uploads/post', $new_image); //di toi cho luu anh do
            $post->post_image = $new_image; //luu ten moi vao co so du lieu
            
        }
        $post->save();
        Session::put('message', 'Update successful post');
        return redirect()->back();

    }
    public function delete_post($post_id)
    {
        $this->AuthLogin();

        $post = Post::find($post_id);
        $post_image = $post->post_image;
        if($post_image){
            $delete = 'public/uploads/post/'.$post_image;
            unlink($delete);
        }

        $post->delete();
        
        Session::put('message', 'Delete post successfully');
        return redirect()->back();
    }

    public function edit_post($post_id){
        $menu_post = MenuPost::orderby('menu_post_id')->get();
        $post = Post::find($post_id);
        return view('admin.post.edit_post')->with(compact('post','menu_post'));
    }

    public function danh_muc_post(Request $request, $post_slug){
        //menu post
        $menu_post = MenuPost::orderBy('menu_post_id','DESC')->get();
         //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

        $menupost = MenuPost::where('menu_post_slug',$post_slug)->take(1)->get();

        foreach($menupost as $key => $menu){
            //seo 
            $meta_desc = $menu->menu_post_desc; 
            $meta_keywords = $menu->menu_post_slug;
            $meta_title = $menu->menu_post_name;
            $menu_id = $menu->menu_post_id;
            $url_canonical = $request->url();
            //--seo
        }
        $post = Post::with('menu_post')->where('post_status',0)->where('menu_post_id',$menu_id)->paginate(5);

        return view('pages.post.menu_post')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)
        ->with('slider',$slider)->with('menu_post',$menu_post)->with('post',$post);
    }

    public function see_post(Request $request, $post_slug){
        //menu post
        $menu_post = MenuPost::orderBy('menu_post_id','DESC')->get();
         //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

        // $menupost = MenuPost::where('menu_post_slug',$post_slug)->take(1)->get();
        $post = Post::with('menu_post')->where('post_status',0)->where('post_slug',$post_slug)->take(1)->get();

        foreach($post as $key => $po){
            //seo 
            $meta_desc = $po->post_meta_desc; 
            $meta_keywords = $po->post_meta_keywords;
            $meta_title = $po->post_title;
            $menu_id = $po->menu_post_id;
            $url_canonical = $request->url();
            //--seo
        }

        return view('pages.post.see_post')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)
        ->with('slider',$slider)->with('menu_post',$menu_post)->with('post',$post);
    }
    
}

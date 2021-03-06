<?php

namespace App\Http\Controllers;

use App\Models\MenuPost;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Category;

session_start();

class CategoryProduct extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    
    public function add_category_product(){
        $this->AuthLogin();
    	return view('admin.category.add_category_product');
    }
    public function all_category_product(){
        $this->AuthLogin();
    	$all_category_product = DB::table('tbl_category_product')->get();
    	$manager_category_product  = view('admin.category.all_category_product')->with('all_category_product',$all_category_product);
    	return view('admin_layout')->with('admin.category.all_category_product', $manager_category_product);


    }
    public function save_category_product(Request $request){
        $this->AuthLogin();
    	$data = array();

    	$data['category_name'] = $request->category_product_name;
        $data['meta_keywords'] = $request->category_product_keywords;
        $data['slug_category_product'] = $request->slug_category_product;
    	$data['category_desc'] = $request->category_product_desc;
    	$data['category_status'] = $request->category_product_status;

    	DB::table('tbl_category_product')->insert($data);
    	Session::put('message','Add successful product categories');
    	return Redirect::to('all-category-product');
    }

    public function unactive_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>1]);
        Session::put('message','Product category not activated successfully');
        return Redirect::to('all-category-product');

    }

    public function active_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>0]);
        Session::put('message','Product category activation successful');
        return Redirect::to('all-category-product');
    }

    public function edit_category_product($category_product_id){
        $this->AuthLogin();
        $edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();

        $manager_category_product  = view('admin.category.edit_category_product')->with('edit_category_product',$edit_category_product);

        return view('admin_layout')->with('admin.category.edit_category_product', $manager_category_product);
    }

    public function update_category_product(Request $request,$category_product_id){
        $this->AuthLogin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['meta_keywords'] = $request->category_product_keywords;
        $data['slug_category_product'] = $request->slug_category_product;
        $data['category_desc'] = $request->category_product_desc;
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        Session::put('message','Product category update successfully');
        return Redirect::to('all-category-product');
    }
    
    public function delete_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->delete();
        Session::put('message','Delete product category successfully');
        return Redirect::to('all-category-product');
    }

    //End Function Admin Page
    public function show_category_home(Request $request , $slug_category_product){
        //menu post
        $menu_post = MenuPost::orderBy('menu_post_id','DESC')->get();
       //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        $category_by_slug = Category::where('slug_category_product',$slug_category_product)->get();
        $min_price = Product::min('product_price');
        $max_price = Product::min('product_price');

        foreach($category_by_slug as $key => $cate){
            $category_id = $cate->category_id;
        } 

        if(isset($_GET['sort_by'])){
            $sort_by = $_GET['sort_by'];

            if($sort_by=='by_descending'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_price','DESC')->paginate(6)
                ->appends(request()->query());
            }elseif($sort_by=='by_ascending'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_price','ASC')->paginate(6)
                ->appends(request()->query());
            }elseif($sort_by=='characters_za'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_name','DESC')->paginate(6)
                ->appends(request()->query());
            }elseif($sort_by=='characters_az'){
                $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_name','ASC')->paginate(6)
                ->appends(request()->query());
            }

        }elseif(isset($_GET['min_price']) && ($_GET['max_price'])){
            $low_price = $_GET['min_price'];
            $high_price = $_GET['max_price'];

            $category_by_id = Product::with('category')->whereBetween('product_price',[$low_price,$high_price])->orderBy('product_price','ASC')
            ->paginate(6);

        }else{
            $category_by_id = Product::with('category')->where('category_id',$category_id)->orderBy('product_name','DESC')->paginate(6);
        }

        // $category_by_id = DB::table('tbl_product')->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')
        // ->where('tbl_category_product.slug_category_product',$slug_category_product)->paginate(6);
     
        foreach($cate_product as $key => $val){
                //seo 
                $meta_desc = $val->category_desc; 
                $meta_keywords = $val->meta_keywords;
                $meta_title = $val->category_name;
                $url_canonical = $request->url();
                //--seo
                }
        
        $category_name = DB::table('tbl_category_product')->where('tbl_category_product.slug_category_product',$slug_category_product)
        ->limit(1)->get();

        return view('pages.category.show_category')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('category_by_id',$category_by_id)->with('category_name',$category_name)->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)
        ->with('slider',$slider)->with('menu_post',$menu_post);
        // ->with('min_price',$min_price)->with('max_price',$max_price)
    }
  

}

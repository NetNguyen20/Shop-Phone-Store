<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MenuPost;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function contact(Request $request){
        //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        //menu post
        $menu_post = MenuPost::orderBy('menu_post_id','DESC')->get();
        //seo 
        $meta_desc = "Contact"; 
        $meta_keywords = "Contact ";
        $meta_title = "Contact ";
        $url_canonical = $request->url();
        //--seo
        
    	$cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        return view('pages.contact.contact')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)->with('slider',$slider)->with('menu_post',$menu_post);;
    }
}

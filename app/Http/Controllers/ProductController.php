<?php

namespace App\Http\Controllers;

use App\Gallery as AppGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Slider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\MenuPost;
use App\Models\Gallery;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use App\Models\Comment;
use App\Models\Rating;

session_start();

class ProductController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Auth::id();
        if ($admin_id) {
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_product()
    {
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();


        return view('admin.product.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
    }

    public function all_product()
    {
        $this->AuthLogin();
        $all_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->orderby('tbl_product.product_id', 'desc')->get();
        $manager_product  = view('admin.product.all_product')->with('all_product', $all_product);
        return view('admin_layout')->with('admin.product.all_product', $manager_product);
    }

    public function save_product(Request $request)
    {
        $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_slug'] = $request->product_slug;
        $data['product_price'] = $request->product_price;
        $data['product_price_cost'] = $request->product_price_cost;
        $data['product_sold'] = $request->product_sold;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $data['product_image'] = $request->product_status;
        $get_image = $request->file('product_image');

        $img = 'public/uploads/product/';
        $img_gallery = 'public/uploads/gallery/';

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move($img, $new_image);
            File::copy($img.$new_image, $img_gallery.$new_image);
            $data['product_image'] = $new_image;
           
        }
        // $data['product_image'] = '';
        // DB::table('tbl_product')->insert($data);
        // Session::put('message', 'Add successful products');
        // return Redirect::to('all-product');
        $pro_id = DB::table('tbl_product')->insertGetId($data);
        $gallery = new Gallery();
        $gallery->gallery_image = $new_image;
        $gallery->gallery_name = $new_image;
        $gallery->product_id = $pro_id;
        $gallery->save();

        Session::put('message', 'Add successful products');
        return Redirect::to('add-product');
    }

    public function unactive_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 1]);
        Session::put('message', 'Product activation failed');
        return Redirect::to('all-product');
    }

    public function active_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 0]);
        Session::put('message', 'Product activation failed');
        return Redirect::to('all-product');
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
    
    public function update_product(Request $request, $product_id)
    {
        $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_quantity'] = $request->product_quantity;
        $data['product_slug'] = $request->product_slug;
        $data['product_price'] = $request->product_price;
        $data['product_price_cost'] = $request->product_price_cost;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $get_image = $request->file('product_image');

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image =  $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            Session::put('message', 'Product update successful');
            return Redirect::to('all-product');
        }

        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message', 'Product update successful');
        return Redirect::to('all-product');
    }

    public function delete_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->delete();
        Session::put('message', 'Delete product successfully');
        return Redirect::to('all-product');
    }

    //End Admin Page
    public function details_product($product_slug, Request $request)
    {
        //menu post
        $menu_post = MenuPost::orderBy('menu_post_id','DESC')->get();
        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $details_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->where('tbl_product.product_slug', $product_slug)->get();

        foreach ($details_product as $key => $value) {
            $product_id = $value->product_id;
            $category_id = $value->category_id;
            $product_cate = $value->category_name;
            $cate_slug = $value->slug_category_product;
            //seo 
            $meta_desc = $value->product_desc;
            $meta_keywords = $value->product_slug;
            $meta_title = $value->product_name;
            $url_canonical = $request->url();
            //--seo
        }
        //gallery
        $gallery = Gallery::where('product_id', $product_id)->get();

        $related_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_slug', [$product_slug])->paginate(6);

        $rating = Rating::where('product_id', $product_id)->avg('rating');
        $rating = round($rating);
        return view('pages.product.show_details')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('product_details', $details_product)->with('relate', $related_product)->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)
            ->with('slider', $slider)->with('menu_post',$menu_post)->with('gallery',$gallery)->with('product_cate',$product_cate)
            ->with('cate_slug',$cate_slug)->with('rating',$rating);
    }

    public function quickview(Request $request){
        $product_id = $request->product_id;
        $product = Product::find($product_id);
        $gallery = Gallery::where('product_id', $product_id)->get();
        $output['product_gallery'] = '';
        foreach($gallery as $key => $gal){
            $output['product_gallery'].='<p><img width = "100%" src="public/uploads/gallery/'.$gal->gallery_image.'"></p>';
        }
        $output['product_id'] = $product->product_id;
        $output['product_name'] = $product->product_name;
        $output['product_price'] = number_format($product->product_price,0,',','.').'VND';
        $output['product_image'] = '<p><img width = "100%" src="public/uploads/product/'.$product->product_image.'"></p>';
        $output['product_desc'] = $product->product_desc;
        $output['product_content'] = $product->product_content;
        echo json_encode($output);

    }

    public function load_comment(Request $request){
        $product_id = $request->product_id;
        $comment = Comment::where('comment_product_id',$product_id)->where('comment_reply','=',0)->where('comment_status',0)->get();
        $comment_rep = Comment::with('product')->where('comment_reply','>',0)->orderBy('comment_id','DESC')->get();

        $output = '';
        foreach($comment as $key => $cmt){
            $output.= '
            <div class="row style_comment" >
					<div class="col-md-2">
						<img src="'.url('/public/frontend/images/avata.png').'" class="img img-responsive img-thumbnail">
					</div>
					<div class="col-md-10">
						<p style="color:deepskyblue;">@'.$cmt->comment_name.'</p>
                        <p style="color:black;">'.$cmt->comment_date.'</p>

						<p>'.$cmt->comment.'</p>
					</div>                 
				</div>
                <p></p>
                ';
                

                foreach($comment_rep as $key => $rep_cmt){
                    if($rep_cmt->comment_reply==$cmt->comment_id){
                $output.= '<div class="row style_comment" style="margin: 3px 88px; background:paleturquoise;">
					<div class="col-md-2">
						<img width: "20%" src="'.url('/public/frontend/images/avata_admin.png').'"
                        class="img img-responsive img-thumbnail">
					</div>
					<div class="col-md-10">
						<p style="color:blue;">@Netnguyen Admin</p>
                        <p>'.$rep_cmt->comment.'</p>

						<p></p>
					</div>                 
				</div>
                <p></p>';
                    }
                }
            

        }
        echo $output;
    }

    public function send_comment(Request $request){
        $product_id = $request->product_id;
        $comment_name = $request->comment_name;
        $comment_content = $request->comment_content;
        $comment = new Comment();
        $comment->comment_product_id = $product_id;
        $comment->comment_name = $comment_name;
        $comment->comment = $comment_content;
        $comment->comment_status = 1;
        $comment->comment_reply = 0;

        $comment->save();

    }

    public function list_comment(Request $request){
        $comment = Comment::with('product')->where('comment_reply','=',0)->orderBy('comment_id','DESC')->get();
        $comment_rep = Comment::with('product')->where('comment_reply','>',0)->orderBy('comment_id','DESC')->get();

        return view('admin.comment.list_comment')->with(compact('comment','comment_rep'));
    }

    public function browse_comment(Request $request){
        $data = $request->all();
        $comment = Comment::find($data['comment_id']);
        $comment->comment_status = $data['comment_status'];

        $comment->save();
    }

    public function reply_comment(Request $request){
        $data = $request->all();
        $comment = new Comment();
        $comment->comment = $data['comment'];
        $comment->comment_product_id = $data['comment_product_id'];
        $comment->comment_reply = $data['comment_id'];
        $comment->comment_status = 0;
        $comment->comment_name = 'NetNguye Admin';

        $comment->save();

    }

    public function insert_rating(Request $request){
        $data = $request->all();
        $rating = new Rating();
        $rating->product_id = $data['product_id'];
        $rating->rating = $data['index'];
        $rating->save();
        echo'done';
    }

    public function delete_comment(Request $request, $comment_id){
        $comment = Comment::find($comment_id);
    	$comment->delete();
    	Session::put('message','Successfully deleted comment');
        return Redirect::to('list-comment');
    }
}

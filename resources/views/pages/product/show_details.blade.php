@extends('layout')
@section('content')
@foreach($product_details as $key => $value)
<div class="product-details">
	<!--product-details-->
	<style type="text/css">
		.lSSlideOuter .lSPager.lSGallery img {
			display: block;
			height: 88px;
			max-width: 100%;
		}
		li.active {
			border: 1px solid #008000 ;
		}
	</style>

	<nav aria-label="breadcrumb">
		<ol class="breadcrumb" style="background:none">
			<li class="breadcrumb-item"><a href="{{url('/trang-chu')}}">Home</a></li>
			<li class="breadcrumb-item"><a href="{{url('/danh-muc/'.$cate_slug)}}">{{$product_cate}}</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{$meta_title}}</li>
		</ol>
	</nav>
	<div class="col-sm-5">
		<ul id="imageGallery">
			@foreach($gallery as $key => $gal)
			<li data-thumb="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}" data-src="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}">
				<img height="300px" width="100%" alt="{{$gal->gallery_name}}" src="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}" />
			</li>
			@endforeach
		</ul>

	</div>
	<div class="col-sm-7">

		<div class="product-information">
			<!--/product-information-->
			<img src="images/product-details/new.jpg" class="newarrival" alt="" />
			<h2>{{$value->product_name}}</h2>
			<p>ID: {{$value->product_id}}</p>
			<img src="images/product-details/rating.png" alt="" />

			<form action="{{URL::to('/save-cart')}}" method="POST">
				@csrf
				<input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">
				<input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">
				<input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->product_id}}">
				<input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->product_id}}">

				<span>
					<span>{{number_format($value->product_price,0,',','.').'VNĐ'}}</span>

					<label>Quantity:</label>
					<input name="qty" type="number" min="1" class="cart_product_qty_{{$value->product_id}}" value="1" />
					<input name="productid_hidden" type="hidden" value="{{$value->product_id}}" />
				</span>
				<input type="button" value="Add to cart" class="btn btn-primary btn-sm add-to-cart" data-id_product="{{$value->product_id}}" name="add-to-cart">
			</form>

			<p><b>Status:</b> Stocking</p>
			<p><b>Conditionn:</b> New 100%</p>
			<p><b>Brand:</b> {{$value->brand_name}}</p>
			<p><b>Category:</b> {{$value->category_name}}</p>
			<a href=""><img src="images/product-details/share.png" class="share img-responsive" alt="" /></a>
		</div>
		<!--/product-information-->
	</div>
</div>
<!--/product-details-->

<div class="category-tab shop-details-tab">
	<!--category-tab-->
	<div class="col-sm-12">
		<ul class="nav nav-tabs">
			<li class="active in"><a href="#details" data-toggle="tab">Description</a></li>
			<li><a href="#companyprofile" data-toggle="tab">Content</a></li>
			<li><a href="#reviews" data-toggle="tab">Evaluate</a></li>
		</ul>
	</div>
	<div class="tab-content">
		<div class="tab-pane fade active in " id="details">
			<p>{!!$value->product_desc!!}</p>

		</div>

		<div class="tab-pane fade" id="companyprofile">
			<p>{!!$value->product_content!!}</p>

		</div>

		<div class="tab-pane fade " id="reviews">
			<div class="col-sm-12">
				<ul>
					<li><a href=""><i class="fa fa-user"></i>NGUYEN PHUC THUAN GCS18697</a></li>
					<li><a href=""><i class="fa fa-clock-o"></i>8:08 PM</a></li>
					<li><a href=""><i class="fa fa-calendar-o"></i>1-2-2020</a></li>
				</ul>

				<form>
					@csrf
					<input type="hidden" name="comment_product_id" value="{{$value->product_id}}" class="comment_product_id">
					<div id="show_comment"></div>

				</form>
				<p><b>Write Your Review</b></p>
				<!--Rating star-->
				<ul class="list-inline rating" title="Rating average">
					@for($count = 1; $count<=5; $count++) @php if($count<=$rating){ $color='color:#ffcc00;' ; }else{ $color='color:#ccc;' ; } @endphp <li title="star_rating" id="{{$value->product_id}}-{{$count}}" data-index="{{$count}}" data-product_id="{{$value->product_id}}" data-rating="{{$rating}}" class="rating" style="cursor:pointer; {{$color}}
						font-size: 30px;">
						&#9733;
						</li>
						@endfor
				</ul>
				<form>
					<div id="notification_comment"></div>
					<span>
						<input style="width: 100%; margin-left: 0;" type="text" class="comment_name" placeholder="Your Name" />
					</span>
					<textarea name="comment" class="comment_content" placeholder="Comment content"></textarea>
					<button type="button" class="btn btn-default pull-right send-comment">
						Sent comment
					</button>
				</form>
			</div>
		</div>

	</div>
</div>
<!--/category-tab-->
@endforeach
<div class="recommended_items">
	<!--recommended_items-->
	<h2 class="title text-center">Related Products</h2>

	<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<div class="item active">
				@foreach($relate as $key => $lienquan)
				<div class="col-sm-4">
					<div class="product-image-wrapper">
						<div class="single-products">
							<div class="productinfo text-center">
								<img src="{{URL::to('public/uploads/product/'.$lienquan->product_image)}}" alt="" />
								<h2>{{number_format($lienquan->product_price).' '.'VNĐ'}}</h2>
								<p>{{$lienquan->product_name}}</p>
								<input type="button" value="Add to cart" class="btn btn-primary btn-sm add-to-cart" data-id_product="{{$value->product_id}}" name="add-to-cart">
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
<!--/recommended_items-->
<ul class="pagination pagination-sm m-t-none m-b-none">
	{!!$relate->links()!!}
</ul>
@endsection

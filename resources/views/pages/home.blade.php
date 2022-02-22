@extends('layout')
@section('content')
<div class="features_items">
    <!--features_items-->

    <h2 class="title text-center">Products new</h2>
    
    @foreach($all_product as $key => $product)
    <div class="col-sm-4">
        <div class="product-image-wrapper">

            <div class="single-products">
                <div class="productinfo text-center">
                    <form>
                        @csrf
                        <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                        <input type="hidden" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                        <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                        <input type="hidden" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                        <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">

                        <a href="{{URL::to('/chi-tiet/'.$product->product_slug)}}">
                            <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                            <h2>{{number_format($product->product_price,0,',','.').' '.'VNĐ'}}</h2>
                            <p>{{$product->product_name}}</p>
                        </a>
                        <input type="button" value="Add to cart" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">
                        <input type="button" data-toggle="modal" data-target="#quickview" value="Quick view" class="btn btn-default quickview" data-id_product="{{$product->product_id}}" name="add-to-cart">

                    </form>
                </div>
            </div>

            <!-- <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-plus-square"></i>Wishlist</a></li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>Compare</a></li>
                </ul>
            </div> -->
        </div>
    </div>
    @endforeach
</div>
<!--features_items-->
<!-- Modal -->
<div class="modal fade" id="quickview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title product_quickview_title" id="">
                    <span id="product_quickview_title"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <span id="product_quickview_image"></span>
                    </div>
                    <div class="col-md-7">
                        <h2><span id="product_quickview_title"></span></h2>
                        <p>ID: <span id="product_quickview_id"></span></p>
                        <p>Price: <span style="font-size: 20px; font-weight: bold; color:red;" id="product_quickview_price"></span></p>

                      
                        <h4 style="font-size:20px; font-weight:bold; color:red;">Description product:</h4>
                        <p><span id="product_quickview_desc"></span></p>
                        <h4 style="font-size:20px; font-weight:bold; color:red;">Configuration product:</h4>
                        <p><span id="product_quickview_content"></span></p>

                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<ul class="pagination pagination-sm m-t-none m-b-none">
    {!!$all_product->links()!!}
</ul>
<!--/recommended_items-->
@endsection
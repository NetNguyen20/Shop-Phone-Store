@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add product
            </header>
            <?php

            use Illuminate\Support\Facades\Session;

            $message = Session::get('message');
            if ($message) {
                echo '<span class="text-alert">' . $message . '</span>';
                Session::put('message', null);
            }
            ?>
            <div class="panel-body">

                <div class="position-center">
                    <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name product</label>
                            <input type="text" data-validation="length" data-validation-length="min10" data-validation-error-msg="Please enter at least 10 characters"
                             name="product_name" class="form-control" id="slug" placeholder="Name product" onkeyup="ChangeToSlug();">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Quantity product</label>
                            <input type="text" data-validation="number" data-validation-error-msg="Please enter the quantity" name="product_quantity" class="form-control" id="exampleInputEmail1" placeholder="Enter quantity">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" name="product_slug" class="form-control" id="convert_slug" placeholder="Slug">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Price product</label>
                            <input type="text" data-validation="number" data-validation-error-msg="Plase enter the price" name="product_price" class="form-control" id="" placeholder="Price procduct">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Price product cost</label>
                            <input type="text" data-validation="number" data-validation-error-msg="Plase enter the price" name="product_price_cost" class="form-control" id="" placeholder="Price procduct cost">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Sold product</label>
                            <input type="text" data-validation="number" name="product_sold" class="form-control" id="" placeholder="Price sold">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Image product</label>
                            <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description product</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_desc" id="ckeditor1" placeholder="Description product"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Content product</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_content" id="id4" placeholder="Content product"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Category product</label>
                            <select name="product_cate" class="form-control input-sm m-bot15">
                                @foreach($cate_product as $key => $cate)
                                <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Brand product</label>
                            <select name="product_brand" class="form-control input-sm m-bot15">
                                @foreach($brand_product as $key => $brand)
                                <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Display</label>
                            <select name="product_status" class="form-control input-sm m-bot15">
                                <option value="0">Show</option>
                                <option value="1">Hide</option>
                            </select>
                        </div>

                        <button type="submit" name="add_product" class="btn btn-info">Add to product</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
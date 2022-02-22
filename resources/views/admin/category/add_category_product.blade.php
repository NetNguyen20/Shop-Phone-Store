@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add category product
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
                    <form role="form" action="{{URL::to('/save-category-product')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name category</label>
                            <input type="text" name="category_product_name" class="form-control" onkeyup="ChangeToSlug();" id="slug" placeholder="Name categor">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" name="slug_category_product" class="form-control" id="convert_slug" placeholder="Slug">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Discription category</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="category_product_desc" id="exampleInputPassword1" placeholder="Discription category"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Keywords</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="category_product_keywords" id="exampleInputPassword1"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Display</label>
                            <select name="category_product_status" class="form-control input-sm m-bot15">
                                <option value="1">Hide</option>
                                <option value="0">Show</option>

                            </select>
                        </div>

                        <button type="submit" name="add_category_product" class="btn btn-info">Add category product</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
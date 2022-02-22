@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit menu post
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
                    <form role="form" action="{{URL::to('/update-menu-post/'.$edit_menu_post->menu_post_id)}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name menu post</label>
                            <input type="text" name="menu_post_name" value="{{$edit_menu_post->menu_post_name}}" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" name="menu_post_slug" value="{{$edit_menu_post->menu_post_slug}}" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Discription menu post</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="menu_post_desc" id="exampleInputPassword1">{{$edit_menu_post->menu_post_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Display</label>
                            <select name="menu_post_status" class="form-control input-sm m-bot15">
                            @if($edit_menu_post->menu_post_status == 0)    
                                <option value="1">Hide</option>
                                <option selected value="0">Show</option>
                            @else
                                <option selected value="1">Hide</option>
                                <option selected value="0">Show</option>
                            @endif
                            </select>
                        </div>

                        <button type="submit" name="update_category_product" class="btn btn-info">Update menu post</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
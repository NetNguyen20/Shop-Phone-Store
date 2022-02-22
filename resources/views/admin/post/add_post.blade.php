@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add post
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
                    <form role="form" action="{{URL::to('/save-post')}}" method="post" enctype='multipart/form-data'> 
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name post</label>
                            <input type="text" name="post_title" class="form-control" onkeyup="ChangeToSlug();" id="slug" placeholder="Name post">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" name="post_slug" class="form-control" id="convert_slug" placeholder="Slug">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description post</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="post_desc" id="ckeditor1" placeholder="Description post"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Content post</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="post_content" id="ckeditor2" placeholder="Content post"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Meta description post</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="post_meta_desc" id="exampleInputPassword1" placeholder="Meta desc post"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Meta keywords post</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="post_meta_keywords" id="exampleInputPassword1" placeholder="Meta keywords post"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Image post</label>
                            <input type="file" name="post_image" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Menu post</label>
                            <select name="menu_post_id" class="form-control input-sm m-bot15">
                                @foreach($menu_post as $key => $menu)
                                    <option value="{{$menu->menu_post_id}}">{{$menu->menu_post_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Display</label>
                            <select name="post_status" class="form-control input-sm m-bot15">
                                <option value="0">Show</option>
                                <option value="1">Hide</option>

                            </select>
                        </div>

                        <button type="submit" name="add_post" class="btn btn-info">Add post</button>
                    </form>
                </div>

            </div>
        </section>
    </div>
    @endsection
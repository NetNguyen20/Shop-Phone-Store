@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Edit post
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
                    <form role="form" action="{{URL::to('/update-post/'.$post->post_id)}}" method="post" enctype='multipart/form-data'> 
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name post</label>
                            <input type="text" name="post_title" class="form-control" onkeyup="ChangeToSlug();" id="slug" placeholder="Name post"
                            value="{{$post->post_title}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" name="post_slug" class="form-control" id="convert_slug" placeholder="Slug" value="{{$post->post_slug}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description post</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="post_desc" id="ckeditor1" placeholder="Description post">{{$post->post_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Content post</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="post_content" id="ckeditor2" placeholder="Content post">{{$post->post_content}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Meta description post</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="post_meta_desc" id="exampleInputPassword1" placeholder="Meta desc post">{{$post->post_meta_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Meta keywords post</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="post_meta_keywords" id="exampleInputPassword1" placeholder="Meta keywords post">{{$post->post_meta_keywords}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Image post</label>
                            <input type="file" name="post_image" class="form-control" id="exampleInputEmail1">
                            <img src="{{asset('public/uploads/post/'.$post->post_image)}}" height="100" width="100">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Menu post</label>
                            <select name="menu_post_id" class="form-control input-sm m-bot15">
                                @foreach($menu_post as $key => $menu)
                                    <option {{$post->menu_post_id==$menu->menu_post_id ? 'selected' : ''}} value="{{$menu->menu_post_id}}">{{$menu->menu_post_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Display</label>
                            <select name="post_status" class="form-control input-sm m-bot15">
                                @if($post->post_status == 0)
                                    <option selected value="0">Show</option>
                                    <option value="1">Hide</option>
                                @else
                                    <option value="0">Show</option>
                                    <option selected value="1">Hide</option>
                                @endif
                            </select>
                        </div>

                        <button type="submit" name="update_post" class="btn btn-info">Update post</button>
                    </form>
                </div>

            </div>
        </section>
    </div>
    @endsection
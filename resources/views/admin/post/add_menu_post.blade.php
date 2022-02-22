@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add menu post
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
                    <form role="form" action="{{URL::to('/save-menu-post')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name menu post</label>
                            <input type="text" name="menu_post_name" class="form-control" onkeyup="ChangeToSlug();" id="slug">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" name="menu_post_slug" class="form-control" id="convert_slug"
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Discription menu post</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="menu_post_desc" id="exampleInputPassword1"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Display</label>
                            <select name="menu_post_status" class="form-control input-sm m-bot15">
                                <option value="1">Hide</option>
                                <option value="0">Show</option>

                            </select>
                        </div>

                        <button type="submit" name="add_menu_post" class="btn btn-info">Add menu post</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      List post
    </div>

    <div class="table-responsive">

      <?php

      use Illuminate\Support\Facades\Session;

      $message = Session::get('message');
      if ($message) {
        echo '<span class="text-alert">' . $message . '</span>';
        Session::put('message', null);
      }
      ?>

      <table class="table table-striped b-t b-light" id="myTable">
        <thead>
          <tr>
            
            <th>Post name</th>
            <th>Image post</th>
            <th>Slug</th>
            <th>Description post</th>
            <th>Keywords post</th>
            <th>Menu post</th>
            <th>Display</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_post as $key => $post)
          <tr>
            <td>{{ $post->post_title }}</td>
            <td><img src="public/uploads/post/{{ $post->post_image }}" height="100" width="100"></td>
            <td>{{ $post->post_slug }}</td>
            <td>{!! $post->post_desc !!}</td>
            <td>{{ $post->post_meta_keywords }}</td>
            <td>{{ $post->menu_post->menu_post_name }}</td>

            <td>
              @if($post->post_status == 0)
                Show
              @else
                Hide
              @endif
            </td>

            <td>
              <a href="{{URL::to('/edit-post/'.$post->post_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i></a>
              <a onclick="return confirm('Are you sure you want to delete this post?')" href="{{URL::to('/delete-post/'.$post->post_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
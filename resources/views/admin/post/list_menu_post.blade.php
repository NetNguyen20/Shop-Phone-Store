@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      List menu post
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
            
            <th>Menu post name</th>
            <th>Menu post description</th>
            <th>Menu post slug</th>
            <th>Display</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($all_menu_post as $key => $menu_post)
          <tr>
            <td>{{ $menu_post->menu_post_name }}</td>
            <td>{{ $menu_post->menu_post_desc }}</td>

            <td>{{ $menu_post->menu_post_slug }}</td>               
            <td>
                @if($menu_post->menu_post_status == 0)
                    Show
                @else
                    Hide
                @endif
            </td>
            <td>
              <a href="{{URL::to('/edit-menu-post/'.$menu_post->menu_post_id)}}" class="active styling-edit" ui-toggle-class="">
                <i class="fa fa-pencil-square-o text-success text-active"></i></a>

              <a onclick="return confirm('Are you sure you want to delete this menu post?')" href="{{URL::to('/delete-menu-post/'.$menu_post->menu_post_id)}}" class="active styling-edit" ui-toggle-class="">
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
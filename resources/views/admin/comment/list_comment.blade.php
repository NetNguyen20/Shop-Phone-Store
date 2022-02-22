@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      List comment product
    </div>
    <div id="notification_comment"></div>

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
            <th>User name </th>
            <th>Comment content</th>
            <th>Date</th>
            <th>Product</th>
            <th>Browse</th>
          </tr>
        </thead>
        
        <tbody>
          @foreach($comment as $key => $cmt)
          <tr>
            <td>{{ $cmt->comment_name }}</td>
            <td>{{ $cmt->comment }}
              <style type="text/css">
                ul.list_rep li {
                  list-style-type: none;
                  color: blue;
                  margin: 5px 10px;
                }

              </style>
              <ul class="list_rep">
                @foreach($comment_rep as $key => $cmt_rep)
                  @if($cmt_rep->comment_reply==$cmt->comment_id)
                    <li >Reply: {{$cmt_rep->comment}}</li>

                  @endif

                @endforeach
              </ul>
              @if($cmt->comment_status == 0)
                  <br><textarea class="form-control reply_comment_{{$cmt->comment_id}}"></textarea>
                  <br><button class="btn btn-default btn-xs btn-reply-comment" data-comment_id="{{$cmt->comment_id}}" data-product_id="{{$cmt->comment_product_id}}">Reply</button>              
              @endif
              
            </td>
            <td>{{ $cmt->comment_date }}</td>
            <td><a href="{{url('/chi-tiet/'.$cmt->product->product_slug)}}" target="_blank">{{ $cmt->product->product_name }}</a></td>

            <td>
              @if($cmt->comment_status == 1)
                  <input type="button" class="btn btn-primary btn-xs comment_btn_browse" id="{{$cmt->comment_product_id}}" value="Browse"
                   data-comment_id="{{$cmt->comment_id}}" data-comment_status="0">
              @else
                  <input type="button" class="btn btn-danger btn-xs comment_btn_browse" id="{{$cmt->comment_product_id}}" value="Quit browse" 
                  data-comment_id="{{$cmt->comment_id}}" data-comment_status="1">
              @endif
            </td>

            <td>            
              <a onclick="return confirm('Are you sure you want to delete this comment?')" href="{{URL::to('/delete-comment/'.$cmt->comment_id)}}" class="active styling-edit" ui-toggle-class="">
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
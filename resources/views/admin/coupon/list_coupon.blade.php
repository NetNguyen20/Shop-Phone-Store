@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      List coupon
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
            <th>Coupon name</th>
            <th>Coupon code</th>
            <th>Quantity coupon</th>
            <th>Conditions</th>
            <th>Decrease number</th>
          </tr>
        </thead>
        <tbody>
          @foreach($coupon as $key => $cou)
          <tr>
            <td>{{ $cou->coupon_name }}</td>
            <td>{{ $cou->coupon_code }}</td>
            <td>{{ $cou->coupon_time }}</td>
            <td><span class="text-ellipsis">
                <?php
                if ($cou->coupon_condition == 1) {
                ?>
                  Discount by %
                <?php
                } else {
                ?>
                  Discount by money
                <?php
                }
                ?>
              </span>
            </td>
            <td><span class="text-ellipsis">
                <?php
                if ($cou->coupon_condition == 1) {
                ?>
                  Discount {{$cou->coupon_number}} %
                <?php
                } else {
                ?>
                  Discount {{$cou->coupon_number}} VND
                <?php
                }
                ?>
              </span></td>

            <td>

              <a onclick="return confirm('Are you sure you want to delete this code?')" href="{{URL::to('/delete-coupon/'.$cou->coupon_id)}}" class="active styling-edit" ui-toggle-class="">
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
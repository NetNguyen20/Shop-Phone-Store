@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">

  <div class="panel panel-default">
    <div class="panel-heading">
      Login information
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
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>User name</th>
            <th>Phone number</th>
            <th>Email</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>

          <tr>
            <td>{{$customer->customer_name}}</td>
            <td>{{$customer->customer_phone}}</td>
            <td>{{$customer->customer_email}}</td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>
</div>
<br>
<div class="table-agile-info">

  <div class="panel panel-default">
    <div class="panel-heading">
      Shipping information
    </div>

    <div class="table-responsive">
      <?php
      $message = Session::get('message');
      if ($message) {
        echo '<span class="text-alert">' . $message . '</span>';
        Session::put('message', null);
      }
      ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>

            <th>Shipping name</th>
            <th>Shipping address</th>
            <th>Phone number</th>
            <th>Email</th>
            <th>Notes</th>
            <th>Method payment</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>

          <tr>
            <td>{{$shipping->shipping_name}}</td>
            <td>{{$shipping->shipping_address}}</td>
            <td>{{$shipping->shipping_phone}}</td>
            <td>{{$shipping->shipping_email}}</td>
            <td>{{$shipping->shipping_notes}}</td>
            <td>@if($shipping->shipping_method==0) Transfer @else Cash @endif</td>
          </tr>
        </tbody>
      </table>

    </div>

  </div>
</div>
<br><br>

<div class="table-agile-info">

  <div class="panel panel-default">
    <div class="panel-heading">
      List order details
    </div>

    <div class="table-responsive">
      <?php
      $message = Session::get('message');
      if ($message) {
        echo '<span class="text-alert">' . $message . '</span>';
        Session::put('message', null);
      }
      ?>

      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Product name</th>
            <th>Amount of stock left</th>
            <th>Code coupon</th>
            <th>Feeship</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Price cost</th>
            <th>Total</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php
            $i = 0;
            $total = 0;
          @endphp
          @foreach($order_details as $key => $details)
            @php
              $i++;
              $subtotal = $details->product_price*$details->product_sales_quantity;
              $total+=$subtotal;
            @endphp
          <tr class="color_qty_{{$details->product_id}}">

            <td><i>{{$i}}</i></td>
            <td>{{$details->product_name}}</td>
            <td>{{$details->product->product_quantity}}</td>
            <td>@if($details->product_coupon!='no')
              {{$details->product_coupon}}
              @else
                No discount
              @endif
            </td>

            <td>{{number_format($details->product_feeship ,0,',','.')}}VND</td>

            <td>

              <input type="number" min="1" {{$order_status==2 ? 'disabled' : ''}} class="order_qty_{{$details->product_id}}" value="{{$details->product_sales_quantity}}" name="product_sales_quantity">

              <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$details->product_id}}" value="{{$details->product->product_quantity}}">

              <input type="hidden" name="order_code" class="order_code" value="{{$details->order_code}}">

              <input type="hidden" name="order_product_id" class="order_product_id" value="{{$details->product_id}}">

              @if($order_status!=2)

              <button class="btn btn-default update_quantity_order" data-product_id="{{$details->product_id}}" name="update_quantity_order">Update</button>

              @endif

            </td>
            <td>{{number_format($details->product_price ,0,',','.')}}VND</td>
            <td>{{number_format($details->product->product_price_cost ,0,',','.')}}VND</td>
            <td>{{number_format($subtotal ,0,',','.')}}VND</td>

          </tr>
          @endforeach
          <tr>
            <td colspan="2">
              @php
                $total_coupon = 0;
              @endphp
              @if($coupon_condition==1)
                @php
                  $total_after_coupon = ($total*$coupon_number)/100;
                  echo 'Total discount :'.number_format($total_after_coupon,0,',','.').'</br>';
                  $total_coupon = $total + $details->product_feeship - $total_after_coupon ;
                @endphp
              @else
                @php
                  echo 'Total discount :'.number_format($coupon_number,0,',','.').'k'.'</br>';
                  $total_coupon = $total + $details->product_feeship - $coupon_number ;

                @endphp
              @endif

              Fee delivery: {{number_format($details->product_feeship,0,',','.')}}đ</br>
              Payment: {{number_format($total_coupon,0,',','.')}}đ
            </td>
          </tr>
          <tr>
            <td colspan="6">
              @foreach($order as $key => $or)
                @if($or->order_status==1)
                <form>
                  @csrf
                  <select class="form-control order_details">
                    <option value="">-----Select order form-----</option>
                    <option id="{{$or->order_id}}" selected value="1">No process</option>
                    <option id="{{$or->order_id}}" value="2">Processed - delivered</option>
                  </select>
                </form>
              
                @else
                <form>
                  @csrf
                  <select class="form-control order_details">
                    <option value="">-----Select order form-----</option>
                    <option disabled id="{{$or->order_id}}" value="1">No process</option>
                    <option id="{{$or->order_id}}" selected value="2">Processed - delivered</option>
                  </select>
                </form>
                @endif
              @endforeach
            </td>
          </tr>
        </tbody>
      </table>
      <a target="_blank" href="{{url('/print-order/'.$details->order_code)}}">Print order</a>
    </div>
  </div>
</div>
@endsection
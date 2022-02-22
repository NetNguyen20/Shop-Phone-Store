@extends('layout')
@section('content')

<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="{{URL::to('/trang-chu')}}">Page home</a></li>
				<li class="active">Your cart</li>
			</ol>
		</div>
		@if(session()->has('message'))
		<div class="alert alert-success">
			{{ session()->get('message') }}
		</div>
		@elseif(session()->has('error'))
		<div class="alert alert-danger">
			{{ session()->get('error') }}
		</div>
		@endif
		<div class="table-responsive cart_info">

			<form action="{{url('/update-cart')}}" method="POST">
				@csrf
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Image</td>
							<td class="description">Product name</td>
							<td class="price">Product price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@if(Session::get('cart')==true)
							@php
								$total = 0;
							@endphp
							@foreach(Session::get('cart') as $key => $cart)
							@php
								$subtotal = $cart['product_price']*$cart['product_qty'];
								$total+=$subtotal;
						@endphp

						<tr>
							<td class="cart_product">
								<img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" width="90" alt="{{$cart['product_name']}}" />
							</td>
							<td class="cart_description">
								<h4><a href=""></a></h4>
								<p>{{$cart['product_name']}}</p>
							</td>
							<td class="cart_price">
								<p>{{number_format($cart['product_price'],0,',','.')}}VND</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">


									<input class="cart_quantity" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}">


								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
									{{number_format($subtotal,0,',','.')}}VND

								</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{url('/del-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>

						@endforeach
						<tr>
							<td><input type="submit" value="Update cart" name="update_qty" class="check_out btn btn-default btn-sm"></td>
							<td><a class="btn btn-default check_out" href="{{url('/del-all-product')}}">Delete all</a></td>
							<td>
								@if(Session::get('coupon'))
								<a class="btn btn-default check_out" href="{{url('/unset-coupon')}}">Delete coupon code</a>
								@endif
							</td>

							<td>
								@if(Session::get('customer_id'))
								<a class="btn btn-default check_out" href="{{url('/checkout')}}">Order</a>

								@else
								<a class="btn btn-default check_out" href="{{url('/dang-nhap')}}">Order</a>
								@endif
							</td>


							<td colspan="2">
								<li>Total: <span>{{number_format($total,0,',','.')}} VND</span></li>
								@if(Session::get('coupon'))
								<li>

									@foreach(Session::get('coupon') as $key => $cou)
									@if($cou['coupon_condition']==1)
									Code coupon : {{$cou['coupon_number']}} %
									<p>
										@php
										$total_coupon = ($total*$cou['coupon_number'])/100;
										echo '
									<p>
								<li>Subtotal:'.number_format($total_coupon,0,',','.').'VND</li>
								</p>';
								@endphp
								</p>
								<p>
									<li>Total discount: {{number_format($total-$total_coupon,0,',','.')}}VND</li>
								</p>
								@elseif($cou['coupon_condition']==2)
								Code coupon : {{number_format($cou['coupon_number'],0,',','.')}} VND
								<p>
									@php
									$total_coupon = $total - $cou['coupon_number'];

									@endphp
								</p>
								<p>
									<li>Subtotal: {{number_format($total_coupon,0,',','.')}}VND</li>
								</p>
								@endif
								@endforeach

								</li>
								@endif
							</td>
						</tr>
						@else
						<tr>
							<td colspan="5">
								<center>
									@php
									echo 'Please add product to cart';
									@endphp
								</center>
							</td>
						</tr>
						@endif
					</tbody>

			</form>
			@if(Session::get('cart'))
			<tr>
				<td>

					<form method="POST" action="{{url('/check-coupon')}}">
						@csrf
						<input type="text" class="form-control" name="coupon" placeholder="Enter discount code"><br>
						<input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Calculate discount code">

					</form>
				</td>
			</tr>
			@endif

			</table>

		</div>
	</div>
</section>
<!--/#cart_items-->

@endsection
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Customer;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Statistic;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PDF;

class OrderController extends Controller
{
	public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

	public function update_qty(Request $request){
		$data = $request->all();
		$order_details = OrderDetails::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();
		$order_details->product_sales_quantity = $data['order_qty'];
		$order_details->save();
	}
	public function update_order_qty(Request $request){
		//update order
		$data = $request->all();
		$order = Order::find($data['order_id']);
		$order->order_status = $data['order_status'];
		$order->save();

		//order date
		$order_date = $order->order_date;
		$statistics = Statistic::where('order_date', $order_date)->get();
		if($statistics){
			$statistics_count = $statistics->count();

		}else{
			$statistics_count = 0;

		}

		if($order->order_status==2){
			$total_order = 0;
			$sales = 0;
			$profit = 0;
			$quantity = 0;
			foreach($data['order_product_id'] as $key => $product_id){
				
				$product = Product::find($product_id);
				$product_quantity = $product->product_quantity;
				$product_sold = $product->product_sold;
				$product_price = $product->product_price;
				$product_cost = $product->product_price_cost;
				$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();	
				foreach($data['quantity'] as $key2 => $qty){
						if($key==$key2){
							$pro_remain = $product_quantity - $qty;
							$product->product_quantity = $pro_remain;
							$product->product_sold = $product_sold + $qty;
							$product->save();

							//update statistic
							$quantity+=$qty;
							$total_order+=1;
							$sales+=$product_price*$qty;
							$profit += ($product_price*$qty)-($product_cost*$qty);
						}
				}
			}

			if($statistics_count > 0){
				$statistics_update = Statistic::where('order_date', $order_date)->first();
				$statistics_update->sales = $statistics_update->sales + $sales;
				$statistics_update->total_order = $statistics_update->total_order + $total_order;
				$statistics_update->profit = $statistics_update->profit + $profit;
				$statistics_update->quantity = $statistics_update->quantity + $quantity;
				$statistics_update->save();

			}else{
				$statistics_new = new Statistic();
				$statistics_new->order_date = $order_date;
				$statistics_new->sales = $sales;
				$statistics_new->total_order = $total_order;
				$statistics_new->profit = $profit;
				$statistics_new->quantity = $quantity;
				$statistics_new->save();

			}
			

		}	
	}

	public function print_order($checkout_code){
		$pdf = App::make('dompdf.wrapper');
		$pdf->loadHTML($this->print_order_convert($checkout_code));
		
		return $pdf->stream();
	}

	public function print_order_convert($checkout_code){
		$order_details = OrderDetails::where('order_code',$checkout_code)->get();
		$order = Order::where('order_code',$checkout_code)->get();
		foreach($order as $key => $ord){
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;
		}
		$customer = Customer::where('customer_id',$customer_id)->first();
		$shipping = Shipping::where('shipping_id',$shipping_id)->first();

		$order_details_product = OrderDetails::with('product')->where('order_code', $checkout_code)->get();

		foreach($order_details_product as $key => $order_d){

			$product_coupon = $order_d->product_coupon;
		}
		if($product_coupon != 'no'){
			$coupon = Coupon::where('coupon_code',$product_coupon)->first();

			$coupon_condition = $coupon->coupon_condition;
			$coupon_number = $coupon->coupon_number;

			if($coupon_condition==1){
				$coupon_echo = $coupon_number.'%';
			}elseif($coupon_condition==2){
				$coupon_echo = number_format($coupon_number,0,',','.').'đ';
			}
		}else{
			$coupon_condition = 2;
			$coupon_number = 0;

			$coupon_echo = '0';
		
		}

		$output = '';

		$output.='<style>body{
			font-family: DejaVu Sans;
		}
		.table-styling{
			border:1px solid #000;
		}
		.table-styling tbody tr td{
			border:1px solid #000;
		}
		</style>
		<h1><center>FINAL PROJECT PHONESTORE</center></h1>
		<h4><center>Nguyen Phuc Thuan GCS18697</center></h4>
		<p>User order</p>
		<table class="table-styling">
				<thead>
					<tr>
						<th>User name</th>
						<th>Phone number</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>';
				
		$output.='		
					<tr>
						<td><center>'.$customer->customer_name.'</td>
						<td><center>'.$customer->customer_phone.'</td>
						<td><center>'.$customer->customer_email.'</td>
						
					</tr>';

		$output.='				
				</tbody>
			
		</table>

		<p>Ship to</p>
			<table class="table-styling">
				<thead>
					<tr>
						<th>Recipient name</th>
						<th>Address</th>
						<th>Phone</th>
						<th>Email</th>
						<th>Notes</th>
					</tr>
				</thead>
				<tbody>';
				
		$output.='		
					<tr>
						<td><center>'.$shipping->shipping_name.'</td>
						<td><center>'.$shipping->shipping_address.'</td>
						<td><center>'.$shipping->shipping_phone.'</td>
						<td><center>'.$shipping->shipping_email.'</td>
						<td><center>'.$shipping->shipping_notes.'</td>
						
					</tr>';
		$output.='				
				</tbody>
			
		</table>

		<p>The order</p>
			<table class="table-styling">
				<thead>
					<tr>
						<th>Product name</th>
						<th>Coupon code</th>
						<th>Feeship</th>
						<th>Quantity</th>
						<th>Product price</th>
						<th>Payment</th>
					</tr>
				</thead>
				<tbody>';
			
				$total = 0;

				foreach($order_details_product as $key => $product){

					$subtotal = $product->product_price*$product->product_sales_quantity;
					$total+=$subtotal;

					if($product->product_coupon!='no'){
						$product_coupon = $product->product_coupon;
					}else{
						$product_coupon = 'no coupon';
					}		

		$output.='		
					<tr>
						<td><center>'.$product->product_name.'</td>
						<td><center>'.$product_coupon.'</td>
						<td><center>'.number_format($product->product_feeship,0,',','.').'VND'.'</td>
						<td><center>'.$product->product_sales_quantity.'</td>
						<td><center>'.number_format($product->product_price,0,',','.').'VND'.'</td>
						<td><center>'.number_format($subtotal,0,',','.').'VND'.'</td>
						
					</tr>';
				}

				if($coupon_condition==1){
					$total_after_coupon = ($total*$coupon_number)/100;
	                $total_coupon = $total - $total_after_coupon;
				}else{
                  	$total_coupon = $total - $coupon_number;
				}

		$output.= '<tr>
				<td colspan="2">
					<p><center>Total discount: '.$coupon_echo.'</p>
					<p><center>Feeship: '.number_format($product->product_feeship,0,',','.').'VND'.'</p>
					<p><center>Total: '.number_format($total_coupon + $product->product_feeship,0,',','.').'VND'.'</p>
				</td>
		</tr>';
		$output.='				
				</tbody>
			
		</table>

		<p>Sign</p>
			<table>
				<thead>
					<tr>
						<th width="200px">Voter</th>
						<th width="800px">Receiver</th>
						
					</tr>
				</thead>
				<tbody>';
						
		$output.='				
				</tbody>
			
		</table>
		';
		
		return $output;

	}
	public function view_order($order_code){
		$order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
		$order = Order::where('order_code',$order_code)->get();
		foreach($order as $key => $ord){
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->shipping_id;
			$order_status = $ord->order_status;
		}
		$customer = Customer::where('customer_id',$customer_id)->first();
		$shipping = Shipping::where('shipping_id',$shipping_id)->first();

		$order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

		foreach($order_details_product as $key => $order_d){

			$product_coupon = $order_d->product_coupon;
		}
		if($product_coupon != 'no'){
			$coupon = Coupon::where('coupon_code',$product_coupon)->first();
			$coupon_condition = $coupon->coupon_condition;
			$coupon_number = $coupon->coupon_number;
		}else{
			$coupon_condition = 2;
			$coupon_number = 0;
		}
		
		return view('admin.view_order')->with(compact('order_details','customer','shipping','order_details','coupon_condition','coupon_number','order','order_status'));

	}
    public function manage_order(){
    	$order = Order::orderby('created_at','DESC')->get();
    	return view('admin.manage_order')->with(compact('order'));
    }
}

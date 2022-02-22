<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The order confirmed</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    <div class="container" style="background: #222; border-radius: 12px; padding: 15px;">
        <div class="col-md-12">
            <p style="text-align: center; color:black">This is an automated email. Please do not reply to this email.!!!</p>
            <div class="row" style="background: cadetblue; padding: 15px">
                <div class="col-md-6" style="text-align:center; color:black; font-weight:bold; font-size: 30px;">
                    <h4 style="margin:0">NETNGUYEN PHONESTORE</h4>
                    <h6 style="margin:0">NGUYEN PHUC THUAN - GCS18697</h6>
                </div>
                <div class="col-md-6 logo" style="color:black">
                    <p>Hi! <strong style="color:#000; text-decoration:underline;">{{$shipping_array['customer_name']}}</strong></p>
                </div>

                <div class="col-md-12">
                    <p style="color:black; font-size:17px;">Information that you have used our services:</p>
                    <h4 style="color:#000; text-transform:uppercase;">The order information</h4>
                    <p>ID order: <strong style="text-transform:uppercase; color:black">{{$code['order_code']}}</strong> </p>
                    <p>Coupon code: <strong style="text-transform:uppercase; color:black">{{$code['coupon_code']}}</strong> </p>
                    <p>Fee ship: <strong style="text-transform:uppercase; color:black">{{$shipping_array['fee']}}</strong> </p>

                    <h4 style="color:#000; text-transform:uppercase;">Receiver information</h4>
                    <p>Email:
                        @if($shipping_array['shipping_email']=='')
                        <span style="color:black">None</span>
                        @else
                        <span style="color:black">{{$shipping_array['shipping_email']}}</span>
                        @endif
                    </p>
                    <p>Name receive:
                        @if($shipping_array['shipping_name']=='')
                        <span style="color:black">None</span>
                        @else
                        <span style="color:black">{{$shipping_array['shipping_name']}}</span>
                        @endif
                    </p>
                    <p>Phone receive:
                        @if($shipping_array['shipping_phone']=='')
                        <span style="color:black">None</span>

                        @else
                        <span style="color:black">{{$shipping_array['shipping_phone']}}</span>
                        @endif
                    </p>
                    <p>Address receive
                        @if($shipping_array['shipping_address']=='')
                        <span style="color:black">None</span>
                        @else
                        <span style="color:black">{{$shipping_array['shipping_address']}}</span>
                        @endif
                    </p>
                    <p>Notes receive:
                        @if($shipping_array['shipping_notes']=='')
                        <span style="color:black">None</span>
                        @else
                        <span style="color:black">{{$shipping_array['shipping_notes']}}</span>
                        @endif
                    </p>
                    <p>Payment method: <strong style="text-transform:uppercase; color:black">
                            @if($shipping_array['shipping_method']=='0')
                            <span style="color:black">Pay by ATM card</span>
                            @else
                            <span style="color:black">Pay with cash</span>
                            @endif
                        </strong>
                    </p>

                    <h4 style="color:#000; text-transform:uppercase;">The ordered product information</h4>
                    <table class="table table-striped" style="border:1px">
                        <thead>
                            <tr>
                                <th>Product name:</th>
                                <th>Product price:</th>
                                <th>Product quantity:</th>
                                <th>Payment:</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $sub_total = 0;
                            $total = 0;
                            @endphp
                            @foreach($cart_array as $cart)
                            @php
                            $sub_total = $cart['product_qty']*$cart['product_price'];
                            $total+=$sub_total;
                            @endphp

                            <tr>
                                <td>{{$cart['product_name']}}</td>
                                <td>{{number_format($cart['product_price'],0,',','.')}}VND</td>
                                <td><center>{{$cart['product_qty']}}</center></td>
                                <td>{{number_format($sub_total,0,',','.')}}VND</td>

                            </tr>
                            @endforeach

                            <tr>
                                <td colspan="4" align="right">Total payment: {{number_format($total,0,',','.')}}VND</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p style="color:black">For details please contact NGUYEN PHUC THUAN - GCS18697. Thank you for ordering from our shop!</p>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</html>
@extends('layout')
@section('content')
<div class="features_items">

    <h2 class="title text-center">{{$meta_title}}</h2>
    <div class="product-image-wrapper">
    @foreach($post as $key => $po)

        <div class="single-products" style="margin:10px 0; padding: 5px 0">
           {!!$po->post_content!!}
        </div>
        <div class="clearfix"></div>
    @endforeach
    </div>
</div>

@endsection
@extends('layout')
@section('content')
<div class="features_items">

    <h2 class="title text-center">{{$meta_title}}</h2>
    <div class="product-image-wrapper">
    @foreach($post as $key => $po)

        <div class="single-products" style="margin:10px 0; padding: 5px 0">
            <div class="text-center">

                @csrf
                    <img style="float:left; width:40%; height:300px; padding:8px" src="{{URL::to('public/uploads/post/'.$po->post_image)}}" alt="{{$po->post_slug}}" />
                    <h4 style="padding:5px" >{{$po->post_title}}</h4>
                    <p>{!!$po->post_desc!!}</p>
                                
            </div>
            <div class="text-right">
                <a href="{{url('/see-post/'.$po->post_slug)}}" class="btn btn-warning btn-sm">See post</a>

            </div>

        </div>
        <div class="clearfix"></div>
    @endforeach
    </div>
</div>

@endsection
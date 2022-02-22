@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add delivery
            </header>
            <?php

            use Illuminate\Support\Facades\Session;

            $message = Session::get('message');
            if ($message) {
                echo '<span class="text-alert">' . $message . '</span>';
                Session::put('message', null);
            }
            ?>
            <div class="panel-body">

                <div class="position-center">
                    <form>
                        @csrf

                        <div class="form-group">
                            <label for="exampleInputPassword1">Choose City</label>
                            <select name="city" id="city" class="form-control input-sm m-bot15 choose city">

                                <option value="">--Choose city--</option>
                                @foreach($city as $key => $ci)
                                <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Choose </label>
                            <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                                <option value="">--Choose district--</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Choose wards</label>
                            <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                <option value="">--Choose wards--</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Feeship</label>
                            <input type="text" name="fee_ship" class="form-control fee_ship" id="exampleInputEmail1">
                        </div>

                        <button type="button" name="add_delivery" class="btn btn-info add_delivery">Add feeship</button>
                    </form>
                </div>
                <div id="load_delivery">
                </div>
            </div>
        </section>
    </div>
@endsection
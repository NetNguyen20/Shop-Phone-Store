@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Add user
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
                    <form role="form" action="{{URL::to('store-users')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">User name</label>
                            <input type="text" name="admin_name" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="text" name="admin_email" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone</label>
                            <input type="text" name="admin_phone" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" name="admin_password" class="form-control" id="exampleInputEmail1">
                        </div>

                        <button type="submit" name="add_users" class="btn btn-info">Add users</button>
                    </form>
                </div>

            </div>
        </section>

    </div>
    @endsection
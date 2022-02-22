@extends('admin_layout')
@section('admin_content')
<h3>WELCOME, NGUYEN PHUC THUAN GCS18697</h3>
<div class="container-fluid">
    <style type="text/css">
        p.title_statistical{
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
    </style>

    <div class="row">
        <p class="title_statistical">Order sales statistics</p>
        <form autocomplete="off"> 
            @csrf

            <div class="col-md-2">
                <p>From date: <input type="text" id="datepicker" class="form-control"></p>
                <input type="button" class="btn btn-primary btn-sm" value="Filter result" id="btn-dashboard-filter">
            </div>

            <div class="col-md-2">
                <p>To date: <input type="text" id="datepicker2" class="form-control"></p>
            </div>

            <div class="col-md-2">
                <p>
                    Filter by:
                    <select class="dashboard-filter form-control">
                        <option>--Choose--</option>
                        <option value="7days">The past 7 days</option>
                        <option value="beforemonth">Last month</option>
                        <option value="thismonth">This month</option>
                        <option value="365days">The past 365 days</option>

                    </select>
                </p>
            </div>
        </form>

        <div class="col-md-12">
            <div id="chart" style="height: 250px;"></div>
        </div>
    </div>

    <!-- <div class="row">
        <style type="text/css">
            table.table.table-bordered.table-light{
                background: #32383e;

            }
            table.table.table-bordered.table-light{
                color: #fff;

            }

        </style>
        <p class="title_statistics">
            <center>ACCESS STATISTICS TABLE</center>
        </p>    

        <table class="table table-bordered table-light">
            <thead>
                <tr>
                    <th scope="col"><center>Online</center></th>
                    <th scope="col"><center>Total last month</center></th>
                    <th scope="col"><center>Total this month</center></th>
                    <th scope="col"><center>Total one year</center></th>
                    <th scope="col"><center>Total access</center></th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div> -->
<br>
<br>
    <div class="row">
        <div class="col-md-4 col-xs-10">
            <p class="title_statistics"><center>Statistics of total products, articles and orders</center></p>
            <div id="donut" class="morris-donut-inverse"></div>
        </div>
    </div>
</div>
@endsection
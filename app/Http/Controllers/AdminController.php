<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Login;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Statistic;
use Illuminate\Support\Carbon;
use function GuzzleHttp\json_encode;

class AdminController extends Controller
{
    public function AuthLogin(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function index(){
    	return view('admin_login');
    }
    
    public function show_dashboard(){
        $this->AuthLogin();

        $app_product = Product::all()->count();
        $app_post = Post::all()->count();
        $app_order = Order::all()->count();
        $app_customer = Customer::all()->count();

    	return view('admin.dashboard')->with(compact('app_product', 'app_post', 'app_order', 'app_customer'));
    }

    public function dashboard(Request $request){
        $admin_email = $request['admin_email'];
        $admin_password = md5($request['admin_password']);
        $login = Login::where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        if($login){
            $login_count = $login->count();
            if($login_count>0){
                Session::put('admin_name',$login->admin_name);
                Session::put('admin_id',$login->admin_id);
                return Redirect::to('/dashboard');
            }
        }else{
                Session::put('message','Password or account is wrong. Please re-enter');
                return Redirect::to('/admin');
        }

    }

    public function dashboard_filter(Request $request){
        $data = $request->all();
  
        $startofmonth = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $startbeforemonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $lastbeforemonth = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
  
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if($data['dashboard_value']=='7days'){
            $get = Statistic::whereBetween('order_date', [$sub7days,$now])->orderBy('order_date', 'ASC')->get();

        }elseif($data['dashboard_value']=='beforemonth'){
            $get = Statistic::whereBetween('order_date', [$startbeforemonth, $lastbeforemonth])->orderBy('order_date', 'ASC')->get();

        }elseif($data['dashboard_value']=='thismonth'){
            $get = Statistic::whereBetween('order_date', [$startofmonth, $now])->orderBy('order_date', 'ASC')->get();

        }else{
            $get = Statistic::whereBetween('order_date', [$sub365days, $now])->orderBy('order_date', 'ASC')->get();

        }

        foreach($get as $key => $sta){
            $chart_data[] = array(
                'stage' => $sta->order_date,
                'order' => $sta->total_order,
                'sales' => $sta->sales,
                'profit' => $sta->profit,
                'quantity' => $sta->quantity

            );
        }
        echo $data = json_encode($chart_data);

    }

    public function filter_by_date(Request $request){
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $get = Statistic::whereBetween('order_date', [$from_date,$to_date])->orderBy('order_date','ASC')->get();

        foreach($get as $key => $sta){
            $chart_data[] = array(
                'stage' => $sta->order_date,
                'order' => $sta->total_order,
                'sales' => $sta->sales,
                'profit' => $sta->profit,
                'quantity' => $sta->quantity
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function day_order(){
        $sub14days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(14)->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Statistic::whereBetween('order_date', [$sub14days, $now])->orderBy('order_date', 'ASC')->get();

        foreach($get as $key => $sta){
            $chart_data[] = array(
                'stage' => $sta->order_date,
                'order' => $sta->total_order,
                'sales' => $sta->sales,
                'profit' => $sta->profit,
                'quantity' => $sta->quantity

            );
        }
        echo $data = json_encode($chart_data);
    }



    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/');
    }
}

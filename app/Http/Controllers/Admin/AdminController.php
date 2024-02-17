<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $req)
    {
        if($req->session()->has('ADMIN_LOGIN')){
            return redirect('admin/dashboard');
        }else{
            return view('admin.login');
        }
    }

    public function auth(Request $req)
    {
        $email=$req->post('email');
        $password=$req->post('password');

        $result=Admin::where(['email'=>$email])->first();
        if($result){
            if(Hash::check($req->post('password'),$result->password)){
                $req->session()->put('ADMIN_LOGIN',true);
                $req->session()->put('ADMIN_ID',$result->id);
                return redirect('admin/dashboard');
            }else{
                $req->session()->flash('error','Please enter correct password');
                return redirect('admin');
            }
        }else{
            $req->session()->flash('error','Please enter valid login details');
            return redirect('admin');
        }
    }

    public function dashboard()
    {
        $result['order_c'] = DB::table('orders')->count();
        $result['order_pen_c'] = DB::table('orders')->leftJoin('orders_status','orders_status.id','=','orders.order_status')->where('orders_status.id','=','2')->count();
        $result['order_pla_c'] = DB::table('orders')->leftJoin('orders_status','orders_status.id','=','orders.order_status')->where('orders_status.id','=','1')->count();
        $result['order_del'] = DB::table('orders')->leftJoin('orders_status','orders_status.id','=','orders.order_status')->where('orders_status.id','=','3')->count();
        $result['pro'] = DB::table('products')->count();
        $result['cus'] = DB::table('customers')->count();
        $result['cus_nv'] = DB::table('customers')->where('is_verify',0)->count();
        $result['cus_v'] = DB::table('customers')->where('is_verify',1)->count();
        // dd($result);
        return view('admin.dashboard',$result);
    }
}

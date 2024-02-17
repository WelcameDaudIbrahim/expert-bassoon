<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $result['data']=Menu::all();
        return view('admin/menu',$result);
    }

    
    public function manage_menu(Request $request,$id='')
    {
        if($id>0){
            $arr=Menu::where(['id'=>$id])->get(); 

            $result['name']=$arr['0']->name;
            $result['parent_id']=$arr['0']->status;
            $result['sirial']=$arr['0']->sirial;
            $result['url']=$arr['0']->url;
            $result['status']=$arr['0']->status;
            $result['id']=$arr['0']->id;
        }else{
            $result['name']='';
            $result['parent_id']='';
            $result['sirial']='';
            $result['url']='';
            $result['status']='';
            $result['id']=0;
            
        }
        $result['menu']=DB::table('menus')->where(['status'=>1])->where('id','!=',$id)->get();
        return view('admin/manage_menu',$result);
    }

    public function manage_menu_process(Request $request)
    {
        //return $request->post();
        
        $request->validate([
            'name'=>'required',   
            'parent_id'=>'required',
        ]);

        if($request->post('id')>0){
            $model=Menu::find($request->post('id'));
            $msg="Menu updated";
        }else{
            $model=new Menu();
            $msg="Menu inserted";
        }
        $model->name=$request->post('name');
        $model->parent_id=$request->post('parent_id');
        $model->sirial=$request->post('sirial');
        $model->url=$request->post('url');
        $model->status=1;
        $model->save();
        $request->session()->flash('message',$msg);
        return redirect('admin/menu');
        
    }

    public function delete(Request $request,$id){
        $model=Menu::find($id);
        $model->delete();
        $request->session()->flash('message','Menu deleted');
        return redirect('admin/menu');
    }

    public function status(Request $request,$status,$id){
        $model=Menu::find($id);
        $model->status=$status;
        $model->save();
        $request->session()->flash('message','Menu status updated');
        return redirect('admin/menu');
    }
}

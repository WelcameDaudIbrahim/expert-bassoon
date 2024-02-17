<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Init;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InitController extends Controller
{
    function index()
    {
        $result['data'] = Init::all();
        return view('admin.init', $result);
    }
    function init_e(Request $req, $id)
    {
        // $result['data'] = Init::all();
        $model = Init::find($id);
        // dd($model);
        $msg = "Init updated";
        if ($req->hasfile('val')) {
            if ($model->id > 0) {
                if (Storage::exists('/public/media/' . $model->val)) {
                    Storage::delete('/public/media/' . $model->val);
                }
            }

            $image = $req->file('val');
            $ext = $image->extension();
            $image_name = time() . '.' . $ext;
            $image->storeAs('/public/media/', $image_name);
            $model->value = $image_name;
        } else {
            $model->value = $req->post('val');
        }
        $model->save();
        $req->session()->flash('message', $msg);
        return redirect('admin/init');
    }
    function init_i(Request $req)
    {
        // $arr = [
        //     ['name', 'text', 'ecomm'],
        //     ['color', 'color', '#ffffff'],
        //     ['email', 'email', 'hello@sundar.com'],
        //     ['suppport_num', 'text', '+65 11.188.888'],
        //     ['suppport_time', 'text', 'support 24/7 time'],
        //     ['address', 'text', '60-49 Road 11378 New York'],
        //     [
        //         'copy',
        //         'text',
        //         '                                Copyright &copy;
        //     <script>
        //         document.write(new Date().getFullYear());
        //     </script>
        //     All rights reserved | This Website is made by name'
        //     ],
        //     ['logo', 'file', 'll'],
        // ];
        $arr = [
            ['name', 'text', 'ecomm'],
            ['top_header_left', 'text', 'All Produst At Lowest Cost'],
            ['top_header_middle1', 'text', '<p>Choose the <span>Best</span> Deal</p>'],
            ['top_header_middle2', 'text', '<p>Get The <span>Best</span> Quality</p>'],
            ['top_header_middle3', 'text', '<p>On The <span>Best</span> Discount</p>'],
            ['footer_text_left', 'text', 'Appland is completely creative, lightweight, clean app landing page.'],
            [
                'footer_copyright',
                'text',
                'Made with <i class="lni-heart mr-1"></i>by<a class="ml-1" href="#" > Mine At <script> document.write(new Date().getFullYear()); </script> </a>'
            ],
            ['logo', 'file', 'll'],
            ['fav_icon', 'file', 'll'],
            ['slider1', 'file', 'll'],
        ];
        foreach ($arr as $item) {
            $model1 = Init::where('name', $item[0])->first();
            if (!isset($model1)) {
                $model = new Init;
                $model->name = $item[0];
                $model->type = $item[1];
                $model->value = $item[2];
                $model->save();
            }
        }
        $msg = "Init Upgraded";
        $req->session()->flash('message', $msg);
        return redirect('admin/init');
    }
}
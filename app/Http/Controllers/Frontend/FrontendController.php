<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function index()
    {
        $result['home_categories'] = DB::table('categories')
            ->where(['status' => 1])
            ->where(['is_home' => 1])
            ->inRandomOrder()
            ->get();

        foreach ($result['home_categories'] as $list) {
            $result['home_categories_product'][$list->id] =
            DB::table('products')
                ->where(['status' => 1])
                ->where(['category_id' => $list->id])
                // ->orwhere(['parent_category_id' => $list->id])
                ->get();

            foreach ($result['home_categories_product'][$list->id] as $list1) {
                $result['home_product_attr'][$list1->id] =
                DB::table('products_attr')
                    ->where(['products_attr.products_id' => $list1->id])
                    ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                    ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                    ->get();
            }
        }

        // dd($result['home_categories_product']);
        // $result['home_brand'] = DB::table('brands')
        //     ->where(['status' => 1])
        //     ->where(['is_home' => 1])
        //     ->get();
        // $result['home_featured_product'] =
        // DB::table('products')
        //     ->where(['status' => 1])
        //     ->where(['is_featured' => 1])
        //     ->get();

        // foreach ($result['home_featured_product'] as $list1) {
        //     $result['home_featured_product_attr'][$list1->id] =
        //     DB::table('products_attr')
        //         ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
        //         ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
        //         ->where(['products_attr.products_id' => $list1->id])
        //         ->get();
        // }

        // //dd($result['home_featured_product'][2]);
        // $result['home_tranding_product'] =
        // DB::table('products')
        //     ->where(['status' => 1])
        //     ->where(['is_tranding' => 1])
        //     ->get();

        // foreach ($result['home_tranding_product'] as $list1) {
        //     $result['home_tranding_product_attr'][$list1->id] =
        //     DB::table('products_attr')
        //         ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
        //         ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
        //         ->where(['products_attr.products_id' => $list1->id])
        //         ->get();
        // }

        // $result['home_discounted_product'] =
        // DB::table('products')
        //     ->where(['status' => 1])
        //     ->where(['is_discounted' => 1])
        //     ->get();
        $result['product'] = 
        DB::table('products')
            ->where(['status' => 1])
            ->inRandomOrder()
            ->get();

        foreach ($result['product'] as $list1) {
            $result['product_attr'][$list1->id] =
            DB::table('products_attr')
                ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                ->where(['products_attr.products_id' => $list1->id])
                ->get();
        }
        // foreach ($result['home_discounted_product'] as $list1) {
        //     $result['home_discounted_product_attr'][$list1->id] =
        //     DB::table('products_attr')
        //         ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
        //         ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
        //         ->where(['products_attr.products_id' => $list1->id])
        //         ->get();
        // }

        $result['home_banner'] = DB::table('home_banners')
            ->where(['status' => 1])
            ->get();

        return view('frontend.index', $result);
    }
    public function product(Request $request, $slug = '')
    {
        $result['product'] =
        DB::table('products')
            ->where(['status' => 1])
            ->where(['slug' => $slug])
            ->get();
        if (!isset($result['product'][0]->id)) {
            return redirect('/');
        }
        foreach ($result['product'] as $list1) {
            $result['product_attr'][$list1->id] =
            DB::table('products_attr')
                ->where(['products_attr.products_id' => $list1->id])
                ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                ->get();
        }

        foreach ($result['product'] as $list1) {
            $result['product_images'][$list1->id] =
            DB::table('product_images')
                ->where(['product_images.products_id' => $list1->id])
                ->get();
        }
        $result['related_product'] =
        DB::table('products')
            ->inRandomOrder()
            ->where(['status' => 1])
            ->where('slug', '!=', $slug)
            ->where(['category_id' => $result['product'][0]->category_id])
            ->limit(4)
            ->get();
        foreach ($result['related_product'] as $list1) {
            $result['related_product_attr'][$list1->id] =
            DB::table('products_attr')
                ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
                ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
                ->where(['products_attr.products_id' => $list1->id])
                ->get();
        }

        $result['product_review'] =
        DB::table('product_review')
            ->where(['product_review.products_id' => $result['product'][0]->id])
            ->leftJoin('customers', 'customers.id', '=', 'product_review.customer_id')
            ->where(['product_review.status' => 1])
            ->orderBy('product_review.added_on', 'desc')
            ->select('product_review.rating', 'product_review.review', 'product_review.added_on', 'customers.name')
            ->get();
        $result['review_group'] = DB::table('product_review')
            ->where(['product_review.products_id' => $result['product'][0]->id])
            ->where(['product_review.status' => 1])
            ->select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->get();
        $result['review_total'] = DB::table('product_review')
            ->where(['product_review.products_id' => $result['product'][0]->id])->where(['product_review.status' => 1])->count();
        $result['review_rating'] = DB::table('product_review')
            ->where(['product_review.products_id' => $result['product'][0]->id])->where(['product_review.status' => 1])->sum('rating');
        $result['review_per'] = [];
        $result['review_star'] = [];
        foreach ($result['review_group'] as $val) {
            $result['review_per'][$val->rating] = $val->total / $result['review_total'] * 100;
            $result['review_star'][$val->rating] = $val->total;
        }
        // dd($result['review_per']);
        return view('frontend.product', $result);
    }
    public function add_to_cart(Request $request)
    {
        if ($request->session()->has('FRONT_USER_LOGIN')) {
            $uid = $request->session()->get('FRONT_USER_ID');
            $user_type = "Reg";
        } else {
            $uid = getUserTempId();
            $user_type = "Not-Reg";
        }

        $size_id = $request->post('size_id');
        $color_id = $request->post('color_id');
        $pqty = $request->post('pqty');
        $product_id = $request->post('product_id');

        $result = DB::table('products_attr')
            ->select('products_attr.id')
            ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
            ->where(['products_id' => $product_id])
            ->where(['sizes.size' => $size_id])
            ->where(['colors.color' => $color_id])
            ->get();
        $result1 = DB::table('products_attr')
            ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
            ->where(['products_id' => $product_id])
            ->where(['sizes.size' => $size_id])
            ->where(['colors.color' => $color_id])
            ->get();
        $product_attr_id = $result[0]->id;
        // $getAvaliableQty=getAvaliableQty($product_id,$product_attr_id);
        // $finalAvaliable=$getAvaliableQty[0]->pqty-$getAvaliableQty[0]->qty;
        if (!($pqty <= $result1[0]->qty)) {
            if ($result1[0]->qty == 0) {
                return response()->json(['msg' => "not_avaliable", 'data' => "Not Avaliable"]);
            } else {
                return response()->json(['msg' => "not_avaliable", 'data' => "Only " . $result1[0]->qty . " left"]);
            }
        }

        $check = DB::table('cart')
            ->where(['user_id' => $uid])
            ->where(['user_type' => $user_type])
            ->where(['product_id' => $product_id])
            ->where(['product_attr_id' => $product_attr_id])
            ->get();
        if (isset($check[0])) {
            $update_id = $check[0]->id;
            if ($pqty == 0) {
                DB::table('cart')
                    ->where(['id' => $update_id])
                    ->delete();
                $msg = "removed";
            } else {
                DB::table('cart')
                    ->where(['id' => $update_id])
                    ->update(['qty' => $pqty]);
                $msg = "updated";
            }
        } else {
            $id = DB::table('cart')->insertGetId([
                'user_id' => $uid,
                'user_type' => $user_type,
                'product_id' => $product_id,
                'product_attr_id' => $product_attr_id,
                'qty' => $pqty,
                'added_on' => date('Y-m-d h:i:s'),
            ]);
            $msg = "added";
        }
        $result = DB::table('cart')
            ->leftJoin('products', 'products.id', '=', 'cart.product_id')
            ->leftJoin('products_attr', 'products_attr.id', '=', 'cart.product_attr_id')
            ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
            ->where(['user_id' => $uid])
            ->where(['user_type' => $user_type])
            ->select('cart.qty', 'products.name', 'products.image', 'sizes.size', 'colors.color', 'products_attr.price', 'products.slug', 'products.id as pid', 'products_attr.id as attr_id')
            ->get();
        return response()->json(['msg' => $msg, 'data' => $result, 'totalItem' => count($result)]);
    }
    public function cart(Request $request)
    {
        if ($request->session()->has('FRONT_USER_LOGIN')) {
            $uid = $request->session()->get('FRONT_USER_ID');
            $user_type = "Reg";
        } else {
            $uid = getUserTempId();
            $user_type = "Not-Reg";
        }
        $result['list'] = DB::table('cart')
            ->leftJoin('products', 'products.id', '=', 'cart.product_id')
            ->leftJoin('products_attr', 'products_attr.id', '=', 'cart.product_attr_id')
            ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
            ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
            ->where(['user_id' => $uid])
            ->where(['user_type' => $user_type])
            ->select('cart.qty', 'products.name', 'products.image', 'sizes.size', 'colors.color', 'products_attr.price', 'products.slug', 'products.id as pid', 'products_attr.qty as pqty', 'products_attr.id as attr_id')
            ->get();
        return view('frontend.cart', $result);
    }
    public function login(Request $req)
    {
        // if ($req->session()->has('FRONT_USER_LOGIN') != null) {
        // return view('frontend.login');
        // }
        return redirect('/reg');
    }
    public function reg(Request $req)
    {
        if ($req->session()->has('FRONT_USER_LOGIN') != null) {
            return redirect('/');
        }

        return view('frontend.register');
    }
    public function reg_process(Request $request)
    {
        $valid = Validator::make($request->all(), [
            "name" => 'required',
            "email" => 'email|unique:customers,email',
            "password" => 'required',
            "mobile" => 'required|numeric|digits:10',
        ]);

        if (!$valid->passes()) {
            return response()->json(['status' => 'error', 'error' => $valid->errors()->toArray()]);
        } else {
            $rand_id = rand(111111111, 999999999);
            $arr = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Crypt::encrypt($request->password),
                "mobile" => $request->mobile,
                "status" => 1,
                "is_verify" => 0,
                "is_forgot_password" => 0,
                "rand_id" => $rand_id,
                "created_at" => date('Y-m-d h:i:s'),
                "updated_at" => date('Y-m-d h:i:s'),
            ];
            $query = DB::table('customers')->insert($arr);
            if ($query > 0) {
                // Mail::send('front/email_verification',$data,function($messages) use ($user){
                //     $messages->to($user['to']);
                //     $messages->subject('Email Id Verification');
                // });
                // sendMail('Email Verification', '<!DOCTYPE html> <head> <meta charset="utf-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine --> <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely --> <title></title> <!-- The title tag shows in email notifications, like Android 4.4. --> <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet"> <!-- CSS Reset : BEGIN --> <style> /* What it does: Remove spaces around the email design added by some email clients. */ /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */ html, body { margin: 0 auto !important; padding: 0 !important; height: 100% !important; width: 100% !important; background: #f1f1f1; } /* What it does: Stops email clients resizing small text. */ * { -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; } /* What it does: Centers email on Android 4.4 */ div[style*="margin: 16px 0"] { margin: 0 !important; } /* What it does: Stops Outlook from adding extra spacing to tables. */ table, td { mso-table-lspace: 0pt !important; mso-table-rspace: 0pt !important; } /* What it does: Fixes webkit padding issue. */ table { border-spacing: 0 !important; border-collapse: collapse !important; table-layout: fixed !important; margin: 0 auto !important; } /* What it does: Uses a better rendering method when resizing images in IE. */ img { -ms-interpolation-mode:bicubic; } /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */ a { text-decoration: none; } /* What it does: A work-around for email clients meddling in triggered links. */ *[x-apple-data-detectors],  /* iOS */ .unstyle-auto-detected-links *, .aBn { border-bottom: 0 !important; cursor: default !important; color: inherit !important; text-decoration: none !important; font-size: inherit !important; font-family: inherit !important; font-weight: inherit !important; line-height: inherit !important; } /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */ .a6S { display: none !important; opacity: 0.01 !important; } /* What it does: Prevents Gmail from changing the text color in conversation threads. */ .im { color: inherit !important; } img.g-img + div { display: none !important; } /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */ @media only screen and (min-device-width: 320px) and (max-device-width: 374px) { u ~ div .email-container { min-width: 320px !important; } } /* iPhone 6, 6S, 7, 8, and X */ @media only screen and (min-device-width: 375px) and (max-device-width: 413px) { u ~ div .email-container { min-width: 375px !important; } } /* iPhone 6+, 7+, and 8+ */ @media only screen and (min-device-width: 414px) { u ~ div .email-container { min-width: 414px !important; } } </style> <!-- CSS Reset : END --> <!-- Progressive Enhancements : BEGIN --> <style> .primary{ background: #30e3ca; } .bg_white{ background: #ffffff; } .bg_light{ background: #fafafa; } .bg_black{ background: #000000; } .bg_dark{ background: rgba(0,0,0,.8); } .email-section{ padding:2.5em; } /*BUTTON*/ .btn{ padding: 10px 15px; display: inline-block; } .btn.btn-primary{ border-radius: 5px; background: #30e3ca; color: #ffffff; } .btn.btn-white{ border-radius: 5px; background: #ffffff; color: #000000; } .btn.btn-white-outline{ border-radius: 5px; background: transparent; border: 1px solid #fff; color: #fff; } .btn.btn-black-outline{ border-radius: 0px; background: transparent; border: 2px solid #000; color: #000; font-weight: 700; } h1,h2,h3,h4,h5,h6{ font-family: "Lato", sans-serif; color: #000000; margin-top: 0; font-weight: 400; } body{ font-family: "Lato", sans-serif; font-weight: 400; font-size: 15px; line-height: 1.8; color: rgba(0,0,0,.4); } a{ color: #30e3ca; } table{ } </style> </head> <body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;"> <center style="width: 100%; background-color: #f1f1f1;"> <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;"> &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp; </div> <div style="max-width: 600px; margin: 0 auto;" class="email-container"> <!-- BEGIN BODY --> <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;"> <tr> <td valign="top" class="bg_white" style="padding: 1em 2.5em 0 2.5em;"> <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"> <tr> <td class="logo" style="text-align: center;"> <h1><a href="#">' . getInit('name') . '</a></h1> </td> </tr> </table> </td> </tr><!-- end tr --> <tr> </tr><!-- end tr --> <tr> <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;"> <table> <tr> <td> <div class="text" style="padding: 0 2.5em; text-align: center;"> <h2>Please verify your email</h2> <p><a href="' . url('/verification') . '/' . $rand_id . '" class="btn btn-primary">Click Here</a></p> </div> </td> </tr> </table> </td> </tr><!-- end tr --> </table> </div> </center> </body> </html>', $request->email);
                $request->session()->flash('msg', "User Register Successfully");
                return response()->json(['status' => 'success', 'msg' => 'User Register Successfully']);
            }
        }
    }

    public function login_process(Request $request)
    {

        $result = DB::table('customers')
            ->where(['email' => $request->str_login_email])
            ->get();

        if (isset($result[0])) {
            $db_pwd = Crypt::decrypt($result[0]->password);
            $status = $result[0]->status;
            $is_verify = $result[0]->is_verify;

            // if ($is_verify == 0) {
            //     return response()->json(['status' => "error", 'msg' => 'Please verify your email id']);
            // }
            if ($status == 0) {
                return response()->json(['status' => "error", 'msg' => 'Your account has been deactivated']);
            }

            if ($db_pwd == $request->str_login_password) {

                if ($request->rememberme === null) {
                    setcookie('login_email', $request->str_login_email, 100);
                    setcookie('login_pwd', $request->str_login_password, 100);
                } else {
                    setcookie('login_email', $request->str_login_email, time() + 60 * 60 * 24 * 100);
                    setcookie('login_pwd', $request->str_login_password, time() + 60 * 60 * 24 * 100);
                }

                $request->session()->put('FRONT_USER_LOGIN', true);
                $request->session()->put('FRONT_USER_ID', $result[0]->id);
                $request->session()->put('FRONT_USER_NAME', $result[0]->name);
                $status = "success";
                $msg = "Successful Login";

                $getUserTempId = getUserTempId();
                DB::table('cart')
                    ->where(['user_id' => $getUserTempId, 'user_type' => 'Not-Reg'])
                    ->update(['user_id' => $result[0]->id, 'user_type' => 'Reg']);
            } else {
                $status = "error";
                $msg = "Please enter valid password";
            }
        } else {
            $status = "error";
            $msg = "Please enter valid email id";
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
        //$request->password
    }
    public function t()
    {
        $productName = str_replace("form", "form style='display:none;'", fake()->randomHtml(rand(3, 3), rand(3, 3)));

        echo "$productName";
        //        dd(Crypt::decrypt('eyJpdiI6InJ4SVpOZHJyTi9iSTZ1blgyVzBzZWc9PSIsInZhbHVlIjoid0l6T2RVOTdMVW5yVXRkNzBhcnhNdz09IiwibWFjIjoiYzg1OWY5NDYzMjVjOWMwOWU5ZmI2ZGQzYjk0NzNmMTNlMmNmYmZkM2Y1YjdkZDBjNWJjNGI1NDhiZTM1YzBlMCIsInRhZyI6IiJ9'));
        //        return sendMail('sub','body','daudsweb@gmail.com');
        //        return 'Shut Up';
    }
    public function email_verification(Request $request, $id)
    {
        $result = DB::table('customers')
            ->where(['rand_id' => $id])
            ->where(['is_verify' => 0])
            ->get();

        if (isset($result[0])) {
            DB::table('customers')
                ->where(['id' => $result[0]->id])
                ->update(['is_verify' => 1, 'rand_id' => '']);
            $request->session()->flash('msg', "User Verify Successfylly");
            return redirect('/login');
        } else {
            return redirect('/');
        }
    }
    public function checkout(Request $request)
    {
        $result['cart_data'] = getAddToCartTotalItem();

        if (isset($result['cart_data'][0])) {

            if ($request->session()->has('FRONT_USER_LOGIN')) {
                $uid = $request->session()->get('FRONT_USER_ID');
                $customer_info = DB::table('customers')
                    ->where(['id' => $uid])
                    ->get();
                $result['customers']['name'] = $customer_info[0]->name;
                $result['customers']['email'] = $customer_info[0]->email;
                $result['customers']['mobile'] = $customer_info[0]->mobile;
                $result['customers']['address'] = $customer_info[0]->address;
                $result['customers']['city'] = $customer_info[0]->city;
                $result['customers']['state'] = $customer_info[0]->state;
                $result['customers']['zip'] = $customer_info[0]->zip;
            } else {
                $result['customers']['name'] = '';
                $result['customers']['email'] = '';
                $result['customers']['mobile'] = '';
                $result['customers']['address'] = '';
                $result['customers']['city'] = '';
                $result['customers']['state'] = '';
                $result['customers']['zip'] = '';
            }

            return view('frontend.checkout', $result);
        } else {
            return redirect('/');
        }
    }
    public function place_order(Request $request)
    {
        $payment_url = '';
        $rand_id = rand(111111111, 999999999);

        $valid = Validator::make($request->all(), [
            "name" => 'required',
            "email" => 'required|',
            "address" => 'required',
            "mobile" => 'required|numeric|digits:10',
            "city" => 'required',
            "state" => 'required',
            "zip" => 'required',
        ]);
        if (!$valid->passes()) {
            return response()->json(['status' => 'error', 'msg' => $valid->errors()]);
        }
        if ($request->session()->has('FRONT_USER_LOGIN')) {
        } else {
            $valid = Validator::make($request->all(), [
                "email" => 'required|email|unique:customers,email',
            ]);

            if (!$valid->passes()) {
                return response()->json(['status' => 'error', 'msg' => "The email has already been taken"]);
            } else {
                $arr = [
                    "name" => $request->name,
                    "email" => $request->email,
                    "address" => $request->address,
                    "city" => $request->city,
                    "state" => $request->state,
                    "zip" => $request->zip,
                    "password" => Crypt::encrypt($rand_id),
                    "mobile" => $request->mobile,
                    "status" => 1,
                    "is_verify" => 1,
                    "rand_id" => $rand_id,
                    "created_at" => date('Y-m-d h:i:s'),
                    "updated_at" => date('Y-m-d h:i:s'),
                    "is_forgot_password" => 0,
                ];

                $user_id = DB::table('customers')->insertGetId($arr);
                $request->session()->put('FRONT_USER_LOGIN', true);
                $request->session()->put('FRONT_USER_ID', $user_id);
                $request->session()->put('FRONT_USER_NAME', $request->name);

                sendMail('Order Placed', '<div style="font-family: "Playfair Display", Georgia, serif;">Login Ditals<br/>Name:' . $request->name . '</br>Email:' . $request->email . '</br>Password:' . $rand_id . '</div>', $request->email, $request->name);

                $getUserTempId = getUserTempId();
                DB::table('cart')
                    ->where(['user_id' => $getUserTempId, 'user_type' => 'Not-Reg'])
                    ->update(['user_id' => $user_id, 'user_type' => 'Reg']);
            }
        }
        $coupon_value = 0;
        if ($request->coupon_code != '') {
            $arr = apply_coupon_code($request->coupon_code);
            $arr = json_decode($arr, true);
            if ($arr['status'] == 'success') {
                $coupon_value = $arr['coupon_code_value'];
            } else {
                return response()->json(['status' => 'false', 'msg' => $arr['msg']]);
            }
        }

        $uid = $request->session()->get('FRONT_USER_ID');
        $totalPrice = 0;
        $getAddToCartTotalItem = getAddToCartTotalItem();
        foreach ($getAddToCartTotalItem as $list) {
            $totalPrice = $totalPrice + ($list->qty * $list->price);
        }
        $arr = [
            "customers_id" => $uid,
            "name" => $request->name,
            "email" => $request->email,
            "mobile" => $request->mobile,
            "address" => $request->address,
            "city" => $request->city,
            "state" => $request->state,
            "pincode" => $request->zip,
            "coupon_code" => $request->coupon_code,
            "coupon_value" => $coupon_value,
            "payment_type" => $request->payment_type,
            "payment_status" => "Pending",
            "total_amt" => $totalPrice,
            "order_status" => 1,
            "added_on" => date('Y-m-d h:i:s'),
        ];
        $order_id = DB::table('orders')->insertGetId($arr);

        if ($order_id > 0) {
            foreach ($getAddToCartTotalItem as $list) {
                $prductDetailArr['product_id'] = $list->pid;
                $prductDetailArr['products_attr_id'] = $list->attr_id;
                $prductDetailArr['price'] = $list->price;
                $prductDetailArr['qty'] = $list->qty;
                $prductDetailArr['orders_id'] = $order_id;
                DB::table('orders_details')->insert($prductDetailArr);
                $model_pro = DB::table('products_attr')->where('id', $list->attr_id)->first();

                DB::table('products_attr')->where('id', $list->attr_id)->update(['qty' => $model_pro->qty - $list->qty]);
            }

            if ($request->payment_type == 'oljGateway') {
                $final_amt = $totalPrice - $coupon_value;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt(
                    $ch,
                    CURLOPT_HTTPHEADER,
                    array(
                        "X-Api-Key:KEY",
                        "X-Auth-Token:TOKEN",
                    )
                );
                $payload = array(
                    'purpose' => 'Buy Product',
                    'amount' => $final_amt,
                    'phone' => $request->mobile,
                    'buyer_name' => $request->name,
                    'redirect_url' => 'http://127.0.0.1:8000/instamojo_payment_redirect',
                    'send_email' => true,
                    'send_sms' => true,
                    'email' => $request->email,
                    'allow_repeated_payments' => false,
                );
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
                $response = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($response);
                if (isset($response->payment_request->id)) {
                    $txn_id = $response->payment_request->id;
                    DB::table('orders')
                        ->where(['id' => $order_id])
                        ->update(['txn_id' => $txn_id]);
                    $payment_url = $response->payment_request->longurl;
                } else {
                    $msg = "";
                    foreach ($response->message as $key => $val) {
                        $msg .= strtoupper($key) . ": " . $val[0] . '<br/>';
                    }
                    return response()->json(['status' => 'error', 'msg' => $msg, 'payment_url' => '']);
                }
            }
            DB::table('cart')->where(['user_id' => $uid, 'user_type' => 'Reg'])->delete();
            $request->session()->put('ORDER_ID', $order_id);

            $status = "success";
            $msg = "Order placed";
        } else {
            $status = "false";
            $msg = "Please try after sometime";
        }
        return response()->json(['status' => $status, 'msg' => $msg, 'payment_url' => $payment_url]);
    }
    public function order_placed(Request $request)
    {
        if ($request->session()->has('ORDER_ID')) {
            $order = DB::table('orders')->where('id', $request->session()->get('ORDER_ID'))->get();
            // dd($order[0]->name);
            $result['order_id'] = str_replace(["-", ':', ' '], "", $order[0]->added_on . session()->get('ORDER_ID') . $order[0]->total_amt);
            return view('frontend.order_placed', $result);
        } else {
            return redirect('/');
        }
    }
    public function order(Request $request)
    {
        $result['orders'] = DB::table('orders')
            ->select('orders.*', 'orders_status.orders_status')
            ->leftJoin('orders_status', 'orders_status.id', '=', 'orders.order_status')
            ->where(['orders.customers_id' => $request->session()->get('FRONT_USER_ID')])
            ->get();
        return view('frontend.order', $result);
    }

    public function order_detail(Request $request, $id)
    {
        $result['orders_details'] =
        DB::table('orders_details')
            ->select('orders.*', 'orders_details.price', 'orders_details.qty', 'products.name as pname', 'products_attr.attr_image', 'sizes.size', 'colors.color', 'orders_status.orders_status')
            ->leftJoin('orders', 'orders.id', '=', 'orders_details.orders_id')
            ->leftJoin('products_attr', 'products_attr.id', '=', 'orders_details.products_attr_id')
            ->leftJoin('products', 'products.id', '=', 'products_attr.products_id')
            ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
            ->leftJoin('orders_status', 'orders_status.id', '=', 'orders.order_status')
            ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
            ->where(['orders.id' => $id])
            ->where(['orders.customers_id' => $request->session()->get('FRONT_USER_ID')])
            ->get();
        if (!isset($result['orders_details'][0])) {
            return redirect('/');
        }
        return view('frontend.order_details', $result);
    }
    public function category(Request $request, $slug)
    {

        $sort = "";
        $sort_txt = "";
        $filter_price_start = "";
        $filter_price_end = "";
        $color_filter = "";
        $size_filter = "";
        $colorFilterArr = [];
        $sizeFilterArr = [];
        if ($request->get('sort') !== null) {
            $sort = $request->get('sort');
        }
        $cateID=Category::where('category_slug','=',$slug)->get()[0]->id;
        // dd($cateID);
        $query = DB::table('products');
        $query = $query->leftJoin('categories', 'categories.id', '=', 'products.category_id');
        $query = $query->where(['products.status' => 1]);
        $query = $query->where(['categories.id' => $cateID]);
        $query = $query->orwhere(['categories.parent_category_id' => $cateID]);
        // dd($query->get());
        $query = $query->leftJoin('products_attr', 'products.id', '=', 'products_attr.products_id');
        if ($sort == 'name') {
            $query = $query->orderBy('products.name', 'asc');
            $sort_txt = "Name";
        }
        if ($sort == 'date') {
            $query = $query->orderBy('products.id', 'desc');
            $sort_txt = "Date";
        }
        if ($sort == 'price_desc') {
            $query = $query->orderBy('products_attr.price', 'desc');
            $sort_txt = "Price High To Low";
        }
        if ($sort == 'price_asc') {
            $query = $query->orderBy('products_attr.price', 'asc');
            $sort_txt = "Price Low To High";
        }
        if ($request->get('filter_price_start') !== null && $request->get('filter_price_end') !== null) {
            $filter_price_start = $request->get('filter_price_start');
            $filter_price_end = $request->get('filter_price_end');

            if ($filter_price_start > 0 && $filter_price_end > 0) {
                $query = $query->whereBetween('products_attr.price', [$filter_price_start, $filter_price_end]);
            }
        }

        if ($request->get('color_filter') !== null) {
            $color_filter = $request->get('color_filter');
            $colorFilterArr = explode(":", $color_filter);
            $colorFilterArr = array_filter($colorFilterArr);

            $query = $query->where(['products_attr.color_id' => $request->get('color_filter')]);
        }
        if ($request->get('size_filter') !== null) {
            $size_filter = $request->get('size_filter');
            $sizeFilterArr = explode(":", $size_filter);
            $sizeFilterArr = array_filter($sizeFilterArr);

            $query = $query->where(['products_attr.size_id' => $request->get('size_filter')]);
        }

        $query = $query->distinct()->select('products.*');
        $query = $query->get();
        $a = arrayPaginate($query, 12, $request->page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
        $result['product'] = $a;

        foreach ($result['product'] as $list1) {

            $query1 = DB::table('products_attr');
            $query1 = $query1->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id');
            $query1 = $query1->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id');
            $query1 = $query1->where(['products_attr.products_id' => $list1->id]);
            $query1 = $query1->get();
            $result['product_attr'][$list1->id] = $query1;
        }

        $result['colors'] = DB::table('colors')
            ->where(['status' => 1])
            ->get();
        $result['sizes'] = DB::table('sizes')
            ->where(['status' => 1])
            ->get();

        $result['categories_left'] = DB::table('categories')
            ->where(['status' => 1])
            ->where(['parent_category_id' => 0])
            ->get();

        $result['slug'] = $slug;
        $result['sort'] = $sort;
        $result['sort_txt'] = $sort_txt;
        $result['filter_price_start'] = $filter_price_start;
        $result['filter_price_end'] = $filter_price_end;
        $result['color_filter'] = $color_filter;
        $result['colorFilterArr'] = $colorFilterArr;
        $result['size_filter'] = $size_filter;
        $result['sizeFilterArr'] = $sizeFilterArr;
        return view('frontend.category', $result);
    }
    public function shop(Request $request)
    {

        $sort = "";
        $sort_txt = "";
        $filter_price_start = "";
        $filter_price_end = "";
        $color_filter = "";
        $size_filter = "";
        $colorFilterArr = [];
        $sizeFilterArr = [];
        if ($request->get('sort') !== null) {
            $sort = $request->get('sort');
        }

        $query = DB::table('products');
        $query = $query->leftJoin('categories', 'categories.id', '=', 'products.category_id');
        $query = $query->leftJoin('products_attr', 'products.id', '=', 'products_attr.products_id');
        $query = $query->where(['products.status' => 1]);
        if ($sort == 'name') {
            $query = $query->orderBy('products.name', 'asc');
            $sort_txt = "Product Name";
        }
        if ($sort == 'date') {
            $query = $query->orderBy('products.id', 'desc');
            $sort_txt = "Date";
        }
        if ($sort == 'price_desc') {
            $query = $query->orderBy('products_attr.price', 'desc');
            $sort_txt = "Price - DESC";
        }
        if ($sort == 'price_asc') {
            $query = $query->orderBy('products_attr.price', 'asc');
            $sort_txt = "Price - ASC";
        }
        if ($request->get('filter_price_start') !== null && $request->get('filter_price_end') !== null) {
            $filter_price_start = $request->get('filter_price_start');
            $filter_price_end = $request->get('filter_price_end');

            if ($filter_price_start > 0 && $filter_price_end > 0) {
                $query = $query->whereBetween('products_attr.price', [$filter_price_start, $filter_price_end]);
            }
        }

        if ($request->get('color_filter') !== null) {
            $color_filter = $request->get('color_filter');
            $colorFilterArr = explode(":", $color_filter);
            $colorFilterArr = array_filter($colorFilterArr);

            $query = $query->where(['products_attr.color_id' => $request->get('color_filter')]);
        }
        if ($request->get('size_filter') !== null) {
            $size_filter = $request->get('size_filter');
            $sizeFilterArr = explode(":", $size_filter);
            $sizeFilterArr = array_filter($sizeFilterArr);

            $query = $query->where(['products_attr.size_id' => $request->get('size_filter')]);
        }

        $query = $query->distinct()->select('products.*');
        $query = $query->get();
        $a = arrayPaginate($query, 9, $request->page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
        $result['product'] = $a;

        foreach ($result['product'] as $list1) {

            $query1 = DB::table('products_attr');
            $query1 = $query1->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id');
            $query1 = $query1->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id');
            $query1 = $query1->where(['products_attr.products_id' => $list1->id]);
            $query1 = $query1->get();
            $result['product_attr'][$list1->id] = $query1;
        }

        $result['colors'] = DB::table('colors')
            ->where(['status' => 1])
            ->get();
        $result['sizes'] = DB::table('sizes')
            ->where(['status' => 1])
            ->get();

        $result['categories_left'] = DB::table('categories')
            ->where(['status' => 1])
            ->where(['parent_category_id' => 0])
            ->get();

        $result['sort'] = $sort;
        $result['sort_txt'] = $sort_txt;
        $result['filter_price_start'] = $filter_price_start;
        $result['filter_price_end'] = $filter_price_end;
        $result['color_filter'] = $color_filter;
        $result['colorFilterArr'] = $colorFilterArr;
        $result['size_filter'] = $size_filter;
        $result['sizeFilterArr'] = $sizeFilterArr;
        return view('frontend.shop', $result);
    }
    public function search(Request $req, $str)
    {
        $result['product'] =
        $query = DB::table('products');
        $query = $query->leftJoin('categories', 'categories.id', '=', 'products.category_id');
        $query = $query->leftJoin('products_attr', 'products.id', '=', 'products_attr.products_id');
        $query = $query->where(['products.status' => 1]);
        $query = $query->where('name', 'like', "%$str%");
        $query = $query->orwhere('short_desc', 'like', "%$str%");
        $query = $query->orwhere('desc', 'like', "%$str%");
        $query = $query->orwhere('keywords', 'like', "%$str%");
        $query = $query->distinct()->select('products.*');
        $query = $query->paginate(9);
        $result['product'] = $query;

        $result['categories_left'] = DB::table('categories')
            ->where(['status' => 1])
            ->where(['parent_category_id' => 0])
            ->get();

        foreach ($result['product'] as $list1) {

            $query1 = DB::table('products_attr');
            $query1 = $query1->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id');
            $query1 = $query1->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id');
            $query1 = $query1->where(['products_attr.products_id' => $list1->id]);
            $query1 = $query1->get();
            $query1 = $query1->unique();

            $result['product_attr'][$list1->id] = $query1;
        }
        $result['str'] = $str;

        return view('frontend.search', $result);
    }
    public function forgot_password(Request $request)
    {
        return view('frontend.forgot_password');
    }
    public function forgot_passwordb(Request $request)
    {

        $result = DB::table('customers')
            ->where(['email' => $request->str_forgot_email])
            ->get();
        $rand_id = rand(111111111, 999999999);
        if (isset($result[0])) {

            DB::table('customers')
                ->where(['email' => $request->str_forgot_email])
                ->update(['is_forgot_password' => 1, 'rand_id' => $rand_id]);

            sendMail('Password Reset', '<!DOCTYPE html> <head> <meta charset="utf-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine --> <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely --> <title></title> <!-- The title tag shows in email notifications, like Android 4.4. --> <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet"> <!-- CSS Reset : BEGIN --> <style> /* What it does: Remove spaces around the email design added by some email clients. */ /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */ html, body { margin: 0 auto !important; padding: 0 !important; height: 100% !important; width: 100% !important; background: #f1f1f1; } /* What it does: Stops email clients resizing small text. */ * { -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; } /* What it does: Centers email on Android 4.4 */ div[style*="margin: 16px 0"] { margin: 0 !important; } /* What it does: Stops Outlook from adding extra spacing to tables. */ table, td { mso-table-lspace: 0pt !important; mso-table-rspace: 0pt !important; } /* What it does: Fixes webkit padding issue. */ table { border-spacing: 0 !important; border-collapse: collapse !important; table-layout: fixed !important; margin: 0 auto !important; } /* What it does: Uses a better rendering method when resizing images in IE. */ img { -ms-interpolation-mode:bicubic; } /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */ a { text-decoration: none; } /* What it does: A work-around for email clients meddling in triggered links. */ *[x-apple-data-detectors],  /* iOS */ .unstyle-auto-detected-links *, .aBn { border-bottom: 0 !important; cursor: default !important; color: inherit !important; text-decoration: none !important; font-size: inherit !important; font-family: inherit !important; font-weight: inherit !important; line-height: inherit !important; } /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */ .a6S { display: none !important; opacity: 0.01 !important; } /* What it does: Prevents Gmail from changing the text color in conversation threads. */ .im { color: inherit !important; } img.g-img + div { display: none !important; } /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */ @media only screen and (min-device-width: 320px) and (max-device-width: 374px) { u ~ div .email-container { min-width: 320px !important; } } /* iPhone 6, 6S, 7, 8, and X */ @media only screen and (min-device-width: 375px) and (max-device-width: 413px) { u ~ div .email-container { min-width: 375px !important; } } /* iPhone 6+, 7+, and 8+ */ @media only screen and (min-device-width: 414px) { u ~ div .email-container { min-width: 414px !important; } } </style> <!-- CSS Reset : END --> <!-- Progressive Enhancements : BEGIN --> <style> .primary{ background: #30e3ca; } .bg_white{ background: #ffffff; } .bg_light{ background: #fafafa; } .bg_black{ background: #000000; } .bg_dark{ background: rgba(0,0,0,.8); } .email-section{ padding:2.5em; } /*BUTTON*/ .btn{ padding: 10px 15px; display: inline-block; } .btn.btn-primary{ border-radius: 5px; background: #30e3ca; color: #ffffff; } .btn.btn-white{ border-radius: 5px; background: #ffffff; color: #000000; } .btn.btn-white-outline{ border-radius: 5px; background: transparent; border: 1px solid #fff; color: #fff; } .btn.btn-black-outline{ border-radius: 0px; background: transparent; border: 2px solid #000; color: #000; font-weight: 700; } h1,h2,h3,h4,h5,h6{ font-family: "Lato", sans-serif; color: #000000; margin-top: 0; font-weight: 400; } body{ font-family: "Lato", sans-serif; font-weight: 400; font-size: 15px; line-height: 1.8; color: rgba(0,0,0,.4); } a{ color: #30e3ca; } table{ } </style> </head> <body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;"> <center style="width: 100%; background-color: #f1f1f1;"> <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;"> &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp; </div> <div style="max-width: 600px; margin: 0 auto;" class="email-container"> <!-- BEGIN BODY --> <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;"> <tr> <td valign="top" class="bg_white" style="padding: 1em 2.5em 0 2.5em;"> <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"> <tr> <td class="logo" style="text-align: center;"> <h1><a href="#">' . getInit('name') . '</a></h1> </td> </tr> </table> </td> </tr><!-- end tr --> <tr> </tr><!-- end tr --> <tr> <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;"> <table> <tr> <td> <div class="text" style="padding: 0 2.5em; text-align: center;"> <h2>To Reset Password</h2> <p><a href="' . url('/forgot_password_change') . '/' . $rand_id . '" class="btn btn-primary">Click Here</a></p> </div> </td> </tr> </table> </td> </tr><!-- end tr --> </table> </div> </center> </body> </html>', $request->str_forgot_email);
            return response()->json(['status' => 'success', 'msg' => 'Please check your email for password']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Email id not registered']);
        }
    }

    public function forgot_password_change(Request $request, $id)
    {
        $result = DB::table('customers')
            ->where(['rand_id' => $id])
            ->where(['is_forgot_password' => 1])
            ->get();

        if (isset($result[0])) {
            $request->session()->put('FORGOT_PASSWORD_USER_ID', $result[0]->id);

            return view('frontend.forgot_password_change');
        } else {
            return redirect('/');
        }
    }

    public function forgot_password_change_process(Request $request)
    {
        DB::table('customers')
            ->where(['id' => $request->session()->get('FORGOT_PASSWORD_USER_ID')])
            ->update(
                [
                    'is_forgot_password' => 0,
                    'password' => Crypt::encrypt($request->password),
                    'rand_id' => '',
                ]
            );
        return response()->json(['status' => 'success', 'msg' => 'Password change']);
    }
    public function account()
    {
        $result['account'] = Customer::find(session()->get('FRONT_USER_ID'));
        // dd($result->name);
        return view('frontend.account', $result);

    }
    public function account_process(Request $request)
    {
        $valid = Validator::make($request->all(), [
            "name" => 'required',
            "email" => 'required|email',
            "mobile" => 'required|numeric|digits:10',
        ]);

        if (!$valid->passes()) {
            $request->session()->flash('msg', str_replace('}', "", str_replace(']', "", str_replace('"', "", str_replace("{", "", str_replace("[", "", $valid->errors()))))));
            // return redirect()->back();
        } else {
            $arr = [
                "name" => $request->name,
                "email" => $request->email,
                "mobile" => $request->mobile,
                "address" => $request->address,
                "city" => $request->city,
                "state" => $request->state,
                "zip" => $request->zip,
                "status" => 1,
                'is_verify' => 1,
                'is_forgot_password' => 0,
                'rand_id' => '',
            ];
            $query = DB::table('customers')->where('id', session()->get('FRONT_USER_ID'))->update($arr);
        }
        return redirect()->back();
    }
    public function apply_coupon_code(Request $request)
    {
        $arr = apply_coupon_code($request->coupon_code);
        $arr = json_decode($arr, true);

        return response()->json(['status' => $arr['status'], 'msg' => $arr['msg'], 'totalPrice' => $arr['totalPrice']]);
    }

    public function remove_coupon_code(Request $request)
    {
        $totalPrice = 0;
        $result = DB::table('coupons')
            ->where(['code' => $request->coupon_code])
            ->get();
        $getAddToCartTotalItem = getAddToCartTotalItem();
        $totalPrice = 0;
        foreach ($getAddToCartTotalItem as $list) {
            $totalPrice = $totalPrice + ($list->qty * $list->price);
        }

        return response()->json(['status' => 'success', 'msg' => 'Coupon code removed', 'totalPrice' => $totalPrice]);
    }
    public function product_review_process(Request $request)
    {
        $uid = $request->session()->get('FRONT_USER_ID');
        $product = DB::table('orders')->where('customers_id', $uid)->count();
        $review = DB::table('product_review')->where('customer_id', $uid)->count();
        if ($review < 1) {
            if ($product > 0) {
                if ($request->session()->has('FRONT_USER_LOGIN')) {

                    $arr = [
                        "rating" => $request->rating,
                        "review" => $request->review,
                        "products_id" => $request->product_id,
                        "status" => 0,
                        "customer_id" => $uid,
                        "added_on" => date('Y-m-d h:i:s'),
                    ];
                    $query = DB::table('product_review')->insert($arr);
                    $status = "success";
                    $msg = "Thank you for providing your review";
                } else {
                    $status = "error";
                    $msg = "Please login to submit your review";
                }
            } else {
                $status = "error";
                $msg = "Please Buy The Product To Review";
            }
        } else {
            $status = "error";
            $msg = "You Already Reviewed";
        }
        return response()->json(['status' => $status, 'msg' => $msg]);
    }
}

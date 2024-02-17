<?php

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function category()
{
    $result = Category::where(['is_home' => 1])->where(['status' => 1])->get();

    return $result;
}

function get__category__name($id)
{
    $result = DB::table('categories')->where(['id' => $id])->where(['status' => 1])
        ->get();


    return $result[0]->category_name;
}
function stor()
{
    $retu = 'storage/media/';
    return $retu;
}
function getUserTempId()
{
    if (!session()->has('USER_TEMP_ID')) {
        $rand = rand(111111111, 999999999);
        session()->put('USER_TEMP_ID', $rand);
        return $rand;
    } else {
        return session()->get('USER_TEMP_ID');
    }
}
function getAvaliableQty($product_id, $attr_id)
{
    $result = DB::table('orders_details')
        ->leftJoin('orders', 'orders.id', '=', 'orders_details.orders_id')
        ->leftJoin('products_attr', 'products_attr.id', '=', 'orders_details.products_attr_id')
        ->where(['orders_details.product_id' => $product_id])
        ->where(['orders_details.products_attr_id' => $attr_id])
        ->select('orders_details.qty', 'products_attr.qty as pqty')
        ->get();

    return $result;
}
function getAddToCartTotalItem()
{
    if (session()->has('FRONT_USER_LOGIN')) {
        $uid = session()->get('FRONT_USER_ID');
        $user_type = "Reg";
    } else {
        $uid = getUserTempId();
        $user_type = "Not-Reg";
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

    return $result;
}
function getInit($name, $isAll = null)
{
    $result = DB::table('init')
        ->where(['name' => $name])
        ->get();

    if (isset($result[0]->name)) {
        if ($isAll == null) {
            return $result[0]->value;
        } else {
            return $result;
        }
    } else {
        return 'Value';
    }
}
function getTopCat()
{
    $Chtml = '';
    $result = DB::table('categories')
        ->where(['is_home' => 1])
        ->where(['status' => 1])
        ->get();
    foreach ($result as $data) {
        $Chtml .= '<li><a href="' . url("/category/" . $data->category_slug) . '">' . $data->category_name . '</a></li>';
    }
    return $Chtml;
}
function getTopNav()
{
    $result = DB::table('menus')
        ->where(['status' => 1])
        ->orderBy('sirial', 'asc')
        ->get();
    $returnHtml = '';
    foreach ($result as $row) {
        $returnHtml .= '                        <li class="nav-item">        <a class="nav-link" href=' . $row->url . '            >' . $row->name . '</a        >    </li>';
    }
    return $returnHtml;
}
function buildTreeView($arr, $parent, $level = 0, $prelevel = -1)
{
    // global $html;
    // foreach ($arr as $id => $data) {
    //     if ($parent == $data['parent_id']) {
    //         if ($level > $prelevel) {
    //             if ($html == '') {
    //                 $html .= '<ul>';
    //             } else {
    //                 $html .= '<ul class="header__menu__dropdown">';
    //             }
    //         }
    //         if ($level == $prelevel) {
    //             $html .= '</li>';
    //         }
    //         $url = url($data['url']);
    //         $html .= '<li><a href="' . $url . '">' . $data['name'] . '</a>';
    //         if ($level > $prelevel) {
    //             $prelevel = $level;
    //         }
    //         $level++;
    //         buildTreeView($arr, $id, $level, $prelevel);
    //         $level--;
    //     }
    // }
    // if ($level == $prelevel) {
    //     $html .= '</li></ul>';
    // }
    // return $html;
}

function sendMail($sub, $body, $address, $name = null)
{
    require base_path("vendor/autoload.php");
    $mail = new PHPMailer(true); // Passing `true` enables exceptions

    try {

        // Email server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; //  smtp host
        $mail->SMTPAuth = true;
        $mail->Username = 'daudsweb1@gmail.com'; //  sender username
        $mail->Password = 'kutcimoasucvpysc'; // sender password
        $mail->SMTPSecure = 'tls'; // encryption - ssl/tls
        $mail->Port = 587; // port - 587/465

        $mail->setFrom('daudsweb1@gmail.com', getInit('name'));
        $mail->addAddress($address, $name);
        //            $mail->addCC($request->emailCc);
        //            $mail->addBCC($request->emailBcc);

        //            $mail->addReplyTo('sender@example.com', 'SenderReplyName');



        $mail->isHTML(true); // Set email content format to HTML

        $mail->Subject = $sub;
        $mail->Body = $body;

        // $mail->AltBody = plain text version of email body;

        if (!$mail->send()) {
            return false;
        } else {
            return true;
        }
    } catch (Exception $e) {
        return false;
    }
}
function arrayPaginate($items, $perPage = 5, $page = null, $options = [])
{
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    $items = $items instanceof Collection ? $items : Collection::make($items);
    return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
}
function apply_coupon_code($coupon_code)
{
    $totalPrice = 0;
    $result = DB::table('coupons')
        ->where(['code' => $coupon_code])
        ->get();

    if (isset($result[0])) {
        $value = $result[0]->value;
        $type = $result[0]->type;
        $getAddToCartTotalItem = getAddToCartTotalItem();

        foreach ($getAddToCartTotalItem as $list) {
            $totalPrice = $totalPrice + ($list->qty * $list->price);
        }
        if ($result[0]->status == 1) {
            if ($result[0]->is_one_time == 1) {
                $status = "error";
                $msg = "Coupon code already used";
            } else {
                $min_order_amt = $result[0]->min_order_amt;
                if ($min_order_amt > 0) {

                    if ($min_order_amt < $totalPrice) {
                        $status = "success";
                        $msg = "Coupon code applied";
                    } else {
                        $status = "error";
                        $msg = "Cart amount must be greater then $min_order_amt";
                    }
                } else {
                    $status = "success";
                    $msg = "Coupon code applied";
                }
            }
        } else {
            $status = "error";
            $msg = "Coupon code deactivated";
        }

    } else {
        $status = "error";
        $msg = "Please enter valid coupon code";
    }

    $coupon_code_value = 0;
    if ($status == 'success') {
        if ($type == 'Value') {
            $coupon_code_value = $value;
            $totalPrice = $totalPrice - $value;
        }
        if ($type == 'Per') {
            $newPrice = ($value / 100) * $totalPrice;
            $totalPrice = round($totalPrice - $newPrice);
            $coupon_code_value = $newPrice;
        }
    }

    return json_encode(['status' => $status, 'msg' => $msg, 'totalPrice' => $totalPrice, 'coupon_code_value' => $coupon_code_value]);
}
function getCustomDate($date)
{
    if ($date != '') {
        $date = strtotime($date);
        return date('d-M Y', $date);
    }
}
function get__rating($rating)
{
    $html = '';
    for ($i = 0; $i < 5; $i++){
        if (floor($rating) - $i >= 1) {
            $html .= '<i class="bi bi-star-fill"></i>';
        }elseif($rating - $i > 0){
            $html .= '<i class="bi bi-star-half"></i>';
        }else{
            $html .= '<i class="bi bi-star"></i>';
        }
    }
    return $html;
}
function get__avg_rate($id){
    $result = DB::table('product_review')
    ->where(['product_review.products_id' => $id])->avg('rating');
    return $result;
}
function rate($id){
    $avg = get__avg_rate($id);
    return get__rating($avg);
}

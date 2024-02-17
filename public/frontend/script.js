var a = false;
function search_oc() {
    if (a) {
        document.querySelector(".search_back").classList.remove("actives");
        document
            .querySelector("#navbarSupportedContent")
            .classList.remove("active");
        document.querySelector("body").classList.remove("overhide");
        a = !a;
    } else {
        document.querySelector(".search_back").classList.add("actives");
        document
            .querySelector("#navbarSupportedContent")
            .classList.add("active");
        document.querySelector("body").classList.add("overhide");
        a = !a;
    }
}
document.addEventListener("click", function (evt) {
    if (
        document
            .querySelector("#navbarSupportedContent")
            .classList.contains("active")
    ) {
        let flyoutEl = document.getElementById("home_search");
        let flyoutElt = document.getElementById("search_icon");
        targetEl = evt.target;
        do {
            if (targetEl == flyoutEl) {
                return;
            } else if (targetEl == flyoutElt) {
                return;
            }
            targetEl = targetEl.parentNode;
        } while (targetEl);
        search_oc();
    }
});
window.addEventListener("scroll", () => {
    let elonscroll = document.querySelector("#middle");
    let scHeader =
        Number(elonscroll.offsetHeight) + Number(elonscroll.offsetTop);
    if (scHeader < window.scrollY) {
        elonscroll.classList.add("sticky");
        // console.log("ff");
    } else {
        elonscroll.classList.remove("sticky");
        // console.log("ll");
    }
});

function change_product_color_image(
    img = null,
    color,
    qty = null,
    price = null,
    id
) {
    $("#color_id").val(color);
    if (!(price == null)) {
        $(".product_price").html("৳" + price);
    }
    if (!(qty == null)) {
        if (qty > 0) {
            $("#ava").html("In Stock");
            $("#qty").max = qty;
        } else {
            $("#ava").html("Out Of Stock");
            $("#qty").max = qty;
        }
    }
    $(".color").removeClass("active");
    $(".color_" + id).addClass("active");

    if (!(img == null)) {
        $(".image_selected").html(
            '<img src="' +
                img +
                '" alt="">'
        );
    }
}

function showColor(size, z = null) {
    $("#size_id").val(size);
    $(".p_color").hide();
    $(".size_" + size).show();
    $(".size_link").removeClass("active");
    $("#size_" + size).addClass("active");
    if (z == null) {
        $("#color_id").val(0);
    }
}
function set_s_c() {
    const size = $("#size_id").val();
    showColor(size, "sdf");
    const id = $("#attr_id").val();
    const color = $("#color_id").val();
    change_product_color_image(null, color, null, null, id);
    // console.log("fpfp");
}
set_s_c();
function home_add_to_cart(id, size_str_id, color_str_id) {
    $("#color_id").val(color_str_id);
    $("#size_id").val(size_str_id);
    add_to_cart(id, size_str_id, color_str_id);
}

function add_to_cart(id, size_str_id, color_str_id) {
    $("#add_to_cart_msg").html("");
    $("#add_to_cart_btn_" + id).html(
        "<div class='spinner-border spinner-border-sm' role='status'><span class='sr-only'></span></div>"
    );
    var color_id = $("#color_id").val();
    var size_id = $("#size_id").val();

    if (size_id == "" || size_id == 0) {
        $("#add_to_cart_btn_" + id).html("Add to Cart");
        $("#add_to_cart_msg").html(
            '<div style="color:red;">Please select size</div>'
        );
    } else if (color_id == "" || color_id == 0) {
        $("#add_to_cart_btn_" + id).html("Add to Cart");
        $("#add_to_cart_msg").html(
            '<div style="color:red;">Please select color</div>'
        );
    } else {
        $("#product_id").val(id);
        $("#pqty").val($("#qty").val());
        jQuery.ajax({
            url: "/add_to_cart",
            data: $("#frmAddToCart").serialize(),
            type: "post",
            success: function (result) {
                var totalPrice = 0;

                if (result.msg == "not_avaliable") {
                    $("#add_to_cart_btn_" + id).html("Add to Cart");
                    alert(result.data);
                } else {
                    $("#add_to_cart_btn_" + id).html("Add to Cart");
                    if (result.totalItem == 0) {
                        $(".cart_count").html("0");
                    } else {
                        $(".cart_count").html(result.totalItem);
                    }
                    jQuery.each(result.data, function (arrKey, arrVal) {
                        totalPrice =
                            parseInt(totalPrice) +
                            parseInt(arrVal.qty) * parseInt(arrVal.price);
                    });
                    $(".cart_price_count").html('৳'+totalPrice);
                    alert("Product " + result.msg);
                }
            },
        });
    }
}let useCoupon = false;
function applyCouponCode(){
    if (!useCoupon) {
        
    
  jQuery('#coupon_code_msg').html('');
  jQuery('#order_place_msg').html('');
  var coupon_code=jQuery('#coupon_code').val();
  if(coupon_code!=''){
    jQuery.ajax({
      type:'post',
      url:'/apply_coupon_code',
      data:'coupon_code='+coupon_code+'&_token='+jQuery("[name='_token']").val(),
      success:function(result){
        console.log(result.status);
        if(result.status=='success'){
            useCoupon=!useCoupon
        //   jQuery('.show_coupon_box').removeClass('d-none');
          jQuery('#coupon_code_str').html("("+coupon_code+")");
          jQuery('#coupon_code_dis').html('-৳'+($('#total_price').html().replace('৳','')-result.totalPrice).toString());
          jQuery('#total_price').html('৳'+result.totalPrice);
          jQuery('.input-group-coupon').hide();
        }
        jQuery('#coupon_code_msg').html(result.msg);
      }
    });
  }else{
    jQuery('#coupon_code_msg').html('Please enter coupon code');
  }
}
}

function remove_coupon_code(){
  jQuery('#coupon_code_msg').html('');
  var coupon_code=jQuery('#coupon_code').val();
  jQuery('#coupon_code').val('');
  if(coupon_code!=''){
    jQuery.ajax({
      type:'post',
      url:'/remove_coupon_code',
      data:'coupon_code='+coupon_code+'&_token='+jQuery("[name='_token']").val(),
      success:function(result){
        if(result.status=='success'){
          jQuery('.show_coupon_box').addClass('hide');
          jQuery('#coupon_code_str').html('');
          jQuery('#total_price').html('INR '+result.totalPrice);
          jQuery('.apply_coupon_code_box').show();
        }else{
          
        }
        jQuery('#coupon_code_msg').html(result.msg);
      }
    });
  }
}

function deleteCartProduct(pid, size, color, attr_id) {
    $("#color_id").val(color);
    $("#size_id").val(size);
    $("#qty").val(0);
    add_to_cart(pid, size, color);
    //jQuery('#total_price_'+attr_id).html('Rs '+qty*price);
    $("#cart_box" + attr_id).hide();
}

function updateQty(pid, size, color, attr_id, price) {
    $("#color_id").val(color);
    $("#size_id").val(size);
    var qty = $("#qty" + attr_id).val();
    $("#qty").val(qty);
    add_to_cart(pid, size, color);
    $("#total_price_" + attr_id).html("৳" + qty * price);
}
function remove_side() {
    $(".sundar__menu__overlay").removeClass("active");
    $(".sundar__menu__wrapper").removeClass("show__sundar__menu__wrapper");
    $("body").removeClass("over_hid");
}
$("#frmRegistration").submit(function (e) {
    document.getElementById("reg-b").disabled = true;
    e.preventDefault();
    $(".field_error").html("");
    $("#reg_process_msg").html("Processing, Please wait...");
    jQuery.ajax({
        url: "reg_process",
        data: $("#frmRegistration").serialize(),
        type: "post",
        success: function (result) {
            if (result.status == "error") {
                jQuery.each(result.error, function (key, val) {
                    $("#" + key + "_error").html(val[0]);
                });
                document.getElementById("reg-b").disabled = false;
            }

            if (result.status == "success") {
                $("#reg_process_msg").html(result.msg);
                // window.location.href = window.location.host + "/login";
            }
        },
    });
});

$("#frmLogin").submit(function (e) {
    document.getElementById("log-b").disabled = true;
    $("#login_msg").html("");
    $("#login_process_msg").html("Processing, Please wait...");
    e.preventDefault();
    jQuery.ajax({
        url: "/login_process",
        data: $("#frmLogin").serialize(),
        type: "post",
        success: function (result) {
            console.log(result.status)
            if (result.status == "success") {
                // $("#login_process_msg").html(result.msg);
                alert(result.msg);
                window.location.href = window.location.href;
                jQuery('#frmLogin')[0].reset();
                //jQuery('#thank_you_msg').html(result.msg);
            }
            if (result.status == "error") {
                $("#login_msg").html(result.msg);
                document.getElementById("log-b").disabled = false;
            }
        },
    });
});
$("#frmPlaceOrder").submit(function (e) {
    // $("#frmbutton").disabled = true;
    // $("#frmbutton").addClass("disabled");
    $("#order_process_msg").html("Processing, Please wait...");
    $("#frmbutton").html(
        "<div class='spinner-border spinner-border-sm' role='status'><span class='sr-only'></span></div>"
    );
    e.preventDefault();
    jQuery.ajax({
        url: "/place_order",
        data: $("#frmPlaceOrder").serialize(),
        type: "post",
        success: function (result) {
            if (result.status == "success") {
                if (result.payment_url != "") {
                    window.location.href = result.payment_url;
                } else {
                    window.location.href = "/order_placed";
                }
                $("#order_place_msg").html(result.msg);
                $("#frmbutton").html("<i class='mdi mdi-cart-outline me-1'></i>                                        Procced");
            } else {
                const msg = result.msg;
                let msga = [];
                // console.log(msg);
                Object.keys(msg).forEach(function (key) {
                    msga.push(result.msg[key]);
                });
                $("#order_place_msg").html(msga.toString().replace(",", ""));
                $("#order_process_msg").html("Try Again");
                $("#frmbutton").html("<i class='mdi mdi-cart-outline me-1'></i>                                        Procced");
            }
        },
    });
});
function sort_by() {
    var sort_by_value = $("#sort_by_value").val();
    $("#sort").val(sort_by_value);
    $("#categoryFilter").submit();
}

function sort_price_filter() {
    $("#filter_price_start").val(Number($("#minamount").val()));
    $("#filter_price_end").val(Number($("#maxamount").val()));
    $("#categoryFilter").submit();
}
$("#frmForgot").submit(function (e) {
    $("#forgot_msg").html("Please wait...");

    e.preventDefault();
    jQuery.ajax({
        url: "/forgot_passwordb",
        data: $("#frmForgot").serialize(),
        type: "post",
        success: function (result) {
            // console.log(result);
            $("#forgot_msg").html(result.msg);
        },
    });
});

$("#frmUpdatePassword").submit(function (e) {
    $("#forgot_msg").html("Please wait...");
    e.preventDefault();
    jQuery.ajax({
        url: "/forgot_password_change_process",
        data: $("#frmUpdatePassword").serialize(),
        type: "post",
        success: function (result) {
            $("#frmUpdatePassword")[0].reset();
            $("#forgot_msg").html(result.msg);
            window.location.replace(window.location.host + "/");
        },
    });
    $("#forgot_msg").html("");
});
function setColor(color, type) {
    var color_str = $("#color_filter").val();
    if (type == 1) {
        var new_color_str = color_str.replace(color + ":", "");
        $("#color_filter").val(new_color_str);
    } else {
        $("#color_filter").val(color + ":" + color_str);
        $("#categoryFilter").submit();
    }

    $("#categoryFilter").submit();
}
function setSize(size, type) {
    var size_str = $("#size_filter").val();
    if (type == 1) {
        var new_size_str = size_str.replace(size + ":", "");
        $("#size_filter").val(new_size_str);
    } else {
        $("#size_filter").val(size + ":" + size_str);
        $("#categoryFilter").submit();
    }

    $("#categoryFilter").submit();
}
function reset_filter() {
    $("#categoryFilter").reset();
    $("#categoryFilter").submit();
    //    window.location.replace(window.location.host+window.location.pathname)
}
function funSearch() {
    var search_str = $("#search_str").val();
    if (search_str != "" && search_str.length > 3) {
        window.location.replace("/search/" + search_str);
    }
}
jQuery('#frmProductReview').submit(function(e){
    jQuery('.review_msg').html("Please wait...");
    jQuery('.review_msg').html("");
    e.preventDefault();
    jQuery.ajax({
      url:'/product_review_process',
      data:jQuery('#frmProductReview').serialize(),
      type:'post',
      success:function(result){
        if(result.status=="success"){
          jQuery('.review_msg').html(result.msg);
          jQuery('#frmProductReview')[0].reset();
          setInterval(function(){
            window.location.href=window.location.href
          },3000);
        }if(result.status=="error"){
          jQuery('.review_msg').html(result.msg)
        }
        //jQuery('#frmUpdatePassword')[0].reset();
        //jQuery('#thank_you_msg').html(result.msg);
      }
    });
  });
  
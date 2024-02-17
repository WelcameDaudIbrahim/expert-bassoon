@extends('frontend/layout') @section('title','Product') @section('main')
<div class="super_container">
    <div class="single_product">
        <div
            class="container-fluid"
            style="background-color: #fff; padding: 11px"
        >
            <div class="row">
                <div class="col-lg-6">
                    <div class="image_selected">
                                                @if(isset($product_attr[$product[0]->id][0]->attr_image))
                        <img
                            src="{{asset(stor().$product_attr[$product[0]->id][0]->attr_image)}}"
                            alt=""
                        />
                        @endif
                    </div>
                    <div class="col-lg-12">
                        <ul class="image_list">
                            @if(isset($product_images[$product[0]->id][0]))

                            @foreach($product_images[$product[0]->id] as $list)
                            <li
                            onclick="$('.image_selected').children('img').attr('src',`{{asset('storage/media/'.$list->images)}}`)"
                            >
                                <img
                                src="{{asset('storage/media/'.$list->images)}}"
                                    alt=""
                                />
                            </li>
                                                    @endforeach
                        @endif
                            <li
                            onclick="$('.image_selected').children('img').attr('src',"{{asset('storage/media/'.$list->images)}}"")"
                            >
                                <img
                                src="{{asset('storage/media/'.$list->images)}}"
                                    alt=""
                                />
                            </li>
                        @foreach($product_attr[$product[0]->id] as $list)
                        @endforeach
                        </ul>
                    </div>
                </div>
                <!-- <div class="col-lg-6 order-3">
                    <div class="product_description">
                        <div class="product_name">
                            {{$product[0]->name}}
                        </div>
                        <div class="product-rating">
                            @if(!$review_total == 0) 
                            {!!get__rating( $review_rating / $review_total)!!} <span>( {{Str::limit($review_rating / $review_total,3,'')}} )</span>
                            @else
                            {!!get__rating(0)!!} <span>( 0 )</span>
                            @endif
                            <span class="rating-review"
                                >{{$review_rating}} Ratings & {{$review_total}} Reviews</span
                            >
                        </div>
                        <div>
                            <span class="product_price"
                                >৳{{$product_attr[$product[0]->id][0]->price}}</span
                            >
                            <strike class="product_discount">
                                <span style="color: black"
                                    >৳{{$product_attr[$product[0]->id][0]->mrp}}</span
                                >
                            </strike>
                        </div>
                        <div>
                            <div class="row" style="margin-top: 15px">
                                @if($product_attr[$product[0]->id][0]->size_id>0)
                                <div class="col-xs-6" style="margin-left: 15px">
                                    <span class="product_options">Sizes</span
                                    ><br />
                                    @php $arrSize=[];
                                    foreach($product_attr[$product[0]->id] as
                                    $attr){ $arrSize[]=$attr->size; }
                                    $arrSize=array_unique($arrSize); @endphp
                                    @foreach($arrSize as $attr) @if($attr!='')
                                    <button
                                        id="size_{{ $attr }}"
                                        class="p_size size_link btn btn-primary btn-sm"
                                        onclick="showColor('{{ $attr }}')"
                                    >
                                        {{ $attr }}
                                    </button>
                                    @endif @endforeach
                                </div>
                                @endif
                                @if($product_attr[$product[0]->id][0]->color_id>0)
                                <div class="col-xs-6" style="margin-left: 15px">
                                    <span class="product_options">Colors</span
                                    ><br />
                                    @foreach($product_attr[$product[0]->id] as $attr) 
                                    @if($attr->color!='')
                                    <button
                                        class="color color_{{$attr->id}} btn btn-primary btn-sm p_color size_{{$attr->size}}" onclick=change_product_color_image("{{asset(stor().$attr->attr_image)}}","{{$attr->color}}","{{$attr->qty}}","{{$attr->price}}","{{$attr->id}}")
                                    >
                                        {{ $attr->color }}
                                    </button>
                                    @endif @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        <hr class="singleline" />
                        <div>
                            {!!$product[0]->short_desc!!}
                        </div>

                        <hr class="singleline" />

                        <div class="row">
                            <div class="col-xs-6" style="margin-left: 13px">
                                <div class="product_quantity pro-qty" id="pro-qty">
                                    <span>QTY: </span>
                                    <input
                                        type="text"
                                        pattern="[0-9]*"
                                        id="qty" value="1" min="1"
                                    />
                                    <!-- <div class="quantity_buttons">
                                        <div
                                            id="quantity_inc_button"
                                            class="quantity_inc quantity_control"
                                        >
                                            <i class="bi bi-plus-lg"></i>
                                        </div>
                                        <div
                                            id="quantity_dec_button"
                                            class="quantity_dec quantity_control"
                                        >
                                            <i class="bi bi-dash-lg"></i>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <div id="add_to_cart_msg"></div>
                            <div class="col-xs-6">
                                <button
                                    type="button"
                                    class="btn btn-primary shop-button"
                                    id="add_to_cart_btn_{{$product[0]->id}}"
                                    href="javascript:void(0)" onclick="add_to_cart('{{$product[0]->id}}','{{$product_attr[$product[0]->id][0]->size_id}}','{{$product_attr[$product[0]->id][0]->color_id}}')"
                                >
                                    Add to Cart
                                </button>
                                <!-- <div class="product_fav">
                                    <i class="bi bi-heart"></i>
                                </div> -->
                                <ul class="mt-2">
                                    <li><b>Availability</b>
                                    <span id="ava" @if($product_attr[$product[0]->id][0]->qty > 1)
                                        style="color:green;" >In Stock
                                        @else
                                        style="color:red;" >Out Of Stock
                                        @endif
                                    </span>
                                </li>
                            </ul>
                        </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
        <div class="container-fluid bg-white mt-3 pt-2">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a
                        class="nav-link desc active text-dark"
                        onclick="openTabs('desc')"
                        aria-current="page"
                        href="javascript:void(0)"
                        >Description</a
                    >
                </li>
                <!-- <li class="nav-item">
                    <a
                        class="nav-link review text-dark"
                        onclick="openTabs('review')"
                        href="javascript:void(0)"
                        >Reviews</a
                    >
                </li> -->
            </ul>
            <div class="tab" id="desc">
                <div class="container m-0 mt-4 pb-4">
                    {!!$product[0]->desc!!}
                </div>
            </div>
            <!-- <div class="tab" id="review">
                <div class="container pb-4">
                    <div id="reviews" class="review-section">
                        <div
                            class="d-flex align-items-center justify-content-between mb-4"
                        >
                            <h4 class="m-0">{{$review_total}} Reviews</h4>
                            <span
                                class="select2 select2-container select2-container--default"
                                dir="ltr"
                                data-select2-id="2"
                                style="width: 188px"
                            >
                                <span
                                    class="dropdown-wrapper"
                                    aria-hidden="true"
                                ></span>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="stars-counters">
                                    <tbody>
                                        <tr class="">
                                            <td>
                                                <span>
                                                    <button
                                                        class="fit-button fit-button-color-blue fit-button-fill-ghost fit-button-size-medium stars-filter bg-transparent text-dark"
                                                    >
                                                        5 Stars
                                                    </button>
                                                </span>
                                            </td>
                                            <td class="progress-bar-container">
                                                <div
                                                    class="fit-progressbar fit-progressbar-bar star-progress-bar"
                                                >
                                                    <div
                                                        class="fit-progressbar-background"
                                                    >
                                                        <span
                                                            class="progress-fill"
                                                            style="
                                                                width: @if(isset($review_per[5])) {{$review_per[5]}}% @else 0% @endif;
                                                            "
                                                        ></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="star-num text-dark">
                                                ( @if(isset($review_star['5'])) {{$review_star['5']}} @else 0 @endif )
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <span>
                                                    <button
                                                        class="fit-button fit-button-color-blue fit-button-fill-ghost fit-button-size-medium stars-filter bg-transparent text-dark"
                                                    >
                                                        4 Stars
                                                    </button>
                                                </span>
                                            </td>
                                            <td class="progress-bar-container">
                                                <div
                                                    class="fit-progressbar fit-progressbar-bar star-progress-bar"
                                                >
                                                    <div
                                                        class="fit-progressbar-background"
                                                    >
                                                        <span
                                                            class="progress-fill"
                                                            style="
                                                                width: @if(isset($review_per[4])) {{$review_per[4]}}% @else 0% @endif;
                                                            "
                                                        ></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="star-num text-dark">
                                                ( @if(isset($review_star['4'])) {{$review_star['4']}} @else 0 @endif )
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <span>
                                                    <button
                                                        class="fit-button fit-button-color-blue fit-button-fill-ghost fit-button-size-medium stars-filter bg-transparent text-dark"
                                                    >
                                                        3 Stars
                                                    </button>
                                                </span>
                                            </td>
                                            <td class="progress-bar-container">
                                                <div
                                                    class="fit-progressbar fit-progressbar-bar star-progress-bar"
                                                >
                                                    <div
                                                        class="fit-progressbar-background"
                                                    >
                                                        <span
                                                            class="progress-fill"
                                                            style="width: @if(isset($review_per[3])) {{$review_per[3]}}% @else 0% @endif"
                                                        ></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="star-num text-dark">
                                                ( @if(isset($review_star['3'])) {{$review_star['3']}} @else 0 @endif )
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <span>
                                                    <button
                                                        class="fit-button fit-button-color-blue fit-button-fill-ghost fit-button-size-medium stars-filter bg-transparent text-dark"
                                                    >
                                                        2 Stars
                                                    </button>
                                                </span>
                                            </td>
                                            <td class="progress-bar-container">
                                                <div
                                                    class="fit-progressbar fit-progressbar-bar star-progress-bar"
                                                >
                                                    <div
                                                        class="fit-progressbar-background"
                                                    >
                                                        <span
                                                            class="progress-fill"
                                                            style="width: @if(isset($review_per['2'])) {{$review_per['2']}}% @else 0% @endif"
                                                        ></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="star-num text-dark">
                                                ( @if(isset($review_star['2'])) {{$review_star['2']}} @else 0 @endif )
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <span>
                                                    <button
                                                        class="fit-button fit-button-color-blue fit-button-fill-ghost fit-button-size-medium stars-filter bg-transparent text-dark"
                                                    >
                                                        1 Stars
                                                    </button>
                                                </span>
                                            </td>
                                            <td class="progress-bar-container">
                                                <div
                                                    class="fit-progressbar fit-progressbar-bar star-progress-bar"
                                                >
                                                    <div
                                                        class="fit-progressbar-background"
                                                    >
                                                        <span
                                                            class="progress-fill"
                                                            style="width: @if(isset($review_per[1])) {{$review_per[1]}}% @else 0% @endif"
                                                        ></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="star-num text-dark">
                                                ( @if(isset($review_star['1'])) {{$review_star['1']}} @else 0 @endif )
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <form id="frmProductReview" action="favascript:void(0)">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Rating(Star)</label>
    <select class="form-select" name="rating" aria-label="Default select example">
        <option value="1">One Star</option>
        <option value="2">Two Star</option>
        <option value="3">Three Star</option>
        <option value="4">Four Star</option>
        <option value="5">Five Star</option>
      </select>
  </div>
  <div class="mb-3">
    <label for="exampleInput1" class="form-label">Review</label>
    <textarea id="" cols="10" rows="10" name="review" class="form-control" id="exampleInput1"></textarea>
  </div>
  <p class="fw-bold review_msg"></p>
                        <input type="hidden" name="product_id" value="{{$product[0]->id}}"/>
                      @csrf
  <button type="submit" class="btn btn-primary">Review</button>
</form>
                            </div>
                        </div>
                    </div>

                    @foreach($product_review as $list)
                    <div class="review-list">
                        <ul>
                            <li>
                                <div class="d-flex">
                                    <div class="left">
                                        <span>
                                            <img
                                                src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                class="profile-pict-img img-fluid"
                                                alt=""
                                            />
                                        </span>
                                    </div>
                                    <div class="right">
                                        <h4>
                                            {{$list->name}}
                                            <span
                                                class="gig-rating text-body-2"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 1792 1792"
                                                    width="15"
                                                    height="15"
                                                >
                                                    <path
                                                        fill="currentColor"
                                                        d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"
                                                    ></path>
                                                </svg>
                                                {{$list->rating}}
                                            </span>
                                        </h4>
                                        <div class="review-description">
                                            <p>
                                                {{$list->review}}
                                            </p>
                                        </div>
                                        <span
                                            class="publish py-3 d-inline-block w-100"
                                            >{{getCustomDate($list->added_on)}}</span
                                        >
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div> -->
        </div>
    </div>
</div>
<script>
    function openTabs(tabsName) {
        var i;
        var x = document.getElementsByClassName("tab");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        var y = document.getElementsByClassName("nav-link");
        for (i = 0; i < y.length; i++) {
            y[i].classList.remove("active");
        }
        document.getElementById(tabsName).style.display = "block";
        document.getElementsByClassName(tabsName)[0].classList.add("active");
    }
    openTabs("desc");
</script>
<form style="display: none" id="frmAddToCart">
    <input
        type="hidden"
        id="size_id"
        name="size_id"
        value="{{$product_attr[$product[0]->id][0]->size}} "
    />
    <input
        type="hidden"
        id="color_id"
        name="color_id"
        value="{{$product_attr[$product[0]->id][0]->color}}"
    />
    <input
        type="hidden"
        id="attr_id"
        name="attr_id"
        value="{{$product_attr[$product[0]->id][0]->id}}"
    />
    <input type="hidden" id="pqty" name="pqty" />
    <input type="hidden" id="product_id" name="product_id" />
    @csrf
</form>
@endsection

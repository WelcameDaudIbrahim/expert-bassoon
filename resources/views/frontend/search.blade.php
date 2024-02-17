@extends('frontend/layout') @section('title','Shop') @section('main')
<div class="container mt-1 shop_container">
    <div class="row">
        <div class="col-2 shop_filter">
            <i
                class="bi bi-x-lg d-none"
                onclick="$('.shop_filter').removeClass('active')"
            ></i>
            <p class="fs-5 fw-bold m-0">Category</p>
            <ul class="list-group list-group-flush">
                @foreach($categories_left as $cat_left)
                <a href="{{url('category/'.$cat_left->category_slug)}}"
                    ><li class="list-group-item border-0">
                        {{$cat_left->category_name}}
                    </li></a
                >
                @endforeach
            </ul>
        </div>
        <div class="col-lg-10">
            <div
                class="d-flex justify-content-between align-items-center ps-5 pe-5 bg-secondary"
                style="opacity: 0.856"
            >
                <p class="m-2 text-light">
                    {{$product->total()}} Product Found
                </p>

            </div>
            <div
                class="mob-filter mt-2 d-none justify-content-between align-items-center ps-2 pe-2 bg-transparent"
            >
                <a class="text-dark" href="{{ url('/') }}">Go Home</a>
                <button
                    class="btn text-light btn-info"
                    style="opacity: 0.69548"
                    onclick="$('.shop_filter').addClass('active')"
                >
                    Filter
                </button>
            </div>
            <section class="shop_products products">
                <div
                    class="container-fluid d-flex justify-content-center mt-50 mb-50"
                >
                    <div class="row">
                        @isset($product) @foreach($product as $item)
                        <div class="col">
                            <div class="card">
                                <a href="{{url('product/'.$item->slug)}}">
                        <div class="card-body">
                            <div class="card-img-actions">
                                <img
                                    src="{{asset(stor().$item->image)}}"
                                    class="card-img img-fluid"
                                    alt=""
                                />
                            </div>
                        </div>
                                </a>

                                <div class="card-body bg-light text-center">
                                    <h6 class="font-weight-semibold mb-2">
                                        <a
                                            href="{{url('product/'.$item->slug)}}"
                                            class="text-default mb-2"
                                            data-abc="true"
                                            >{{$item->name}}</a
                                        >
                                    </h6>

                                    <div
                                        class="d-flex justify-content-center price"
                                    >
                                        <h3 class="mb-0 font-weight-semibold">
                                            ৳{{$product_attr[$item->id][0]->price}}
                                        </h3>

                                        <h5
                                            class="mb-0 font-weight-semibold text-danger"
                                        >
                                            <del>
                                                ৳{{$product_attr[$item->id][0]->mrp}}</del
                                            >
                                        </h5>
                                    </div>
 

                                    <div class="text-muted mb-1"></div>

                                    <button type="button" class="btn bg-cart" onclick="home_add_to_cart('{{$item->id}}','{{$product_attr[$item->id][0]->size}}','{{$product_attr[$item->id][0]->color}}')" id="add_to_cart_btn_{{$item->id}}">
                                        <i class="fa fa-cart-plus mr-2"></i> Add
                                        to cart
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach @endisset
                    </div>
                </div>
            </section>
            <div class="d-flex justify-content-end mt-3">
                {{$product->links()}}
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="qty" value="1" />
<form id="frmAddToCart">
    <input type="hidden" id="size_id" name="size_id" />
    <input type="hidden" id="color_id" name="color_id" />
    <input type="hidden" id="pqty" name="pqty" />
    <input type="hidden" id="product_id" name="product_id" />
    @csrf
</form>

@endsection

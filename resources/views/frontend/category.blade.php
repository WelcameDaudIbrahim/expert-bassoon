@extends('frontend/layout') @section('title','Category') @section('main')
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
                @if($slug==$cat_left->category_slug)
                <a href="javascript:void(0)"
                    ><li class="list-group-item border-0 fw-bolder">
                        {{$cat_left->category_name}}
                    </li></a
                >
                @else
                <a href="{{url('category/'.$cat_left->category_slug)}}"
                    ><li class="list-group-item border-0">
                        {{$cat_left->category_name}}
                    </li></a
                >
                @endif @endforeach
            </ul>
            <p class="fs-5 fw-bold m-0">Price</p>
            <div class="input-group input-group-sm mb-3">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Min Price"
                    id="minamount"
                    onchange="sort_price_filter()"
                    value="{{ $filter_price_start }}"
                />
                <span class="input-group-text border-0 bg-transparent">-</span>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Max Price"
                    id="maxamount"
                    onchange="sort_price_filter()"
                    value="{{ $filter_price_end }}"
                />
            </div>

            <p class="fs-5 fw-bold mt-3">Sizes</p>
            <div class="ms-3">
                @foreach($sizes as $size)
                @if(in_array($size->id,$sizeFilterArr))
                <a
                    href="javascript:void(0)"
                    onclick="setSize('{{$size->id}}','1')"
                >
                    <div class="form-check">
                        <label
                            class="form-check-label text-dark"
                            style="cursor: pointer"
                            >{{$size->size}} ❌</label
                        >
                    </div>
                </a>
                @else
                <a
                    href="javascript:void(0)"
                    onclick="setSize('{{$size->id}}','0')"
                    class="p_size"
                >
                    <div class="form-check" style="cursor: pointer">
                        <label
                            style="cursor: pointer"
                            class="form-check-label text-dark"
                            >{{$size->size}}</label
                        >
                    </div>
                </a>
                @endif @endforeach
            </div>
            <p class="fs-5 fw-bold mt-3">Colors</p>
            <div class="ms-3">
                @foreach($colors as $color)
                @if(in_array($color->id,$colorFilterArr))
                <a
                    href="javascript:void(0)"
                    onclick="setColor('{{$color->id}}','1')"
                >
                    <div class="form-check">
                        <label
                            class="form-check-label text-dark"
                            style="cursor: pointer"
                            >{{$color->color}} ❌</label
                        >
                    </div>
                </a>
                @else
                <a
                    href="javascript:void(0)"
                    onclick="setColor('{{$color->id}}','0')"
                    class="p_size"
                >
                    <div class="form-check">
                        <label
                            style="cursor: pointer"
                            class="form-check-label text-dark"
                            >{{$color->color}}</label
                        >
                    </div>
                </a>
                @endif @endforeach
            </div>
        </div>
        <div class="col-lg-10">
            <div
                class="d-flex justify-content-between align-items-center ps-5 pe-5 bg-secondary"
                style="opacity: 0.856"
            >
                <p class="m-2 text-light">{{$product->total()}} Product Found</p>
                <div class="sort text-light me-1">
                    Sort By
                    <select onchange="sort_by()" id="sort_by_value">
                        @if($sort_txt)
                        <option value="">Best Match</option>
                        @endif
                        <option value="" disabled selected>
                            {{ $sort_txt ? $sort_txt : 'Best Match'}}
                        </option>
                        <option value="name">Name</option>
                        <option value="date">Date</option>
                        <option value="price_asc">Price Low To High</option>
                        <option value="price_desc">Price High To Low</option>
                    </select>
                </div>
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

<form id="categoryFilter">
    <input type="hidden" id="sort" name="sort" value="{{ $sort }}" />
    <input
        type="hidden"
        id="filter_price_start"
        name="filter_price_start"
        value="{{ $filter_price_start }}"
    />
    <input
        type="hidden"
        id="filter_price_end"
        name="filter_price_end"
        value="{{ $filter_price_end }}"
    />
    <input
        type="hidden"
        id="color_filter"
        name="color_filter"
        value="{{ $color_filter }}"
    />
    <input
        type="hidden"
        id="size_filter"
        name="size_filter"
        value="{{ $size_filter }}"
    />
</form>
@endsection

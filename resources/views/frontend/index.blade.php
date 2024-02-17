@extends('frontend/layout') @section('title','Home') @section('main')
<div id="carouselExampleAutoplaying" class="carousel slide">
    <div class="carousel-inner">
        @foreach($home_banner as $list)
        <div class="carousel-item @if ($loop->first) active @endif">
            <div
                class="slider"
                style="background-image: url('{{ stor().getInit('slider1') }}')"
            >
                <div class="slide_left">
                    <h2>{!!$list->text!!}</h2>
                    <p>{!!$list->texttwo!!}</p>
                    <p>{!!$list->textthree!!}</p>
                    <a href="{{$list->btn_link}}">
                        <button class="slide_button">
                            {!!$list->btn_txt!!}
                        </button>
                    </a>
                </div>
                <div class="slide_right">
                    <div class="img">
                        <img
                            src="{{asset('storage/media/banner/'.$list->image)}}"
                            alt=""
                        />
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#carouselExampleAutoplaying"
        data-bs-slide="prev"
    >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#carouselExampleAutoplaying"
        data-bs-slide="next"
    >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<section class=" products">
    <div class="header">
        <h1>Products</h1>
    </div>
    <div class="container d-flex justify-content-center mt-50 mb-50">
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

                        <div class="d-flex justify-content-center price">
                            <h3 class="mb-0 font-weight-semibold">
                                ৳{{$product_attr[$item->id][0]->price}}
                            </h3>

                            <h5 class="mb-0 font-weight-semibold text-danger">
                                <del>
                                    ৳{{$product_attr[$item->id][0]->mrp}}</del
                                >
                            </h5>
                        </div>

                        <div class="text-muted mb-1"></div>

                        <button
                            type="button"
                            class="btn bg-cart"
                            onclick="home_add_to_cart('{{$item->id}}','{{$product_attr[$item->id][0]->size}}','{{$product_attr[$item->id][0]->color}}')"
                            id="add_to_cart_btn_{{$item->id}}"
                        >
                            <i class="fa fa-cart-plus mr-2"></i> Add to cart
                        </button>
                    </div>
                </div>
            </div>
            @endforeach @endisset
        </div>
    </div>
</section>
@foreach($home_categories_product as $key1 => $item1)
<section class="products">
    <div class="header">
        <h1>{{ get__category__name($key1) }}</h1>
    </div>
    <div class="container d-flex justify-content-center mt-50 mb-50">
        <div class="row">
            @foreach($item1 as $item)
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

                        <div class="d-flex justify-content-center price">
                            <h3 class="mb-0 font-weight-semibold">
                                ৳{{$home_product_attr[$item->id][0]->price}}
                            </h3>

                            <h5 class="mb-0 font-weight-semibold text-danger">
                                <del>
                                    ৳{{$home_product_attr[$item->id][0]->mrp}}</del
                                >
                            </h5>
                        </div>

                        <div class="text-muted mb-1"></div>

                        <button
                            type="button"
                            class="btn bg-cart"
                            onclick="home_add_to_cart('{{$item->id}}','{{$home_product_attr[$item->id][0]->size}}','{{$home_product_attr[$item->id][0]->color}}')"
                            id="add_to_cart_btn_{{$item->id}}"
                        >
                            <i class="fa fa-cart-plus mr-2"></i> Add to cart
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endforeach
<input type="hidden" id="qty" value="1" />
<form id="frmAddToCart">
    <input type="hidden" id="size_id" name="size_id" />
    <input type="hidden" id="color_id" name="color_id" />
    <input type="hidden" id="pqty" name="pqty" />
    <input type="hidden" id="product_id" name="product_id" />
    @csrf
</form>
@endsection

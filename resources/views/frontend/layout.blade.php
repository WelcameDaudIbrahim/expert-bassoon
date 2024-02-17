<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" type="image/x-icon" href="{{asset(stor().'/'.getInit('fav_icon'))}}">
        <link
            rel="stylesheet"
            href="{{
                asset('frontend/bootstrap-5.3.1-dist/css/bootstrap.min.css')
            }}"
        />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
        />
        <link rel="stylesheet" href="{{ asset('frontend/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('frontend/responsive.css') }}" />
        <title>@yield('title')</title>
    </head>

    <body>
        @php $getAddToCartTotalItem=getAddToCartTotalItem();
        $totalCartItem=count($getAddToCartTotalItem); $totalPrice=0 @endphp
        @foreach($getAddToCartTotalItem as $cartItem) @php
        $totalPrice=$totalPrice+($cartItem->qty*$cartItem->price) @endphp
        @endforeach
        <div class="bottom_nav d-flex justify-content-evenly">
            <a href="{{ url('/') }}">
                <div
                    class="items d-flex align-items-center text-white flex-column active"
                >
                    <i class="bi bi-house-door-fill"></i>
                    <p>Home</p>
                </div>
            </a>
            <a href="{{ url('/account') }}">
                <div
                    class="items d-flex align-items-center text-white flex-column"
                >
                    <i class="bi bi-person-circle"></i>
                    <p>Account</p>
                </div>
            </a>
            <a href="{{ url('/cart') }}">
                <div
                    class="items d-flex align-items-center text-white flex-column"
                >
                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                    >
                        {{ $totalCartItem }}
                        <span class="visually-hidden">cart</span>
                    </span>
                    <i class="bi bi-cart"></i>
                    <p>Cart</p>
                </div>
            </a>
            <a href="{{ url('/shop') }}">
                <div
                    class="items d-flex align-items-center text-white flex-column"
                >
                    <i class="bi bi-shop"></i>
                    <p>Shop</p>
                </div>
            </a>
        </div>
        <div class="backdrop" onclick="backdrop(false)"></div>

        <header>
            <div class="top">
                <div class="top_header">
                    <div class="left">{!!getInit('top_header_left')!!}</div>
                    <div class="middle">
                        <div>
                            {!!getInit('top_header_middle1')!!}
                            {!!getInit('top_header_middle2')!!}
                            {!!getInit('top_header_middle3')!!}
                        </div>
                    </div>
                    @if(session()->has('FRONT_USER_LOGIN')!=null)
                    <div class="right">
                        <div class="btn-group">
                            <button
                                class="btn btn-sm dropdown-toggle"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Hi, {{session()->get('FRONT_USER_NAME')}}
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="{{ url('account') }}"
                                        >Account</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="{{ url('order') }}"
                                        >Orders</a
                                    >
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="{{ url('logout') }}"
                                        >Logout</a
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                    @else
                    <div class="right">
                        <div class="btn-group">
                            <a href="{{ url('reg') }}" class="text-dark">
                                Login / Register
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="middle" id="middle">
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
                    <div class="container-fluid d-flex justify-content-around">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img
                                src="{{asset(stor().'/'.getInit('logo'))}}"
                                alt="Logo"
                                class="d-inline-block align-text-top"
                            />
                            {{ getInit("name") }}
                        </a>
                        <div
                            class="collapse navbar-collapse justify-content-center"
                            id="navbarSupportedContent"
                        >
                            <form
                                class="d-flex"
                                id="home_search"
                                action="javascript:void(0)"
                                method="get"
                                role="search"
                                onsubmit="funSearch()"
                            >
                                <input
                                    class="form-control me-2"
                                    type="search"
                                    placeholder="Search"
                                    aria-label="Search"
                                    id="search_str"
                                />
                                <button
                                    class="btn btn-outline-success"
                                    type="submit"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 16 16"
                                    >
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"
                                        />
                                    </svg>
                                </button>
                            </form>
                            <div class="search_back">
                                <svg
                                    onclick="search_oc()"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="28"
                                    height="28"
                                    fill="currentColor"
                                    class="bi bi-x"
                                    viewBox="0 0 16 16"
                                    style="
                                        position: absolute;
                                        top: 14px;
                                        left: 93%;
                                    "
                                >
                                    <path
                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                                    />
                                </svg>
                            </div>
                        </div>
                        <div class="header-cart">
                            <a
                                href="#"
                                class="me-2"
                                style="visibility: hidden"
                                id="search_icon"
                                onclick="search_oc()"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"
                                    />
                                </svg>
                            </a>
                            <a href="./account.html">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    class="bi bi-person"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"
                                    />
                                </svg>
                                &nbsp;
                            </a>
                            <a href="{{ url('/cart') }}">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
                                    />
                                </svg>

                                <span class="badge cart_count">
                                    {{ $totalCartItem }}
                                </span>
                            </a>
                            <span class="fw-bold cart_price_count"
                                >৳{{ $totalPrice }}</span
                            >
                        </div>
                    </div>
                </nav>
            </div>
            <div class="bottom">
                <div
                    class="offcanvas offcanvas-start"
                    tabindex="-1"
                    id="offcanvasExample"
                    aria-labelledby="offcanvasExampleLabel"
                >
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">
                            All Categories
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="offcanvas"
                            aria-label="Close"
                        ></button>
                    </div>

                    <div class="offcanvas-body m-0 p-0">
                        <ul class="list-group list-group-horizontal-xxl">
                            @foreach(category() as $item)
                            @if(count($item->subcategory) < 1)
                            <a
                                href="{{url('/category/'.$item->category_slug)}}"
                            >
                                <button
                                    type="button"
                                    class="list-group-item list-group-item-action"
                                >
                                    {{$item->category_name}}
                                </button>
                            </a>
                            @else
                            <div class="dropdown">
                                <li
                                    class="list-group-item list-group-item-action dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    {{$item->category_name}}
                                </li>
                                <ul
                                    class="dropdown-menu"
                                    style="
                                        padding: 0px;
                                        padding-left: 10px;
                                        width: 100%;
                                    "
                                >
                                    @foreach($item->subcategory as $subitem)
                                    <a href="{{url('/category/'.$subitem->category_slug)}}">

                                        <li>
                                            <button
                                            class="ps-5 dropdown-item list-group-item list-group-item-action"
                                            type="button"
                                            >
                                            {{$subitem->category_name}}
                                        </button>
                                    </li>
                                        </a>
                                    @endforeach
                                </ul>
                            </div>
                            @endif @endforeach
                        </ul>
                    </div>
                </div>
                <div class="container-fluid">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a
                                data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasExample"
                                aria-controls="offcanvasExample"
                                class="nav-link"
                                aria-current="page"
                                href="#"
                                ><svg
                                    style="margin: -3px 0 0 0"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    class="bi bi-list"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"
                                    /></svg
                                >&nbsp; All Categories</a
                            >
                        </li>
                        {!!getTopNav()!!}
                    </ul>
                </div>
            </div>
        </header>
        @section('main') @show
        <hr class="mt-5" />
        <footer class="footer_area section_padding_130_0">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="single-footer-widget section_padding_0_130">
                            <div class="footer-logo mb-3"></div>
                            <p>{!!getInit('footer_text_left')!!}</p>
                            <div class="footer_social_area">
                                <a
                                    href="#"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title=""
                                    data-original-title="Facebook"
                                    ><i class="bi bi-facebook"></i></a
                                ><a
                                    href="#"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title=""
                                    data-original-title="Skype"
                                    ><i class="bi bi-skype"></i></a
                                ><a
                                    href="#"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    title=""
                                    data-original-title="linkedin"
                                    ><i class="bi bi-linkedin"></i
                                ></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg">
                        <div class="single-footer-widget section_padding_0_130">
                            <h5 class="widget-title">About</h5>
                            <div class="footer_menu">
                                <ul class="d-flex flex-column">
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Corporate Sale</a></li>
                                    <li><a href="#">Terms &amp; Policy</a></li>
                                    <li><a href="#">Community</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg">
                        <div class="single-footer-widget section_padding_0_130">
                            <h5 class="widget-title">Support</h5>
                            <div class="footer_menu">
                                <ul class="d-flex flex-column">
                                    <li><a href="#">Help</a></li>
                                    <li><a href="#">Support</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li>
                                        <a href="#">Term &amp; Conditions</a>
                                    </li>
                                    <li><a href="#">Help &amp; Support</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg">
                        <div class="single-footer-widget section_padding_0_130">
                            <h5 class="widget-title">Contact</h5>
                            <div class="footer_menu">
                                <ul class="d-flex flex-column">
                                    <li><a href="#">Call Centre</a></li>
                                    <li><a href="#">Email Us</a></li>
                                    <li>
                                        <a href="#">Term &amp; Conditions</a>
                                    </li>
                                    <li><a href="#">Help Center</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copywrite-text mb-5">
                    <p class="mb-0">{!!getInit('footer_copyright')!!}</p>
                </div>
            </div>
        </footer>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="{{
                asset(
                    'frontend/bootstrap-5.3.1-dist/js/bootstrap.bundle.min.js'
                )
            }}"></script>
        <script src="{{ asset('frontend/script.js') }}"></script>
    </body>
</html>

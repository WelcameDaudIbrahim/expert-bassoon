@extends('frontend/layout') @section('title','Checkout')
@section('cat_active','display: none;') @section('main')
<form action="javascript:void(0)" method="get" id="frmPlaceOrder">
    @csrf
    <div class="container checkout">
        <div class="row">
            <div class="col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <ol class="activity-checkout mb-0 px-4 mt-3">
                            <li>
                                <div class="feed-item-list">
                                    <div>
                                        <div class="mb-3">
                                            <div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label
                                                                class="form-label"
                                                                for="billing-name"
                                                                >Name</label
                                                            >
                                                            <input
                                                                value="{{
                                                                    $customers[
                                                                        'name'
                                                                    ]
                                                                }}"
                                                                name="name"
                                                                type="text"
                                                                class="form-control"
                                                                placeholder="Enter name"
                                                            />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label
                                                                class="form-label"
                                                                for="billing-email-address"
                                                                >Email
                                                                Address</label
                                                            >
                                                            <input
                                                                value="{{
                                                                    $customers[
                                                                        'email'
                                                                    ]
                                                                }}"
                                                                name="email"
                                                                type="email"
                                                                class="form-control"
                                                                id="billing-email-address"
                                                                placeholder="Enter email"
                                                            />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label
                                                                class="form-label"
                                                                for="billing-phone"
                                                                >Phone</label
                                                            >
                                                            <input
                                                                value="{{
                                                                    $customers[
                                                                        'mobile'
                                                                    ]
                                                                }}"
                                                                name="mobile"
                                                                type="text"
                                                                class="form-control"
                                                                id="billing-phone"
                                                                placeholder="Enter Phone no."
                                                            />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label
                                                        class="form-label"
                                                        for="billing-address"
                                                        >Address</label
                                                    >
                                                    <textarea
                                                        value="{{
                                                            $customers[
                                                                'address'
                                                            ]
                                                        }}"
                                                        name="address"
                                                        class="form-control"
                                                        id="billing-address"
                                                        rows="3"
                                                        placeholder="Enter full address"
                                                    ></textarea>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-lg-12">
                                                        <div
                                                            class="mb-4 mb-lg-0"
                                                        >
                                                            <label
                                                                class="form-label"
                                                                >Country</label
                                                            >
                                                            <select
                                                                class="form-control form-select"
                                                                title="Country"
                                                                disabled
                                                            >
                                                                <option
                                                                    value="0"
                                                                >
                                                                    Select
                                                                    Country
                                                                </option>
                                                                <option
                                                                    value="BN"
                                                                    selected
                                                                >
                                                                    Bangledesh
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div
                                                            class="mb-4 mb-lg-0"
                                                        >
                                                            <label
                                                                class="form-label"
                                                                for="billing-city"
                                                                >City</label
                                                            >
                                                            <input
                                                                value="{{
                                                                    $customers[
                                                                        'city'
                                                                    ]
                                                                }}"
                                                                name="city"
                                                                type="text"
                                                                class="form-control"
                                                                id="billing-city"
                                                                placeholder="Enter City"
                                                            />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="mb-0">
                                                            <label
                                                                class="form-label"
                                                                for="zip-code"
                                                                >District</label
                                                            >
                                                            <input
                                                                value="{{
                                                                    $customers[
                                                                        'state'
                                                                    ]
                                                                }}"
                                                                name="state"
                                                                type="text"
                                                                class="form-control"
                                                                id="State"
                                                                placeholder="Enter District"
                                                            />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-0">
                                                            <label
                                                                class="form-label"
                                                                for="zip-code"
                                                                >Zip / Postal
                                                                code</label
                                                            >
                                                            <input
                                                                value="{{
                                                                    $customers[
                                                                        'zip'
                                                                    ]
                                                                }}"
                                                                name="zip"
                                                                type="text"
                                                                class="form-control"
                                                                id="zip-code"
                                                                placeholder="Enter Postal code"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="card checkout-order-summary">
                    <div class="card-body">
                        <div class="p-3 bg-light mb-3">
                            <h5 class="font-size-16 mb-0">Order Summary</h5>
                        </div>
                        <div class="table-responsive">
                            <table
                                class="table table-centered mb-0 table-nowrap"
                            >
                                <thead>
                                    <tr>
                                        <th
                                            class="border-top-0"
                                            style="width: 110px"
                                            scope="col"
                                        >
                                            Product
                                        </th>
                                        <th class="border-top-0" scope="col">
                                            Product Desc
                                        </th>
                                        <th class="border-top-0" scope="col">
                                            Price
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalPrice=0; @endphp
                                    @foreach($cart_data as $list) @php
                                    $totalPrice=$totalPrice+($list->price*$list->qty)
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <img
                                                src="{{asset(stor().$list->image)}}"
                                                alt="product-img"
                                                title="product-img"
                                                class="avatar-lg rounded"
                                            />
                                        </th>
                                        <td>
                                            <h5
                                                class="font-size-16 text-truncate"
                                            >
                                                <a
                                                    href="{{url('product/'.$list->slug)}}"
                                                    class="text-dark"
                                                    >{{$list->name}}</a
                                                >
                                            </h5>
                                            <p class="text-muted mb-0 mt-1">
                                                ৳ {{$list->price}} x
                                                {{$list->qty}}
                                            </p>
                                        </td>
                                        <td>
                                            @php $totalPrice =
                                            $totalPrice+$list->price*$list->qty;
                                            @endphp ৳{{$list->price*$list->qty}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2">
                                            <h5 class="font-size-14 mt-2 mb-2">
                                                Sub Total :
                                            </h5>
                                        </td>
                                        <td>৳{{ $totalPrice }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <h5 class="font-size-14 mt-2 mb-2">
                                                Discount <span id="coupon_code_str"></span>:
                                            </h5>
                                        </td>
                                        <td class="text-danger fw-bold" id="coupon_code_dis">-৳0</td>
                                    </tr>

                                    <tr class="bg-light">
                                        <td colspan="2">
                                            <h5 class="font-size-14 mt-2 mb-2">
                                                Total:
                                            </h5>
                                        </td>
                                        <td id="total_price">৳{{ $totalPrice }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="input-group input-group-coupon mt-2">
                            <input
                                type="search"
                                class="form-control"
                                placeholder="Coupon Code"
                                name="coupon_code" id="coupon_code"
                            />
                            <div class="input-group-append">
                                <button
                                    class="input-group-text"
                                    type="button"
                                    id="button-addonTags"
                                    onclick="applyCouponCode()"
                                >
                                    Apply
                                </button>
                            </div>
                        </div>
                        <p class="fw-bold" id="coupon_code_msg"></p>
                        <ol style="list-style-type: none" class="mt-3">
                            <li class="checkout-item">
                                <div class="feed-item-list">
                                    <div>
                                        <h5 class="font-size-14 mb-3">
                                            Payment method :
                                        </h5>
                                        @if(session()->has('FRONT_USER_LOGIN')==null)
                                        <div>
                                            <h5 class="font-size-16 mb-1">
                                                Your Account Will Created And
                                                Password Will Be Send In Email
                                            </h5>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mt-3">
                                                <div>
                                                    <label
                                                        class="card-radio-label"
                                                    >
                                                        <input
                                                            type="radio"
                                                            name="payment_type"
                                                            value="COD(Out Dhaka 150tk)"
                                                            class="card-radio-input"
                                                            checked=""
                                                        />

                                                        <span
                                                            class="card-radio py-3 text-center text-truncate"
                                                        >
                                                            <i
                                                                class="bi bi-cash-stack d-block h2 mb-3"
                                                            ></i>
                                                            <span
                                                                >Cash on
                                                                Delivery(Out Dhaka 150tk)</span
                                                            >
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mt-3">
                                                <div>
                                                    <label
                                                        class="card-radio-label"
                                                    >
                                                        <input
                                                            type="radio"
                                                            name="payment_type"
                                                            value="COD(In Dhaka 50tk)"
                                                            class="card-radio-input"
                                                            checked=""
                                                        />

                                                        <span
                                                            class="card-radio py-3 text-center text-truncate"
                                                        >
                                                            <i
                                                                class="bi bi-cash-stack d-block h2 mb-3"
                                                            ></i>
                                                            <span
                                                                >Cash on
                                                                Delivery (In of Dhaka 50tk)</span
                                                            >
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ol>
                        <p class="fw-bold text-danger" id="order_place_msg"></p>
                        <p class="fw-bold text-dark" id="order_process_msg"></p>
                        <div class="row">
                            <div class="col">
                                <a
                                    href="{{ url('/shop') }}"
                                    class="btn btn-link text-muted"
                                >
                                    <i class="mdi mdi-arrow-left me-1"></i>
                                    Continue Shopping
                                </a>
                            </div>
                            <div class="col">
                                <div class="text-end mt-2 mt-sm-0">
                                    <button
                                        id="frmbutton"
                                        class="btn btn-success"
                                    >
                                        <i
                                            class="mdi mdi-cart-outline me-1"
                                        ></i>
                                        Procced
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

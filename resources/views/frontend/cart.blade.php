@extends('frontend/layout') @section('title','Product')
@section('cat_active','display: none;') @section('main')
<div class="container mt-3">
    <div class="contentbar">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Cart</h5>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-xl-8">
                                <div class="cart-container">
                                    <div class="cart-head">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-borderless"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">
                                                            Photo
                                                        </th>
                                                        <th scope="col">
                                                            Product
                                                        </th>
                                                        <th scope="col">Qty</th>
                                                        <th scope="col">
                                                            Price
                                                        </th>
                                                        <th
                                                            scope="col"
                                                            class="text-right"
                                                        >
                                                            Total
                                                        </th>
                                                        <th scope="col">
                                                            Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $total_p = 0; $i = 1
                                                    @endphp @foreach($list as $data)
                                                    <tr
                                                        id="cart_box{{$data->attr_id}}"
                                                    >
                                                        <th scope="row">{{$i}}</th>
                                                        <td>
                                                            <img
                                                                src="{{asset(stor().$data->image)}}"
                                                                class="img"
                                                                width="35"
                                                                alt="product"
                                                            />
                                                        </td>
                                                        <td>{{$data->name}}</td>
                                                        <td>
                                                            <div
                                                                class="form-group mb-0"
                                                            >
                                                                <input
                                                                    type="number"
                                                                    class="form-control cart-qty"
                                                                    onchange="updateQty('{{$data->pid}}','{{$data->size}}','{{$data->color}}','{{$data->attr_id}}','{{$data->price}}')"
                                                                    id="qty{{$data->attr_id}}"
                                                                    value="{{$data->qty}}"
                                                                    min="0"
                                                                    max="{{$data->pqty}}"
                                                                />
                                                            </div>
                                                        </td>
                                                        @if($data->size!='')
                                                        <td>{{$data->size}}</td>
                                                        @endif
                                                        @if($data->color!='')
                                                        <td>
                                                            {{$data->color}}
                                                        </td>
                                                        @endif
                                                        <td>
                                                            ৳{{$data->price}}
                                                        </td>
                                                        <td class="text-right">
                                                            @php $total_p =
                                                            $total_p+$data->price*$data->qty;
                                                            $i++ @endphp ৳{{$data->price*$data->qty}}
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="javascript:void(0)"
                                                                onclick="deleteCartProduct('{{$data->pid}}','{{$data->size}}','{{$data->color}}','{{$data->attr_id}}')"
                                                                style="
                                                                    cursor: pointer;
                                                                "
                                                                class="text-danger"
                                                                ><i
                                                                    class="bi bi-trash-fill"
                                                                ></i
                                                            ></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="cart-body p-0">
                                        <div class="row">
                                            <div
                                                class="col-md-12 order-2 order-lg-1 col-lg-5 col-xl-6"
                                            >
                                                <div class="order-note">
                                                    <form>
                                                        <div class="form-group">
                                                            <!-- <div
                                                                class="input-group"
                                                            >
                                                                <input
                                                                    type="search"
                                                                    class="form-control"
                                                                    placeholder="Coupon Code"
                                                                    aria-label="Search"
                                                                    aria-describedby="button-addonTags"
                                                                />
                                                                <div
                                                                    class="input-group-append"
                                                                >
                                                                    <button
                                                                        class="input-group-text"
                                                                        type="submit"
                                                                        id="button-addonTags"
                                                                    >
                                                                        Apply
                                                                    </button>
                                                                </div>
                                                            </div> -->
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-12 order-1 order-lg-2 col-lg-7 col-xl-6"
                                            >
                                                <div
                                                    class="order-total table-responsive"
                                                >
                                                    <table
                                                        class="table table-borderless text-right"
                                                    >
                                                        <tbody>
                                                            <tr>
                                                                <td
                                                                    class="f-w-7 font-18"
                                                                >
                                                                    <h4>
                                                                        Amount :
                                                                    </h4>
                                                                </td>
                                                                <td
                                                                    class="f-w-7 font-18"
                                                                >
                                                                    <h4>
                                                                        ৳{{
                                                                            $total_p
                                                                        }}
                                                                    </h4>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="cart-footer text-right ms-4 me-4 mb-4 d-flex justify-content-between"
                    >
                        <a href="{{ url('/shop') }}">
                            <button
                                type="button"
                                class="btn btn-outline-secondary my-1"
                            >
                                Continue Shopping
                            </button></a
                        >
                        <a
                            href="{{ url('/checkout') }}"
                            class="btn btn-success my-1"
                            >Proceed to Checkout
                            <i class="bi bi-arrow-right ml-2"></i
                        ></a>
                    </div>
                </div>
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

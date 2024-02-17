@extends('admin/layout')
@section('page_title','Dashboard')
@section('dashboard_select','active')
@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="overview-wrap">
                <h2 class="title-1">overview</h2>
                <a href="{{url("admin/product/manage_product")}}">
                    <button class="au-btn au-btn-icon au-btn--blue">
                        <i class="zmdi zmdi-plus"></i>add product</button>
                    </a>
            </div>
        </div>
    </div>
    <div class="row m-t-25">
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c{{random_int(1, 4)}}">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                        </div>
                        <div class="text">
                            <h2>{{$order_pen_c}}</h2>
                            <span>Pending Orders</span>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c{{random_int(1, 4)}}">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                        </div>
                        <div class="text">
                            <h2>{{$order_pla_c}}</h2>
                            <span>Placed Orders</span>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c{{random_int(1, 4)}}">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                        </div>
                        <div class="text">
                            <h2>{{$order_c}}</h2>
                            <span>Total Orders</span>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c{{random_int(1, 4)}}">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                        </div>
                        <div class="text">
                            <h2>{{$order_del}}</h2>
                            <span>Delivered Orders</span>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c{{random_int(1, 4)}}">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                        </div>
                        <div class="text">
                            <h2>{{$pro}}</h2>
                            <span>Total Products</span>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c{{random_int(1, 4)}}">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                        </div>
                        <div class="text">
                            <h2>{{$cus}}</h2>
                            <span>Total Customer</span>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c{{random_int(1, 4)}}">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                        </div>
                        <div class="text">
                            <h2>{{$cus_v}}</h2>
                            <span>Total Verified Customer</span>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="overview-item overview-item--c{{random_int(1, 4)}}">
                <div class="overview__inner">
                    <div class="overview-box clearfix">
                        <div class="icon">
                        </div>
                        <div class="text">
                            <h2>{{$cus_nv}}</h2>
                            <span>Total Not Verified Customer</span>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
@endsection
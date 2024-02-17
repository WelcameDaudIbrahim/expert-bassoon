@extends('frontend/layout') @section('title','Orders') @section('main')
<div class="container-fluid mt-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-10">
            <div class="rounded">
                <div class="table-responsive table-borderless">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
                                <th>Total Amt</th>
                                <th>Payment ID</th>
                                <th>Placed At</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            <!-- <tr class="cell-1">
                  <td class="text-center">
                    <div class="toggle-btn">
                      <div class="inner-circle"></div>
                    </div>
                  </td>
                  <td>#SO-13487</td>
                  <td>Gasper Antunes</td>
                  <td><span class="badge badge-success">Fullfilled</span></td>
                  <td>$2674.00</td>
                  <td>Today</td>
                  <td><i class="fa fa-ellipsis-h text-black-50"></i></td>
                </tr> -->
                            @foreach($orders as $list)
                            <tr class="cell-1">
                                <td class="order_id_btn">
                                    <a
                                        href="{{
                                            url('order_detail')
                                        }}/{{$list->id}}"
                                        >#{{str_replace(["-",':',' '],"",$list->added_on.$list->id.$list->total_amt)}}</a
                                    >
                                </td>
                                <td>{{$list->orders_status}}</td>
                                <td>{{$list->payment_status}}</td>
                                <td>{{$list->total_amt}}</td>
                                <td>{{$list->payment_id}}</td>
                                <td>{{$list->added_on}}</td>
                                <td><a href="{{url('order_detail')}}/{{$list->id}}"><i class="bi bi-three-dots"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

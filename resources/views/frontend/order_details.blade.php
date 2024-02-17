@extends('frontend/layout') @section('title','Order Detail') @section('main')
<div class="container-fluid single-order">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center py-3">
        <h2 class="h5 mb-0">
          <a href="#" class="text-muted"></a> Order #{{str_replace(["-",':',' '],"",$orders_details[0]->added_on.$orders_details[0]->id.$orders_details[0]->total_amt)}}
        </h2>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-4">
            <div class="card-body">
              <div class="mb-3 d-flex justify-content-between">
                <div>
                  <span class="me-3">{{$orders_details[0]->added_on}}</span>
                  <span class="badge bg-success text-dark">{{$orders_details[0]->orders_status}}</span>
                </div>
              </div>
              <table class="table table-borderless">
                <tbody>
                                         @php 
                     $totalAmt=0;
                     @endphp
                     @foreach($orders_details as $list)
                     @php 
                     $totalAmt=$totalAmt+($list->price*$list->qty);
                     @endphp
                  <tr>
                    <td>
                      <div class="d-flex mb-2">
                        <div class="flex-shrink-0">
                          <img
                          src='{{asset(stor().$list->attr_image)}}'
                            alt=""
                            width="35"
                            class="img-fluid"
                          />
                        </div>
                        <div class="flex-lg-grow-1 ms-3">
                          <h6 class="small mb-0">
                            <a href="#" class="text-reset"
                              >{{$list->pname}}</a
                            >
                          </h6>
                          @if($list->color)
                          <span class="small">Color: {{$list->color}}</span>
                          @endif
                          @if($list->size)
                          <span class="small">Size: {{$list->size}}</span>
                          @endif
                        </div>
                      </div>
                    </td>
                    <td>Qty: {{$list->qty}}</td>
                    <td class="text-end">৳{{$list->price*$list->qty}}</td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2" class="text-start">Subtotal</td>
                    <td class="text-end">৳{{$totalAmt}}</td>
                  </tr>
                  @if($orders_details[0]->coupon_value>0)
                  <tr>
                    <td colspan="2" class="text-start">Discount (Code: {{$orders_details[0]->coupon_code}})</td>
                    <td class="text-danger text-end">- ৳{{$orders_details[0]->coupon_value}}</td>
                  </tr>
                  @else
                  <tr>
                    <td colspan="2" class="text-start">Discount</td>
                    <td class="text-danger text-end">- ৳0</td>
                  </tr>
                  @endif
                  <tr class="fw-bold">
                    <td colspan="2" class="text-start">TOTAL</td>
                    <td class="text-end">৳{{$orders_details[0]->total_amt - $orders_details[0]->coupon_value}}</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="card mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <h3 class="h6">Payment Method</h3>
                  <p>
                    {{$orders_details[0]->payment_type}} <br />
                    Total: ৳{{$orders_details[0]->total_amt - $orders_details[0]->coupon_value}}
                    <span class="badge bg-success rounded-pill">{{$orders_details[0]->payment_status}}</span>
                  </p>
                </div>
                <div class="col-lg-6">
                  <h3 class="h6">Address</h3>
                  <address>
                    <strong>{{$orders_details[0]->name}}(Phone: {{$orders_details[0]->mobile}})</strong>
                     <br/>{{$orders_details[0]->address}}<br/>{{$orders_details[0]->city}}</br>{{$orders_details[0]->state}}</br/>{{$orders_details[0]->pincode}}<br/>
                    <abbr title="Phone">Phone:</abbr> {{$orders_details[0]->mobile}}
                  </address>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
@endsection
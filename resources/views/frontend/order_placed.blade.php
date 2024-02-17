@extends('frontend/layout')
@section('title','Order Placed')
@section('main')
<div class="container-fluid">
    <div class="container text-center">
        <h1>Thank you.</h1>
        <p class="lead w-lg-50 mx-auto">Your order has been placed successfully.</p>
        <p class="w-lg-50 mx-auto">Your order number is <a href="#">#{{$order_id}}</a>. We will immediatelly process your and it will be delivered in some business days.</p>
    </div>
</div>
@endsection

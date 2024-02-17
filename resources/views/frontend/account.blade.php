@extends('frontend/layout') @section('title','Account') @section('main')
<div class="container-xl px-4 mt-4">
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="javascript:void(0)">Profile</a>
        <a class="nav-link" href="{{url('order')}}">Orders</a>
    </nav>
    <hr class="mt-0 mb-4" />
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    @if (session()->has('msg')){{session()->get('msg')}} @endif
                    <form action="{{ url('account_process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername"
                                >Name
                            </label>
                            <input
                                class="form-control"
                                type="text"
                                name="name"
                                placeholder="Enter your name"
                                value="{{$account->name}}"
                            />
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstName"
                                    >Email</label
                                >
                                <input
                                    class="form-control"
                                    id="inputFirstName"
                                    name="email"
                                    type="text"
                                    value="{{$account->email}}"
                                />
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLastName"
                                    >Phone</label
                                >
                                <input
                                    class="form-control"
                                    id="inputLastName"
                                    name="mobile"
                                    type="number"
                                    value="{{$account->mobile}}"
                                />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="inputAddress"
                                >Address</label
                            >
                            <input
                                class="form-control"
                                id="inputAddress"
                                name="address"
                                type="text"
                                value="{{$account->address}}"
                            />
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-4">
                                <label class="small mb-1" for="inputOrgName"
                                    >City</label
                                >
                                <input
                                    class="form-control"
                                    id="inputOrgName"
                                    name="city"
                                    type="text"
                                    value="{{$account->city}}"
                                />
                            </div>
                            <div class="col-md-4">
                                <label class="small mb-1" for="inputOrgName1"
                                    >District</label
                                >
                                <input
                                    class="form-control"
                                    id="inputOrgName1"
                                    name="state"
                                    type="text"
                                    value="{{$account->state}}"
                                />
                            </div>
                            <div class="col-md-4">
                                <label class="small mb-1" for="inputOrgName2"
                                    >Zip</label
                                >
                                <input
                                    class="form-control"
                                    id="inputOrgName2"
                                    name="zip"
                                    type="text"
                                    value="{{$account->zip}}"
                                />
                            </div>
                        </div>
                        <button class="btn btn-info text-light" type="submit">
                            Save changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

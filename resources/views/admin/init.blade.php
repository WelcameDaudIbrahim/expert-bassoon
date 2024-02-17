@extends('admin/layout')
@section('page_title','Init')
@section('init_select','active')
@section('container')
<h1 class="mb10">Init</h1>
@if(session()->has('message'))
<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
    {{session('message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
@endif
<a href="{{url('admin/init_install')}}">
        <button type="button" class="btn btn-success">
            Init Upgrade
        </button>
    </a>
<div class="row m-t-30">
    <div class="col-md-12">

        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $list)
                    <form action="{{url('admin/init_edit/'.$list->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <tr>
                            <td>{{$list->id}}</td>
                            <td>{{$list->name}}</td>
                            <td>
                                <div class="col-lg-8">

                                    <input name="val" type="{{$list->type}}" class="form-control" aria-required="true" aria-invalid="false" required {{ ($list->type == 'file') ? '' : 'value='.$list->value}}>
                                    <br>
                                    @if($list->type=='file')
                                        <img src="{{asset(stor().'/'.$list->value)}}" alt="">
                                    @endif
                                </div>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success">Update</button>
                            </td>
                        </tr>
                    </form>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>

@endsection
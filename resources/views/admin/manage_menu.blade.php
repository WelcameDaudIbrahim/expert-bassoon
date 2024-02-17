@extends('admin/layout')
@section('page_title','Manage Menu')
@section('menu_select','active')
@section('container')
<h1 class="mb10">Manage Menu</h1>
<a href="{{url('admin/menu')}}">
    <button type="button" class="btn btn-success">
        Back
    </button>
</a>
<div class="row m-t-30">
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('menu.manage_menu_process')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="control-label mb-1">Name </label>
                                <input id="name" value="{{$name}}" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="parent" class="control-label mb-1">Parent Menu</label>
                                <select id="parent_id" name="parent_id" class="form-control" required>
                                    <option value="0">Select Categories</option>
                                    @foreach($menu as $list)
                                    @if($parent_id==$list->id)
                                    <option selected value="{{$list->id}}">
                                        @else
                                    <option value="{{$list->id}}">
                                        @endif
                                        {{$list->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="sirial" class="control-label mb-1">sirial </label>
                                <input id="sirial" value="{{$sirial}}" name="sirial" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                @error('sirial')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="url" class="control-label mb-1">Url </label>
                                <input id="url" value="{{$url}}" name="url" type="text" class="form-control" aria-required="true" aria-invalid="false" required>
                                @error('url')
                                <div class="alert alert-danger" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div>
                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                    Submit
                                </button>
                            </div>
                            <input type="hidden" name="id" value="{{$id}}" />
                        </form>
                    </div>
                </div>
            </div>






        </div>

    </div>
</div>

@endsection
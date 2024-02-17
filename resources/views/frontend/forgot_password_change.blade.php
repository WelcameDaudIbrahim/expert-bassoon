@extends('frontend/layout') @section('title','Forgot Password')
@section('main')
<div id="logreg-forms">
    <form class="form-reset active" action=javascript:void(0)"" id="frmUpdatePassword">
      @csrf
        <h1 class="h3 mb-3 font-weight-normal" style="text-align: center">
            Forgot Password
        </h1>
        <input
            type="password"
            class="form-control"
            placeholder="New Password"
            required=""
            autofocus=""
            name="password"
        />
        <div id="password_error" class="field_error"></div> 
        <p id="forgot_msg"></p>
        <button class="btn btn-success btn-block" type="submit">
             Change Password
        </button>
    </form>
</div>
@endsection
@extends('frontend/layout') @section('title','Login - Register')
@section('main')
@php
if(isset($_COOKIE['login_email']) && isset($_COOKIE['login_pwd'])){
  $login_email=$_COOKIE['login_email'];
  $login_pwd=$_COOKIE['login_pwd'];
  $is_remember="checked='checked'";
} else{
  $login_email='';
  $login_pwd='';
  $is_remember="";
}   

@endphp    
<div id="logreg-forms">
    <form class="form-signin active" action=javascript:void(0)"" id="frmLogin">
      @csrf
        <h1 class="h3 mb-3 font-weight-normal" style="text-align: center">
            Log in
        </h1>
        <input
            type="email"
            class="form-control"
            placeholder="Email address"
            required=""
            autofocus=""
            name="str_login_email"
            value="{{$login_email}}"
        />
        @if(session()->has('msg'))
        <div style="color: red" id="msg" class="field_error">
            {{ session("msg") }}
        </div>
        @endif
        <div style="color: red" id="login_msg" class="field_error"></div>
        <input
            type="password"
            class="form-control"
            placeholder="Password"
            required=""
            name="str_login_password"
            value="{{$login_pwd}}"
        />
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="rememberme" id="rememberme" {{$is_remember}}>
          <label class="form-check-label" for="rememberme">
            Remember Me
          </label>
        </div>
        <p class="fw-bold" id="login_process_msg"></p>
        <button id="log-b" class="btn btn-success btn-block" type="submit">
            <i class="fas fa-sign-in-alt"></i> Log in
        </button>
        <a href="javascript:void(0)" id="forgot_pswd" onclick="toggleReset()"
            >Forgot password?</a
        >
        <hr />
        <button
            onclick="toggleSignUp()"
            class="btn btn-primary btn-block"
            type="button"
            id="btn-signup"
        >
            <i class="fas fa-user-plus"></i> Register New Account
        </button>
    </form>

    <form action="javascript:void(0)" class="form-reset" id="frmForgot">
      @csrf
        <h1 class="h3 mb-3 font-weight-normal" style="text-align: center">
            Reset Password
        </h1>
        <input
            type="email"
            id="resetEmail"
            class="form-control"
            placeholder="Email address"
            required=""
            autofocus=""
            name="str_forgot_email"
        />
                            <p class="fw-bold" id="forgot_msg"></p>
        <button
        
            onclick="toggleReset()"
            class="btn btn-primary btn-block log-b"
            type="submit"
        >
            Reset Password
        </button>
        <a href="javascript:void(0)" onclick="toggleSignIn()" id="cancel_reset"
            > Back</a
        >
    </form>

    <form action="javascript:void(0)" class="form-signup" id="frmRegistration">
        <h1 class="h3 mb-3 font-weight-normal" style="text-align: center">
            Register
        </h1>
        <!-- <div class="social-login">
        <button class="btn facebook-btn social-btn" type="button">
          <span
            ><i class="fab fa-facebook-f"></i> Register with Facebook</span
          >
        </button>
      </div>
      <div class="social-login">
        <button class="btn google-btn social-btn" type="button">
          <span
            ><i class="fab fa-google-plus-g"></i> Register with Google+</span
          >
        </button>
      </div> -->

        <!-- <p style="text-align: center">OR</p> -->

        <!-- <input
        type="text"
        id="user-name"
        class="form-control"
        
        required=""
        autofocus=""
      />
      <input
        type="email"
        id="user-email"
        class="form-control"
        
        required
        autofocus=""
      />
      <input
        type="password"
        id="user-pass"
        class="form-control"
        
        required
        autofocus=""
      />
      <input
        type="password"
        id="user-repeatpass"
        class="form-control"
        
        required
        autofocus=""
      /> -->

        <input
            type="text"
            name="name"
            placeholder="Full name"
            class="form-control"
            required
        />
        <div style="color: red" id="name_error" class="field_error"></div>

        <input
            type="text"
            name="email"
            placeholder="Email address"
            class="form-control"
            required
        />
        <div style="color: red" id="email_error" class="field_error"></div>

        <input
            type="number"
            name="mobile"
            placeholder="Mobile Number"
            class="form-control"
            required
        />
        <div style="color: red" id="mobile_error" class="field_error"></div>

        <input
            type="password"
            name="password"
            placeholder="Password"
            class="form-control"
            required
        />
        <div style="color: red" id="password_error" class="field_error"></div>

        @csrf
        <p class="fw-bold" id="reg_process_msg"></p>
        <button id="reg-b" class="btn btn-primary btn-block" type="submit">
            <i class="fas fa-user-plus"></i> Register
        </button>
        <a href="javascript:void(0)" onclick="toggleSignIn()" id="cancel_signup"
            >Login</a
        >
    </form>
    <br />
</div>
<script>
    function removeActive() {
        $(".active").removeClass("active");
    }
    function toggleSignIn() {
        removeActive();
        document.querySelector(".form-signin").classList.toggle("active");
    }
    function toggleSignUp() {
        removeActive();
        document.querySelector(".form-signup").classList.toggle("active");
    }
    function toggleReset() {
        removeActive();
        document.querySelector(".form-reset").classList.toggle("active");
    }
</script>
@endsection

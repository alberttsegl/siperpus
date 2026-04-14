@extends('be.master')

@section('main')
<section>
  <div class="page-header min-vh-75">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
          <div class="card card-plain shadow-lg mt-5">
            <div class="card-header pb-0 text-start bg-transparent">
              <h3 class="font-weight-bolder text-primary text-gradient">Welcome Back</h3>
              <p class="mb-0">Enter your email and password to sign in</p>
            </div>
            <div class="card-body">
              <form action="{{ route('login') }}" method="POST" role="form">
                @csrf
                <div class="mb-3">
                  <label class="form-label font-weight-bold">Email</label>
                  <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" aria-label="Email" required>
                </div>
                <div class="mb-3">
    <label class="form-label font-weight-bold">Password</label>
    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" required>
</div>

<div class="form-check">
    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
    <label class="custom-control-label" for="rememberMe">Remember me</label>
</div>
                <div class="text-center">
                  <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Sign In</button>
                </div>
              </form>
            </div>
            <div class="card-footer text-center pt-0 px-lg-2 px-1">
              <p class="mb-4 text-sm mx-auto">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-primary text-gradient font-weight-bold">Sign Up</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
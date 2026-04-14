@extends('be.master')

@section('main')
<section>
  <div class="page-header min-vh-75">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
          <div class="card card-plain shadow-lg mt-5">
            <div class="card-header pb-0 text-start bg-transparent">
              <h3 class="font-weight-bolder text-primary text-gradient">Get Started</h3>
              <p class="mb-0">Create a new account to access the dashboard</p>
            </div>
            <div class="card-body">
              <div class="card-body">
  {{-- Tambahkan baris ini --}}
  @if ($errors->any())
      <div class="alert alert-danger text-white text-sm border-radius-lg">
          <ul class="mb-0">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
              <form action="/register" method="POST" role="form">
                @csrf
                <div class="mb-3">
                  <label class="form-label font-weight-bold">Full Name</label>
                  <input type="text" name="name" class="form-control form-control-lg" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                  <label class="form-label font-weight-bold">Email</label>
                  <input type="email" name="email" class="form-control form-control-lg" placeholder="Email@example.com" required>
                </div>
                <div class="mb-3">
                  <label class="form-label font-weight-bold">Password</label>
                  <input type="password" name="password" class="form-control form-control-lg" placeholder="Min. 6 characters" required>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Sign Up</button>
                </div>
              </form>
            </div>
            <div class="card-footer text-center pt-0 px-lg-2 px-1">
              <p class="mb-4 text-sm mx-auto">
                Already have an account?
                <a href="{{ route('login') }}" class="text-primary text-gradient font-weight-bold">Sign In</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@extends('be.master')

@section('title', 'Edit User')

@section('menu')
    @include('be.menu')
@endsection

@section('main')
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0">Edit User Management</h6>
        </nav>
      </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                @include('user.frmEdit')
            </div>
        </div>
    </div>
@endsection
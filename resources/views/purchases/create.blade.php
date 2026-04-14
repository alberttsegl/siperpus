@extends('be.master')
@section('title', 'Input Purchase')
@section('menu')
    @include('be.menu')
@endsection
@section('main')
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{$title}}</li>
      </ol>
      <h6 class="font-weight-bolder mb-0">{{$title}}</h6>
    </nav>
  </div>
</nav>

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            @include('purchases.frmInsert')
        </div>
    </div>
</div>
@endsection
@extends('be.master')

@section('title', 'Edit Transaksi')

@section('menu')
    @include('be.menu')
@endsection

@section('main')
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0">Edit Transaksi Pembelian</h6>
        </nav>
      </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-7 mx-auto">
                <div class="card">
                    <div class="card-body">
                        @include('purchases.frmEdit')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
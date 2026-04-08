@extends('be.master')

@section('title', 'Users')

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
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" id="userSearch" class="form-control" placeholder="Search user...">
            </div>
          </div>
          <ul class="navbar-nav justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a class="btn btn-outline-primary btn-sm mb-0 me-3" href="{{route('user.create')}}">Add User</a>
            </li>
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Sign In</span>
              </a>
            </li>
            </ul>
        </div>
      </div>
    </nav>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Users Table</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
  <tr>
    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">User</th>
    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Email</th>
    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
  </tr>
</thead>
<tbody>
  @foreach ($users as $index => $user)
  <tr>
    <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $index + 1 }}</span></td>
    
    <td class="align-middle ps-3">
      <div class="d-flex px-0 py-1 align-items-center">
        <div>
  <img src="{{ route('user.avatar', $user->id) }}" 
       class="avatar avatar-sm me-3" 
       alt="user profile"
       style="border-radius: 50%; object-fit: cover; width: 36px; height: 36px;">
</div>
        <div class="d-flex flex-column justify-content-center">
          <h6 class="mb-0 text-sm font-weight-bold">{{ $user->name }}</h6>
        </div>
      </div>
    </td>

    <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $user->email }}</span></td>
    
    <td class="align-middle text-center">
      <div class="d-flex justify-content-center gap-2">
        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 mb-0">
          <i class="fa-regular fa-pen-to-square"></i> Edit
        </a>

        <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="delete-user-form mb-0">
          @csrf
          @method('DELETE')
          <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1 btn-delete mb-0">
            <i class="fa-regular fa-trash-can"></i> Delete
          </button>
        </form>
      </div>
    </td>
  </tr>
  @endforeach

  @if($users->isEmpty())
  <tr>
    <td colspan="4" class="text-center text-muted py-4">Belum ada data user</td>
  </tr>
  @endif
</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search
        const searchInput = document.getElementById('userSearch');
        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
            });
        });

        // Delete Alert
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Yakin hapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#cb0c9f',
                    cancelButtonColor: '#8392ab',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) this.closest('form').submit();
                });
            });
        });
    });
</script>
@endsection
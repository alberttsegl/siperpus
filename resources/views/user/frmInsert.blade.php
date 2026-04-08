<h5 class="mb-4">Input Users Data</h5>

<form action="{{ route('user.store') }}" method="post" id="frm" enctype="multipart/form-data"> @csrf

  <div class="mb-3">
    <label for="name" class="form-label">Full Name</label>
    <input type="text" id="name" name="name" class="form-control" placeholder="Enter name...">
  </div>
  
  <div class="mb-3">
    <label for="email" class="form-label">Email Address</label>
    <input type="email" id="email" name="email" class="form-control" placeholder="name@example.com">
  </div>

  <div class="mb-3">
    <label for="profile_picture" class="form-label">Profile Picture <small class="text-muted">(Optional)</small></label>
    <input type="file" id="profile_picture" name="profile_picture" class="form-control" accept="image/png, image/jpeg, image/jpg">
    <small class="form-text text-muted">Format: JPG, JPEG, PNG. Max: 2MB.</small>
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" id="password" name="password" class="form-control" placeholder="Minimum 8 chars">
  </div>
  
  <div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Repeat your password">
  </div>

  <div class="mt-4">
    <button type="submit" id="btnSimpan" class="btn btn-outline-primary btn-sm mb-0 me-2">Save User</button>
    <a href="{{ route('user.index') }}" class="btn btn-outline-secondary btn-sm mb-0">Cancel</a>
  </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Script validasi (sesuaikan dengan id input yang baru)
  document.getElementById("frm").onsubmit = function (e) {
    e.preventDefault();
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');
    const photo = document.getElementById('profile_picture');

    if (name.value.trim() === "") {
      Swal.fire("Invalid", "Nama wajib diisi", "error"); name.focus(); return;
    }
    if (email.value.trim() === "" || !email.value.includes('@')) {
      Swal.fire("Invalid", "Format email tidak valid", "error"); email.focus(); return;
    }
    if (password.value.length < 8) {
      Swal.fire("Invalid", "Password minimal 8 karakter", "error"); password.focus(); return;
    }
    if (password.value !== confirm.value) {
      Swal.fire("Invalid", "Konfirmasi password tidak cocok", "error"); confirm.focus(); return;
    }

    // Validasi Ukuran Foto (Opsional, tapi bagus)
    if (photo.files.length > 0) {
      if (photo.files[0].size > 2 * 1024 * 1024) {
        Swal.fire("Invalid", "Ukuran foto maksimal 2MB", "error"); return;
      }
    }

    this.submit();
  };
</script>
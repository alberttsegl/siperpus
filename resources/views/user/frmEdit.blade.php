<h5>Edit User Data</h5>

{{-- 1. Pastikan Route benar (user.update) dan tambahkan enctype --}}
<form action="{{ route('user.update', $user->id) }}" method="POST" id="frmEdit" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}">
        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- 2. Input Role (Ini WAJIB ada karena di Controller statusnya 'required') --}}
    <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" id="role" class="form-control">
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
            <option value="siswa" {{ $user->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
            <option value="kepala perpustakaan" {{ $user->role == 'kepala perpustakaan' ? 'selected' : '' }}>Kepala Perpustakaan</option>
        </select>
        @error('role') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Current Profile Picture</label><br>
        <img src="{{ route('user.avatar', $user->id) }}" class="avatar avatar-xl me-3 border-radius-lg" alt="user1">
    </div>

    <div class="mb-3">
        <label class="form-label">Upload New Photo</label>
        {{-- Nama input harus 'profile_picture' sesuai Controller --}}
        <input type="file" id="profile_picture" name="profile_picture" class="form-control">
        @error('profile_picture') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Password <small class="text-muted">(Kosongkan jika tidak ganti)</small></label>
        <input type="password" id="password" name="password" class="form-control">
        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <button type="submit" class="btn btn-primary btn-sm">SAVE CHANGES</button>
    <a href="{{ route('user.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("frmEdit").onsubmit = function(e) {
        let name = document.getElementById('name').value;
        let email = document.getElementById('email').value;

        if (name.trim() === "" || email.trim() === "") {
            e.preventDefault();
            Swal.fire("Error", "Name and Email are required!", "error");
            return;
        }
    };
</script>
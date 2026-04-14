<div class="card">
    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h5>Edit User Data</h5>
        <a href="{{ route('user.index') }}" class="btn btn-secondary btn-sm mb-0">Back</a>
    </div>
    <div class="card-body">
        <form action="{{ route('user.update', $user->id) }}" method="POST" id="frmEdit" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" id="role" class="form-control">
                    <option value="siswa" {{ $user->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Current Profile Picture</label>
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ route('user.avatar', $user->id) }}?v={{ time() }}" 
                         class="avatar avatar-md border-radius-lg" 
                         alt="profile_image" 
                         style="object-fit: cover; width: 80px; height: 80px; border: 1px solid #ddd;">
                </div>
                <label for="profile_picture" class="form-label">Upload New Photo</label>
                <input type="file" id="profile_picture" name="profile_picture" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label class="form-label">Password <small class="text-muted">(Kosongkan jika tidak ganti)</small></label>
                <input type="password" id="password" name="password" class="form-control" placeholder="******">
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary btn-sm mb-0">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("frmEdit").onsubmit = function(e) {
        e.preventDefault();
        const name = document.getElementById('name');
        const email = document.getElementById('email');

        if (name.value.trim() === "") {
            Swal.fire("Error", "Nama tidak boleh kosong!", "error"); return;
        }
        if (!email.value.includes('@')) {
            Swal.fire("Error", "Email tidak valid!", "error"); return;
        }

        Swal.fire({
            title: 'Simpan Perubahan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#cb0c9f',
            confirmButtonText: 'Ya, Update!'
        }).then((result) => {
            if (result.isConfirmed) this.submit();
        });
    };
</script>
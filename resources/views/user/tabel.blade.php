<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center ps-3">
        <h6>Users Table</h6>
        <input type="text" id="userSearch" class="form-control form-control-sm w-auto" placeholder="Search users...">
      </div>
      <div class="table-responsive p-0">
        <table class="table align-items-center justify-content-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Nama User</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Email</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $index => $user)
            <tr>
              <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $index + 1 }}</span></td>
              <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $user->name }}</span></td>
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

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Search filter khusus User
  const input = document.getElementById('userSearch');
  input.addEventListener('keyup', () => {
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
      // Index 1 = Nama, Index 2 = Email
      const name = row.cells[1]?.textContent.toLowerCase() || '';
      const email = row.cells[2]?.textContent.toLowerCase() || '';

      row.style.display = (name.includes(filter) || email.includes(filter)) ? '' : 'none';
    });
  });

  // SweetAlert2 untuk delete user
  const deleteButtons = document.querySelectorAll('.btn-delete');
  deleteButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      const form = this.closest('form');
      Swal.fire({
        title: 'Are you sure?',
        text: "This user will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });
});
</script>
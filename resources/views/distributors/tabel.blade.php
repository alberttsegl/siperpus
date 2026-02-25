<!-- Include SweetAlert2 via CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center ps-3">
        <h6>Distributor Table</h6>
        <input type="text" id="distributorSearch" class="form-control form-control-sm w-auto" placeholder="Search distributors...">
      </div>
      <div class="table-responsive p-0">
        <table class="table align-items-center justify-content-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Nama Distributor</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Alamat</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No. Telpon</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($distributors as $distributor)
            <tr>
              <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $distributor->id_distributor }}</span></td>
              <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $distributor->nama_distributor }}</span></td>
              <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $distributor->alamat }}</span></td>
              <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $distributor->no_telpon }}</span></td>
              <td class="align-middle text-center">
                <div class="d-flex justify-content-center gap-2">
                  <!-- Edit -->
                  <a href="{{ route('distributors.edit', $distributor->id_distributor) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                  </a>

                  <!-- Delete pakai SweetAlert2 -->
                  <form action="{{ route('distributors.destroy', $distributor->id_distributor) }}" method="POST" class="delete-distributor-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1 btn-delete">
                      <i class="fa-regular fa-trash-can"></i> Delete
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @endforeach
            @if($distributors->isEmpty())
            <tr>
              <td colspan="5" class="text-center text-muted">Belum ada data distributor</td>
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
  // Search filter
  const input = document.getElementById('distributorSearch');
  input.addEventListener('keyup', () => {
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
      const name = row.cells[1]?.textContent.toLowerCase() || '';
      const address = row.cells[2]?.textContent.toLowerCase() || '';
      const phone = row.cells[3]?.textContent.toLowerCase() || '';

      row.style.display = (name.includes(filter) || address.includes(filter) || phone.includes(filter)) ? '' : 'none';
    });
  });

  // SweetAlert2 untuk delete
  const deleteButtons = document.querySelectorAll('.btn-delete');
  deleteButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      const form = this.closest('form');
      Swal.fire({
        title: 'Are you sure?',
        text: "This distributor will be permanently deleted!",
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
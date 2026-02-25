<!-- Include SweetAlert2 via CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center ps-3">
        <h6>Projects Table</h6>
        <input type="text" id="bookSearch" class="form-control form-control-sm w-auto" placeholder="Search books...">
      </div>
      <div class="table-responsive p-0">
        <table class="table align-items-center justify-content-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Title</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Type</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Year</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Writer</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Publisher</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Stock</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($books as $book)
            <tr>
              <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $book->kdbuku }}</span></td>
              <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $book->judul }}</span></td>
              <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $book->jenis }}</span></td>
              <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $book->tahun_terbit }}</span></td>
              <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $book->penulis }}</span></td>
              <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $book->penerbit }}</span></td>
              <td class="align-middle ps-3"><span class="text-sm font-weight-bold">{{ $book->stock }}</span></td>
              <td class="align-middle text-center">
                <div class="d-flex justify-content-center gap-2">
                  <!-- Edit -->
                  <a href="{{ route('books.edit', $book->kdbuku) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                  </a>

                  <!-- Delete pakai SweetAlert2 -->
                  <form action="{{ route('books.destroy', $book->kdbuku) }}" method="POST" class="delete-book-form">
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
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Search filter
  const input = document.getElementById('bookSearch');
  input.addEventListener('keyup', () => {
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
      const title = row.cells[1]?.textContent.toLowerCase() || '';
      const writer = row.cells[4]?.textContent.toLowerCase() || '';
      const publisher = row.cells[5]?.textContent.toLowerCase() || '';

      row.style.display = (title.includes(filter) || writer.includes(filter) || publisher.includes(filter)) ? '' : 'none';
    });
  });

  // SweetAlert2 untuk delete
  const deleteButtons = document.querySelectorAll('.btn-delete');
  deleteButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      const form = this.closest('form');
      Swal.fire({
        title: 'Are you sure?',
        text: "This book will be permanently deleted!",
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
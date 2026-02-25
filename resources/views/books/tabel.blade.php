<div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
  <h6>Projects Table</h6>
  <input type="text" id="bookSearch" class="form-control form-control-sm w-auto" placeholder="Search books...">
</div>
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Title</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Publication Year</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Writer</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Publisher</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Stock</th>

                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
  @foreach ($books as $book)
  <tr>
    <td class="align-middle">
      <p class="text-sm font-weight-bold mb-0">{{ $book->kdbuku }}</p>
    </td>
    <td class="align-middle">
      <p class="text-sm font-weight-bold mb-0">{{ $book->judul }}</p>
    </td>
    <td class="align-middle">
      <p class="text-sm font-weight-bold mb-0">{{ $book->jenis }}</p>
    </td> 
    <td class="align-middle">
      <p class="text-sm font-weight-bold mb-0">{{ $book->tahun_terbit }}</p>
    </td>
    <td class="align-middle">
      <p class="text-sm font-weight-bold mb-0">{{ $book->penulis }}</p>
    </td>
    <td class="align-middle">
      <p class="text-sm font-weight-bold mb-0">{{ $book->penerbit }}</p>
    </td>
    <td class="align-middle">
      <p class="text-sm font-weight-bold mb-0">{{ $book->stock }}</p>
    </td>

    <td class="align-middle text-center">
      <a href="{{ route('books.edit', $book->kdbuku) }}" class="text-secondary font-weight-bold text-xs">
        <i class="fas fa-edit text-primary"></i> Edit
      </a>
    </td>
  </tr>
</tbody>
@endforeach


                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('bookSearch');
  input.addEventListener('keyup', () => {
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
      const title = row.cells[1]?.textContent.toLowerCase() || '';
      const writer = row.cells[4]?.textContent.toLowerCase() || '';
      const publisher = row.cells[5]?.textContent.toLowerCase() || '';

      // tampilkan row kalau match, hide kalau tidak
      row.style.display = (title.includes(filter) || writer.includes(filter) || publisher.includes(filter)) ? '' : 'none';
    });
  });
});
</script>

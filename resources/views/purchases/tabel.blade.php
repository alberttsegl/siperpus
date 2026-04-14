<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center ps-3">
        <h6>Purchases Table</h6>
        <input type="text" id="purchaseSearch" class="form-control form-control-sm w-auto" placeholder="Search purchases...">
      </div>
      <div class="table-responsive p-0">
        <table class="table align-items-center justify-content-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No. Nota</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Tanggal</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Distributor</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Buku</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Total Bayar</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($purchases as $item)
            <tr>
              <td class="align-middle ps-3">
                <span class="text-sm font-weight-bold">{{ $item->no_nota }}</span>
              </td>
              <td class="align-middle ps-3">
                <span class="text-sm">{{ \Carbon\Carbon::parse($item->tgl_nota)->format('d/m/Y') }}</span>
              </td>
              <td class="align-middle ps-3">
                <div class="d-flex flex-column">
                  <h6 class="mb-0 text-sm">{{ $item->nama_distributor }}</h6>
                  <p class="text-xs text-secondary mb-0">{{ $item->no_telpon }}</p>
                </div>
              </td>
              <td class="align-middle ps-3">
                <div class="d-flex flex-column">
                  <span class="text-sm font-weight-bold">{{ $item->judul }}</span>
                  <p class="text-xs text-secondary mb-0">Qty: {{ $item->jumlah_beli }}</p>
                </div>
              </td>
              <td class="align-middle ps-3">
                <span class="text-sm font-weight-bold text-dark">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</span>
              </td>
              <td class="align-middle text-center">
                <div class="d-flex justify-content-center gap-2">
                  <a href="{{ route('purchases.edit', $item->no_nota) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 mb-0">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                  </a>

                  <form action="{{ route('purchases.destroy', $item->no_nota) }}" method="POST" class="delete-purchase-form mb-0">
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

            @if($purchases->isEmpty())
            <tr>
              <td colspan="6" class="text-center text-muted py-4">Belum ada data transaksi pembelian</td>
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
  // Search filter untuk Nota, Distributor, dan Buku
  const input = document.getElementById('purchaseSearch');
  input.addEventListener('keyup', () => {
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
      const nota = row.cells[0]?.textContent.toLowerCase() || '';
      const distributor = row.cells[2]?.textContent.toLowerCase() || '';
      const buku = row.cells[3]?.textContent.toLowerCase() || '';

      row.style.display = (nota.includes(filter) || distributor.includes(filter) || buku.includes(filter)) ? '' : 'none';
    });
  });

  // SweetAlert2 untuk delete
  const deleteButtons = document.querySelectorAll('.btn-delete');
  deleteButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      const form = this.closest('form');
      Swal.fire({
        title: 'Hapus Transaksi?',
        text: "Data pembelian ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
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
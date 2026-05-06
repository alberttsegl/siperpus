<!-- Load SweetAlert2 -->
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
            @php
              // Gunakan md5 dari no_nota untuk ID form agar unik dan aman dari karakter spesial
              $safeId = md5($item->no_nota);
            @endphp
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
                  <!-- Tombol Edit -->
                  <button type="button" onclick="verifyAction('edit', '{{ addslashes($item->no_nota) }}', '{{ $safeId }}')" class="btn btn-sm btn-outline-primary mb-0">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                  </button>

                  <!-- Form Delete: Mengarah ke no_nota yang ada di tabel purchase_details dan purchases[cite: 6, 7] -->
                  <form id="delete-form-{{ $safeId }}" action="{{ route('purchases.destroy', $item->no_nota) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                  </form>
                  
                  <button type="button" onclick="verifyAction('delete', '{{ addslashes($item->no_nota) }}', '{{ $safeId }}')" class="btn btn-sm btn-outline-danger mb-0">
                    <i class="fa-regular fa-trash-can"></i> Delete
                  </button>
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
function verifyAction(action, id, safeId) {
    Swal.fire({
        title: 'Password diperlukan!',
        input: 'password',
        inputPlaceholder: 'Masukkan password boss',
        showCancelButton: true,
        confirmButtonText: 'Verifikasi',
        confirmButtonColor: '#cb0c9f',
        showLoaderOnConfirm: true,
        preConfirm: (password) => {
            return fetch("{{ route('user.checkBossPassword') }}", {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify({ password: password })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => { throw new Error(data.message || 'Gagal verifikasi') });
                }
                return response.json();
            })
            .catch(error => { Swal.showValidationMessage(error.message); });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            if (action === 'edit') {
                window.location.href = `/purchases/${encodeURIComponent(id)}/edit`;
            } else {
                confirmDeletion(safeId);
            }
        }
    });
}

function confirmDeletion(safeId) {
    Swal.fire({
        title: 'Hapus Transaksi?',
        text: "Data di tabel purchases dan purchase_details akan ikut terhapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ea0606',
        confirmButtonText: 'Ya, Hapus Sekarang!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('delete-form-' + safeId);
            if (form) {
                form.submit(); // Mengirim perintah hapus ke controller[cite: 6]
            }
        }
    });
}

// Search Filter
document.getElementById('purchaseSearch')?.addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('table tbody tr');
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>
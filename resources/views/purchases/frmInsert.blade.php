<h5>Form Transaksi Pembelian</h5>
<hr>

<form action="{{ route('purchases.store') }}" method="POST" id="frmPurchase">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">No. Nota</label>
                <input type="text" name="no_nota" id="no_nota" class="form-control" placeholder="Contoh: K001" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Tanggal Nota</label>
                <input type="date" name="tgl_nota" id="tgl_nota" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Distributor</label>
                <select name="id_distributor" id="id_distributor" class="form-control" required>
                    <option value="">-- Pilih Distributor --</option>
                    @foreach($distributors as $d)
                        <option value="{{ $d->id_distributor }}">{{ $d->nama_distributor }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <h6 class="mt-4">Detail Item Buku</h6>
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead class="bg-light">
                <tr>
                    <th width="35%">Buku</th>
                    <th width="15%">Jumlah</th>
                    <th width="25%">Harga Beli</th>
                    <th width="25%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="kdbuku" id="kdbuku" class="form-control" required>
                            <option value="">-- Pilih Buku --</option>
                            @foreach($books as $b)
                                <option value="{{ $b->kdbuku }}" data-harga="{{ $b->harga_beli ?? 0 }}">
                                    {{ $b->judul }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="jumlah_beli" id="jumlah_beli" class="form-control" min="1" value="1">
                    </td>
                    <td>
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control" placeholder="0">
                    </td>
                    <td>
                        <input type="number" name="subtotal" id="subtotal" class="form-control" readonly value="0">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-4 text-end">
        <input type="hidden" name="total_bayar" id="total_bayar_hidden" value="0">
        
        <h4 class="mb-3">Total Bayar: <span id="displayTotal" class="text-primary">Rp 0</span></h4>
        
        <hr>
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary btn-sm">Batal</a>
            <button type="submit" id="btnSimpan" class="btn btn-outline-primary btn-sm">Simpan Transaksi</button>
        </div>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const kdbuku = document.getElementById("kdbuku");
    const qty = document.getElementById("jumlah_beli");
    const harga = document.getElementById("harga_beli");
    const subtotalInput = document.getElementById("subtotal");
    const totalHidden = document.getElementById("total_bayar_hidden");
    const displayTotal = document.getElementById("displayTotal");
    const frm = document.getElementById("frmPurchase");

    // Fungsi menghitung subtotal dan total bayar secara real-time
    function hitung() {
        let vQty = parseFloat(qty.value) || 0;
        let vHarga = parseFloat(harga.value) || 0;
        let total = vQty * vHarga;

        // Mengisi nilai ke input agar terbaca oleh Controller saat submit
        subtotalInput.value = total; 
        totalHidden.value = total;

        // Update tampilan teks ke user
        displayTotal.innerText = "Rp " + total.toLocaleString('id-ID');
    }

    // Listener saat input angka berubah
    qty.addEventListener('input', hitung);
    harga.addEventListener('input', hitung);

    // Listener saat buku dipilih (auto-fill harga)
    kdbuku.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const hargaBuku = selected.getAttribute('data-harga') || 0;
        harga.value = hargaBuku;
        hitung();
    });

    // Validasi submit agar tidak ada data kosong yang masuk
    frm.onsubmit = function(e) {
        if (totalHidden.value == 0 || totalHidden.value == "") {
            e.preventDefault();
            Swal.fire("Gagal", "Total bayar tidak boleh 0. Silahkan isi jumlah/harga.", "error");
            return false;
        }
    }
</script>
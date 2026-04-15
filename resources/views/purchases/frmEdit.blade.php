<h5>Edit Transaksi Pembelian: {{ $purchase->no_nota }}</h5>

<form action="{{ route('purchases.update', $purchase->no_nota) }}" method="POST" id="frmEditPurchase">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Tanggal Nota</label>
        <input type="date" id="tgl_nota" name="tgl_nota" class="form-control" 
               value="{{ date('Y-m-d', strtotime($purchase->tgl_nota)) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Distributor</label>
        <select name="id_distributor" id="id_distributor" class="form-control">
            @foreach($distributors as $d)
                <option value="{{ $d->id_distributor }}" 
                    {{ $purchase->id_distributor == $d->id_distributor ? 'selected' : '' }}>
                    {{ $d->nama_distributor }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Buku</label>
        <select name="kdbuku" id="kdbuku" class="form-control">
            @foreach($books as $b)
                <option value="{{ $b->kdbuku }}" 
                    {{ $detail->kdbuku == $b->kdbuku ? 'selected' : '' }}>
                    {{ $b->judul }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Jumlah Beli</label>
        <input type="number" id="jumlah_beli" name="jumlah_beli" class="form-control" 
               value="{{ $detail->jumlah_beli }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Harga Beli</label>
        <input type="number" id="harga_beli" name="harga_beli" class="form-control" 
               value="{{ $detail->harga_beli }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Subtotal</label>
        <input type="number" id="subtotal" name="subtotal" class="form-control bg-light" 
               value="{{ $detail->subtotal }}" readonly>
    </div>

    <input type="hidden" name="total_bayar" id="total_bayar_hidden" value="{{ $purchase->total_bayar }}">

    <div class="mt-4">
        <button type="submit" class="btn btn-primary btn-sm">UPDATE NOW</button>
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-sm">CANCEL</a>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const qty = document.getElementById("jumlah_beli");
    const harga = document.getElementById("harga_beli");
    const subtotal = document.getElementById("subtotal");
    const totalHidden = document.getElementById("total_bayar_hidden");

    // Fungsi Hitung Otomatis seperti di form Distributor/Pembelian awal
    function hitung() {
        let vQty = parseFloat(qty.value) || 0;
        let vHarga = parseFloat(harga.value) || 0;
        let res = vQty * vHarga;
        
        subtotal.value = res;
        totalHidden.value = res;
    }

    qty.oninput = hitung;
    harga.oninput = hitung;

    // Validasi SweetAlert2 biar sama gaya komunikasinya
    document.getElementById("frmEditPurchase").onsubmit = function(e) {
        e.preventDefault();
        
        if (qty.value <= 0 || harga.value <= 0) {
            Swal.fire("Error", "Jumlah atau Harga tidak boleh nol!", "error");
            return;
        }

        this.submit();
    };
</script>
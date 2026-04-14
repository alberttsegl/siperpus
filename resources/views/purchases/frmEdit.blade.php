<h5>Edit Transaksi Pembelian: {{ $purchase->no_nota }}</h5>

<form action="{{ route('purchases.update', $purchase->no_nota) }}" method="POST" id="frmEditPurchase">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Tanggal Nota</label>
        <input type="date" id="tgl_nota" name="tgl_nota" class="form-control" value="{{ date('Y-m-d', strtotime($purchase->tgl_nota)) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Distributor</label>
        <select name="id_distributor" id="id_distributor" class="form-control">
            @foreach($distributors as $d)
                <option value="{{ $d->id_distributor }}" {{ $purchase->id_distributor == $d->id_distributor ? 'selected' : '' }}>
                    {{ $d->nama_distributor }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Buku</label>
        <select name="kdbuku" id="kdbuku" class="form-control">
            @foreach($books as $b)
                <option value="{{ $b->kdbuku }}" {{ $detail->kdbuku == $b->kdbuku ? 'selected' : '' }}>
                    {{ $b->judul }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Jumlah Beli</label>
            <input type="number" id="jumlah_beli" name="jumlah_beli" class="form-control" value="{{ $detail->jumlah_beli }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Harga Beli</label>
            <input type="number" id="harga_beli" name="harga_beli" class="form-control" value="{{ $detail->harga_beli }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Subtotal</label>
            <input type="number" id="subtotal" name="subtotal" class="form-control" value="{{ $detail->subtotal }}" readonly>
        </div>
    </div>

    <input type="hidden" name="total_bayar" id="total_bayar_hidden" value="{{ $purchase->total_bayar }}">

    <button type="submit" class="btn btn-primary btn-sm">Update Now</button>
    <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const qty = document.getElementById("jumlah_beli");
    const harga = document.getElementById("harga_beli");
    const subtotal = document.getElementById("subtotal");
    const totalHidden = document.getElementById("total_bayar_hidden");

    // Fungsi Hitung Otomatis
    function hitung() {
        let vQty = parseFloat(qty.value) || 0;
        let vHarga = parseFloat(harga.value) || 0;
        let res = vQty * vHarga;
        subtotal.value = res;
        totalHidden.value = res;
    }

    qty.oninput = hitung;
    harga.oninput = hitung;

    // Validasi Form sebelum Submit
    document.getElementById("frmEditPurchase").onsubmit = function(e) {
        e.preventDefault();
        const inputs = [
            { id: 'tgl_nota', name: 'Tanggal Nota' },
            { id: 'jumlah_beli', name: 'Jumlah Beli' },
            { id: 'harga_beli', name: 'Harga Beli' }
        ];

        for (let input of inputs) {
            let el = document.getElementById(input.id);
            if (el.value.trim() === "" || el.value == 0) {
                Swal.fire("Error", input.name + " tidak boleh kosong!", "error");
                el.focus();
                return;
            }
        }

        this.submit();
    };
</script>
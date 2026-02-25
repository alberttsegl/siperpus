<h5>Input Distributor</h5>

<form action="{{ route('distributors.store') }}" method="POST" id="frmDistributor">
    @csrf

    <div class="mb-3">
        <label for="nama_distributor" class="form-label">Nama Distributor</label>
        <input type="text" id="nama_distributor" name="nama_distributor" class="form-control">
    </div>

    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <input type="text" id="alamat" name="alamat" class="form-control">
    </div>

    <div class="mb-3">
        <label for="no_telpon" class="form-label">No. Telpon</label>
        <input type="text" id="no_telpon" name="no_telpon" class="form-control">
    </div>

    <button type="submit" id="btnSimpan" class="btn btn-outline-primary btn-sm">
        Simpan Sekarang
    </button>

    <a href="{{ route('distributors.index') }}" class="btn btn-outline-secondary btn-sm">
        Batal
    </a>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const frm = document.getElementById("frmDistributor");
    const nama = document.getElementById("nama_distributor");
    const alamat = document.getElementById("alamat");
    const telpon = document.getElementById("no_telpon");

    frm.onsubmit = function(e) {
        e.preventDefault();

        if (nama.value.trim() === "") {
            Swal.fire("Invalid Data", "Nama distributor tidak boleh kosong", "error");
            nama.focus();
            return;
        }

        if (alamat.value.trim() === "") {
            Swal.fire("Invalid Data", "Alamat tidak boleh kosong", "error");
            alamat.focus();
            return;
        }

        if (telpon.value.trim() === "") {
            Swal.fire("Invalid Data", "No. telpon tidak boleh kosong", "error");
            telpon.focus();
            return;
        }

        frm.submit();
    }
</script>
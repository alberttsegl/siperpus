<h5>Edit Distributor Data</h5>

<form action="{{ route('distributors.update', $distributor->id_distributor) }}" method="POST" id="frmEditDistributor">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Nama Distributor</label>
        <input type="text" id="nama_distributor" name="nama_distributor" class="form-control" value="{{ $distributor->nama_distributor }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Alamat</label>
        <input type="text" id="alamat" name="alamat" class="form-control" value="{{ $distributor->alamat }}">
    </div>

    <div class="mb-3">
        <label class="form-label">No. Telpon</label>
        <input type="text" id="no_telpon" name="no_telpon" class="form-control" value="{{ $distributor->no_telpon }}">
    </div>

    <button type="submit" class="btn btn-primary btn-sm">Update Now</button>
    <a href="{{ route('distributors.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById("frmEditDistributor").onsubmit = function(e) {
    e.preventDefault();
    const inputs = [
        { id: 'nama_distributor', name: 'Nama Distributor' },
        { id: 'alamat', name: 'Alamat' },
        { id: 'no_telpon', name: 'No. Telpon' }
    ];

    for (let input of inputs) {
        let el = document.getElementById(input.id);
        if (el.value.trim() === "") {
            Swal.fire("Error", input.name + " cannot be empty!", "error");
            el.focus();
            return;
        }
    }

    this.submit();
};
</script>
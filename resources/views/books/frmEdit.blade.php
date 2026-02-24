<h5>Edit Books Data</h5>

<form action="{{ route('books.update', $book->kdbuku) }}" method="POST" id="frmEdit">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" id="judul" name="judul" class="form-control" value="{{ $book->judul }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Type</label>
        <input type="text" id="jenis" name="jenis" class="form-control" value="{{ $book->jenis }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Publication Year</label>
        <input type="text" id="tahun_terbit" name="tahun_terbit" class="form-control" value="{{ $book->tahun_terbit }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Writer</label>
        <input type="text" id="penulis" name="penulis" class="form-control" value="{{ $book->penulis }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Publisher</label>
        <input type="text" id="penerbit" name="penerbit" class="form-control" value="{{ $book->penerbit }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number" id="stock" name="stock" class="form-control" value="{{ $book->stock }}">
    </div>

    <button type="submit" class="btn btn-primary btn-sm">Update Now</button>
    <a href="{{ route('books.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("frmEdit").onsubmit = function(e) {
        e.preventDefault();
        const inputs = [
            { id: 'judul', name: 'Title' },
            { id: 'jenis', name: 'Type' },
            { id: 'tahun_terbit', name: 'Year' },
            { id: 'penulis', name: 'Writer' },
            { id: 'penerbit', name: 'Publisher' }
        ];

        for (let input of inputs) {
            let el = document.getElementById(input.id);
            if (el.value.trim() === "") {
                Swal.fire("Error", input.name + " cannot be empty!", "error");
                el.focus();
                return;
            }
        }

        if (document.getElementById('stock').value <= 0) {
            Swal.fire("Error", "Stock must be greater than 0", "error");
            return;
        }

        this.submit();
    };
</script>
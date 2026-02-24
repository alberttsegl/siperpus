<h5>Input Books Data</h5>

<form action="{{ route('books.store') }}" method="post" id="frm">
  @csrf

  <div class="mb-3">
    <label for="judul" class="form-label">Title</label>
    <input type="text" id="judul" name="judul" class="form-control">
  </div>

  <div class="mb-3">
    <label for="jenis" class="form-label">Type</label>
    <input type="text" id="jenis" name="jenis" class="form-control">
  </div>

  <div class="mb-3">
    <label for="tahun_terbit" class="form-label">Publication Year</label>
    <input type="text" id="tahun_terbit" name="tahun_terbit" class="form-control">
  </div>

  <div class="mb-3">
    <label for="penulis" class="form-label">Writer</label>
    <input type="text" id="penulis" name="penulis" class="form-control">
  </div>

  <div class="mb-3">
    <label for="penerbit" class="form-label">Publisher</label>
    <input type="text" id="penerbit" name="penerbit" class="form-control">
  </div>

  <div class="mb-3">
    <label for="stock" class="form-label">Stock</label>
    <input type="number" id="stock" name="stock" class="form-control">
  </div>

  <button type="submit" id="btnSimpan" class="btn btn-outline-primary btn-sm">
    Save Now
  </button>

  <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-sm">
    Cancel
  </a>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  var frm = document.getElementById("frm");
  var btnSimpan = document.getElementById("btnSimpan");
  var judul = document.getElementById("judul");
  var jenis = document.getElementById("jenis");
  var tahun = document.getElementById("tahun_terbit");
  var penulis = document.getElementById("penulis");
  var penerbit = document.getElementById("penerbit");
  var stock = document.getElementById("stock");

  document.getElementById("frm").onsubmit = function (e) {
    e.preventDefault();

    if (judul.value.trim() === "") {
      Swal.fire("Invalid Data", "Title tidak boleh kosong", "error");
      judul.focus();
      return;
    }

    if (jenis.value.trim() === "") {
      Swal.fire("Invalid Data", "Type tidak boleh kosong", "error");
      jenis.focus();
      return;
    }

    if (tahun.value.trim() === "") {
      Swal.fire("Invalid Data", "Publication year tidak boleh kosong", "error");
      tahun.focus();
      return;
    }

    if (penulis.value.trim() === "") {
      Swal.fire("Invalid Data", "Writer tidak boleh kosong", "error");
      penulis.focus();
      return;
    }

    if (penerbit.value.trim() === "") {
      Swal.fire("Invalid Data", "Publisher tidak boleh kosong", "error");
      penerbit.focus();
      return;
    }

    if (stock.value.trim() === "" || stock.value <= 0) {
      Swal.fire("Invalid Data", "Stock harus lebih dari 0", "error");
      stock.focus();
      return;
    }

    // semua valid → submit
    document.getElementById("frm").submit();
  };
</script>

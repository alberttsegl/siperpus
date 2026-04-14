<h5>Tambah Peminjam Baru</h5>
<form action="{{ route('borrowers.store') }}" method="post" id="frm" enctype="multipart/form-data">
  @csrf
  <div class="row">
    <div class="col-md-6 mb-3">
      <label>Nama Peminjam</label>
      <input type="text" name="nama_peminjam" class="form-control" maxlength="30">
    </div>
    <div class="col-md-3 mb-3">
      <label>Jenis Kelamin</label>
      <select name="jk" class="form-control">
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
      </select>
    </div>
    <div class="col-md-3 mb-3">
      <label>Status</label>
      <select name="status" class="form-control">
        <option value="siswa">Siswa</option>
        <option value="guru">Guru</option>
        <option value="tendik">Tendik</option>
        <option value="umum">Umum</option>
      </select>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4 mb-3"><label>NIP</label><input type="text" name="nip" class="form-control"></div>
    <div class="col-md-4 mb-3"><label>NUPTK</label><input type="text" name="nuptk" class="form-control"></div>
    <div class="col-md-4 mb-3"><label>NIK</label><input type="text" name="nik" class="form-control"></div>
  </div>

  <div class="row">
    <div class="col-md-4 mb-3"><label>NISN</label><input type="text" name="nisn" class="form-control"></div>
    <div class="col-md-4 mb-3"><label>Kelas</label><input type="text" name="kelas" class="form-control"></div>
    <div class="col-md-4 mb-3"><label>Tahun Ajaran</label><input type="text" name="tahun_ajaran" class="form-control" placeholder="2023/2024"></div>
  </div>

  <div class="mb-3"><label>No Telpon</label><input type="text" name="no_telpon" class="form-control"></div>
  <div class="mb-3"><label>Alamat</label><textarea name="alamat" class="form-control"></textarea></div>
  <div class="mb-3"><label>Foto</label><input type="file" name="foto" class="form-control"></div>

  <button type="submit" class="btn btn-primary">Simpan</button>
  <a href="{{ route('borrowers.index') }}" class="btn btn-secondary">Batal</a>
</form>
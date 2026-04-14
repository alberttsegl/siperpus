<h5>Edit Peminjam</h5>
<form action="{{ route('borrowers.update', $borrowers->id_peminjam) }}" method="post" enctype="multipart/form-data">
  @csrf @method('PUT')
  
  <div class="row">
    <div class="col-md-6 mb-3">
      <label>Nama Peminjam</label>
      <input type="text" name="nama_peminjam" class="form-control" value="{{ $borrowers->nama_peminjam }}">
    </div>
    <div class="col-md-3 mb-3">
      <label>JK</label>
      <select name="jk" class="form-control">
        <option value="L" {{ $borrowers->jk == 'L' ? 'selected' : '' }}>L</option>
        <option value="P" {{ $borrowers->jk == 'P' ? 'selected' : '' }}>P</option>
      </select>
    </div>
    <div class="col-md-3 mb-3">
      <label>Status</label>
      <select name="status" class="form-control">
        @foreach(['siswa', 'guru', 'tendik', 'umum'] as $st)
          <option value="{{ $st }}" {{ $borrowers->status == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="{{ $borrowers->email }}">
  </div>
  
  <div class="mb-3">
    <label>Password (Kosongkan jika tidak ganti)</label>
    <input type="password" name="password" class="form-control">
  </div>

  <button type="submit" class="btn btn-info">Update</button>
  <a href="{{ route('borrowers.index') }}" class="btn btn-secondary">Batal</a>
</form>
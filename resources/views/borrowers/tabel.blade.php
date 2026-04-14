<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center ps-3">
        <h6>Data Peminjam (Borrowers)</h6>
        <input type="text" id="borrowerSearch" class="form-control form-control-sm w-auto" placeholder="Cari peminjam...">
      </div>
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">ID</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Foto</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Nama</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">JK</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Status</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">NIK</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">NIP</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">NUPTK</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">NISN</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Kelas</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Tahun Ajaran</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Email</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Telepon</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Alamat</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($borrowers as $b)
            <tr>
              <td class="ps-3 text-xs font-weight-bold">{{ $b->id_peminjam }}</td>
              <td class="ps-3">
                <img src="{{ $b->foto ? asset('storage/'.$b->foto) : asset('be/assets/img/default-avatar.png') }}" class="avatar avatar-sm" alt="foto">
              </td>
              <td class="ps-3 text-sm font-weight-bold">{{ $b->nama_peminjam }}</td>
              <td class="ps-3 text-xs">{{ $b->jk }}</td>
              <td class="ps-3 text-xs">{{ $b->status }}</td>
              <td class="ps-3 text-xs">{{ $b->nik ?? '-' }}</td>
              <td class="ps-3 text-xs">{{ $b->nip ?? '-' }}</td>
              <td class="ps-3 text-xs">{{ $b->nuptk ?? '-' }}</td>
              <td class="ps-3 text-xs">{{ $b->nisn ?? '-' }}</td>
              <td class="ps-3 text-xs">{{ $b->kelas ?? '-' }}</td>
              <td class="ps-3 text-xs">{{ $b->tahun_ajaran ?? '-' }}</td>
              <td class="ps-3 text-xs">{{ $b->email }}</td>
              <td class="ps-3 text-xs">{{ $b->no_telpon }}</td>
              <td class="ps-3">
                <p class="text-xs mb-0 text-truncate" style="max-width: 120px;">{{ $b->alamat }}</p>
              </td>
              <td class="align-middle">
                <div class="d-flex gap-2 pe-3">
                  <a href="{{ route('borrowers.edit', $b->id_peminjam) }}" class="text-primary font-weight-bold text-xs">Edit</a>
                  <form action="{{ route('borrowers.destroy', $b->id_peminjam) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="border-0 bg-transparent text-danger font-weight-bold text-xs" onclick="return confirm('Hapus data?')">Delete</button>
                  </form>
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
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
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Peminjam</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Identitas Dasar</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Akademik/Kerja</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Alamat & Kontak</th>
              <th class="text-secondary opacity-7"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($borrowers as $b)
            <tr>
              <td class="ps-3">
                <div class="d-flex px-2 py-1">
                  <div>
                    <img src="{{ $b->foto ? asset('storage/'.$b->foto) : asset('be/assets/img/default-avatar.png') }}" class="avatar avatar-sm me-3" alt="user">
                  </div>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">{{ $b->nama_peminjam }}</h6>
                    <p class="text-xs text-secondary mb-0">{{ $b->jk == 'L' ? 'Laki-laki' : 'Perempuan' }} | <b>{{ $b->status }}</b></p>
                  </div>
                </div>
              </td>

              <td class="ps-3">
                <p class="text-xs font-weight-bold mb-0">NIK: {{ $b->nik ?? '-' }}</p>
                <p class="text-xs text-secondary mb-0">NISN: {{ $b->nisn ?? '-' }}</p>
                <p class="text-xs text-secondary mb-0">NIP/NUPTK: {{ $b->nip ?? '-' }} / {{ $b->nuptk ?? '-' }}</p>
              </td>

              <td class="ps-3">
                <p class="text-xs font-weight-bold mb-0">Kelas: {{ $b->kelas ?? '-' }}</p>
                <p class="text-xs text-secondary mb-0">Thn Ajaran: {{ $b->tahun_ajaran ?? '-' }}</p>
              </td>

              <td class="ps-3">
                <p class="text-xs font-weight-bold mb-0">{{ $b->email }}</p>
                <p class="text-xs text-secondary mb-0">{{ $b->no_telpon }}</p>
                <p class="text-xxs text-secondary mb-0 text-truncate" style="max-width: 150px;">{{ $b->alamat }}</p>
              </td>

              <td class="align-middle">
                <div class="d-flex justify-content-center gap-2 pe-3">
                  <a href="{{ route('borrowers.edit', $b->id_peminjam) }}" class="text-primary font-weight-bold text-xs">
                    Edit
                  </a>
                  <form action="{{ route('borrowers.destroy', $b->id_peminjam) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="button" class="btn-delete border-0 bg-transparent text-danger font-weight-bold text-xs">
                      Delete
                    </button>
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
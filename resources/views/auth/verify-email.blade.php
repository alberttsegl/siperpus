@extends('be.master')

@section('main')
<section>
  <div class="page-header min-vh-75">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8 d-flex flex-column mx-lg-0 mx-auto">
          <div class="card card-plain shadow-lg mt-5">
            <div class="card-header pb-0 text-center bg-transparent">
              <h3 class="font-weight-bolder text-primary text-gradient">Verifikasi Email Kamu</h3>
              <p class="mb-0">Satu langkah lagi untuk mengakses SIPERPUS Laravel Web.</p>
            </div>
            <div class="card-body">
              <div class="alert alert-info text-white border-0" role="alert">
                Kami telah mengirimkan link verifikasi ke alamat Gmail kamu. Silakan klik tombol di dalam email tersebut.
              </div>
              
              @if (session('message'))
                <div class="alert alert-success text-white border-0" role="alert">
                  Link verifikasi baru telah dikirim ke email kamu!
                </div>
              @endif

              <p class="text-sm">
                Tidak menerima email? Pastikan untuk memeriksa folder **Spam** atau klik tombol di bawah untuk mengirim ulang link verifikasi.
              </p>

              <div class="text-center">
                <form method="POST" action="{{ route('verification.send') }}">
                  @csrf
                  <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">
                    Kirim Ulang Email Verifikasi
                  </button>
                </form>
              </div>
            </div>
            <div class="card-footer text-center pt-0 px-lg-2 px-1">
              <p class="mb-4 text-sm mx-auto">
                Salah memasukkan email? 
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link text-primary text-gradient font-weight-bold p-0">Sign Out</button>
                </form>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
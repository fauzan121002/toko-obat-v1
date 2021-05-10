
@section('header')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Aplikasi Kasir Toko Obat / Klinik Smartpharmacy - @yield('judul')</title>
  <link rel="icon" href="{{ asset('images/ico.ico') }}">
  <link rel="stylesheet" href="{{ asset('style.css') }}">
  <link rel="stylesheet" href="{{ asset('bootstrap-4.3.1-dist/css/bootstrap.min.css') }}">  
  <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
  <a class="navbar-brand text-white" href="#statistik">Smartpharmacy</a>

  <div class="btn-group ml-auto">
    <button class="btn bg-transparent m-auto"><i class="fas fa-user text-white mr-1"></i></button>
    <form action="/logout" method="POST">@csrf<button type="submit" class="btn bg-transparent m-auto"><i class="fas fa-sign-out-alt text-white"></i></button></form> 
  </div>
</nav>

<nav class="navbar navbar2 bg-dark navbar-expand-lg navbar-light">
  <a class="navbar-brand" href="#"></a>
  <button class="btn btn-outline-light navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link text-white" href="/dashboard"><i class="fas fa-home mr-1"></i>Dashboard<span class="sr-only">(current)</span></a>
      </li>


             
              <div class="dropdown">
                <button class="btn nav-link dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Data Master
                </button>


              <div class="dropdown-menu bg-danger" aria-labelledby="dropdownMenuButton">
                <div class="dropdown-header text-white">Data Master :</div>
                    @if (session('level') == 'admin' || session('level') == 'developer')                
                    <a class="nav-link text-white" href="/kasir"><span class="mr-1 ml-2"><i class="fas fa-user-cog"></i></span>Kasir</a>
                    @endif
                    <a class="nav-link text-white" href="/kategoriobat"><span class="mr-1 ml-2"><i class="fas fa-tablets"></i></span>Kategori</a>
                    <a class="nav-link text-white" href="/jenisobat"><span class="mr-1 ml-2"><i class="fas fa-pills"></i></span>Jenis</a>
                    <a class="nav-link text-white" href="/obat"><span class="mr-1 ml-2"><i class="fas fa-tablets"></i></span>Obat</a>
                    <a class="nav-link text-white" href="/alatkesehatan"><span class="mr-1 ml-2"><i class="fas fa-stethoscope"></i></span>Alat Kesehatan</a>
                    <a class="nav-link text-white" href="/suplemen"><span class="mr-1 ml-2"><i class="fas fa-capsules"></i></span>Suplemen</a>  

                </div>
              </div>

              <div class="dropdown">
                <button class="btn nav-link dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Manajemen
                </button>

                <div class="dropdown-menu bg-danger" aria-labelledby="dropdownMenuButton">
                  <div class="dropdown-header text-white">Manajemen :</div>
                  <a class="nav-link text-white" href="/supplier"><span class="mr-1 ml-2"><i class="fas fa-truck"></i></span>Supplier</a>  
                  <a class="nav-link text-white" href="/riwayattransaksi"><span class="mr-1 ml-2"><i class="fas fa-comment-dollar"></i></span>Riwayat Transaksi</a>
                  @if (session('level') == 'admin' || session('level') == 'developer')
                      <a data-toggle="modal" data-target="#ubahpengumuman" class="nav-link text-white"><span class="mr-1 ml-2"><i class="fas fa-plus"></i></span>Update Pengumuman</a>         
                  @endif

                </div>
              </div>
    </ul>

  </div>
</nav>

@if (session('level') == 'admin' || session('level') == 'developer')
  <div class="modal fade" id="ubahpengumuman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ubah Pengumuman</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <form action="/ubahpengumuman" method="POST">
              @method('PUT')
              @csrf
              <textarea name="isi_pengumuman" class="form-control" id="isi_pengumuman" cols="30" rows="10"></textarea>  
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Ubah</button>
          </form>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>        
        </div>
      </div>
    </div>
  </div>
@endif
@show


<div class="container-fluid mt-3">
 @if ($errors->any())
    <div class="alert alert-danger removeAlert">
        <ol>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ol>
    </div>
 @endif

@if (session('berhasilTambahStok'))
    <div class="alert alert-success removeAlert">
        {{ session('berhasilTambahStok') }}
    </div>
@endif
@if(session('berhasilTambah'))
    <div class="alert alert-success removeAlert">
        {{ session('berhasilTambah') }}
    </div>
@endif
@if(session('berhasilHapus'))
    <div class="alert alert-success removeAlert">          
        {{ session('berhasilHapus') }}
    </div>
@endif
@if (session('berhasilUbah'))
    <div class="alert alert-success removeAlert">          
        {{ session('berhasilUbah') }}
    </div>
@endif

  @yield('content')
</div>

@section('footer')

<script src="{{ asset('fontawesome/js/all.min.js') }}"></script>
<script src="{{ asset('bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script>
<script> 
    $(document).ready(function(){
        $('.removeAlert').click(function(){
          $(this).remove();
        });
    });   
</script>

</body>
</html>

@show

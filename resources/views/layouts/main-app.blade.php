
@section('header')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Aplikasi Kasir Toko Obat / Klinik Smartpharmacy - @yield('judul')</title>
  <link rel="icon" href="{{ asset('images/ico.ico') }}">
  <link rel="stylesheet" href="{{ asset('style.css') }}">
  <link rel="stylesheet" href="{{ asset('bootstrap-4.3.1-dist/css/bootstrap.min.css') }}">  
  <link rel="stylesheet" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.css') }}">  
  <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
<body>
<div class="page-wrapper chiller-theme toggled">
  <div id="show-sidebar" class="btn rounded-0 btn-sm btn-dark text-white"></div>
  <aside id="sidebar" class="sidebar-wrapper">
  <div class="sidebar">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}">Smartpharmacy</a>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">
        <div class="user-pic">
          <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
            alt="User picture">
        </div>
        <div class="user-info">
          <span class="user-name">Jhon
            <strong>Smith</strong>
          </span>
          <span class="user-role">Administrator</span>
          <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>Online</span>
          </span>
        </div>
      </div>
      <!-- sidebar-header  -->
      {{-- <div class="sidebar-search">
        <div>
          <div class="input-group">
            <input type="text" class="form-control search-menu" placeholder="Search...">
            <div class="input-group-append">
              <span class="input-group-text">
                <i class="fa fa-search" aria-hidden="true"></i>
              </span>
            </div>
          </div>
        </div>
      </div> --}}
      <!-- sidebar-search  -->
      <div class="sidebar-menu">
        <ul>
          <li class="header-menu">
            <span>General</span>
          </li>
          <li class="sidebar-menu">
            <a href="{{ route('dashboard') }}">
              <i class="fa fa-tachometer-alt"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="sidebar-dropdown">
            <a>
              <i class="fa fa-tachometer-alt"></i>
              <span>Data Master</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  @if (session('level') == 'admin' || session('level') == 'developer')                
                  <a class="nav-link text-white" href="{{ route('cashier.index') }}"><span class="mr-1 ml-2"><i class="fas fa-user-cog"></i></span>Kasir</a>
                  @endif
                </li>
                <li>
                  <a class="nav-link text-white" href="{{ route('drug-category.index') }}"><span class="mr-1 ml-2"><i class="fas fa-tablets"></i></span>Kategori</a>
                </li>
                <li>
                  <a class="nav-link text-white" href="{{ route('drug-type.index') }}"><span class="mr-1 ml-2"><i class="fas fa-pills"></i></span>Jenis</a>
                </li>
                <li>
                  <a class="nav-link text-white" href="{{ route('drug.index') }}"><span class="mr-1 ml-2"><i class="fas fa-tablets"></i></span>Obat</a>
                </li>
                <li>
                  <a class="nav-link text-white" href="{{ route('medical-device.index') }}"><span class="mr-1 ml-2"><i class="fas fa-stethoscope"></i></span>Alat Kesehatan</a>
                </li>
                <li>
                  <a class="nav-link text-white" href="{{ route('supplement.index') }}"><span class="mr-1 ml-2"><i class="fas fa-capsules"></i></span>Suplemen</a>  
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a>
              <i class="fa fa-tachometer-alt"></i>
              <span>Manajemen</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a class="nav-link text-white" href="{{ route('supplier.index') }}"><span class="mr-1 ml-2"><i class="fas fa-truck"></i></span>Supplier</a>  
                </li>
                <li>
                  <a class="nav-link text-white" href="{{ route('transaction.index') }}"><span class="mr-1 ml-2"><i class="fas fa-comment-dollar"></i></span>Riwayat Transaksi</a>
                </li>
                <li>
                @if (session('level') == 'admin' || session('level') == 'developer')
                    <a data-toggle="modal" data-target="#notification-update" class="nav-link text-white"><span class="mr-1 ml-2"><i class="fas fa-plus"></i></span>Update Pengumuman</a>         
                @endif
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
      <a href="#">
        <i class="fa fa-bell"></i>
        <span class="badge badge-pill badge-warning notification">3</span>
      </a>
      <a href="#">
        <i class="fa fa-envelope"></i>
        <span class="badge badge-pill badge-success notification">7</span>
      </a>
      <a href="#">
        <i class="fa fa-cog"></i>
        <span class="badge-sonar"></span>
      </a>
      <a href="#">
        <i class="fa fa-power-off"></i>
      </a>
    </div>
  </div>
  </aside>
  <!-- sidebar-wrapper  -->

  <!-- content-wrapper  -->
  <div class="content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand text-white" href="#statistik">Smartpharmacy</a>

      <div class="btn-group ml-auto">
        <form action="/logout" method="POST">@csrf<button type="submit" class="btn bg-transparent m-auto"><i class="fas fa-sign-out-alt text-white"></i></button></form> 
      </div>
    </nav>

    @if (session('level') == 'admin' || session('level') == 'developer')
      <div class="modal fade" id="notification-update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <form action="{{ route('notification.update') }}" method="POST">
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
      @if ($notification = Session::get('error'))
        <div class="alert alert-danger alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button>   
          <strong>{{ $notification }}</strong>
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>   
            <ol>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
            </ol>
        </div>
      @endif

      @if (session('stockUpdated'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>   
            {{ session('stockUpdated') }}
          </div>
      @endif
      @if(session('itemAdded'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>   
            {{ session('itemAdded') }}
          </div>
      @endif
      @if(session('itemDeleted'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>           
            {{ session('itemDeleted') }}
          </div>
      @endif
      @if (session('itemUpdated'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>       
            {{ session('itemUpdated') }}
          </div>
      @endif

      @yield('content')
    </div>
  </div>
</div>
@section('footer')

<script src="{{ asset('fontawesome/js/all.min.js') }}"></script>
<script src="{{ asset('bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script>
<script>
$(document).ready(function(){
  $(".sidebar-dropdown > a").click(function() {
    $(".sidebar-submenu").slideUp(200);
    if (
      $(this)
        .parent()
        .hasClass("active")
    ) {
      $(".sidebar-dropdown").removeClass("active");
      $(this)
        .parent()
        .removeClass("active");
    } else {
      $(".sidebar-dropdown").removeClass("active");
      $(this)
        .next(".sidebar-submenu")
        .slideDown(200);
      $(this)
        .parent()
        .addClass("active");
    }
  });

  $("#close-sidebar").click(function() {
    $(".page-wrapper").removeClass("toggled");
  });
  $("#show-sidebar").click(function() {
    $(".page-wrapper").addClass("toggled");
  });
});
</script>
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

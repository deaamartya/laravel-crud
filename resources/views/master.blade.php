<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
	<title>@yield('Judul')</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="{{ asset('/admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
	<link href="{{ asset('/admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="icon" type="image/png" href="/img/store.png">
  <style type="text/css">
    body {
      font-family: Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: black;
      text-align: left;
    }
    .table {
      color: black;
    }
    th {
    text-align: inherit;
    background-color: #4e73df;
    color: white;
    }
    .table thead th {
    vertical-align: bottom;
    border-bottom: 0px;
    }
    .sidebar .nav-item .nav-link i {
      font-size: 1.2rem;
      margin-right: .25rem;
    }
    .sidebar .nav-item .nav-link span {
      font-size: 1rem;
      margin-right: .25rem;
    }
    @yield('tambahstyle')
  </style>
	@yield('headlink')
</head>
<body id="page-top">
	<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/home')}}">
        <div class="sidebar-brand-icon">
          <i class="fas fa-store"></i>
        </div>
        <div class="sidebar-brand-text mx-3">dedstore</div>
      </a>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      <!-- Nav Item - Dashboard -->
      <li class="nav-item mt-3">
        <a class="nav-link" href="{{ url('/home')}}">
          <i class="fas fa-fw fa-chart-line"></i>
          <span>Dashboard</span></a>
      </li>

      <li class="nav-item">
        @if(session('type') == 4 || ((session('type') == 2) || (session('type') == 1)))
            <a class="nav-link mt-3" href="{{ route('categories.index') }}">
                <i class="fas fa-fw fa-bookmark"></i>
                <span class="">Kategori</span>
            </a>
            <a class="nav-link mt-3" href="{{ url('product') }}">
                <i class="fas fa-fw fa-box-open"></i>
                <span class="">Produk</span>
            </a>
        @endif
        @if((session('type') == 2) || (session('type') == 1))
            <a class="nav-link mt-3" href="{{ url('user') }}"><i class="fas fa-fw fa-user-circle"></i>
                <span class="">User</span></a>
        @endif
        @if(session('type') == 2 || ((session('type') == 3) || (session('type') == 1)))
            <a class="nav-link mt-3" href="{{ url('customer') }}">
              <i class="fas fa-fw fa-user-tag"></i>
                <span class="">Customer</span>
            </a>
            <a class="nav-link mt-3" href="{{url('sale')}}">
              <i class="fas fa-fw fa-cart-plus"></i>
                <span class="">Penjualan</span>
              </a>
        @endif
      </li>
      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline mt-3">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
      	<!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            

            <!-- Nav Item - User Information -->
            <li class="nav-item ">
              <a class="nav-link">
                <span class="mr-2 d-none d-lg-inline text-gray-600">Welcome Back, {{ @session('name') }} {{@session('last_name') }}</span>
                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
              </a>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item"><a class="nav-link logout-confirm" href="{{ url('/logout')}}" style="color: black;">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
              Logout
            </a></li>

          </ul>

        </nav>
        <!-- End of Topbar -->
        <div class="container-fluid">
          @yield('konten')
        </div>
      </div>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Dea Amartya 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
</body>
  <script src="{{ asset('/admin/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{ asset('/admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('/admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
  <script src="{{ asset('/admin/js/sb-admin-2.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script>
  $('.logout-confirm').on('click', function (e) {
    event.preventDefault();
    const url = $(this).attr('href');
    Swal.fire({
    title: 'Apakah kamu yakin ingin logout?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya',
    cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            window.location.href = url;
        }
    });
  });
  </script>
@yield('bottom')
</html>
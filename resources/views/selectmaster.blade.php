@extends('master')
@section('headlink')
<link href="{{ asset('/admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link href="{{ asset('/admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
<style type="text/css">
  .btn-group-sm > .btn-icon-split.btn .icon, .btn-icon-split.btn-sm .icon {
    padding: 2px 5px;
  };
@yield('tambahstyle')
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@endsection
@section('konten')
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
  		<h3 class="m-0 font-weight-bold text-primary">Data @yield('judultable')</h3>
      	@yield('btn-insert')
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table display" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              @yield('header')
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @yield('data')
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @if(count($trash) !=0)
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h3 class="m-0 font-weight-bold text-primary">History @yield('judultable')</h3>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table display" id="trashTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              @yield('header')
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @yield('dataTrash')
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endif
  @yield('tambahankonten')
@endsection
@section('bottom')
<script src="{{ asset('/admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
@yield('bottomlink')
@endsection
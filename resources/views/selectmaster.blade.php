@extends('master')
@section('headlink')
	<link href="{{ asset('/admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <!-- <link rel="stylesheet" href="{{ asset('/alert/sweetalert2.min.css') }}"> -->
  <style type="text/css">
    .btn-group-sm > .btn-icon-split.btn .icon, .btn-icon-split.btn-sm .icon {
      padding: 2px 5px;
    };
    td.details-control {
    background: url('../resources/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('../resources/details_close.png') no-repeat center center;
}
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
          <tfoot>
            <tr>
              @yield('header')
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
            @yield('data')
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @yield('tambahankonten')
@endsection
@section('bottom')
<script>
  $(document).ready( function () {
    $('#dataTable').DataTable();
});
</script>
<script src="{{ asset('/admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
@yield('bottomlink')
@endsection
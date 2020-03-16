@extends('master')
@section('headlink')
  <link href="/admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <style type="text/css">
    .btn-group-sm > .btn-icon-split.btn .icon, .btn-icon-split.btn-sm .icon {
      padding: 2px 5px;
    };
  </style>
@endsection
@section('konten')
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h3 class="m-0 font-weight-bold text-primary">Data Detail Penjualan</h3>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama Product</th>
              <th>Jumlah</th>
              <th>Harga Jual</th>
              <th>Diskon</th>
              <th>Total Harga</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>ID</th>
              <th>Nama Product</th>
              <th>Jumlah</th>
              <th>Harga Jual</th>
              <th>Diskon</th>
              <th>Total Harga</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($saledets as $c)
            <tr>
              <td>{{ $c -> nota_id }}</td>
              <td>{{ $c -> product_name }}</td>
              <td>{{ $c -> quantity }}</td>
              <td>{{ $c -> selling_price }}</td>
              <td>{{ $c -> discount }}</td>
              <td>{{ $c ->total_price }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
@section('bottom')
<script>
  $(document).ready( function () {
    $('#dataTable').DataTable();
});
</script>
<script src="/admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
@yield('bottomlink')
@endsection
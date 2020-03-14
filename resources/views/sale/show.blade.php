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
      <h3 class="m-0 font-weight-bold text-primary">Invoice #{{ $sale -> nota_id }}</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <h4>Nama Pembeli : {{ $sale -> u_name }}</h4>
      </div>
      <div class="row">
        <h4>Nama Karyawan : {{ $sale -> c_name }}</h4>
      </div>
      <div class="row">
        <h4>Tanggal Pembelian : {{ $sale -> nota_date }}</h4>
      </div>
      <div class="row">
        <table class="table" width="100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama Produk</th>
              <th>Jumlah</th>
              <th>Harga</th>
              <th>Diskon</th>
              <th>Total Harga</th>
            </tr>
          </thead>
          <tbody>
            @foreach($saledetail as $c)
              <tr>
                <td>{{ $c -> product_id }}</td>
                <td>{{ $c -> product_name }}</td>
                <td>{{ $c -> quantity }}</td>
                <td>{{ $c -> selling_price }}</td>
                <td>{{ $c -> discount }}</td>
                <td>{{ $c -> total_price }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="row">
        <div class="col align-self-end">
          <h6>Total Payment : Rp. {{ $sale -> total_payment }}</h6>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('bottom')
<script src="/admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/admin/js/demo/datatables-demo.js"></script>
@yield('bottomlink')
@endsection
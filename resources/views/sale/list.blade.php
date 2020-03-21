@extends('selectmaster')

@section('judultable','Penjualan')

@section('btn-insert')
<a href="{{ route('sale.create') }}">
@endsection

@section('header')
  <th>ID</th>
  <th>Nama Customer</th>
  <th>Nama User</th>
  <th>Tanggal Penjualan</th>
  <th>Total Pembelian</th>
@endsection

@section('data')

@foreach($sales as $c)
<tr>
  <div class="row">
  	<td>{{ $c -> nota_id }}</td>
  	<td>{{ $c -> c_fullname }}</td>
    <td>{{ $c -> u_fullname }}</td>
    <td>{{ $c -> nota_date }}</td>
    <td>{{ $c -> total_payment }}</td>
    <td>
      <button class="btn btn-success btn-icon-split btn-sm" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" >
          <span class="icon text-white-30">
            <i class="material-icons">visibility</i>
          </span>
          <span class="text">Lihat Invoice</span>
      </button>
      @include('actbtn', 
      array(
      'editlink' => 'sale.edit',
      'id' => $c -> nota_id,
      'dellink' => 'sale.destroy',
      'name' => $c -> nota_id,
      'entity' => 'penjualan',
      'Entity' => 'Penjualan'))
    </td>
  </div>
</tr>
  <div class="row">
    <div class="collapse" id="collapseExample">
    <div class="card card-body">
        Anim pariatur cliche reprehenderit
    </div>
  </div>
  </div>

@endforeach
@endsection
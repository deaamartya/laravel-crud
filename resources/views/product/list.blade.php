@extends('selectmaster')

@section('judultable','Produk')

@section('btn-insert')
<a href="{{ route('product.create') }}">
@endsection

@section('header')
  <th>ID</th>
  <th>Nama Kategori</th>
  <th>Nama Produk</th>
  <th>Harga</th>
  <th>Stok</th>
  <th>Deskripsi</th>
@endsection

@section('data')

@foreach($products as $c)
<tr>
	<td>{{ $c -> product_id }}</td>
	<td>{{ $c -> category_name }}</td>
  <td>{{ $c -> product_name }}</td>
  <td>{{ $c -> product_price }}</td>
  <td>{{ $c -> product_stock }}</td>
  <td>{{ $c -> explanation }}</td>
  <td>
    @include('actbtn', 
    array(
    'editlink' => 'product.edit',
    'id' => $c -> product_id,
    'dellink' => 'product.destroy',
    'name' => $c -> product_name,
    'entity' => 'produk',
    'Entity' => 'Produk'))
  </td>
</tr>
@endforeach
@endsection
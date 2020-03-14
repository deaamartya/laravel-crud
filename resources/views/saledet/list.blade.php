@extends('selectmaster')

@section('judultable','Detail Penjualan')

@section('btn-insert')
<a href="{{ route('saledet.create') }}">
@endsection

@section('header')
  <th>ID</th>
  <th>Nama Product</th>
  <th>Jumlah</th>
  <th>Harga Jual</th>
  <th>Diskon</th>
  <th>Total Harga</th>
@endsection

@section('data')

@foreach($saledets as $c)
<tr>
	<td>{{ $c -> nota_id }}</td>
	<td>{{ $c -> product_name }}</td>
  <td>{{ $c -> quantity }}</td>
  <td>{{ $c -> selling_price }}</td>
  <td>{{ $c -> discount }}</td>
  <td>{{ $c ->total_price }}</td>
  <td>

    <a href="/saledet/edit/{{$c ->nota_id}}/{{$c ->product_id}}" class="btn btn-warning btn-icon-split btn-sm">
        <span class="icon text-white-30">
          <i class="material-icons">edit</i>
        </span>
        <span class="text">Edit</span>
    </a>
    <button class="btn btn-danger btn-icon-split btn-sm" type="button" data-toggle="modal" data-target=".deleteModal{{$c ->nota_id}}{{$c ->product_id}}">
      <span class="icon text-white-30">
              <i class="material-icons">delete</i>
            </span>
            <span class="text">Delete</span>
    </button>

    <div class="modal fade deleteModal{{$c ->nota_id}}{{$c ->product_id}}" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Hapus Detail Penjualan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Apakah anda yakin ingin menghapus detail penjualan id nota {{$c ->nota_id}} dan produk {{ $c -> product_name }} ?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" style="padding: 2px 6px" data-dismiss="modal">Cancel</button>
          <form action="/saledet/destroy/{{$c ->nota_id}}/{{$c ->product_id}}" method="get" style="width: 200px;">
          @csrf
            <button type="submit" class="btn btn-primary btn-sm" style="padding: 2px 6px">
              Ya
            </button>
        </form>
          </div>
        </div>
      </div>
      </div>
  </td>
</tr>
@endforeach
@endsection
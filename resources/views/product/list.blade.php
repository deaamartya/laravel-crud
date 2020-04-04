@extends('selectmaster')

@section('Judul','Data Produk')
@section('judultable','Produk')

@if(session('type') == 4)
@section('btn-insert')
<a href="{{ route('product.create') }}">
  <button class="btn btn-primary">Tambah Produk)</button>
</a>
@endsection
@endif

@section('header')
  <th>ID</th>
  <th>Kategori</th>
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
  <td class="price" align="right">{{ $c -> product_price }}</td>
  <td align="center">{{ $c -> product_stock }}</td>
  <td>@if($c -> explanation == "") - @else {{ $c -> explanation }} @endif</td>
  <td>
    @if(session('type') == 4)
      @include('editbtn', 
      array(
      'editlink' => 'product.edit',
      'id' => $c -> product_id))
    @elseif(session('type') == 1)
    @include('delbtn', 
    array(
    'id' => $c -> product_id,
    'dellink' => 'product'))
    @endif
  </td>
</tr>
@endforeach
@endsection

@section('tambahankonten')
  @if(session('deleted'))
    <script>
      Swal.fire(
        'Delete Success!',
        "Produk {{ @session('deleted') }} telah dihapus",
        'success'
      )
    </script>
  @endif
  @if(session('inserted'))
    <script>
      Swal.fire(
        'Insert Success!',
        "Produk {{ @session('inserted') }} berhasil ditambahkan",
        'success'
      )
    </script>
  @endif
  @if(session('edited'))
    <script>
      Swal.fire(
        'Edit Success!',
        "Data produk dengan ID {{ @session('edited') }} berhasil diubah",
        'success'
      )
    </script>
  @endif
@endsection

@section('bottomlink')
<script type="text/javascript" src="{{ asset('/js/autoNumeric.js') }}"></script>
<script>
  $(document).ready(function(){
    $('.price').autoNumeric('init', {aSep: '.', aDec: ',', aSign: 'Rp ', aPad: false, nBracket: '(,)', lZero: 'deny'});
    $('#dataTable').dataTable({
       columns: [
                {name: 'product_id', width:'5%'},
                {name: 'category_name', width:'10%'},
                {name: 'product_name', width:'25%'},
                {name: 'product_price', width:'15%'},
                {name: 'product_stock', width:'10%'},
                {name: 'explanation', width:'20%'},
                {name: 'action', orderable: false, searchable: false, width:'15%'},
             ],
      order: [[0, 'asc']]
    });
  });

$('.delete-confirm').on('click', function (e) {
    event.preventDefault();
    const url = $(this).attr('href');
    Swal.fire({
    title: 'Apakah kamu yakin?',
    text: "Produk yang dihapus tidak dapat dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Saya Yakin!',
    cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            window.location.href = url;
        }
        else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire(
          'Cancelled',
          'Produk tidak dihapus',
          'error'
        )
      }
    });
  });
</script>
@endsection
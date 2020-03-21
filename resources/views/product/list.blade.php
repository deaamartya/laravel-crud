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
    'dellink' => 'product'))
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
<script>
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
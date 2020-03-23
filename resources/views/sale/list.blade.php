@extends('selectmaster')

@section('Judul','Data Penjualan')
@section('judultable','Penjualan')

@if(session('type') == 3)
  @section('btn-insert')
  <a href="{{ route('sale.create') }}">
    <button class="btn btn-primary">Tambah Penjualan</button>
  </a>
  @endsection
@endif

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
      @if((session('type') == 3) || ((session('type') == 2) || (session('type') == 1)))
      <a class="btn btn-success btn-icon-split btn-sm" href="{{ route('sale.show',$c -> nota_id) }}">
          <span class="icon text-white-30">
            <i class="material-icons">visibility</i>
          </span>
          <span class="text">Lihat Invoice</span>
      </a>
      @endif
      @if(session('type') == 3)
        @include('editbtn', 
        array(
        'editlink' => 'sale.edit',
        'id' => $c -> nota_id))
      @elseif(session('type') == 1)
      @include('delbtn', 
      array(
      'id' => $c -> nota_id,
      'dellink' => 'sale'))
      @endif
    </td>
  </div>
</tr>
@endforeach
@endsection
@section('tambahankonten')
  @if(session('deleted'))
    <script>
      Swal.fire(
        'Delete Success!',
        "Penjualan {{ @session('deleted') }} telah dihapus",
        'success'
      )
    </script>
  @endif
  @if(session('inserted'))
    <script>
      Swal.fire(
        'Insert Success!',
        "Penjualan {{ @session('inserted') }} berhasil ditambahkan",
        'success'
      )
    </script>
  @endif
  @if(session('edited'))
    <script>
      Swal.fire(
        'Edit Success!',
        "Data penjualan dengan ID {{ @session('edited') }} berhasil diubah",
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
    text: "Penjualan yang dihapus tidak dapat dikembalikan!",
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
          'Penjualan tidak dihapus',
          'error'
        )
      }
    });
  });
</script>
@endsection
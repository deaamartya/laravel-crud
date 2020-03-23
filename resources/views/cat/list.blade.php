@extends('selectmaster')

@section('Judul','Data Kategori')
@section('judultable','Kategori')

@if(session('type') == 4)
  @section('btn-insert')
  <a href="{{ route('categories.create') }}">
    <button class="btn btn-primary">Tambah Kategori</button>
  </a>
  @endsection
@endif

@section('header')
  <th>ID</th>
  <th>Name</th>
@endsection

@section('data')

@foreach($categories as $c)
<tr>
	<td>{{ $c -> category_id }}</td>
	<td>{{ $c -> category_name }}</td>
  <td>
    @if(session('type') == 4)
      @include('editbtn', 
      array(
      'editlink' => 'categories.edit',
      'id' => $c -> category_id))
    @elseif(session('type') == 1)
    @include('delbtn', 
    array(
    'id' => $c -> category_id,
    'dellink' => 'categories'))
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
        "Kategori {{ @session('deleted') }} telah dihapus",
        'success'
      )
    </script>
  @endif
  @if(session('inserted'))
    <script>
      Swal.fire(
        'Insert Success!',
        "Kategori {{ @session('inserted') }} berhasil ditambahkan",
        'success'
      )
    </script>
  @endif
  @if(session('edited'))
    <script>
      Swal.fire(
        'Edit Success!',
        "Data kategori dengan ID {{ @session('edited') }} berhasil diubah",
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
    text: "Kategori yang dihapus tidak dapat dikembalikan!",
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
          'Kategori tidak dihapus',
          'error'
        )
      }
    });
  });
</script>
@endsection
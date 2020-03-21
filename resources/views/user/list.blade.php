@extends('selectmaster')

@section('judultable','User')

@section('btn-insert')
<a href="{{ route('user.create') }}">
@endsection

@section('header')
  <th>ID</th>
  <th>First Name</th>
  <th>Last Name</th>
  <th>Phone</th>
  <th>Email</th>
  <th>Job Status</th>
@endsection

@section('data')

@foreach($users as $c)
<tr>
	<td>{{ $c->user_id }}</td>
	<td>{{ $c->first_name }}</td>
	<td>{{ $c->last_name }}</td>
	<td>0{{ $c->phone }}</td>
	<td>{{ $c->email }}</td>
	<td>{{ $c->job_status }}</td>
  <td>
    @include('actbtn', 
    array(
    'editlink' => 'user.edit',
    'id' => $c -> user_id,
    'dellink' => 'user'))
  </td>
</tr>
@endforeach
@endsection
@section('tambahankonten')
  @if(session('deleted'))
    <script>
      Swal.fire(
        'Delete Success!',
        "User {{ @session('deleted') }} telah dihapus",
        'success'
      )
    </script>
  @endif
  @if(session('inserted'))
    <script>
      Swal.fire(
        'Insert Success!',
        "User {{ @session('inserted') }} berhasil ditambahkan",
        'success'
      )
    </script>
  @endif
  @if(session('edited'))
    <script>
      Swal.fire(
        'Edit Success!',
        "Data user dengan ID {{ @session('edited') }} berhasil diubah",
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
    text: "User yang dihapus tidak dapat dikembalikan!",
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
          'User tidak dihapus',
          'error'
        )
      }
    });
  });
</script>
@endsection
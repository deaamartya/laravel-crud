@extends('selectmaster')

@section('Judul','Data User')
@section('judultable','User')

@if(session('type') == 1)
  @section('btn-insert')
  <a href="{{ route('user.create') }}">
    <button class="btn btn-primary"><i class="fa fa-plus-circle mr-2"></i>Tambah User</button>
  </a>
  @endsection
@endif

@section('header')
  <th>ID</th>
  <th>Name</th>
  <th>Phone</th>
  <th>Email</th>
  <th>Job Status</th>
@endsection

@section('data')

@foreach($users as $c)
<tr>
	<td>{{ $c->user_id }}</td>
	<td>{{ $c->first_name }} {{ $c->last_name }}</td>
	<td>0{{ $c->phone }}</td>
	<td>{{ $c->email }}</td>
	<td>{{ $c->nama_job }}</td>
  <td>
      @if(session('type') == 1)
      @include('editbtn', 
      array(
      'editlink' => 'user.edit',
      'id' => $c -> user_id))
      @include('delbtn', 
      array(
      'id' => $c -> user_id,
      'dellink' => 'user'))
      @endif
  </td>
</tr>
@endforeach
@endsection

@section('dataTrash')
@foreach($trash as $c)
<tr id="trash{{$c->category_id}}">
  <td>{{ $c->user_id }}</td>
  <td>{{ $c->first_name }} {{ $c->last_name }}</td>
  <td>0{{ $c->phone }}</td>
  <td>{{ $c->email }}</td>
  <td>{{ $c->nama_job }}</td>
  <td>
      @if(session('type') == 1)
      @include('restorebtn', 
      array(
      'id' => $c -> user_id,
      'dellink' => 'user'))
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
        "User dengan ID {{ @session('edited') }} berhasil diubah",
        'success'
      )
    </script>
  @endif
  @if(session('restore'))
    <script>
      Swal.fire(
        'Restore Success!',
        "User {{ @session('restore') }} berhasil dikembalikan",
        'success'
      )
    </script>
  @endif
@endsection

@section('bottomlink')
<script>
  $(document).ready(function(){
    $('#dataTable').dataTable({
       columns: [
                {name: 'user_id', width:'5%'},
                {name: 'first_name', width:'25%'},
                {name: 'phone', width:'15%'},
                {name: 'email', width:'15%'},
                {name: 'nama_job', width:'15%'},
                {name: 'action', orderable: false, searchable: false, width:'25%'},
             ],
      order: [[0, 'asc']]
    });
    $('#trashTable').dataTable({
       columns: [
                {name: 'user_id', width:'10%'},
                {name: 'first_name', width:'30%'},
                {name: 'phone', width:'15%'},
                {name: 'email', width:'15%'},
                {name: 'nama_job', width:'15%'},
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
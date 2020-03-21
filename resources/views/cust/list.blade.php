@extends('selectmaster')

@section('judultable','Customer')

@section('btn-insert')
<a href="{{ route('customer.create') }}">
@endsection

@section('header')
  <th>ID</th>
  <th>First Name</th>
  <th>Last Name</th>
  <th>Phone</th>
  <th>Email</th>
  <th>Street</th>
  <th>City</th>
  <th>State</th>
  <th>Zip Code</th>
@endsection

@section('data')

@foreach($customers as $c)
<tr>
	<td>{{ $c->customer_id }}</td>
	<td>{{ $c->first_name }}</td>
	<td>{{ $c->last_name }}</td>
	<td>0{{ $c->phone }}</td>
	<td>{{ $c->email }}</td>
	<td>{{ $c->street }}</td>
	<td>{{ $c->city }}</td>
	<td>{{ $c->state }}</td>
	<td>{{ $c->zip_code }}</td>
  <td>
    @include('actbtn', 
    array(
    'editlink' => 'customer.edit',
    'id' => $c -> customer_id,
    'dellink' => 'customer'))
  </td>
</tr>
@endforeach
@endsection

@section('tambahankonten')
  @if(session('deleted'))
    <script>
      Swal.fire(
        'Delete Success!',
        "Customer {{ @session('deleted') }} telah dihapus",
        'success'
      )
    </script>
  @endif
  @if(session('inserted'))
    <script>
      Swal.fire(
        'Insert Success!',
        "Customer {{ @session('inserted') }} berhasil ditambahkan",
        'success'
      )
    </script>
  @endif
  @if(session('edited'))
    <script>
      Swal.fire(
        'Edit Success!',
        "Data customer dengan ID {{ @session('edited') }} berhasil diubah",
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
    text: "Customer yang dihapus tidak dapat dikembalikan!",
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
          'Customer tidak dihapus',
          'error'
        )
      }
    });
  });
</script>
@endsection
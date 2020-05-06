@extends('selectmaster')

@section('Judul','Data Customer')
@section('judultable','Customer')

@if(session('type') == 3)
  @section('btn-insert')
  <a href="{{ route('customer.create') }}">
    <button class="btn btn-primary">Tambah Customer</button>
  </a>
  @endsection
@endif

@section('header')
  <th>ID</th>
  <th>Name</th>
  <th>Phone</th>
  <th>Email</th>
  <th>Address</th>
@endsection

@section('data')

@foreach($customers as $c)
<tr>
	<td>{{ $c->customer_id }}</td>
	<td>{{ $c->first_name }} {{ $c->last_name }}</td>
	<td>0{{ $c->phone }}</td>
	<td>{{ $c->email }}</td>
	<td>{{ $c->street }} {{ $c->city }}, {{ $c->state }}, {{ $c->zip_code }}</td>
  <td>
    @if(session('type') == 3)
      @include('editbtn', 
      array(
      'editlink' => 'customer.edit',
      'id' => $c -> customer_id))
    @elseif(session('type') == 1)
    @include('delbtn', 
    array(
    'id' => $c -> customer_id,
    'dellink' => 'customer'))
    @endif
  </td>
</tr>
@endforeach

@endsection

@section('dataTrash')

@foreach($trash as $c)
<tr>
  <td>{{ $c->customer_id }}</td>
  <td>{{ $c->first_name }} {{ $c->last_name }}</td>
  <td>0{{ $c->phone }}</td>
  <td>{{ $c->email }}</td>
  <td>{{ $c->street }} {{ $c->city }}, {{ $c->state }}, {{ $c->zip_code }}</td>
  <td>
    @if(session('type') == 3)
      @include('editbtn', 
      array(
      'editlink' => 'customer.edit',
      'id' => $c -> customer_id))
    @elseif(session('type') == 1)
    @include('restorebtn', 
    array(
    'id' => $c -> customer_id,
    'dellink' => 'customer'))
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
        "Customer dengan ID {{ @session('edited') }} berhasil diubah",
        'success'
      )
    </script>
  @endif
  @if(session('restore'))
    <script>
      Swal.fire(
        'Restore Success!',
        "Customer {{ @session('restore') }} berhasil dikembalikan",
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
$(document).ready(function(){
  var SITEURL = '{{URL::to('')}}';
  $('#dataTable').dataTable({
    columns: [
              {name: 'customer_id'},
              {name: 'first_name'},
              {name: 'phone'},
              {name: 'email'},
              {name: 'street'},
              {name: 'action', orderable: false, searchable: false},
              ],
    order: [[0, 'desc']],
  });
  $('#trashTable').dataTable({
    columns: [
              {name: 'customer_id'},
              {name: 'first_name'},
              {name: 'phone'},
              {name: 'email'},
              {name: 'street'},
              {name: 'action', orderable: false, searchable: false},
              ],
    order: [[0, 'desc']],
  });
 $('.switch').change(function(){
    var id = $(this).attr('id');
    var baseurl = '{{URL::to('')}}';
    $.ajax({
        url: baseurl+'/customer/updateStatus/'+id,
        method: 'GET',
        success: function(data) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Customer '+data.name+' berhasil di update',
            showConfirmButton: false,
            timer: 1200
          });
          $("#badgestatus"+id).html(data.html);
          $("#label"+id).html(data.label);
        },
        error: function(data) {
          console.log(data);
        }
    });
  });
});
</script>
@endsection
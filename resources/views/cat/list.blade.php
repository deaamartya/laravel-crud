@extends('selectmaster')

@section('Judul','Data Kategori')
@section('judultable','Kategori')

@section('tambahstyle')
div.dataTables_wrapper div.dataTables_filter input {
  width:700px;
}
@endsection

@if(session('type') == 4)
  @section('btn-insert')
  <a href="{{ route('categories.create') }}">
    <button class="btn btn-primary">Tambah Kategori</button>
  </a>
  @endsection
@endif

@section('header')
<th>Status</th>
  <th>ID</th>
  <th>Name</th>
  
@endsection

@section('data')

@foreach($categories as $c)
<tr id="row{{$c->category_id}}">
  <td>
    <h5 id="badgestatus{{ $c -> category_id }}"><span class="badge badge-success">Aktif</span></h5>
  </td>
	<td>{{ $c -> category_id }}</td>
	<td>{{ $c -> category_name }}</td>
  <td>
    @if(session('type') == 4)
      @include('editbtn', 
      array(
      'editlink' => 'categories.edit',
      'id' => $c -> category_id))
    @elseif(session('type') == 1)
    @include('updatebtn', 
    array(
    'id' => $c -> category_id,
    'dellink' => 'categories',
    'status' => $c -> status))
    @endif
  </td>
</tr>
@endforeach
@endsection

@section('dataTrash')

@foreach($trash as $c)
<tr id="trash{{$c->category_id}}">
  <td>
    <h5 id="badgestatus{{ $c -> category_id }}"><span class="badge badge-secondary">Nonaktif</span></h5>
  </td>
  <td>{{ $c -> category_id }}</td>
  <td>{{ $c -> category_name }}</td>
  <td>
    @if(session('type') == 1)
    @include('updatebtn', 
    array(
    'id' => $c -> category_id,
    'dellink' => 'categories',
    'status' => $c -> status))
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
function submit(id){
  document.getElementById("switch"+id).submit();
}
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
$(document).ready(function(){
  var SITEURL = '{{URL::to('')}}';
  $('#dataTable').dataTable({
     columns: [
              {name: 'status', orderable: true, width:'10%'},
              {name: 'category_id', searchable: false, width:'10%'},
              {name: 'category_name', orderable: true, width:'60%'},
              {name: 'action', orderable: false, searchable: false, width:'20%'},
           ],
    order: [[0, 'desc']],
    lengthChange: false,
  });
 $('.switch').change(function(){
    var id = $(this).attr('id');
    var baseurl = '{{URL::to('')}}';
    $.ajax({
        url: baseurl+'/categories/updateStatus/'+id,
        method: 'GET',
        success: function(data) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Kategori '+data.name+' berhasil di update',
            showConfirmButton: false,
            timer: 1200
          });
          $("#badgestatus"+data.id).html(data.html);
          $("#label"+data.id).html(data.label);
        },
        error: function(data) {
          console.log(data);
        }
    });
  });
});
</script>
@endsection
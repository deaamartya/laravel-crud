@extends('master')
@section('Judul','Data Penjualan')
@section('headlink')
<link href="{{ asset('/admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link href="https://cdn.datatables.net/searchpanes/1.0.1/css/searchpanes.dataTables.min.css" rel="stylesheet">
  <!-- <link rel="stylesheet" href="{{ asset('/alert/sweetalert2.min.css') }}"> -->
  <style type="text/css">
    .btn-group-sm > .btn-icon-split.btn .icon, .btn-icon-split.btn-sm .icon {
      padding: 2px 5px;
    };
    td.details-control {
    background: url('../resources/details_open.png') no-repeat center center;
    cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('../resources/details_close.png') no-repeat center center;
    }
    .btn.focus, .btn:focus {
      border: none;
    }
    .shadow {
    box-shadow: 0 .15rem 1rem 0 rgba(58,59,69,.15) !important;
    }
    th {
        text-align: inherit;
        background-color: transparent;
        color: #5a5c69;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@endsection
@section('konten')
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h3 class="m-0 font-weight-bold text-primary">Data Penjualan</h3>
        @if(session('type') == 3)
          <a href="{{ route('sale.create') }}">
            <button class="btn btn-primary">Tambah Penjualan</button>
          </a>
        @endif
    </div>
    <div class="card-body">
      <div class="row align-text-bottom ml-1 mb-2">
        <div class="col-1">
          Nota ID
        </div>
        <div class="col-3">
          Nama Customer
        </div>
        <div class="col-3 pr-0">
          Nama User
        </div>
        <div class="col-2 pl-0 pr-0">
          Tanggal Penjualan
        </div>
        <div class="col-2 pl-0 pr-0">
          Total Pembelian
        </div>
        <div class="col-1 pl-0">
          Detail
        </div>
      </div>
      <div class="accordion" id="accordionTable">
      @foreach($sales as $c)
          <div class="card z-depth-0 shadow mb-4">
            <div class="card-body" id="heading{{ $c -> nota_id }}">
              <div class="row align-text-bottom mb-3 pl-3">
                <div class="col-1">
                  <span class="align-middle">{{ $c -> nota_id }}</span>
                </div>
                <div class="col-3">
                  <span class="align-middle">{{ $c -> c_fullname }}</span>
                </div>
                <div class="col-3">
                  <span class="align-middle">{{ $c -> u_fullname }}</span>
                </div>
                <div class="col-2">
                  <span class="align-middle">{{ $c -> nota_date }}</span>
                </div>
                <div class="col-2">
                  <span class="align-middle price">{{ $c -> total_payment }}</span>
                </div>
                <div class="col-1">
                  <button class="btn btn-sm btn-success" type="button" data-toggle="collapse" data-target="#collapse{{ $c -> nota_id }}" aria-expanded="false" aria-controls="collapse{{ $c -> nota_id }}" onclick="change({{ $c -> nota_id }})" style="font-size: .1rem;">
                    <i class="material-icons" id="icon{{$c->nota_id}}">keyboard_arrow_down</i>
                  </button>
                </div>
              </div>
            
            <div id="collapse{{ $c -> nota_id }}" class="collapse px-3" aria-labelledby="heading{{ $c -> nota_id }}"
              data-parent="#accordionTable">
                <table class="table" width="80%">
                <tr>
                  <th>
                    <span class="align-middle text-left">ID</span>
                  </th>
                  <th>
                    <span class="align-middle text-left">Nama Produk</span>
                  </th>
                  <th>
                    <span class="align-middle text-left">Harga</span>
                  </th>
                  <th>
                    <span class="align-middle text-left">Qty</span>
                  </th>
                  <th>
                    <span class="align-middle text-left">Disc.</span>
                  </th>
                  <th>
                    <span class="align-middle text-left">Total</span>
                  </th>
                </tr>
                
                  @foreach($c->detail as $d)
                  <tr>
                    <td width="5%">
                      <span class="align-middle text-left">{{ $d -> product_id }}</span>
                    </td>
                    <td width="55%">
                      <span class="align-middle">{{ $d -> product_name }}</span>
                    </td>
                    <td width="15%">
                      <span class="align-middle text-left price">{{ $d -> selling_price }}</span>
                    </td>
                    <td width="5%">
                      <span class="align-middle text-left">x{{ $d -> quantity }}</span>
                    </td>
                    <td width="5%">
                      @if($d->discount != "0")
                      <span class="align-middle text-left" style="color: #cc0000">
                         <?php echo (($d->discount/($d->selling_price*$d->quantity))*100)."%"; ?>
                      </span>
                      @else
                        -
                      @endif
                    </td>
                    <td width="25%">
                      <span class="align-middle text-left price">{{ $d -> total_price }}</span>
                    </td>
                  </tr>
                  @endforeach
                </table>                     
              </div>
              </div>
            
          </div>
        @endforeach
    </div>
  </div>
</div>
<div class="card shadow mb-4">
  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h3 class="m-0 font-weight-bold text-primary">History Penjualan</h3>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table display" id="dataTable1" width="100%" cellspacing="0">
          <thead>
              <th>ID</th>
              <th>Nama Customer</th>
              <th>Nama User</th>
              <th>Tanggal Penjualan</th>
              <th>Total Pembelian</th>
              <th>Action</th>
          </thead>
          <tfoot>
              <th>ID</th>
              <th>Nama Customer</th>
              <th>Nama User</th>
              <th>Tanggal Penjualan</th>
              <th>Total Pembelian</th>
              <th>Action</th>
          </tfoot>
          <tbody>
              @foreach($trash as $c)
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
                    @if(session('type') == 1)
                    @include('restorebtn', 
                    array(
                    'id' => $c -> nota_id,
                    'dellink' => 'sales',
                    'status' => $c -> status))
                    @endif
                  </td>
                </div>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
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
@section('bottom')
<script src="{{ asset('/admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script>
  function change(id){
    console.log("rotatinggg");
    var icon = $("#icon"+id);
    if(icon.html() == "keyboard_arrow_down"){
      icon.html("keyboard_arrow_up");
      console.log("berubaaaah");
    }
    else{
      icon.html("keyboard_arrow_down");
      console.log("masuk else");
    }
  }
  $(document).ready(function(){
    $('.price').each(function(){
      $(this).html("Rp "+money($(this).html()));
    });
  })
  
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
function money(text){
  var text = text.toString();
  var panjang = text.length;
  var hasil = new Array();
  if (panjang>0){
    if(panjang>3){
      var div = parseInt(panjang/3);
      var char = new Array();
      var result="";
      if (div > 1 && panjang > 6) {
        var x = parseInt(panjang - (div*3));
        div++;
        for (var i=0; i<div; i++) {
          if (i == 0) {
            char[i] = text.slice(i,x);
          }
          else{
            char[i] = text.slice(((i-1)*3)+x,(i*3)+x);
          }
          if (i == (div-1)) {         
            hasil[i]= char[i];
          }
          else{
            hasil[i]= char[i]+".";
          }
        }
        for (var i=0; i<div; i++) {
          result+=hasil[i];
        }
      }
      else{
        result = text.slice(0,panjang-3)+"."+text.slice(panjang-3,panjang);
      }
      return result;
    }
    else{
      return text;
    }
  }
  else{
    return 0;
  }
}
</script>
@endsection
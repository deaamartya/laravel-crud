@extends('master')
@section('Judul','Data Penjualan')
@section('headlink')
<link href="{{ asset('/admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link href="https://cdn.datatables.net/searchpanes/1.0.1/css/searchpanes.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
    th {
        text-align: inherit;
        background-color: transparent;
        color: #5a5c69;
    }
    .totals{
      font-weight: bold;
      color: #5a5c69;
    }
    .total{
      font-weight: bold;
      color: black;
      font-size: 1.1rem;
    }
    .shadowrow {
      box-shadow: 0 .15rem .50rem 0 rgba(58,59,69,.15) !important;
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
      <div class="row align-items-center my-3 pl-3">
        <div class="col-1 mr-3">
          <div class="pretty p-icon p-curve">
              <input type="checkbox" id="parentA" />
              <div class="state">
                  <i class="icon mdi mdi-check material-icons">check</i>
                  <label>Select All</label>
              </div>
          </div>
        </div>
        <div class="col-1">
          #
        </div>
        <div class="col-2">
          Nama Customer
        </div>
        <div class="col-2 pr-0">
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
      <div class="accordion mt-4" id="accordionTable">
      @foreach($sales as $c)
          <div class="card z-depth-0 shadowrow mb-4">
            <div class="card-body bg-light" id="heading{{ $c -> nota_id }}">
              <div class="row align-items-center my-1 pl-3">
                <div class="col-1">
                  <div class="pretty p-icon p-curve">
                      <input type="checkbox" class="childcheck" id="check{{$c->nota_id}}"/>
                      <div class="state">
                          <i class="icon mdi mdi-check material-icons">check</i>
                          <label></label>
                      </div>
                  </div>
                </div>
                <div class="col-1">
                  <span class="align-middle">{{ $c -> nota_id }}</span>
                </div>
                <div class="col-2">
                  <span class="align-middle">{{ $c -> c_fullname }}</span>
                </div>
                <div class="col-2">
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
            
            <div id="collapse{{ $c -> nota_id }}" class="collapse p-3 mt-4" aria-labelledby="heading{{ $c -> nota_id }}" data-parent="#accordionTable">
              <div class="row">
                <table class="table" width="80%">
                <tr>
                  <th>ID</th>
                  <th>Nama Produk</th>
                  <th>Harga</th>
                  <th>Qty</th>
                  <th>Disc.</th>
                  <th>Total</th>
                </tr>
                
                  @foreach($c->detail as $d)
                  <tr>
                    <td width="5%">{{ $d -> product_id }}</td>
                    <td width="55%">{{ $d -> product_name }}</td>
                    <td width="15%">
                      <span class="price harga{{ $c -> nota_id }}">{{ $d -> selling_price }}</span>
                    </td>
                    <td width="5%">
                      x<span class="quantity{{ $c -> nota_id }}">{{ $d -> quantity }}</span>
                    </td>
                    <td width="5%">
                      <input type="hidden" value="{{$d->discount}}" class="discount{{ $c -> nota_id }}">
                      @if($d->discount != "0")
                      <span style="color: #cc0000">
                         <?php echo (($d->discount/($d->selling_price*$d->quantity))*100)."%"; ?>
                      </span>
                      @else
                        -
                      @endif
                    </td>
                    <td width="25%">
                      <span class="price total_price">{{ $d -> total_price }}</span>
                    </td>
                  </tr>
                  @endforeach
                </table>  
                </div>
                <div class="row justify-content-end px-12 my-2">
                  <div class="col-3 totals">Subtotal</div>
                  <div class="col-2 price totals" id="subtotal{{ $c -> nota_id }}">{{ $c -> total_payment }}</div>
                </div>
                <div class="row justify-content-end px-12 my-2">
                  <div class="col-3 totals">Total Diskon</div>
                  <div class="col-2 price totals" id="total_disc{{ $c -> nota_id }}">{{ $c -> total_payment }}</div>
                  </div>
                <div class="row justify-content-end px-12 my-2">
                  <div class="col-3 total">Total Payment</div>
                  <div class="col-2 price total" id="total_payment{{ $c -> nota_id }}">{{ $c -> total_payment }}</div>
                </div>
              </div>
              </div>
            
          </div>
        @endforeach
    </div>
    <div class="row pl-3">
      <div class="col-1 mr-4">
        <div class="pretty p-icon p-curve">
            <input type="checkbox" id="parentB" />
            <div class="state">
                <i class="icon mdi mdi-check material-icons">check</i>
                <label>Select All</label>
            </div>
        </div>
      </div>
      <div class="col-2">
        <button class="btn btn-danger btn-icon-split btn-sm delete-confirm">
          <span class="icon text-white-30">
            <i class="material-icons">delete</i>
          </span>
          <span class="text">Delete</span>
        </button>
      </div>
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
                    @if(session('type') == 1)
                    @include('restorebtn', 
                    array(
                    'id' => $c -> nota_id,
                    'dellink' => 'sale',
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
  @if(session('restored'))
    <script>
      Swal.fire(
        'Restore Success!',
        "Data penjualan dengan ID {{ @session('restored') }} berhasil dikembalikan",
        'success'
      )
    </script>
  @endif
@endsection
@section('bottom')
<script src="{{ asset('/admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script>
  var sales = <?php echo json_encode($sales); ?>;
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

    $("#parentB").click(function(){
      if($("#parentB").is(":checked")){
        $("#parentA").prop("checked",true);
          $('.childcheck').each(function(){
            $(this).prop("checked",true);
          });
      }
      else{
        $("#parentA").prop("checked",false);
          $('.childcheck').each(function(){
            $(this).prop("checked",false);
          });
      }
    });

    $("#parentA").click(function(){
      if($("#parentA").is(":checked")){
        $("#parentB").prop("checked",true);
          $('.childcheck').each(function(){
            $(this).prop("checked",true);
          });
      }
      else{
        $("#parentB").prop("checked",false);
          $('.childcheck').each(function(){
            $(this).prop("checked",false);
          });
      }
    });

    for(var i=0;i<sales.length;i++){
      getTotal(sales[i]["nota_id"]);
    }

    function getTotal(id){
      var qty = document.getElementsByClassName("quantity"+id);
      var prc = document.getElementsByClassName("harga"+id);
      var subtotal=0;
      // console.log("qty = "+qty[0].innerHTML);
      for (var i=0; i<prc.length; i++) {
        subtotal+=(parseInt(qty[i].innerHTML*prc[i].innerHTML));
        // console.log(subtotal);
      }
      // console.log(subtotal);
      $("#subtotal"+id).html(subtotal);
      var disc = document.getElementsByClassName("discount"+id);
      var total_disc=0;
      for (var i = disc.length - 1; i >= 0; i--) {
        total_disc += (parseInt(disc[i].value));
      }
      // console.log(total_disc);
      $("#total_disc"+id).html(total_disc);
    }

    $('.price').each(function(){
      $(this).html("Rp "+money($(this).html()));
    });
  });
  
$('.delete-confirm').on('click', function (e) {
    event.preventDefault();
    var baseurl = '{{URL::to('')}}';
    var url = baseurl+'sale'
    Swal.fire({
    title: 'Apakah kamu yakin?',
    text: "Penjualan yang dihapus hanya dapat dikembalikan oleh Super Admin!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Saya Yakin!',
    cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
          var ids= new Array();
          $('.childcheck').each(function(){
            if($(this).is(":checked")){
              ids[ids.length+1] = $(this).attr("id").substring(5,10);
            }
          });
          var flag = -1;
          for(var i=0;i<ids.length;i++){
            $.ajax({
                url: baseurl+'/sale/delete/'+ids[i],
                method: 'GET',
                success: function(data) {
                  window.location.replace(baseurl+'/sale');
                }
            });
          }
          Swal.fire(
            'Delete Success!',
            "Penjualan berhasil dihapus",
            'success'
          )
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
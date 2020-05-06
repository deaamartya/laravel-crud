@extends('master')
@section('headlink')
	<link href="/admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <style type="text/css">
    .btn-group-sm > .btn-icon-split.btn .icon, .btn-icon-split.btn-sm .icon {
      padding: 2px 5px;
    };
  </style>
@endsection
@section('konten')
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h3 class="m-0 font-weight-bold text-primary">Invoice #{{ $sale -> nota_id }}</h3>
    </div>
    <div class="card-body px-5">
      <div class="row mb-2">
        <div class="col"><h5>Tanggal Pembelian : {{ $sale -> nota_date }}</h5></div>
      </div>
      <div class="row mb-4 align-middle">
        <div class="col-4">
          <div class="card bg-dark">
            <div class="card-body text-white" style="padding-left: 40px;">
              <div class="row"><h5 style="font-weight: bold">Pembeli : </h5></div>
              <div class="row"><h6>{{ $sale -> c_name }}</h6></div>
              <div class="row"><h6>{{ $sale -> street }}</h6></div>
              <div class="row"><h6>{{ $sale -> c_address }}</h6></div>
              <div class="row"><h6>+62{{ $sale -> phone }}</h6></div>
              <div class="row"><h6>{{ $sale -> email }}</h6></div>
            </div>
          </div>
        </div>
        <div class="col-4"></div>
        <div class="col-4">
          <div class="card bg-dark">
            <div class="card-body text-white" style="padding-left: 40px;">
              <div class="row"><div class="col"><h5 style="font-weight: bold;text-align: right;">Dibuat oleh : </h5></div></div>
              <div class="row"><div class="col"><h6 style="text-align: right;">{{ $sale -> u_name }}</h6></div></div>
              <div class="row"><div class="col"><h6 style="text-align: right;">+62{{ $sale -> u_phone }}</h6></div></div>
              <div class="row"><div class="col"><h6 style="text-align: right;">{{ $sale -> u_email }}</h6></div></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <table class="table" width="100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama Produk</th>
              <th>Jumlah</th>
              <th>Harga</th>
              <th>Diskon</th>
              <th>Total Harga</th>
            </tr>
          </thead>
          <tbody>
            @foreach($saledetail as $c)
            <?php $id = $c -> product_id ?>
              <tr>
                <td>{{ $c -> product_id }}</td>
                <td>{{ $c -> product_name }}</td>
                <td id="quantity{{$id}}">{{ $c -> quantity }}</td>
                <td id="price{{$id}}">{{ $c -> selling_price }}</td>
                <td id="disc{{$id}}">{{ $c -> discount }}</td>
                <td id="total{{$id}}">{{ $c -> total_price }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="row justify-content-end px-3">
        <div class="col-7">
        <div class="card text-black" style="border:3px solid #FF4F5B">
          <div class="card-body">
              <div class="row align-baseline">
                <div class="col-8">
                  <h6 style="text-align: left; ">Sub Total : Rp </h6>
                </div>
                <div class="col-4">
                  <h6 style="text-align: right;" id="subtotal-val">0</h6>
                </div>
              </div>

              <div class="row align-baseline">
                <div class="col-8">
                  <h6 style="text-align: left;">Discount : Rp</h6>
                </div>
                <div class="col-4">
                  <h6 style="text-align: right;" id="total_discount-val">0</h6>
                </div>
              </div>

              <div class="row align-baseline">
                <div class="col-8">
                <h6 style="text-align: left; font-size: 14pt;"><b>Total Payment : Rp </b></h6>
                </div>
                <div class="col-4">
                  <b><h6 id="total_payment-val" style="text-align: right; font-size: 14pt;">{{$sale -> total_payment}}</h6></b>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('bottom')
<script src="/admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/admin/js/demo/datatables-demo.js"></script>
<script src="/js/hitung.js"></script>
<script src="/js/add-del-row.js"></script>
<script>
  var saledetails = <?php echo json_encode($saledetail); ?>;
  $(document).ready( function () {
    var total_disc = 0;
    var subtotal = 0;
    for(var i=0; i<saledetails.length;i++){
        var id = saledetails[i]["product_id"];
        var quantity = saledetails[i]["quantity"];
        var disc = saledetails[i]["discount"];
        var total_price = saledetails[i]["total_price"];
        var selling_price = saledetails[i]["selling_price"];
        document.getElementById("total"+id).innerHTML = "Rp "+money(total_price- disc);
        document.getElementById("price"+id).innerHTML = "Rp "+money(selling_price);
        if (disc != 0) {
            document.getElementById("disc"+id).innerHTML = "Rp "+money(disc);
        }
        else{
          document.getElementById("disc"+id).innerHTML = "-";
        }
        subtotal+=(selling_price*quantity);
        total_disc+=disc;
    }
    document.getElementById("subtotal-val").innerHTML = money(subtotal);
    document.getElementById("total_discount-val").innerHTML = money(total_disc);
    var totalp = document.getElementById("total_payment-val").innerHTML;
    totalp = money(totalp);
    document.getElementById("total_payment-val").innerHTML = totalp;
  });
</script>
@yield('bottomlink')
@endsection
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>@yield('Judul')</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="{{ asset('/admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
  <link href="{{ asset('/admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="{{asset('/admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <style type="text/css">
    body {
      font-family: Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: black;
      text-align: left;
    }
    .table {
      color: black;
    }
    th {
    text-align: inherit;
    background-color: #4e73df;
    color: white;
    }
    .table thead th {
    vertical-align: bottom;
    border-bottom: 0px;
    }
    .sidebar .nav-item .nav-link i {
      font-size: 1.2rem;
      margin-right: .25rem;
    }
    .sidebar .nav-item .nav-link span {
      font-size: 1rem;
      margin-right: .25rem;
    }
    .btn-group-sm > .btn-icon-split.btn .icon, .btn-icon-split.btn-sm .icon {
      padding: 2px 5px;
    };
    .totals{
      font-family: Montserrat;
      font-weight: bold;
      color: black;

    }
    .total{
      font-weight: bold;
      color: black;
      font-size: 1.1rem;
    }
    .shadowrow {
      box-shadow: 0 .15rem .50rem 0 rgba(58,59,69,.15) !important;
      border-radius: 13px;
    }
    .headsale{
      background-color: #344055 !important;
      color: black;
    }
    .table {
      color: black;
    }
    th{
      color: white;
    }
    .table th{
      padding: .75rem;
      vertical-align: top;
      border: 0px;
    }
    .table td {
      padding: .75rem;
      vertical-align: top;
      border-bottom: 1px solid #e3e6f0;
    }
    .total_payment{
      text-align: right;
    }
    .price{
      text-align: right;
    }
    .judul{
      font-family: Montserrat;
      color: darkgrey;
      font-size: 0.9rem;
      font-weight: 600;
    }
    .data{
      font-family: Roboto;
      font-size: 1rem;
    }
    .nama{
      font-size: 1.15rem;
      font-weight: 600;
    }
    #totalatas{
      font-family: Montserrat;
      font-size: 1.5rem;
      font-weight: 600;
    }
    .invoice{
      font-family: Montserrat;
    }
  </style>
</head><body>
<div class="container-fluid">
      <div class="row px-3 py-3">
        <div class="col-12">
          <div class="row">
            <div class="col-12">
              <div class="row mb-3 justify-content-between">
                <div class="col-6"><h3 class="m-0 font-weight-bold text-primary invoice">Invoice #{{ $sale -> nota_id }}</h3></div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="row mb-1 col-12">
                    <h6 class="judul">Tanggal Pembelian</h6>
                  </div>
                  <div class="row mb-1 col-12">
                    <h5 class="data">{{ $sale -> nota_date }}</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr class="mb-3"/>
          <div class="row mb-2">
            <div class="col-6">
              <div class="row mb-2">
                <div class="col-12">
                  <div class="row col-12">
                    <h6 class="judul">Pembeli</h6>
                  </div>
                  <div class="row col-12">
                    <h5 class="data nama">{{ $sale -> c_name }}</h5>
                  </div>
                  <div class="row col-12">
                    <h5 class="data">{{ $sale -> street }}</h5>
                  </div>
                  <div class="row col-12">
                    <h5 class="data">{{ $sale -> c_address }}</h5>
                  </div>
                  <div class="row col-12">
                    <h5 class="data">+62{{ $sale -> phone }}</h5>
                  </div>
                  <div class="row col-12">
                    <h5 class="data">{{ $sale -> email }}</h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="row mb-2">
                <div class="col-12">
                  <div class="row col-12">
                    <h6 class="judul">Total Pembelian</h6>
                  </div>
                  <div class="row col-12">
                    <h5 class="data" id="totalatas">{{$sale -> total_payment}}</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row px-3 mb-3">
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
      <div class="row justify-content-end my-2">
        <div class="col-3 totals">Subtotal</div>
        <div class="col-2 price totals" id="subtotal-val">{{ $sale -> total_payment }}</div>
      </div>

      <div class="row justify-content-end my-2">
        <div class="col-3 totals">Total Diskon</div>
        <div class="col-2 price totals totaldiskon" id="total_discount-val">{{ $sale -> total_payment }}</div>
      </div>

      <div class="row justify-content-end my-2">
        <div class="col-3 totals">Pajak(10%)</div>
        <div class="col-2 price totals" id="total_tax">
          0
        </div>
      </div>

      <div class="row justify-content-end mt-2 mb-4">
        <div class="col-5">
          <div class="row">
            <div class="col-5 total">Total Payment</div>
            <div class="col-7 price total total_payment" id="total_payment-val">{{ $sale -> total_payment }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('/admin/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('/admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('/admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{ asset('/admin/js/sb-admin-2.min.js')}}"></script>
<script src="{{asset('/admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/admin/js/demo/datatables-demo.js')}}"></script>
<script src="{{asset('/js/hitung.js')}}"></script>
<script src="{{asset('/js/add-del-row.js')}}"></script>
<script>
  var saledetails = <?php echo json_encode($saledetail); ?>;
  var sale = <?php echo json_encode($sale); ?>;
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
    document.getElementById("subtotal-val").innerHTML = "Rp "+money(subtotal);
    document.getElementById("total_discount-val").innerHTML = "Rp "+money(total_disc);
    document.getElementById("total_tax").innerHTML = "Rp "+money(Number(10/100*subtotal));
    var totalp = document.getElementById("total_payment-val").innerHTML;
    totalp = money(totalp);
    document.getElementById("total_payment-val").innerHTML = "Rp "+totalp;
    document.getElementById("totalatas").innerHTML = "Rp "+money(document.getElementById("totalatas").innerHTML);
  });
</script></body>
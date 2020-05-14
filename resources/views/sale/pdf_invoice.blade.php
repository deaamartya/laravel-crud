<head>
  <meta charset="utf-8">
  <title>Invoice</title>
  <link href="{{ asset('/admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> 
  <link href='https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>
  <style type="text/css">
    body {
      font-family: Nunito,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
      color: black;
      text-align: left;
    }
    .totals{
      font-family: Nunito;
      color: black;
      font-size: 1rem;
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
    .tableproduk {
      color: black;
      font-size: 1rem;
      display: table;
      border-collapse: separate;
      border-spacing:10px;
    }
    .tabelproduk td {
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
      font-family: 'Roboto', sans-serif;
      font-size: 0.9rem;
    }
    .nama{
      font-size: 1rem;
      font-weight: 700;
    }
    #totalatas{
      font-family: Montserrat;
      font-size: 1.2rem;
      font-weight: 600;
    }
    .invoice{
      font-family: Montserrat;
      font-weight: 700;
    }
    .head td {
      font-family: Nunito;
      background-color: #4e73df;
      color: white;
      font-size: 1rem;
      font-weight: 800;
    }
  </style>
</head><body>
  <table>
    <tr><td><h3 class="text-primary invoice">Invoice #{{ $sale -> nota_id }}</h3></td></tr>
    <tr><td><h6 class="judul">Tanggal Pembelian</h6></td></tr>
    <tr><td><h5 class="data">{{ $sale -> nota_date }}</h5></td></tr>
    <tr><td><br></td></tr>
    <tr>
      <td><h6 class="judul">Pembeli</h6></td>
      <td><h6 class="judul">Total Pembelian</h6></td>
    </tr>
    <tr>
      <td><h5 class="data nama">{{ $sale -> c_name }}</h5></td>
      <td><h5 class="data" id="totalatas">Rp {{$sale -> total_payment}}</h5></td>
    </tr>
    <tr><td><h5 class="data">{{ $sale -> street }}</h5></td></tr>
    <tr><td><h5 class="data">{{ $sale -> c_address }}</h5></td></tr>
    <tr><td><h5 class="data">+62{{ $sale -> phone }}</h5></td></tr>
    <tr><td><h5 class="data">{{ $sale -> email }}</h5></td></tr>
  </table>
  <br>
    <table class="tabelproduk" width="100%">
      <thead>
        <tr class="head">
          <td >ID</td>
          <td valign="center">Nama Produk</td>
          <td valign="center">Jumlah</td>
          <td valign="center">Harga</td>
          <td valign="center">Diskon</td>
          <td valign="center">Total</td>
        </tr>
      </thead>
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
    </table>
  </div>
  <table cellspacing="1" style="float: right;">
    <tr>
      <td><div class="totals">Subtotal</div></td>
      <td><span style="margin-right: 30px;"></span></td>
      <td><div class="price totals" id="subtotal-val">
        Rp <?php
        $subtotal = 0;
          foreach ($saledetail as $key) {
            $subtotal = $subtotal + ($key->selling_price*$key->quantity);
          }
        echo $subtotal;
        ?></div>
      </td>
    </tr>
    <tr>
      <td><div class="totals">Total Diskon</div></td>
      <td><span style="margin-right: 30px;"></span></td>
      <td><div class="price totals totaldiskon" id="total_discount-val">
        Rp <?php
        $sum = 0;
          foreach ($saledetail as $key) {
            $sum = $sum +  $key->discount;
          }
        echo $sum;
        ?>
      </div></td>
    </tr>
    <tr>
      <td><div class="totals">Pajak(10%)</div></td>
      <td><span style="margin-right: 30px;"></span></td>
      <td><div class="price totals" id="total_tax">
        Rp <?php echo intval($subtotal*10/100) ?>
      </div></td>
    </tr>
    <tr>
      <td><div class="total">Total Payment</div></td>
      <td><span style="margin-right: 30px;"></span></td>
      <td><div class="price total total_payment" id="total_payment-val">Rp {{ $sale -> total_payment }}</div></td>
    </tr>
  </table>
</body>
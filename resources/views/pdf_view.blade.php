<html><head><link href="{{ asset('/admin/css/sb-admin-2.min.css')}}" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"><link href='https://fonts.googleapis.com/css?family=Montserrat:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'><style type="text/css">
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
    .table thead th{
    vertical-align: middle;
    }
    .table tbody td{
    vertical-align: middle;
    }
    h2{
    	font-family: Montserrat;
    	font-weight: 800;
    }
    h6{
    	font-family: Montserrat;
    	font-weight: 600;
    }</style></head><body id="page-top">
        <div class="row"><h2>Laporan Penjualan</h2></div>
        <div class="row"><h6>Periode : 2020-01-01 - @php echo date("Y-m-d") @endphp</h6></div>
        <div class="row"><h6>Dibuat pada : @php echo date("l, j F Y H:i:s ") @endphp</h6></div>
        <div class="row">
            <table class="table bordered" width="100%">
                <thead>
                    <tr>
                        <th>Nota ID</th>
                        <th>Nama Karyawan</th>
                        <th>Nama Customer</th>
                        <th>Tanggal</th>
                        <th>Total Pembelian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $c)
                    <tr>
                        <td>{{$c->nota_id}}</td>
                        <td>{{$c->u_fullname}}</td>
                        <td>{{$c->c_fullname}}</td>
                        <td>{{$c->nota_date}}</td>
                        <td>Rp {{$c->total_payment}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <table class="table bordered" width="100%">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product as $c)
                    <tr>
                        <td>{{$c->product_id}}</td>
                        <td>{{$c->product_name}}</td>
                        <td>{{$c->product_stock}}</td>
                        <td>Rp {{$c->product_price}}</td>
                        <td>{{$c->total_penjualan}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div></body></html>
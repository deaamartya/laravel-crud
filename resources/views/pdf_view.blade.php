<!DOCTYPE html>
<html><head>
<link href="{{ asset('/admin/css/sb-admin-2.min.css')}}" rel="stylesheet">
<link href="{{ asset('/admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
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
    h2{
    	font-family: Montserrat;
    	font-weight: 800;
    }
</style>
</head><body id="page-top">
    <table width="100%">
        <thead>
            <tr>
  		<th>Nota ID</th>
  		<th>User ID</th>
  		<th>Customer ID</th>
  		<th>Tanggal</th>
  		<th>Total Pembelian</th></tr>
  		</thead>
  		<tbody>
  		@foreach($sales as $c)
        <tr>
          	<td>{{$c->nota_id}}</td>
          	<td>{{$c->user_id}}</td>
          	<td>{{$c->customer_id}}</td>
          	<td>{{$c->nota_date}}</td>
          	<td class="price">{{$c->total_payment}}</td>
        </tr>
        @endforeach
  		</tbody>
  		
    </table></body><script src="{{asset('/js/add-del-row.js')}}"></script></html>
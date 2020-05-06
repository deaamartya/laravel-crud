@extends('selectfield')
@section('tambahlink')
  <!-- <script src="jquery.maskMoney.js" type="text/javascript"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
@endsection
@section('tmbhstyle')
<style type="text/css">
  .quantity{
    width: 20%;
  }
  .discount{
    width: 100%;
  }
</style>
@endsection
@section('kontent')
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h3 class="m-0 font-weight-bold text-primary">Tambahkan Data Penjualan</h3>
        </div>
      <div class="card-body" style="margin: 20px;">
        <form method="post" action="{{ route('sale.update', $sale -> nota_id) }}" id="catForm">
          @csrf
          @METHOD('PUT')
          <input type="hidden" name="nota_id" value="{{ $sale -> nota_id}}">
          <div class="row" style="margin-bottom: 0px">
            <div class="col-6">
            <h4>ID NOTA : #{{ $sale -> nota_id}}</h4>
              <div style="margin-top: 20px;">
                <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon" style="width: 100%;">
                <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">calendar_today</i>
                <input type="date" class="mdc-text-field__input" name="nota_date" required id="nota_date" min="2018-01-01" value="{{ $sale -> nota_date}}">
                <div class="mdc-notched-outline">
                 <div class="mdc-notched-outline__leading"></div>
                  <div class="mdc-notched-outline__notch">
                    <span class="mdc-floating-label" id="my-label-id">Tanggal Pembelian</span>
                  </div>
                  <div class="mdc-notched-outline__trailing"></div>
                </div>
              </label>
              </div>
            </div>
          </div>
          <div class="row" style="margin-bottom: 20px">
            <div class="col-6">
              <h6>Nama Customer*</h6>
                <select class="selectpicker" data-live-search="true" name="customer_id" required id="customer_id">
                  <option disabled="true">Pilih customer</option>
                  @foreach($customers as $c)
                  @if($c -> customer_id == $sale -> customer_id)
                  <option value="{{$c -> customer_id}}" selected>{{$c -> first_name}} {{$c -> last_name}}</option>
                  @else
                  <option value="{{$c -> customer_id}}">{{$c -> first_name}} {{$c -> last_name}}</option>
                  @endif
                  @endforeach
                </select>
              </div>
            <div class="col-6">
              <h6>Nama User*</h6>
              <select class="selectpicker" data-live-search="true" name="user_id" required id="user_id">
                <option disabled="true" selected="">Pilih user</option>
                @foreach($users as $c)
                @if($c -> user_id == $sale -> user_id)
                <option value="{{$c -> user_id}}" selected>{{$c -> first_name}} {{$c -> last_name}}</option>
                @else
                <option value="{{$c -> user_id}}">{{$c -> first_name}} {{$c -> last_name}}</option>
                @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="row" style="margin-bottom: 20px">
            <div class="col-12">
            <h6>Nama Product</h6>
            <select class="selectpicker" data-live-search="true" id="idproduk" style="width: 100%;">
                <option disabled="true" selected>Pilih produk</option>
                @foreach($product as $c)
                <option value="{{$c -> product_id}}" id="product_id" hidden>{{$c -> product_id}}</option>
                <option>{{$c -> product_name}}</option>
                <option hidden>{{$c -> product_price}}</option>
                <option hidden>{{$c -> product_stock}}</option>
                @endforeach
            </select>
            <input type="button" class="add-row" value="Tambahkan produk">
          </div>
          </div>
          <div class="table-responsive">
          <table class="table table-bordered" id="example" width="100%" cellspacing="0">
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
              	@foreach($detailorder as $d)
              	<?php $id = $d -> product_id; ?>
                <tr>
                	<td>
                		<input type="hidden" name="product_id[{{$id}}]" value="{{$id}}" readonly id="product_id{{$id}}">{{$d -> product_id}}
                	</td>
                	<td>
                		<h6 class="product_name">{{ $d -> product_name }}
                	</td>
                	<td style="width: 5%;">
                		<input type="number" style="width: 100%;" class="quantity" oninput="myFunction(<?php echo $id; ?>)" name="quantity[{{$id}}]" min="1" id="jumlah{{$id}}" required max="{{$d -> product_stock}}" value="{{$d -> quantity}}">
                	</td>
                	<td>
                		<input type="hidden" class="selling_price" name="selling_price[{{$id}}]" min="1" id="price{{$id}}"required value="{{$d -> selling_price}}" readonly>{{$d -> selling_price}}
                	</td>
                	<td style="width: 20%;">
                		<input type="number" min="0" oninput="myFunction(<?php echo $id; ?>)" class="discount" name="discount[{{$id}}]" id="discount{{$id}}" placeholder="0" style="-moz-appearance: textfield; text-align:right;" value="{{$d -> discount}}">
                	</td>
                	<td>
                		<input type="hidden" class="total" name="total[{{$id}}]" min="1" id="total{{$id}}" required readonly value="{{$d -> total_price}}">
                		<h6 id="totaltext{{$id}}">{{$d -> total_price}}
                	</td>
                </tr>
                @endforeach
              </tbody>
          </table>
        </div>
          <h6 style="text-align: right;">Sub Total : Rp. <input type="text" id="subtotal" style="text-align: right; border: 0px;"></h6>
          <h6 style="text-align: right;">Discount : Rp. (<input type="text" id="total_discount" style="text-align: right; border: 0px;">)</h6>
          <h6 style="text-align: right;">Total Payment : Rp. <input type="text" name="total_payment" id="total_payment" style="text-align: right; border: 0px;"></h6>
          <input type="submit" name="" value="Submit">
          </form>
        </div>
      </div>
    </div>
  </div>
<button type="button" class="delete-row">Delete Row</button>
@endsection
@section('tambahan')
<script type="text/javascript">
	
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1;
    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 
    today = yyyy+'-'+mm+'-'+dd;
    document.getElementById("nota_date").setAttribute("max", today);

    function myFunction(id) {
      var jumlah = document.getElementById("jumlah"+id).value;
      var price = document.getElementById("price"+id).value;
      var subtotal = (jumlah*price);
      document.getElementById("discount"+id).setAttribute("max", subtotal);
      
      var total = (jumlah * price);
      document.getElementById("total"+id).value = total;
      document.getElementById("totaltext"+id).innerHTML = total;

      var totals = document.getElementsByClassName("total");

      var i;
      var total_p = 0;
      for (i = 0; i < totals.length; ++i) {
        total_p = total_p + Number(totals[i].value);
      }
      document.getElementById('subtotal').value = total_p;

      var discounts = document.getElementsByClassName("discount");

      var i;
      var total_disc = 0;
      for (i = 0; i < discounts.length; ++i) {
        total_disc = total_disc + Number(discounts[i].value);
      }
      document.getElementById('total_discount').value = total_disc;

      document.getElementById('total_payment').value = total_p - total_disc;
    };

    $(document).ready(function(){
    	  var i;
		  var total_p = 0;
		  for (i = 0; i < totals.length; ++i) {
		    total_p         = total_p + Number(totals[i].value);
		  }
		  document.getElementById('subtotal').value = total_p;

		  var discounts = document.getElementsByClassName("discount");

		  var i;
		  var total_disc = 0;
		  for (i = 0; i < discounts.length; ++i) {
		    total_disc = total_disc + Number(discounts[i].value);
		  }
		  document.getElementById('total_discount').value = total_disc;
		  document.getElementById('total_payment').value = total_p - total_disc;

        $(".add-row").click(function(){
          var y = document.getElementById("idproduk").options;
          var x = document.getElementById("idproduk").selectedIndex;
          var id = y[x-1].text;
          var name = y[x].text;
          var price = y[x+1].text;
          var stock = y[x+2].text;
          var markup = "<tr><td><input type='hidden' name='product_id["+id+"]' value='"+id+"' readonly id='product_id"+id+"'>"+id+"</td><td><h6 class='product_name'>"+name+"</td><td style='width: 5%;'><input type='number' style='width: 100%;' class='quantity' oninput='myFunction("+id+")' name='quantity["+id+"]' min='1' id='jumlah"+id+"'required max='"+stock+"' value='1'></td><td><input type='hidden' class='selling_price' name='selling_price["+id+"]' min='1' id='price"+id+"'required value='"+price+"' readonly>"+price+"</td><td style='width: 20%;''><input type='number' min='0' oninput='myFunction("+id+")' class='discount' name='discount["+id+"]' id='discount"+id+"' placeholder='0' style='-moz-appearance: textfield; text-align:right;'></td><td><input type='hidden' class='total' name='total["+id+"]' min='1' id='total"+id+"' required readonly value='0'><h6 id='totaltext"+id+"'></td></tr>";
          $("table tbody").append(markup);
          myFunction(id);
          $("#idproduk option:selected").remove();
        });

        $(".delete-row").click(function(){
            $("table tbody").find('input[name="record"]').each(function(){
              if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                }
            });
            var totals = document.getElementsByClassName("total");

            var i;
            var total_p = 0;
            for (i = 0; i < totals.length; ++i) {
              total_p = total_p + Number(totals[i].value);
            }
            document.getElementById('subtotal').value = total_p;

            var discounts = document.getElementsByClassName("discount");

            var i;
            var total_disc = 0;
            for (i = 0; i < discounts.length; ++i) {
              total_disc = total_disc + Number(discounts[i].value);
            }
            document.getElementById('total_discount').value = total_disc;

            document.getElementById('total_payment').value = total_p - total_disc;
        });

    });
      $('#example').dataTable( {
    "columns": [
      { "width": "5%" },
      { "width": "5%" },
      { "width": "30%" },
      { "width": "5%" },
      { "width": "25%" },
      { "width": "10%" },
      { "width": "20%" }
    ]
  });   
</script>
<script src="/admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/admin/js/demo/datatables-demo.js"></script>
@endsection
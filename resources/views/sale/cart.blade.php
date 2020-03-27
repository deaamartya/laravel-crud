@extends('selectfield')
@section('tambahlink')
  <script src="jquery.maskMoney.js" type="text/javascript"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
        <form method="post" action="{{ route('sale.store') }}" id="catForm">
          @csrf
          <input type="hidden" name="nota_id" value="{{$nota_id}}">
          <div class="row" style="margin-bottom: 20px">
            <div class="col-3">
            <h4>ID NOTA : #{{$nota_id}}</h4>
              <div style="margin-top: 20px;">
                <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon" style="width: 100%;">
                <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">calendar_today</i>
                <input type="date" class="mdc-text-field__input" name="nota_date" required id="nota_date" min="2018-01-01">
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
                  <option disabled="true" selected="">Pilih customer</option>
                  @foreach($customers as $c)
                  <option value="{{$c -> customer_id}}">{{$c -> first_name}} {{$c -> last_name}}</option>
                  @endforeach
                </select>
              </div>
            <div class="col-6">
              <h6>Nama User*</h6>
              <select class="selectpicker" data-live-search="true" name="user_id" required id="user_id">
                <option disabled="true" selected="">Pilih user</option>
                @foreach($users as $c)
                <option value="{{$c -> user_id}}">{{$c -> first_name}} {{$c -> last_name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <h6>Nama Produk</h6>
          <div class="row" style="margin-bottom: 20px">
            
            <div class="col-12">
            <select class="selectpicker" data-live-search="true" required id="idproduk" style="width: 100%;">
                <option disabled="true" selected>Pilih produk</option>
                @foreach($product as $c)
                <option value="{{$c -> product_id}}">{{$c -> product_name}}</option>
                @endforeach
            </select>
            <button type="button" class="add-row btn btn-primary" style="padding: 10px 15px 10px 15px; margin-left: 10px;">Tambahkan produk</button>
          </div>
          </div>
          <div class="table-responsive">
          <table class="table" id="example" width="100%" cellspacing="0" align="right">
              <tbody>
              </tbody>
          </table>
        </div>
          <h6 style="text-align: right;">Sub Total : Rp. <input type="text" id="subtotal" style="text-align: right; border: 0px;"></h6>
          <h6 style="text-align: right;">Discount : Rp.(<input type="text" id="total_discount" style="text-align: right; border: 0px;">)</h6>
          <h6 style="text-align: right;">Total Payment : Rp. <input type="text" name="total_payment" id="total_payment" style="text-align: right; border: 0px;"></h6>

          <input type="submit" class="btn btn-info btn-lg align-self-end" value="Submit">
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('tambahan')
<script type="text/javascript">
    var products = <?php echo json_encode($product); ?>;
    
    function getTotal(){
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
    }

    function percentDisc(id){
      var percent = document.getElementById("percent"+id).value;
      var total = document.getElementById("total"+id).value;
      var hasil = (Number(percent)/100) * total;
      document.getElementById("discount"+id).value = hasil;

      getTotal();
    }

    function getIndex(id){
      for(var i=0; i<products.length;i++){
        if(products[i]["product_id"] == id){
            return i;
        }
      }
    }

    function delRow(id){
      $("#idproduk option").each(function(){
        if($(this).val() == id){
          $(this).show();
        }
      });
    }

    function myFunction(id) {

      var jumlah = document.getElementById("jumlah"+id).value;
      var price = document.getElementById("price"+id).value;
      var subtotal = (jumlah*price);
      document.getElementById("discount"+id).setAttribute("max", subtotal);
      
      var total = (jumlah * price);
      document.getElementById("total"+id).value = total;
      document.getElementById("totaltext"+id).innerHTML = total;
      percentDisc(id);
    };

    $(document).ready(function(){
        $(".add-row").click(function(){
          var y = $("#idproduk").children("option:selected").val();
          var i = getIndex(y);
          console.log(i);
          $("#idproduk").children("option:selected").hide();
          var id = products[i]["product_id"];
          var name = products[i]["product_name"];
          var price = products[i]["product_price"];
          var stock = products[i]["product_stock"];
          var markup = "\
            <tr>\
                <td style='text-align: left; padding-left: 50px;' class='align-middle'>\
                <div class='row'>\
                  <h6 class='product_name'>"+name+"</div>\
                <div class='row'>\
                <input type='hidden' name='product_id["+id+"]' value='"+id+"' readonly id='product_id"+id+"'>#"+id+"</div>\
              </td>\
              <td style='width: 10%;' class='align-middle'>\
              <input type='number' style='width: 100%; border:0px;' class='quantity' oninput='myFunction("+id+")' name='quantity["+id+"]' min='1' id='jumlah"+id+"'required max='"+stock+"' value='1'>\
              </td>\
              <td style='text-align: right; width:30%;' class='align-middle'>\
                <div class='row'>\
                  <input type='hidden' class='selling_price' name='selling_price["+id+"]' min='1' id='price"+id+"'required value='"+price+"' readonly>@ Rp. "+price+"\
                  </div>\
                  <div class='row align-items-left'>\
                  <div class='col-3'>Disc. </div>\
                  <div class='col-4'>\
                    <input type='number' min='0' max='100' oninput='percentDisc("+id+")' class='percent' name='percent["+id+"]' id='percent"+id+"' placeholder='0' style='-moz-appearance: textfield; text-align:right; width:100%;'>\
                    <input type='hidden' min='0' oninput='myFunction("+id+")' class='discount' name='discount["+id+"]' id='discount"+id+"' placeholder='0' style='-moz-appearance: textfield; text-align:right;'>\
                  </div>\
                  <div class='col-1' style='text-align: left;'>%</div>\
                  </div>\
              </td>\
              <td style='text-align: right;' class='align-middle'>\
              <div class='row'>\
              <input type='hidden' class='total' name='total["+id+"]' min='1' id='total"+id+"' required readonly value='0'>Rp. <h6 id='totaltext"+id+"'></div>\
              </td>\
              <td style='width: 5%;' class='align-middle'>\
              <i class='material-icons del' style='cursor: pointer;' onclick='delRow("+id+")'>clear</i>\
              </td>\
            </tr>";
          $("table tbody").append(markup);
          myFunction(id);
          
          getTotal();
        });
    });
</script>
<script src="/admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/admin/js/demo/datatables-demo.js"></script>
@endsection
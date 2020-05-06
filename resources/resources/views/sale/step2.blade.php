@extends('master')
@section('Judul','Insert Penjualan')
@section('headlink')

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link href="{{ asset('/admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="{{ asset('/materialdesign/material-components-web.min.css')}}">
@endsection
@section('tambahstyle')
<style type="text/css">
    @use "@material/textfield/mdc-text-field";
  .quantity{
    width: 20%;
  }
  .discount{
    width: 100%;
  }
  #tabelproduk_filter {
    text-align: left;
  }
  #tabelproduk_filter input {
    margin-left: 0.5em;
    display: inline-block;
    width: 750px;
  }
  .row-cart{
    border-bottom: 1px solid darkgrey; 
    /*border-top: 1px solid darkgrey; */
  }
  .percent{
    -moz-appearance: textfield;
    padding-right:10px;
    text-align: right;
    color: black;
    border: 1px solid darkgrey;
    border-radius: 10px;
    width: 100%;
  }
  .sum-kanan{
    font-family: Montserrat;
    font-weight: 500;
    text-align: right;
  }
  .sum-kiri{
    font-family: Montserrat;
    font-weight: 500;
    text-align: left;
  }
  .data-kiri{
    font-family: Nunito;
    font-weight: 700;
    font-style: bold;
    text-align: left;
  }
  .total{
    font-weight: 700;
    font-size: 14pt;
  }
  .filter-option-inner-inner{
    color: black;
  }
  .quantity{
    background-color:#f5f5f5; 
    -moz-appearance: textfield; 
    width: 30%; 
    border:1px;
    text-align: center;
  }
</style>
@endsection
@section('konten')
<form method="post" action="{{ route('sale.store') }}" id="catForm">
@csrf
<input type="hidden" name="nota_id" value="{{$sale->nota_id}}">
<input type="hidden" name="user_id" value="{{$sale->user_id}}">
<div class="row mb-5">
  <div class="col-7" style="min-height: 92%;">
    <div class="card shadow">
      <div class="card-body" style="margin: 20px;">
        <div id="keranjang">
          <div class="row pl-2 mb-2">
            <h2 style="font-family: Montserrat; font-weight: 700;"><i class="material-icons mr-2" style="vertical-align: bottom;font-size: 2rem;">shopping_cart</i>Checkout</h2>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="row py-2">
                <div class="col-12">
                  <form method="post" action="{{ url('/sale/edit/step1') }}" id="notaForm">
                  <div class="row py-2">
                    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon" style="width: 50%;">
                      <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">calendar_today</i>
                      <input type="date" oninvalid="setCustomValidity('Pilih Tanggal')" class="mdc-text-field__input" name="nota_date" required id="nota_date" min="2018-01-01" value="@if($sale->nota_date != null) $sale->nota_date @endif">
                      <div class="mdc-notched-outline">
                       <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                          <span class="mdc-floating-label" id="my-label-id">Tanggal Pembelian</span>
                        </div>
                        <div class="mdc-notched-outline__trailing"></div>
                      </div>
                    </label>
                  </div>
                  <div class="row py-2">
                    Customer :
                  </div>
                  <div class="row py-2">
                      <select class="selectpicker" data-live-search="true" name="customer_id" id="customer_id" data-size="10" title="Pilih Customer" style="color: black;">
                        @foreach($customer as $c)
                        @if($c->customer_id == $sale->customer_id)
                          <option value="{{$c -> customer_id}}" selected>{{$c -> first_name}} {{$c -> last_name}}</option>
                        @else
                          <option value="{{$c -> customer_id}}">{{$c -> first_name}} {{$c -> last_name}}</option>
                        @endif
                        @endforeach
                      </select>
                  </div>
                </form>
                  <div id="data_cust">
                    <div class="row pt-2 pb-1">
                        <h6 class="data-kiri"><i class="material-icons mr-2" style="vertical-align: bottom;">perm_identity</i><span id="customer_name">Dea Amartya</span></h6>
                    </div>
                    <div class="row py-1">
                      <h6 class="data-kiri"><i class="material-icons mr-2" style="vertical-align: bottom;">phone_iphone</i><span id="phone">+6281333654616</span></h6>
                    </div>
                    <div class="row py-1">
                        <h6 class="data-kiri"><i class="material-icons mr-2" style="vertical-align: bottom;">home</i><span id="street">Pesona Sekar Gading 3 Blok S-7 RT25 RW08, Sekardangan</span></h6>
                    </div>
                    <div class="row" style="padding-left: 32px;">
                        <h6 class="data-kiri"><span id="state">Sidoarjo, Jawa Timur 61215</span></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center mt-3">
            <button type="submit" class="btn btn-primary btn-lg" style="width: 70%; font-weight: bold;">SUBMIT</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-5">
    <div class="card shadow">
      <div class="card-body" style="margin: 20px;">
            <div class="row">
                <h4 style="font-family: Montserrat; font-weight: 700;">Pembelian</h4>
            </div>

              <div class="row" id="cart">
                <div class="col-12">

                    @foreach($saledetails as $s)
                      @php $id = $s->product_id @endphp
                        <input type="hidden" class="discount" name="discount[{{$id}}]" id="discount{{$id}}" value="{{$s->discount}}" readonly>

                        <input type="hidden" class="selling_price" name="selling_price[{{$id}}]" id="price{{$id}}" value="{{$s->selling_price}}" readonly>

                        <input type="hidden" class="quantity" name="jumlah[{{$id}}]" min="1" id="jumlah{{$id}}" required value="{{$s->quantity}}" readonly>

                        <input type="hidden" class="total" name="total[{{$id}}]" min="1" id="total{{$id}}" required value="{{$s->total_price}}" readonly>

                        <input type="hidden" name="product_id[{{$id}}]" value={{$id}} readonly id="product_id{{$id}}">

                        <input type="hidden" name="boh">

                        <div class="row py-3 px-4 row-cart align-items-center mb-3" id="{{$id}}">
                          <div class="col-5" style="text-align: left;">
                            <div class="row">
                              <h6 class="product_name" style="font-weight:bold;">{{$s->product_name}}</h6></div>
                            <div class="row">
                              #{{$id}}
                            </div>
                            <div class="row">
                              <h6 class="mr-1">@ Rp </h6><h6 class="price">{{$s->selling_price}}</h6>
                            </div>
                          </div>
                          
                          <div class="col-1">
                            <div class="row justify-content-center">
                              x{{$s->quantity}}
                            </div>
                          </div>
                          
                          <div class="col-6">
                            <div class="row justify-content-end">
                              <h6 class="mr-1">Rp </h6><h6 style="text-align: right;" class="price">{{$s->total_price}}</h6>
                            </div>
                            <div class="row justify-content-end">
                              
                              @if($s->discount != "0")
                              <span style="color: #cc0000">
                                 <h6 style="text-align: right; color: red;">(Disc.<span class="ml-1"><?php echo (($s->discount/($s->selling_price*$s->quantity))*100) ?></span>%)</h6>
                              </span>
                              @endif
                            </div>
                          </div>
                        </div>
                        
                    @endforeach
                  
                </div>
              </div>

              <div class="row" id="summary">
                <div class="col-12">
                  <div class="row align-middle mt-1 mb-4">
                    <a href="{{ url('sale/edit/step1') }}"><button type="button" class="btn btn-md mx-2" style="background-color:#FF5E5B;font-weight: bold;color: white">Edit Keranjang</button></a>
                  </div>
                  <div class="row">
                    <h4 style="font-family: Montserrat; font-weight: 700;">Summary</h4>
                    <div class="col-12">
                      <h5 class="sum-kanan" id="items"><i class="material-icons mr-2" style="vertical-align: bottom;">shopping_basket</i> 0 item</h5>
                    </div>
                  </div>
                  <div class="row align-baseline justify-content-end">
                    <div class="col-5">
                      <h6 class="sum-kiri">Subtotal : </h6>
                      <input type="hidden" id="subtotal">
                    </div>
                    <div class="col-7">
                      <h6 class="sum-kanan mr-1">Rp <span id="subtotal-val"></span></h6>
                    </div>
                  </div>

                  <div class="row align-baseline">
                    <div class="col-5">
                      <h6 class="sum-kiri">Discount : Rp</h6>
                      <input type="hidden" id="total_discount">
                    </div>
                    <div class="col-7">
                      <h6 class="sum-kanan mr-1">Rp <span id="total_discount-val"></span></h6>
                    </div>
                  </div>

                  <div class="row align-baseline">
                    <div class="col-5">
                      <h6 class="sum-kiri">Tax (10%) : Rp</h6>
                      <input type="hidden" id="total_tax">
                    </div>
                    <div class="col-7">
                      <h6 class="sum-kanan mr-1">Rp <span id="total_tax-val"></span></h6>
                    </div>
                  </div>

                  <div class="row align-baseline mt-2">
                    <div class="col-5">
                    <h6 class="sum-kiri total">Total : Rp </h6>
                    <input type="hidden" name="total_payment" id="total_payment">
                    </div>
                    <div class="col-7">
                      <b><h6 class="sum-kanan total mr-1">Rp <span id="total_payment-val"></span></h6><b>
                    </div>
                  </div>
                </div>
              </div>
      </div>
    </div>
  </div>
</div>
</form>
@endsection
@section('bottom')
<script src="{{ asset('/js/hitung.js')}}"></script>
<script src="{{ asset('/js/add-del-row.js')}}"></script>
<script src="{{ asset('/js/onkey.js')}}"></script>
<!-- <script src="{{ asset('/admin/vendor/datatables/jquery.dataTables.min.js')}}"></script> -->
<!-- <script src="{{ asset('/admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script>
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
        document.getElementById("nota_date").value = today;
        <?php if(isset($sale->nota_date)){?>
        
        document.getElementById("nota_date").value = <?php echo $sale->nota_date; }?>;
          

      jQuery(function($) {
        getTotal();
          const textFields = document.querySelectorAll('.mdc-text-field');
          for (const textField of textFields) {
            mdc.textField.MDCTextField.attachTo(textField);
          }
          
          $("#data_cust").css("display", "none");
        var prices = document.getElementsByClassName("price");
          for (var i = 0; i < prices.length; ++i) {
            console.log(prices[i].innerHTML);
            prices[i].innerHTML = money(prices[i].innerHTML);
            console.log(prices[i].innerHTML);
          }

          $("#data_cust").css("display","none");
        $("#customer_id").change(function(){
            var id = $('#customer_id').find(":selected").val();
            var baseurl = '{{URL::to('')}}';
            $.ajax({
                url: baseurl+'/customer/getData/'+id,
                method: 'GET',
                success: function(data) {
                  var customer = data.customer;

                  if(customer.last_name == null){
                    $("#customer_name").html(customer.first_name);
                  }
                  else{
                    $("#customer_name").html(customer.first_name+" "+customer.last_name);
                  }
                  $("#phone").html("+62"+customer.phone);
                  $("#street").html(customer.street);
                  $("#state").html(customer.city+", "+customer.state+" "+customer.zip_code);
                  
                  $("#data_cust").css("display","block");
                  console.log("tampil haruse ndeng")
                },
                error: function(data) {
                  console.log(data);
                }
            });
        })
      });
</script>
@endsection
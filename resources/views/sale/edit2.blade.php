@extends('selectfield')
@section('tambahlink')
  <link href="/admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-touchspin/4.2.5/jquery.bootstrap-touchspin.min.css">
  
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
          <h3 class="m-0 font-weight-bold text-primary">Edit Data Penjualan</h3>
      </div>
      <div class="card-body" style="margin: 20px;">
        <form method="post" action="{{ route('sale.update', $sale->nota_id) }}" id="catForm">
          @METHOD('PUT')
          @csrf
          <input type="hidden" name="nota_id" value="{{$sale -> nota_id}}">
          <div class="row" style="margin-bottom: 20px">
            <div class="col-3">
            <h4>ID NOTA : #{{$sale -> nota_id}}</h4>
              <div style="margin-top: 20px;">
                <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon" style="width: 100%;">
                <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">calendar_today</i>
                <input type="date" oninvalid="setCustomValidity('Pilih Tanggal')" class="mdc-text-field__input" name="nota_date" required id="nota_date" min="2018-01-01" value="{{$sale -> nota_date}}">
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
                <select class="selectpicker" oninvalid="setCustomValidity('Pilih Customer')" data-live-search="true" name="customer_id" required id="customer_id" data-size="5" multiple title="Pilih Customer....">
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
              <select class="selectpicker" oninvalid="setCustomValidity('Pilih User')" data-live-search="true" name="user_id" required id="user_id" data-size="5" multiple title="Pilih User....">
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
          <div id="keranjang">
            <div class="row" style="margin-bottom: 20px">
              <div class="col-12">
              <button type="button" class="add-row btn" style="color: white;padding: 10px 15px 10px 15px;background-color: #FF4F5B;" data-toggle="modal" data-target="#pilihanProduct"><b>Tambah Produk</b></button>
              </div>
            </div>
          
            <table class="table" id="cart" width="100%" cellspacing="0">
              <thead style="text-align: center;">
                <th>Nama Produk</th>
                <th>Quantity</th>
                <th>Harga</th>
                <th>Total Harga</th>
                <th></th>
              </thead>
              <tbody>
                @foreach($detailorder as $d)
                <?php 
                  $id =  $d->product_id;
                  $price =  $d->selling_price;
                  $name =  $d->product_name;
                  $stock =  $d->product_stock;
                  $total =  $d->total_price;
                  $discount =  $d->discount;
                  $quantity =  $d->quantity;
                ?>
                  <tr id="{{ $id }}" style='border: 1px;'>
                    <td style='text-align: left; padding-left: 40px;' class='align-middle'>
                      <div class='row'>
                        <h6 class='product_name' style='font-weight:bold;'>{{$name}}</div>
                      <div class='row'>
                        <input type='hidden' name='product_id[{{ $id }}]' value="{{ $id }}" readonly id="product_id{{ $id }}">#{{ $id }}</div>
                    </td>
                    <td style='width: 15%;' class='align-middle'>
                      <div class='row justify-content-center'>
                        <button class='inc btn btn-sm btn-dark' type='button' onclick="inc({{ $id }})">+</button>
                        <input type='number'
                        style='background-color:#f5f5f5; -moz-appearance: textfield; width: 30%; border:1px;text-align: center;' 
                        class='quantity' oninput='recount({{ $id }})' name='jumlah[{{ $id }}]' min='1' id='jumlah{{ $id }}'
                        required max='{{ $stock }}' value='{{$quantity}}'>
                        <button class='dec btn btn-sm btn-dark' type='button' onclick='dec({{ $id }})'>-</button>
                      </div>
                    </td>
                    
                    <td style='text-align: right; width:20%;' class='align-middle'>
                      <div class='row justify-content-center'>
                        <input type='hidden' class='selling_price' name='selling_price[{{ $id }}]' id='price{{ $id }}' value='{{ $price }}'><span id="mprice{{$id}}" class="mprice"></span>
                      </div>
                      <div class='row align-text-bottom justify-content-center'>
                        <div class='col-4 pl-0 pt-2 align-middle'>
                        <h6 style='text-align: left; font-weight:bold;'>Disc. </h6></div>
                        <div class='col-4 px-0 pt-1'>
                          <input type='number' min='0' max='100' oninput='percentDisc({{ $id }})' class='percent' 
                          name='percent[{{ $id }}]' id='percent{{ $id }}'
                          placeholder='0' 
                          style='-moz-appearance: textfield;padding-right:10px; text-align:right; width: 100%;color: black;border-radius: 10pt;border: 2px solid #E06C78;'>
                          <input type='hidden' min='0' oninput='recount({{ $id }})' 
                          class='discount' name='discount[{{ $id }}]' 
                          id='discount{{ $id }}' placeholder='0' 
                          style='-moz-appearance: textfield;text-align: right;' value="{{$discount}}">
                        </div>
                        <div style='text-align: left;font-weight:bold;' class='col-2 pt-2'>%</div>
                      </div>
                    </td>
                    
                    <td class='align-middle' style='width: 25%;'>
                      <div class='row align-middle justify-content-end'>
                        <input type='hidden' class='total' name='total[{{ $id }}]' min='1' id='total{{ $id }}' required value="{{$total}}">
                        <div class='col-4 pl-4'>
                          <h6 style='text-align: left;'>Rp  </h6>
                        </div>
                        <div class='col-8'>
                            <h6 style='text-align: right; padding-right: 18px;' id='total-val{{ $id }}' class="total-val">{{$total}}</h6>
                          </div>
                      </div>
                    </td>
                    
                    <td style='width: 5%;' class='align-middle'>
                      <i class='material-icons' onclick='delRow({{ $id }})' style='cursor: pointer;'>clear</i>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

              <div class="row justify-content-end" style="margin-top: 60px;">
                <div class="col-7">
                <div class="card text-black" style="border:3px solid #FF4F5B">
                  <div class="card-body">
                      <div class="row align-baseline">
                        <div class="col-8">
                          <h6 style="text-align: left; ">Sub Total : Rp </h6>
                          <input type="hidden" id="subtotal">
                        </div>
                        <div class="col-4">
                          <h6 style="text-align: right;" id="subtotal-val">0</h6>
                        </div>
                      </div>

                      <div class="row align-baseline">
                        <div class="col-8">
                          <h6 style="text-align: left;">Discount : Rp</h6>
                          <input type="hidden" id="total_discount">
                        </div>
                        <div class="col-4">
                          <h6 style="text-align: right;" id="total_discount-val">0</h6>
                        </div>
                      </div>

                      <div class="row align-baseline">
                        <div class="col-8">
                        <h6 style="text-align: left; font-size: 14pt;"><b>Total Payment : Rp </b></h6>
                        <input type="hidden" name="total_payment" id="total_payment" value="{{$d -> total_payment}}">
                        </div>
                        <div class="col-4">
                          <b><h6 id="total_payment-val" style="text-align: right; font-size: 14pt;">0</h6></b>
                        </div>
                      </div>
                      <div class="row align-middle" style="margin-top: 20px;">
                        <input type="submit" class="btn btn-info btn-lg mx-2" style="width: 100%; font-weight: bold;" value="SIMPAN">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- end of keranjang -->
          </form>
          <div class="card mt-5" id="kosong" style="border: 0px;">
            <img class="card-img" src="{{ asset('/img/empty_cart.svg')}}" style="height: 500px;">
            <div class="card-img-overlay">
              <a href="#pilihanProduct" data-toggle="modal">
                <img src="{{ asset('/img/add_btn.svg')}}" style="height: 40px;margin-top: 150px;margin-left: 200px;" class=" add-row"  >
              </a>
          </div>
        </div> <!-- end of card-body -->
      </div> <!-- end of card -->
    </div>
  </div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="pilihanProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="m-0 font-weight-bold text-primary">Pilih Produk</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
      <div class="table-responsive" id="tableproduk">
          <table class="table table-hover" id="tabelproduk" width="100%">
          <thead>
            <tr>
              <th></th>
              <th scope="col">Nama Produk</th>
              <th scope="col">Harga</th>
              <th scope="col">Stok</th>
            </tr>
          </thead>
          <tbody>
            @foreach($product as $p)
            <tr id="{{$p -> product_id}}">
              <td class="align-middle no-sort" width="10%">
                <div class="mdc-checkbox">
                  <input type="checkbox"
                         class="mdc-checkbox__native-control productcheck"
                         id="check{{$p-> product_id}}"/>
                  <div class="mdc-checkbox__background">
                    <svg class="mdc-checkbox__checkmark"
                         viewBox="0 0 24 24">
                      <path class="mdc-checkbox__checkmark-path"
                            fill="none"
                            d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                    </svg>
                    <div class="mdc-checkbox__mixedmark"></div>
                  </div>
                  <div class="mdc-checkbox__ripple"></div>
                </div>
              </td>
              <td class="align-middle" width="60%">{{ $p-> product_name }}</td>
              <td class="align-middle" width="20%">
                Rp  <span class="productprice" style="text-align: right;">{{ $p-> product_price }}</span>
              </td>
              <td class="align-middle" width="10%">{{ $p-> product_stock }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
      </div>
      <div class="modal-footer" >
        <button type="button" class="btn btn-outline-secondary btn-lg" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-lg" style="padding: auto 30px;" id="save">Add to Cart</button>
      </div>
    </div>
  </div>
</div>  <!-- End of Modal Produk-->
@endsection
@section('tambahan')
<script src="/admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/js/hitung.js"></script>
<script src="/js/add-del-row.js"></script>
<script>
        var products = <?php echo json_encode($product); ?>;
        var deleted = new Array();
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

        var prices = document.getElementsByClassName("productprice");
        for (var i = 0; i < prices.length; ++i) {
          prices[i].innerHTML = money(prices[i].innerHTML);
        }

        var sprices = document.getElementsByClassName("selling_price");
        var mprices = document.getElementsByClassName("mprice");
        for (var i = 0; i < sprices.length; ++i) {
          mprices[i].innerHTML = "@ Rp "+money(sprices[i].value);
        }

        var totals = document.getElementsByClassName("total");
        var totalvals = document.getElementsByClassName("total-val");
        var discounts = document.getElementsByClassName("discount");
        for (var i = 0; i < totals.length; ++i) {
          totalvals[i].innerHTML = money(totals[i].value - discounts[i].value);
        }

        
        var percents = document.getElementsByClassName("percent");
        var quantitys = document.getElementsByClassName("quantity");
        for (var i = 0; i < discounts.length; ++i) {
          var total = sprices[i].value*quantitys[i].value;
          var persen = parseInt((((total - discounts[i].value) / total)*100));
          percents[i].value = 100 - persen;
        }

        getTotal();
        $('#keranjang').show();
        $('#kosong').hide();
        $('#tabelproduk').DataTable();

      jQuery(function($) {
        
        $("#save").click(function(){
          var checks = $("#tabelproduk").find("input[type=checkbox]:checked");
          var ids = Array();
          for(var i=0;i<checks.length;i++) {
              ids[i] = checks[i].id;
              $("#"+ids[i]).prop("checked", false);
              ids[i] = ids[i].substring(5,10);
              addRow(ids[i]);
              $("#tabelproduk tbody tr#"+ids[i]).hide();
          }
          cekTabelProduk();
        });

        $('#tabelproduk tr').click(function() {
            var check = $(this).find("input[type=checkbox]");
            if (check.prop("checked") == true) {
              check.prop("checked", false);
            }
            else{
              check.prop("checked", true);
            }
        });
        
      });


</script>
@endsection
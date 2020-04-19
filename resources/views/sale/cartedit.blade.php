@extends('master')
@section('Judul','Insert Penjualan')
@section('headlink')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link href="{{ asset('/admin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection
@section('tambahstyle')
<style type="text/css">
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
    border: 1px solid darkgrey; border-radius: 10px;
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
  .total{
    font-weight: 700;
    font-size: 14pt;
  }
  .filter-option-inner-inner{
    color: black;
  }
</style>
@endsection
@section('konten')
    <div class="card shadow mb-5">
      <div class="card-body" style="margin: 20px;">
        <div id="keranjang">
          <div class="row pl-2 mb-2">
            <h2 style="font-family: Montserrat; font-weight: 700;"><i class="material-icons mr-2" style="vertical-align: bottom;font-size: 2rem;">shopping_cart</i>Cart</h2>
          </div>
          <div class="row">
            <div class="col-7">
              <form method="post" action="{{ url('sale/create/step1') }}" id="catForm">
                @csrf
                <input type="hidden" name="nota_id" value="{{$nota_id}}">
                  <div class="row">
                      <div id="cart" class="col mb-3">
                        @foreach($saledetails as $s)
                        @php $percent = $s->discount/($s->quantity*$s->selling_price)*100; @endphp
                        @php $percent = intval($percent); @endphp
                        <div class="row py-3 px-4 row-cart align-items-center mb-3" id="{{$s->product_id}}">

                      <div class="col-4" style="text-align: left;">     
                        <div class="row">       
                          <h6 class="product_name" style="font-weight:bold;">{{$s->product_name}}</h6>
                        </div>      
                        <div class="row">       
                          <input type="hidden" name="product_id[{{$s->product_id}}]" value="{{$s->product_id}}" readonly="" id="product_id{{$s->product_id}}">#{{$s->product_id}}</div>     
                          <div class="row justify-content-start">       
                            <input type="hidden" class="selling_price" name="selling_price[{{$s->product_id}}]" id="price{{$s->product_id}}" value="{{$s->selling_price}}">@ Rp {{$s->selling_price}}   
                          </div>    
                        </div>        
                        <div class="col-3">     
                          <div class="row justify-content-center">        
                            <button class="btn btn-sm btn-outline-dark" type="button" onclick="dec('{{$s->product_id}}')">-</button>          
                            <input type="number" style="background-color:#f5f5f5; -moz-appearance: textfield; width: 30%; border:1px;text-align: center;" class="quantity" oninput="recount('{{$s->product_id}}')"
                             name="jumlah[{{$s->product_id}}]" min="1" id="jumlah{{$s->product_id}}" required="" max="25" value="{{$s->quantity}}">          
                            <button class="btn btn-sm btn-outline-dark" type="button" onclick="inc('{{$s->product_id}}')">+</button>      
                          </div>    
                        </div>        
                        <div class="col-4">     
                          <div class="row align-middle justify-content-end">        
                            <input type="hidden" class="total" name="total[{{$s->product_id}}]" min="1" id="total{{$s->product_id}}" required="" value="{{$s->total_price}}">       
                            <div class="col-3">         
                              <h6 style="text-align: left;">Rp  </h6>       
                            </div>        
                            <div class="col-9">           
                              <h6 style="text-align: right;" id="total-val{{$s->product_id}}"></h6>         
                            </div>      
                          </div>     
                          <div class="row align-text-bottom justify-content-center">       
                            <div class="col-4 pl-0 pt-2 align-middle">        
                            <h6 style="text-align: right; font-weight:bold;">Disc. </h6>
                          </div>        
                          <div class="col-4 px-0 pt-1">        
                            <input type="number" oninput="recount('{{$s->product_id}}')" class="percent" name="percent[{{$s->product_id}}]" id="percent{{$s->product_id}}" placeholder="0" value="{{$percent}}">     
                            <input type="hidden" min="0" oninput="recount('{{$s->product_id}}')" class="discount" name="discount[{{$s->product_id}}]" id="discount{{$s->product_id}}" placeholder="0" style="-moz-appearance: textfield;text-align: right;" value="{{$s->discount}}">        
                          </div>        
                          <div style="text-align: left;font-weight:bold;" class="col-2 pt-2">%</div>      
                        </div>      
                            <div class="row">       
                              <div class="badge badge-danger" id="errpercent{{$s->product_id}}" aria-hidden="true" style="display: none;">Silahkan input nilai 0-100</div>      
                          </div>    
                        </div>        
                            <div class="col-1">     
                              <i class="material-icons" onclick="delRow('\'{{$s->product_id}}\')" style="cursor: pointer;">clear</i>   
                            </div>  
                          </div>
                      
                    @endforeach
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 20px">
                    <button type="button" class="add-row btn btn-block btn-outline-primary" data-toggle="modal" data-target="#pilihanProduct"><i class="material-icons mr-2" style="vertical-align: bottom;">add_shopping_cart</i><b>Tambah Produk</b></button>
                  </div>
              </form>
            </div>
            <div class="col-5">
                <div class="card shadow bg-dark text-white ml-3">
                  <div class="card-body px-4 my-auto">
                      <div class="row pl-2 mb-3">
                        <h2 style="font-family: Montserrat; font-weight: 700;">Summary</h2>
                      </div>
                      <div class="row mb-2">
                        <div class="col-12">
                          <h5 class="sum-kiri" id="items"><i class="material-icons mr-2" style="vertical-align: bottom;">shopping_basket</i> 0 item</h5>
                        </div>
                      </div>
                      <div class="row align-baseline">
                        <div class="col-5">
                          <h6 class="sum-kiri">Subtotal : Rp </h6>
                          <input type="hidden" id="subtotal">
                        </div>
                        <div class="col-7">
                          <h6 class="sum-kanan" id="subtotal-val">0</h6>
                        </div>
                      </div>

                      <div class="row align-baseline">
                        <div class="col-5">
                          <h6 class="sum-kiri">Discount : Rp</h6>
                          <input type="hidden" id="total_discount">
                        </div>
                        <div class="col-7">
                          <h6 class="sum-kanan" id="total_discount-val">0</h6>
                        </div>
                      </div>

                      <div class="row align-baseline">
                        <div class="col-5">
                          <h6 class="sum-kiri">Tax (10%) : Rp</h6>
                          <input type="hidden" id="total_tax">
                        </div>
                        <div class="col-7">
                          <h6 class="sum-kanan" id="total_tax-val">0</h6>
                        </div>
                      </div>

                      <div class="row align-baseline mt-2">
                        <div class="col-5">
                        <h6 class="sum-kiri total">Total : Rp </h6>
                        <input type="hidden" name="total_payment" id="total_payment">
                        </div>
                        <div class="col-7">
                          <b><h6 class="sum-kanan total" id="total_payment-val">0</h6></b>
                        </div>
                      </div>
                      <div class="row align-middle" style="margin-top: 20px;">
                        <button onclick="$('#catForm').submit()" class="btn btn-info btn-lg mx-2" style="width: 100%; font-weight: bold;">Checkout</button>
                      </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="card mt-5" id="kosong" style="border: 0px;">
          <img class="card-img" src="{{ asset('/img/empty_cart.svg')}}" style="height: 500px;">
          <div class="card-img-overlay">
            <a href="#pilihanProduct" data-toggle="modal">
              <img src="{{ asset('/img/add_btn.svg')}}" style="height: 40px;margin-top: 150px;margin-left: 240px;" class=" add-row"  >
            </a>
          </div>
        </div>
      </div>
    </div>
<div class="modal fade" id="pilihanProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content" style="min-height: 400px;">
      <div class="modal-header">
        <h4 class="m-0 font-weight-bold text-primary">Pilih Produk</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="table-responsive" id="tableproduk" style="min-height: 250px;">
          <table class="table table-hover" id="tabelproduk" width="100%">
          <thead>
            <tr>
              <th></th>
              <th>Nama Kategori</th>
              <th>Nama Produk</th>
              <th>Harga</th>
              <th>Stok</th>
            </tr>
          </thead>
          <tbody>
            @foreach($product as $p)

            <tr id="{{$p -> product_id}}">
              <td style="width: 5%;">
                <div class="pretty p-svg p-curve">
                    <input type="checkbox" class="productcheck" id="check{{$p-> product_id}}"/>
                    <div class="state p-success">
                        <!-- svg path -->
                        <svg class="svg svg-icon" viewBox="0 0 20 20">
                            <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                        </svg>
                        <label></label>
                    </div>
                </div>
              </td>
              <td>{{ $p-> category_name }}</td>
              <td>{{ $p-> product_name }}</td>
              <td>Rp <span class="productprice" style="text-align: right;">{{ $p-> product_price }}</span></td>
              <td>{{ $p-> product_stock }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
      </div>
      <div class="modal-footer" >
        <button type="button" class="btn btn-primary btn-lg" id="save"><h6 class="sum-kiri"><i class="material-icons mr-1" style="vertical-align: bottom;">add_shopping_cart</i>Add to Cart</h6></button>
      </div>
    </div>
  </div>
</div>  <!-- End of Modal Produk-->
@endsection
@section('bottom')
<script src="{{ asset('/js/hitung.js')}}"></script>
<script src="{{ asset('/js/add-del-row.js')}}"></script>
<script src="{{ asset('/js/onkey.js')}}"></script>
<script src="{{ asset('/admin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/admin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script>
        var products = <?php echo json_encode($product); ?>;
        var categories = <?php echo json_encode($categories); ?>;
        var saledetails = new Array(<?php echo json_encode($saledetails); ?>);
        console.log("atas iki wah");
        var prices = document.getElementsByClassName("productprice");
        for (var i = 0; i < prices.length; ++i) {
          prices[i].innerHTML = money(prices[i].innerHTML);
        }
        console.log("cbcb");
        $('#keranjang').show();
        $('#kosong').hide();
        $('#tabelproduk').dataTable({
           columns: [
                    {name: 'check', orderable: false,searchable: false, width:'1%'},
                    {name: 'category_name', width:'25%'},
                    {name: 'product_name', width:'30%'},
                    {name: 'harga', searchable: false, width:'20%'},
                    {name: 'stok', searchable: false, width:'20%'},
                 ],
          order: [[4, 'asc']],
          lengthChange: false,
        });
        var length = document.getElementById("tabelproduk_wrapper").childNodes[0].childNodes[0];
        length.remove();
        var seachpane = document.getElementById("tabelproduk_wrapper").childNodes[0].childNodes[0];
        seachpane.classList.remove("col-md-6");
        seachpane.classList.remove("col-sm-12");
        seachpane.classList.add("col-9");
        $("#tabelproduk_filter").parent().parent().prepend('<div class="col-3">\
          <select class="selectpicker" data-live-search="true" name="category_id" id="category_id" data-size="5" title="Filter by Kategori" style="color: black;">\
          <option value="0">Tampilkan Semua</option>\
          @foreach($categories as $c)\
          <option value="{{$c -> category_id}}">{{$c -> category_name}}</option>\
          @endforeach\
          </select>\
          </div>');
        console.log("yes");

      jQuery(function($) {
        
        $(".row-cart").each(function(){
          recount($(this).attr('id'));
        });

        $("#save").click(function(){
          $('#keranjang').show();
          $('#kosong').hide();
          var checks = $("#tabelproduk").find("input[type=checkbox]:checked");
          var ids = Array();
          for(var i=0;i<checks.length;i++) {
              ids[i] = checks[i].id;
              $("#"+ids[i]).prop("checked", false);
              ids[i] = ids[i].substring(5,15);
              // console.log(ids[i]);
              if($("#cart #"+ids[i]).length){
                inc(ids[i]);
              }
              else{
                addRow(ids[i]);
              }
          }
          $("#pilihanProduct").modal('hide');
        });

        $("#category_id").change(function(){
            var id = $('#category_id').find(":selected").val();
            var baseurl = '{{URL::to('')}}';
            $.ajax({
                url: baseurl+'/product/filterbyCat/'+id,
                method: 'GET',
                success: function(data) {
                  var table = $("#tabelproduk").DataTable();
                  var product = data.product;
                  table.clear().draw();
                  for(var index=0;index<product.length;index++){
                    console.log("produk yang masok"+product[index]["product_id"]);
                    table.row.add(['<div class="pretty p-svg p-curve"><input type="checkbox" class="productcheck" id="check'+product[index]["product_id"]+'"/><div class="state p-success"><svg class="svg svg-icon" viewBox="0 0 20 20"><path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path></svg><label></label></div></div>',
                        product[index]["category_name"],
                        product[index]["product_name"],
                        'Rp <span class="productprice" style="text-align: right;">'+product[index]["product_price"]+'</span>',
                        product[index]["product_stock"]
                    ]).node().id = product[index]["product_id"];
                    table.draw();
                  }
                  $('#tabelproduk >tbody tr').click(function() {
                      var check = $(this).find("input[type=checkbox]");
                      if (check.prop("checked") == true) {
                        check.prop("checked", false);
                      }
                      else{
                        check.prop("checked", true);
                      }
                  });
                  var prices = document.getElementsByClassName("productprice");
                  for (var i = 0; i < prices.length; ++i) {
                    prices[i].innerHTML = money(prices[i].innerHTML);
                  }
                },
                error: function(data) {
                  console.log(data);
                }
            });
        })

        $('#tabelproduk >tbody tr').click(function() {
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
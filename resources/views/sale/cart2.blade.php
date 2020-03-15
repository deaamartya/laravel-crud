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
            <button type="button" class="add-row btn btn-primary" style="padding: 10px 15px 10px 15px;" data-toggle="modal" data-target="#pilihanProduct">Tambahkan produk</button>
            </div>
          </div>
          <div class="table-responsive">
          <table class="table" id="cart" width="100%" cellspacing="0" align="right">
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

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="pilihanProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="table-responsive">
          <table class="table table-hover" id="tabelproduk" width="100%">
          <thead>
            <tr>
              <th scope="col">Pilih Produk</th>
              <th scope="col">Nama Produk</th>
              <th scope="col">Harga</th>
              <th scope="col">Stok</th>
            </tr>
          </thead>
          <tbody>
            @foreach($product as $p)
            <tr id="{{$p -> product_id}}">
              <td class="align-middle">
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
              <td class="align-middle">{{ $p-> product_name }}</td>
              <td class="align-middle">Rp. {{ $p-> product_price }}</td>
              <td class="align-middle">{{ $p-> product_stock }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save">Add to Cart</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('tambahan')
<script src="/admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/js/hitung.js"></script>
<script src="/js/bootstrap-input-spinner.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-touchspin/4.2.5/jquery.bootstrap-touchspin.min.js"></script> -->
<script>
        var products = <?php echo json_encode($product); ?>;
        
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
    
        function delRow(id){
          $('#cart tbody tr#'+id).remove();
          getTotal();
          $("#tabelproduk tbody tr#"+id).show();
        }

        function inc(id){
          var oldValue = $("#jumlah"+id).val();
          var newVal = parseFloat(oldValue)+1;
          $("#jumlah"+id).val(newVal);
          recount(id);
        }

        function dec(id){
          var oldValue = $("#jumlah"+id).val();
          if (parseFloat(oldValue) > 1) {
              var newVal = parseFloat(oldValue)-1;
              $("#jumlah"+id).val(newVal);
          }
          recount(id);
        }

      jQuery( function( $ ) {

        $(".qButton").click(function(){

          var $button = $(this);
          var oldValue = $button.parent().find(".quantity").val();
          console.log(oldValue);
          if ($button.text() == "+") {
            var newVal = parseFloat(oldValue) + 1;
          } else {
           // Don't allow decrementing below zero
            if (oldValue > 0) {
              var newVal = parseFloat(oldValue) - 1;
            } else {
              newVal = 0;
            }
          }

          $button.parent().find(".quantity").val(newVal);

          console.log(newVal);

        });

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

        

         function addRow(id){
            var index = getIndex(id);
            var id = products[index]["product_id"];
            var name = products[index]["product_name"];
            var price = products[index]["product_price"];
            var stock = products[index]["product_stock"];
            var markup = "\
            <tr id='"+id+"'>\
              <td style='text-align: left; padding-left: 50px;' class='align-middle'>\
                <div class='row'>\
                  <h6 class='product_name'>"+name+"</div>\
                <div class='row'>\
                  <input type='hidden' name='product_id["+id+"]' value="+id+" readonly id='product_id"+id+"'>#"+id+"</div>\
              </td>\
              <td style='width: 20%;' class='align-middle'>\
                <div class='row'>\
                <div class='col-12'>\
                <button class='inc btn btn-sm btn-dark' type='button' onclick='inc("+id+")'>+</button>\
                <input type='number' style='-moz-appearance: textfield; width: 30%; border:1px;text-align: center;' class='quantity' oninput='recount("+id+")' name='jumlah["+id+"]' min='1' id='jumlah"+id+"'required max='"+stock+"' value='1'>\
                <button class='dec btn btn-sm btn-dark' type='button' onclick='dec("+id+")'>-</button></div></div>\
              </td>\
              <td style='text-align: right; width:30%;' class='align-middle'>\
                <div class='row'>\
                  <input type='hidden' class='selling_price' name='selling_price["+id+"]' min='1' id='price"+id+"'required value='"+price+"' readonly>@ Rp. "+price+"\
                </div>\
                <div class='row'>\
                  <div class='col-3'>Disc. </div>\
                  <div class='col-4'>\
                    <input type='number' min='0' max='100' oninput='percentDisc("+id+")' class='percent' name='percent["+id+"]' id='percent"+id+"' placeholder='0' style='-moz-appearance: textfield; text-align:right; width:100%;'>\
                    <input type='hidden' min='0' oninput='recount("+id+")' class='discount' name='discount["+id+"]' id='discount"+id+"' placeholder='0' style='-moz-appearance: textfield; text-align:right;'>\
                  </div>\
                  <div class='col-1' style='text-align: left;'>%</div>\
                </div>\
              </td>\
              <td style='text-align: right;' class='align-middle'>\
              <div class='row'>\
              <input type='hidden' class='total' name='total["+id+"]' min='1' id='total"+id+"' required readonly value='0'>Rp. <h6 id='totaltext"+id+"'></div>\
              </td>\
              <td style='width: 5%;' class='align-middle'>\
              <i class='material-icons' onclick='delRow("+id+")' style='cursor: pointer;'>clear</i>\
              </td>\
            </tr>";
          $("#cart tbody").append(markup);
          recount(id);
          
         }

         function getIndex(id){
            for(var i = 0;i<products.length;i++){
              if(products[i]["product_id"] == id){
                  var index = i;
                  return index;
              }
            }
          }

      });
        $('#tabelproduk').DataTable();
</script>
@endsection
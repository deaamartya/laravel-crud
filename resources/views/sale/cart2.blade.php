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
            <button type="button" class="add-row btn" style="color: white;padding: 10px 15px 10px 15px;background-color: #FF9190;" data-toggle="modal" data-target="#pilihanProduct"><b>Tambah Produk</b></button>
            </div>
          </div>
          
          <table class="table" id="cart" width="100%" cellspacing="0">
            <tbody>
            </tbody>
          </table>
          <div class="row justify-content-end">
            <div class="col-6">
            <div class="card" style="background-color: #E06C78; border: 0px; color: white;">
              <div class="card-body">
                  <div class="row align-baseline">
                    <div class="col-9">
                      <h6 style="text-align: left; ">Sub Total : Rp. </h6>
                      <input type="hidden" id="subtotal">
                    </div>
                    <div class="col-3">
                      <h6 style="text-align: right;" id="subtotal-val">0</h6>
                    </div>
                  </div>

                  <div class="row align-baseline">
                    <div class="col-9">
                      <h6 style="text-align: left;">Discount : Rp.</h6>
                      <input type="hidden" id="total_discount">
                    </div>
                    <div class="col-3">
                      <h6 style="text-align: right;" id="total_discount-val">0</h6>
                    </div>
                  </div>

                  <div class="row align-baseline">
                    <div class="col-9">
                    <h6 style="text-align: left; font-size: 14pt;"><b>Total Payment : Rp. </b></h6>
                    <input type="hidden" name="total_payment" id="total_payment">
                    </div>
                    <div class="col-3">
                      <b><h6 id="total_payment-val" style="text-align: right; font-size: 14pt;">0</h6></b>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="table-responsive">
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
              <td class="align-middle" width="50%">{{ $p-> product_name }}</td>
              <td class="align-middle" width="30%">
                Rp. {{ $p-> product_price }}
              </td>
              <td class="align-middle" width="10%">{{ $p-> product_stock }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn-lg" id="save">Add to Cart</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('tambahan')
<script src="/admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/js/hitung.js"></script>
<script src="/js/add-del-row.js"></script>
<script>
        var products = <?php echo json_encode($product); ?>;
        $('#tabelproduk').DataTable( {
            select: true
        } );

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
      });
</script>
@endsection
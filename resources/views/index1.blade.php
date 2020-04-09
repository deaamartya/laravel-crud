<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <table border="1" width="100%" id="tableModal">
          <thead>
            <td style="text-align:center"><b>Nama Barang</b></td>
            <td style="text-align:center"><b>Harga</b></td>
          </thead>
      <!--    <tr style="cursor:pointer" onclick="pilihBarang(2)">
              <td style="text-align:center">Citos</td>
              <td style="text-align:center">2000</td>
          </tr>
          <tr style="cursor:pointer" onclick="pilihBarang(1)">
              <td style="text-align:center">Ciki</td>
              <td style="text-align:center">1000</td>
          </tr>
          <tr style="cursor:pointer" onclick="pilihBarang(3)">
              <td style="text-align:center">Curos</td>
              <td style="text-align:center">2400</td>
          </tr>
          <tr style="cursor:pointer" onclick="pilihBarang(4)">
              <td style="text-align:center">Pelem</td>
              <td style="text-align:center">3000</td>
          </tr>
          <tr style="cursor:pointer" onclick="pilihBarang(5)">
              <td style="text-align:center">Fanta</td>
              <td style="text-align:center">4500</td>
          </tr>
          <tr style="cursor:pointer" onclick="pilihBarang(6)">
              <td style="text-align:center">Sirup</td>
              <td style="text-align:center">2000</td>
          </tr>
        -->
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-lg" onclick="modal()">Open Modal</button>

<br>
<input type="text" id="myText" value="hallo" onkeyup="getVal(event)" onfocus="select()">
<br>
<br>
<table width="100%" border="1" id="keranjang">
  <thead>
    <td width="40%"><b>Nama</b></td>
    <td width="20%"><b>Harga</b></td>
    <td width="10%"><b>Qty</b></td>
    <td width="20%"><b>Subtotal</b></td>
    <td width="10%"><b>action</b></td>
  </thead>
</table>
<br>
<br>
<h3>Total: Rp. <input type="text" name="total" id="total" value="0" readonly></h3>

<script>

var barang;

window.onload=function(){
  document.getElementById('total').value=0;
}

var arrBarang = new Array(new Array(1, 'ciki', 1000),
                          new Array(2, 'citos', 2000),
                          new Array(3, 'curos', 2400),
                          new Array(4, 'pelem', 3000),
                          new Array(5, 'Fanta', 4500),
                          new Array(6, 'sirup', 2000) );

var colnum=0;

function modal()
{
    $("#myModal").modal("show");
}

function getVal(event)
{  
    if(event.keyCode==13)
    {
      var key = document.getElementById('myText').value;

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
            type:"POST",
            url:"/testAjax/getProduct",
            data:{
              "key":key,
        //      "_token": "{{ csrf_token() }}",//harus ada ini jika menggunakan metode POST
            },
            success : function(results) {
              console.log(JSON.stringify(results)); //print_r
                //console.log(results.product[0].product_name);

          /*    barang = results;
              var table = document.getElementById('tableModal');

              while(table.rows.length > 1)
              {
                table.deleteRow(1);
              }

              for(var i=0; i<results.product.length; i++)
              {
                var row = table.insertRow(table.rows.length);
                row.style.cursor="pointer";
                row.setAttribute("onclick","pilihBarang('"+i+"')");

                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);

                cell1.innerHTML = '<td style="text-align:center">'+results.product[i].product_name+'</td>';
                cell2.innerHTML = '<td style="text-align:center">'+results.product[i].product_price+'</td>';
              }

              modal();
          */    
            },
            error: function(data) {
                console.log(data);
            }
      });
    }
}

//function pilihBarang(id)
function pilihBarang(index)
{
 /* for(var i=0; i<arrBarang.length; i++)
  {
    if(arrBarang[i][0]==id)
      break;
  }
  console.log(arrBarang[i]);
  */

  $("#myModal").modal("hide");

  var table = document.getElementById('keranjang');

  var flag=-1;

  var id = barang.product[index].product_id;
  var nama_barang = barang.product[index].product_name;
  var harga = barang.product[index].product_price;

  for(var z=1; z<table.rows.length; z++)
  {
    //console.log(table.rows[z].childNodes[0].childNodes[2].value);
    if(table.rows[z].childNodes[0].childNodes[2].value == id)
    {
      flag=z;
      break;
    }
  }

  if(flag != -1)
  {
    var qty = table.rows[flag].childNodes[2].childNodes[0];
    qty.value = parseInt(qty.value) + 1;
    var row_id = table.rows[flag].id;
    updateSubtotal(row_id);
  }
  else
  {
    var row = table.insertRow(table.rows.length);
    var idrow = 'col'+colnum;
    row.setAttribute('id',idrow);
    colnum++;

    var cel_1=row.insertCell(0);
    var cel_2=row.insertCell(1);
    var cel_3=row.insertCell(2);
    var cel_4=row.insertCell(3);
    var cel_5=row.insertCell(4);

/*    cel_1.innerHTML = '<input type="text" name="barang[]" value="'+arrBarang[i][1]+'" style="background:transparent; border:none; text-align:center; width=100%" readonly>\
                        <input type="hidden" name="idBarang" id="idBarang" value="'+arrBarang[i][0]+'">';
    cel_2.innerHTML = '<input type="text" name="harga[]" value="'+arrBarang[i][2]+'" readonly>';
    cel_3.innerHTML = '<input type="text" name="qty[]" value="1" onkeyup="updateSubtotal(\''+idrow+'\')" onfocus="select()">';
    cel_4.innerHTML = '<input type="text" name="subtotal[]" value="'+arrBarang[i][2]+'" readonly>';
    cel_5.innerHTML = '<button onclick="hapusEl(\''+idrow+'\')">Del</button>';
*/
    cel_1.innerHTML = '<input type="text" name="barang[]" value="'+nama_barang+'" style="background:transparent; border:none; text-align:center; width=100%" readonly>\
                        <input type="hidden" name="idBarang" id="idBarang" value="'+id+'">';
    cel_2.innerHTML = '<input type="text" name="harga[]" value="'+harga+'" readonly>';
    cel_3.innerHTML = '<input type="text" name="qty[]" value="1" onkeyup="updateSubtotal(\''+idrow+'\')" onfocus="select()">';
    cel_4.innerHTML = '<input type="text" name="subtotal[]" value="'+harga+'" readonly>';
    cel_5.innerHTML = '<button onclick="hapusEl(\''+idrow+'\')">Del</button>';
  }

  updateTotal();

}

function hapusEl(idRow)
{
  document.getElementById(idRow).remove();
  updateTotal();
}

function updateSubtotal(id)
{
  
  //hanya menerima input angka
  
  var row = document.getElementById(id);
  var qty = row.childNodes[2].childNodes[0].value;    
  var harga = row.childNodes[1].childNodes[0].value;
  
  var subTot = harga*qty;

  var colSubTot = row.childNodes[3].childNodes[0];
  colSubTot.value = subTot;

  
  updateTotal();
}

function updateTotal()
{
  var table = document.getElementById('keranjang');
  var total=0;
  for(var i=1; i<table.rows.length; i++)
  {
    total = total + parseInt(table.rows[i].childNodes[3].childNodes[0].value);
  }

  document.getElementById('total').value=total;
}




</script>

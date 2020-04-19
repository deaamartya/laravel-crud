function delRow(id){
  $('#cart > #'+id).remove();
  getTotal();
	if ($('#cart :first-child').length < 1) {
      $('#keranjang').hide();
      $('#kosong').show();
    }
    else{
      $('#keranjang').show();
      $('#kosong').hide();
    }
}
function addRow(id){
	var index = getIndex(id);
	var id = products[index]["product_id"];
	var name = products[index]["product_name"];
	var price = products[index]["product_price"];
	var stock = products[index]["product_stock"];
	var mprice = money(price);
	var markup = "\
      <div class='row py-3 px-4 row-cart align-items-center mb-3' id='"+id+"'>\
	  \
	  <div class='col-4' style='text-align: left;'>\
	    <div class='row'>\
	      <h6 class='product_name' style='font-weight:bold;'>"+name+"</div>\
	    <div class='row'>\
	      <input type='hidden' name='product_id["+id+"]' value="+id+" readonly id='product_id"+id+"'>#"+id+"</div>\
	  	<div class='row justify-content-start'>\
	      <input type='hidden' class='selling_price' name='selling_price["+id+"]' id='price"+id+"' value='"+price+"'>\
	      @ Rp "+"  "+mprice+"\
	    </div>\
	  </div>\
	  \
	  <div class='col-3'>\
	    <div class='row justify-content-center'>\
		    <button class='btn btn-sm btn-outline-dark' type='button' onclick='dec(\""+id+"\")'>-</button>\
		    	<input type='number' \
		    	style='background-color:#f5f5f5; -moz-appearance: textfield; width: 30%; border:1px;text-align: center;' \
		    	class='quantity' oninput='recount(\""+id+"\")' name='jumlah["+id+"]' min='1' id='jumlah"+id+"'\
		    	required max='"+stock+"' value='1'>\
		    	<button class='btn btn-sm btn-outline-dark' type='button' onclick='inc(\""+id+"\")'>+</button>\
	    </div>\
	  </div>\
	  \
	  <div class='col-4'>\
		  <div class='row align-middle justify-content-end'>\
		  	<input type='hidden' class='total' name='total["+id+"]' min='1' id='total"+id+"' required>\
		  	<div class='col-3'>\
		  		<h6 style='text-align: left;'>Rp  </h6>\
		  	</div>\
		  	<div class='col-9'>\
	      		<h6 style='text-align: right;' id='total-val"+id+"'>{{ $p-> product_price }}</h6>\
	      	</div>\
		  </div>\
		 <div class='row align-text-bottom justify-content-center'>\
	      <div class='col-4 pl-0 pt-2 align-middle'>\
	      <h6 style='text-align: right; font-weight:bold;'>Disc. </h6></div>\
	      <div class='col-4 px-0 pt-1'>\
	        <input type='number' oninput='recount(\""+id+"\")' class='percent' \
	        name='percent["+id+"]' id='percent"+id+"' placeholder='0'>\
	        <input type='hidden' min='0' oninput='recount(\""+id+"\")' \
	        class='discount' name='discount["+id+"]' \
	        id='discount"+id+"' placeholder='0' \
	        style='-moz-appearance: textfield;text-align: right;'>\
	      </div>\
	      <div style='text-align: left;font-weight:bold;' class='col-2 pt-2'>%</div>\
	    </div>\
	    <div class='row'>\
	    	<div class='badge badge-danger' id='errpercent"+id+"' aria-hidden='true'>\
	    	Silahkan input nilai 0-100</div>\
	    </div>\
	  </div>\
	  \
	  <div class='col-1'>\
	  	<i class='material-icons' onclick='delRow(\""+id+"\")' style='cursor: pointer;'>clear</i>\
	  </div>\
	</div>\
	";
	$("#cart").append(markup);
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

function money(text){
	var text = text.toString();
	var panjang = text.length;
	var hasil = new Array();
	if (panjang>0){
		if(panjang>3){
			var div = parseInt(panjang/3);
			var char = new Array();
			var result="";
			if (div > 1 && panjang > 6) {
				var x = parseInt(panjang - (div*3));
				div++;
				for (var i=0; i<div; i++) {
					if (i == 0) {
						char[i] = text.slice(i,x);
					}
					else{
						char[i] = text.slice(((i-1)*3)+x,(i*3)+x);
					}
					if (i == (div-1)) {					
						hasil[i]= char[i];
					}
					else{
						hasil[i]= char[i]+".";
					}
				}
				for (var i=0; i<div; i++) {
					result+=hasil[i];
				}
			}
			else{
				result = text.slice(0,panjang-3)+"."+text.slice(panjang-3,panjang);
			}
			return result;
		}
		else{
			return text;
		}
	}
	else{
		return 0;
	}
}
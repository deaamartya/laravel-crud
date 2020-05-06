$.ajax({
    url: baseurl+'/getInfoSale',
    method: 'GET',
    success: function(data) {
      setCardData(data.monthsale,data.yearsale,data.productsale,data.sale,data.monproductsale);
    },
    error: function(data){
    }
});
function setCardData(monthsale,yearsale,productsale,sale,monproductsale){
	$("#monthsale").html("Rp "+money(monthsale[0]['total']));
	$("#yearsale").html("Rp "+money(yearsale[0]['total']));
	$("#productsale").html(productsale[0]['total']);
	$("#totalsale").html("Rp "+money(sale[0]['total']));
	if(monproductsale[0]['total'] > 0){
		$("#monproductsale").html(monproductsale[0]['total']);
	}
	
}
function money(text){
	if(text === null){
		return 0;
	}
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
function checkperc(id){
	console.log("masook");
	if($("#percent"+id).val() > 100 || $("#percent"+id).val() < 0){
		return false;
	}
}
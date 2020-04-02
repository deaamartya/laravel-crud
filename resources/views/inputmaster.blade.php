@extends('master')
@section('headlink')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="{{ asset('/materialdesign/material-components-web.min.css')}}">
<link rel="stylesheet" href="{{ asset('/alert/sweetalert2.min.css') }}">
<style type="text/css">
	@use "@material/textfield/mdc-text-field";
</style>
@yield('tambahlink')
@endsection

@section('konten')

	@yield('kontent')

@endsection

@section('bottom')
@yield('bottomlink')
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>
const textFields = document.querySelectorAll('.mdc-text-field');
for (const textField of textFields) {
  mdc.textField.MDCTextField.attachTo(textField);
}

function lettersOnlySpace(evt) {
evt = (evt) ? evt : event;
var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
  ((evt.which) ? evt.which : 0));
if (charCode > 32 && (charCode < 65 || charCode > 90) &&
  (charCode < 97 || charCode > 122 )) {
  return false;
}
return true;
}

function numOnly(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function lettersOnly(evt) {
   evt = (evt) ? evt : event;
   var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
      ((evt.which) ? evt.which : 0));
   if (charCode > 31 && (charCode < 65 || charCode > 90) &&
      (charCode < 97 || charCode > 122)) {
      return false;
   }
   return true;
 }
 function lettersNum(evt) {
   evt = (evt) ? evt : event;
   var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
      ((evt.which) ? evt.which : 0));
   if (charCode > 31 && (charCode < 65 || charCode > 90) ||
      (charCode < 97 || charCode > 122)) {
      return false;
   }
   return true;
 }
function changeVal(){
  var s = document.getElementById("switch");
  if(s.value == "false"){
    s.value = "true";
    document.getElementById("label").innerHTML = "Aktif";
    
    console.log("masuk sini woy");
  }
  else if(s.value == "true"){
    s.value = "false";
    document.getElementById("label").innerHTML = "Non-Aktif";
    console.log("masuk sini hh");
  }
}
</script>
@endsection
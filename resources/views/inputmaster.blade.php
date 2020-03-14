@extends('master')
@section('headlink')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="/materialdesign/material-components-web.min.css">
<style type="text/css">
	@use "@material/textfield/mdc-text-field";
</style>
@endsection

@section('konten')

	@yield('kontent')

@endsection

@section('bottom')
@yield('bottomlink')
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script>
const textFields = document.querySelectorAll('.mdc-text-field');
for (const textField of textFields) {
  mdc.textField.MDCTextField.attachTo(textField);
}
</script>
<script type="text/javascript">

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
</script>
@endsection
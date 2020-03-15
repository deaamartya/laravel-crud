@extends('master')
@section('headlink')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
@yield('tambahlink')
<style type="text/css">
  @use "@material/textfield/mdc-text-field";
  .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: 50%;
  }
  .btn-light {
    color: #3a3b45;
    background-color: transparent;
    border-color: #858796;
    height: 50px;
    padding: 10px;
    padding-left: 20px;
  }
  .btn-light:hover {
    color: #3a3b45;
    background-color: transparent;
    border-color: black;
  }
  @yield('tmbhstyle')
</style>
@endsection

@section('konten')
  @yield('kontent')
@endsection

@section('bottom')

@yield('tambahan')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script> -->
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>

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
$(document).ready(function() {
$("#currency").inputmask('currency', {
  rightAlign: true,
  'groupSeparator': '.',
  'autoGroup': true,
  prefix : "Rp ",
  'digits': '0',
  'radixPoint': ","
});
});
</script>
@endsection
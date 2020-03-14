<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
  <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">{{$icon}}</i>
  <input type="number" class="mdc-text-field__input" aria-labelledby="my-label-id" name="{{$name}}" required="{{$req}}" onkeypress="{{$onkey}}" value="{{$value}}" style="-moz-appearance : textfield;" maxlength="{{$maxl}}" pattern="[0-9]*">
  <div class="mdc-notched-outline">
   <div class="mdc-notched-outline__leading"></div>
    <div class="mdc-notched-outline__notch">
      <span class="mdc-floating-label" id="my-label-id">{{$label}}</span>
    </div>
    <div class="mdc-notched-outline__trailing"></div>
  </div>
</label>
<div class="mdc-text-field-helper-line">
  <div class="mdc-text-field-helper-text" id="my-helper-id" aria-hidden="true">{{$help}}</div>
  <div class="mdc-text-field-character-counter">{{$char}}</div>
</div>
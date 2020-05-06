<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon {{$err}}" style="width: 100%;">
  <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">{{$icon}}</i>
  <input type="{{$type}}" class="mdc-text-field__input" aria-labelledby="my-label-id" name="{{$name}}" onkeypress="{{$onkey}}" maxlength="{{$maxl}}" value="{{$value}}">
  <div class="mdc-notched-outline">
   <div class="mdc-notched-outline__leading"></div>
    <div class="mdc-notched-outline__notch">
      <span class="mdc-floating-label" id="my-label-id">{{$label}}</span>
    </div>
    <div class="mdc-notched-outline__trailing"></div>
  </div>
</label>
<div class="mdc-text-field-helper-line">
  <div class="mdc-text-field-helper-text {{$err2}}" id="my-helper-id" aria-hidden="true">
    {{ $help }}
  </div>
  <div class="mdc-text-field-character-counter">{{$char}}</div>
</div>
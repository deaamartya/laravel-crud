@extends('inputmaster')
@section('Judul','Edit Customer')
@section('kontent')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		  		<h3 class="m-0 font-weight-bold text-primary">Edit Data Customer</h3>
		    </div>
			<div class="card-body" style="margin: 10px; padding: 20px;">

				<form method="post" action="{{ route('customer.update', $customer->customer_id) }}" id="catForm">
					@method('PUT')
					@csrf
					<div class="row">
					<div class="col-6" style="margin-bottom: 10px; padding-left: 0px;">
						@field
						    @slot('icon') perm_identity @endslot
						    @slot('type') text @endslot
						    @slot('onkey') return lettersOnly(event) @endslot
						    @slot('name') first_name @endslot
						    @slot('req') true @endslot
						    @slot('maxl') 50 @endslot
						    @slot('max') 50 @endslot
						    @slot('value') {{$customer->first_name}} @endslot
						    @slot('label') Nama Depan @endslot
						    @slot('err') 
						    	@error('first_name') mdc-text-field--invalid @enderror 
						    @endslot
							@slot('help') 
								@if ($errors->has('first_name'))
						      	Nama harus diisi dengan huruf(Aa-Zz)
						    	@else
						      	Masukkan huruf(Aa-Zz)
						    	@endif
						    @endslot
						    @slot('err2') @error('first_name','mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg') @enderror @endslot
						    @slot('char') 0 / 50 @endslot
					    @endfield
					</div>
					<div class="col-6" style="margin-bottom: 10px; padding-left: 0px;">
						<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon" style="width: 100%;">
						  <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">perm_identity</i>
						  <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id" name="last_name" onkeypress="return lettersOnly(event)" style="-moz-appearance : textfield;" maxlength="50" value="{{$customer -> last_name}}">
						  <div class="mdc-notched-outline">
						   <div class="mdc-notched-outline__leading"></div>
						    <div class="mdc-notched-outline__notch">
						      <span class="mdc-floating-label" id="my-label-id">Nama Belakang</span>
						    </div>
						    <div class="mdc-notched-outline__trailing"></div>
						  </div>
						</label>
						<div class="mdc-text-field-helper-line">
						  <div class="mdc-text-field-helper-text" id="my-helper-id" aria-hidden="true">Masukkan huruf(Aa-Zz)</div>
						  <div class="mdc-text-field-character-counter">0 / 50</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-4" style="margin-bottom: 10px; padding-left: 0px;">
					    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon @error('phone') mdc-text-field--invalid @enderror">
						  <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">phone</i>
						  <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id" name="phone" required onkeypress="return numOnly(event)" style="-moz-appearance : textfield;" maxlength="12" placeholder="8xxxxxxxxxxx" value="{{ $customer->phone }}">
						  <div class="mdc-notched-outline">
						   <div class="mdc-notched-outline__leading"></div>
						    <div class="mdc-notched-outline__notch">
						      <span class="mdc-floating-label" id="my-label-id">Nomor Telepon</span>
						    </div>
						    <div class="mdc-notched-outline__trailing"></div>
						  </div>
						</label>
						<div class="mdc-text-field-helper-line">
						  <div class="mdc-text-field-helper-text @error('phone','mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg') @enderror" id="my-helper-id" aria-hidden="true">@if ($errors->has('phone'))
						      	Nomor telepon harus diisi dengan benar
						    	@else
						      	Masukkan angka setelah +62
						    	@endif</div>
						  <div class="mdc-text-field-character-counter">0 / 12</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-6" style="margin-bottom: 10px; padding-left: 0px;">
					    @field
					    	
						    @slot('icon') mail_outline @endslot
						    @slot('type') email @endslot
						    @slot('onkey')  @endslot
						    @slot('name') email @endslot
						    @slot('req') true @endslot
						    @slot('maxl') 50 @endslot
						    @slot('max') 50 @endslot
						    @slot('value') {{ $customer->email }} @endslot
						    @slot('label') Email @endslot
						    @slot('err') @error('email') mdc-text-field--invalid @enderror @endslot
							@slot('help') 
								@if ($errors->has('email'))
						      	Email harus diisi dengan benar
						    	@else
						      	Masukkan email yang valid
						    	@endif
						    @endslot
						    @slot('err2') @error('email','mdc-text-field-helper-text--persistentmdc-text-field-helper-text--validation-msg') @enderror @endslot
						    @slot('char') 0 / 50 @endslot
					    @endfield
					</div>
				</div>
				<div class="row">
					<div class="col-12" style="margin-bottom: 10px; padding-left: 0px;">
					    @field
						    @slot('icon') my_location @endslot
						    @slot('type') text @endslot
						    @slot('onkey') @endslot
						    @slot('name') street @endslot
						    @slot('req') true @endslot
						    @slot('maxl') 100 @endslot
						    @slot('max') 100 @endslot
						    @slot('value') {{ $customer->street }} @endslot
						    @slot('label') Jalan @endslot
						    @slot('err') @error('street') mdc-text-field--invalid @enderror @endslot
							@slot('help') 
								@if ($errors->has('street'))
						      	Nama jalan harus diisi dengan benar
						    	@else
						      	Masukkan nama jalan
						    	@endif
						    @endslot
						    @slot('err2') @error('street','mdc-text-field-helper-text--persistent
						    mdc-text-field-helper-text--validation-msg') @enderror @endslot
						    @slot('char') 0 / 50 @endslot
					    @endfield
					</div>
				</div>
				<div class="row">
					<div class="col-5" style="margin-bottom: 10px; padding-left: 0px;">
					    @field
						    @slot('icon') location_city @endslot
						    @slot('type') text @endslot
						    @slot('onkey') return lettersOnlySpace(event) @endslot
						    @slot('name') city @endslot
						    @slot('req') true @endslot
						    @slot('maxl') 50 @endslot
						    @slot('max') 50 @endslot
						    @slot('value') {{ $customer->city }} @endslot
						    @slot('label') Nama Kota @endslot
						    @slot('err') @error('city') mdc-text-field--invalid @enderror @endslot
							@slot('help') 
								@if ($errors->has('city'))
						      	Nama kota harus diisi dengan benar(Aa-Zz)
						    	@else
						      	Masukkan nama kota
						    	@endif
						    @endslot
						    @slot('err2') @error('city','mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg') @enderror @endslot
						    @slot('char') 0 / 50 @endslot
					    @endfield
					</div>
					<div class="col-4" style="margin-bottom: 10px; padding-left: 0px;">
					    @field
					    	
						    @slot('icon') place @endslot
						    @slot('type') text @endslot
						    @slot('onkey') return lettersOnlySpace(event) @endslot
						    @slot('name') state @endslot
						    @slot('req') true @endslot
						    @slot('maxl') 50 @endslot
						    @slot('max') 50 @endslot
						    @slot('value') {{ $customer->state }} @endslot
						    @slot('label') Nama Provinsi @endslot
						    @slot('err') @error('state') mdc-text-field--invalid @enderror @endslot
							@slot('help') 
								@if ($errors->has('state'))
						      	Nama provinsi harus diisi dengan benar(Aa-Zz)
						    	@else
						      	Masukkan nama provinsi
						    	@endif
						    @endslot
						    @slot('err2') @error('state','mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg') @enderror @endslot
						    @slot('char') 0 / 50 @endslot
					    @endfield
					</div>
					<div class="col-3" style="margin-bottom: 10px; padding-left: 0px;">
					    @field
					    	
						    @slot('icon') map @endslot
						    @slot('type') text @endslot
						    @slot('onkey') return numberOnly(event) @endslot
						    @slot('name') zip_code @endslot
						    @slot('req') true @endslot
						    @slot('maxl') 5 @endslot
						    @slot('max') 5 @endslot
						    @slot('value') {{ $customer->zip_code }} @endslot
						    @slot('label') Kode Pos @endslot
						    @slot('err') @error('zip_code') mdc-text-field--invalid @enderror @endslot
							@slot('help') 
								@if ($errors->has('zip_code'))
						      	Kode pos harus diisi dengan benar
						    	@else
						      	Masukkan kode pos
						    	@endif
						    @endslot
						    @slot('err2') @error('zip_code','mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg') @enderror @endslot
						    @slot('char') 0 / 5 @endslot
					    @endfield
					</div>
				</div>

					<h6 class="m-10 font-italic text-danger">(*) Wajib diisi</h3>
					<button type="submit" class="btn btn-primary btn-block">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
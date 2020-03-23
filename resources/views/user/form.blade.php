@extends('inputmaster')
@section('Judul','Insert User')
@section('kontent')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		  		<h3 class="m-0 font-weight-bold text-primary">Tambahkan Data User</h3>
		    </div>
			<div class="card-body" style="margin: 10px; padding: 20px;">

				<form method="post" action="{{ route('user.store') }}" id="catForm">
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
						    @slot('value') @endslot
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
					<div class="col-6" style="margin-bottom: 10px;">
					    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon" style="width: 100%;">
						  <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">perm_identity</i>
						  <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id" name="last_name" onkeypress="return lettersOnly(event)" style="-moz-appearance : textfield;" maxlength="50">
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
					    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon @error('phone') mdc-text-field--invalid @enderror" style="width: 100%;">
						  <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">phone</i>
						  <input type="text" class="mdc-text-field__input" aria-labelledby="my-label-id" name="phone" required onkeypress="return numOnly(event)" style="-moz-appearance : textfield;" maxlength="12" placeholder="8xxxxxxxxxxx" minlength="10">
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
						      	Nomor Telepon harus diisi
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
						    @slot('value') @endslot
						    @slot('label') Email @endslot
						    @slot('err') 
						    	@error('email') mdc-text-field--invalid @enderror 
						    @endslot
							@slot('help') 
								@if ($errors->has('email'))
						      	Email harus diisi dengan benar
						    	@else
						      	Masukkan email yang valid
						    	@endif
						    @endslot
						    @slot('err2') @error('email','mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg') @enderror @endslot
						    @slot('char') 0 / 50 @endslot
					    @endfield
					</div>
				</div>
				<div class="row">
					<div class="col-4" style="margin-bottom: 10px; padding-left: 0px;">
					    @field
						    @slot('icon') my_location @endslot
						    @slot('type') password @endslot
						    @slot('onkey') @endslot
						    @slot('name') password @endslot
						    @slot('req') true @endslot
						    @slot('maxl') 8 @endslot
						    @slot('max') 8 @endslot
						    @slot('value') @endslot
						    @slot('label') Password @endslot
						    @slot('err') 
						    	@error('password') mdc-text-field--invalid @enderror 
						    @endslot
							@slot('help') 
								@if ($errors->has('password'))
						      	Password harus diisi
						    	@else
						      	Masukkan password
						    	@endif
						    @endslot
						    @slot('err2') @error('password','mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg') @enderror @endslot
						    @slot('char') 0 / 8 @endslot
					    @endfield
					</div>
				</div>
				<div class="row">
					<div class="col-5" style="margin-bottom: 10px; padding-left: 0px;">
					    @field
						    @slot('icon') location_city @endslot
						    @slot('type') text @endslot
						    @slot('onkey') return lettersOnlySpace(event) @endslot
						    @slot('name') job_status @endslot
						    @slot('req') true @endslot
						    @slot('maxl') 15 @endslot
						    @slot('max') 15 @endslot
						    @slot('value') @endslot
						    @slot('label') Job Status @endslot
						    @slot('err') 
						    	@error('job_status') mdc-text-field--invalid @enderror 
						    @endslot
							@slot('help') 
								@if ($errors->has('job_status'))
						      	Status harus diisi
						    	@else
						      	Masukkan status
						    	@endif
						    @endslot
						    @slot('err2') @error('job_status','mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg') @enderror @endslot
						    @slot('char') 0 / 15 @endslot
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
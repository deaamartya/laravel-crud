@extends('inputmaster')
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
						    @slot('help') Masukkan huruf(Aa-Zz) @endslot
						    @slot('char') 0 / 50 @endslot
					    @endfield
					</div>
					<div class="col-6" style="margin-bottom: 10px; padding-left: 0px;">
					    @field
					    	
						    @slot('icon') perm_identity @endslot
						    @slot('type') text @endslot
						    @slot('onkey') return lettersOnly(event) @endslot
						    @slot('name') last_name @endslot
						    @slot('req') true @endslot
						    @slot('maxl') 50 @endslot
						    @slot('max') 50 @endslot
						    @slot('value') {{ $customer->last_name }} @endslot
						    @slot('label') Nama Belakang @endslot
						    @slot('help') Masukkan huruf(Aa-Zz) @endslot
						    @slot('char') 0 / 50 @endslot
					    @endfield
					</div>
				</div>
				<div class="row">
					<div class="col-4" style="margin-bottom: 10px; padding-left: 0px;">
					    <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
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
						  <div class="mdc-text-field-helper-text" id="my-helper-id" aria-hidden="true">Masukkan angka setelah +62</div>
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
						    @slot('help') Masukkan email Anda @endslot
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
						    @slot('help') Masukkan nama jalan @endslot
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
						    @slot('help') Masukkan huruf(Aa-Zz) @endslot
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
						    @slot('help') Masukkan huruf(Aa-Zz) @endslot
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
						    @slot('help') Masukkan kode pos Anda @endslot
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
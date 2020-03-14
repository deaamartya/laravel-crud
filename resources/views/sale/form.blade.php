@extends('selectfield')
@section('kontent')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		  		<h3 class="m-0 font-weight-bold text-primary">Tambahkan Data Penjualan</h3>
		    </div>
			<div class="card-body" style="margin: 20px;">
				<form method="post" action="{{ route('sale.store') }}" id="catForm">
					@csrf
					<h6>Nama Customer*</h6>
					<div class="row" style="margin-bottom: 20px">
						<div class="col-9">
						<select class="selectpicker" data-live-search="true" name="customer_id" required>
								<option disabled="true" selected="">Pilih customer</option>
								@foreach($customers as $c)
								<option value="{{$c -> customer_id}}">{{$c -> first_name}} {{$c -> last_name}}</option>
								@endforeach
							</select>
							</div>
					</div>
					<h6>Nama User*</h6>
					<div class="row" style="margin-bottom: 20px">
						<div class="col-9">
						<select class="selectpicker" data-live-search="true" name="user_id" required>
								<option disabled="true" selected="">Pilih user</option>
								@foreach($users as $c)
								<option value="{{$c -> user_id}}">{{$c -> first_name}} {{$c -> last_name}}</option>
								@endforeach
							</select>
							</div>
					</div>
					<div class="row" style="margin-bottom: 10px">
						<div class="col-3">
						    <label class="mdc-text-field mdc-text-field--outlined" style="width: 100%;">
							  <input id="currency" type="text" class="mdc-text-field__input" aria-labelledby="my-label-id" name="total_payment" required onkeypress="return numOnly(event)" maxlength="16">
							  <div class="mdc-notched-outline">
							   <div class="mdc-notched-outline__leading"></div>
							    <div class="mdc-notched-outline__notch">
							      <span class="mdc-floating-label" id="my-label-id">Total Pembayaran</span>
							    </div>
							    <div class="mdc-notched-outline__trailing"></div>
							  </div>
							</label>
							<div class="mdc-text-field-helper-line">
							  <div class="mdc-text-field-helper-text" id="my-helper-id" aria-hidden="true">Masukkan harga (max. 10 angka)</div>
							</div>
							
						</div>
					</div>
					<div class="row" style="margin-bottom: 5px">
						<div class="col-3">
							@field
							    @slot('icon') calendar_today @endslot
							    @slot('type') date @endslot
							    @slot('onkey')  @endslot
							    @slot('name') nota_date @endslot
							    @slot('req') true @endslot
							    @slot('maxl')  @endslot
							    @slot('max')  @endslot
							    @slot('value')  @endslot
							    @slot('label') Tanggal Pembelian @endslot
							    @slot('help') Masukkan tanggal pembelian @endslot
							    @slot('char') @endslot
						    @endfield
						</div>
					</div>



					<h6 class="m-10 font-italic text-danger">(*) Wajib diisi</h6>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
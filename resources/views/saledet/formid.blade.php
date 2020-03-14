@extends('selectfield')
@section('tmbhstyle')
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: 100%;
}
.btn-light {
	height: 55px;
}
.btn{
	line-height:2;
}
@endsection
@section('kontent')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		  		<h3 class="m-0 font-weight-bold text-primary">Tambahkan Data Detail Penjualan</h3>
		    </div>
			<div class="card-body" style="margin: 20px;">
				<form method="post" action="/saledet/store/{{$nota_id}}" id="catForm">
					@csrf
					
					<h6>ID Penjualan*</h6>
					<div class="row" style="margin-bottom: 20px">
						<div class="col-9">
							@if($nota_id>0)
							<input type="text" name="nota_id" value="{{$nota_id}}" disabled>
							@else
							<select class="selectpicker" data-live-search="true" name="nota_id" required>
								<option disabled="true" selected="">Pilih nota</option>
								@foreach($sales as $c)
								<option value="{{$c -> nota_id}}">{{$c -> nota_id}}</option>
								@endforeach
							</select>
							@endif
						</div>
					</div>
					
					<h6>Nama Produk*</h6>
					<div class="row">
						<div class="col-6">
						<select class="selectpicker" data-live-search="true" name="product_id" required style="width: 100%;">
								<option disabled="true" selected="">Pilih produk</option>
								@foreach($products as $c)
								<option value="{{$c -> product_id}}">{{$c -> product_name}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-2">
						    <label class="mdc-text-field mdc-text-field--outlined" style="width: 100%;">
							  <input type="number" class="mdc-text-field__input" aria-labelledby="my-label-id" name="quantity" required onkeypress="return numOnly(event)" max="99" min="1" value="1">
							  <div class="mdc-notched-outline">
							   <div class="mdc-notched-outline__leading"></div>
							    <div class="mdc-notched-outline__notch">
							      <span class="mdc-floating-label" id="my-label-id">Jumlah</span>
							    </div>
							    <div class="mdc-notched-outline__trailing"></div>
							  </div>
							</label>
							<div class="mdc-text-field-helper-line">
							  <div class="mdc-text-field-helper-text" id="my-helper-id" aria-hidden="true">Masukkan jumlah (max. 10 angka)</div>
							</div>
						</div>
						<div class="col-4">
						    <label class="mdc-text-field mdc-text-field--outlined" style="width: 100%;">
							  <input id="currency" type="text" class="mdc-text-field__input" aria-labelledby="my-label-id" name="discount" required onkeypress="return numOnly(event)" maxlength="16" value="0">
							  <div class="mdc-notched-outline">
							   <div class="mdc-notched-outline__leading"></div>
							    <div class="mdc-notched-outline__notch">
							      <span class="mdc-floating-label" id="my-label-id">Discount</span>
							    </div>
							    <div class="mdc-notched-outline__trailing"></div>
							  </div>
							</label>
							<div class="mdc-text-field-helper-line">
							  <div class="mdc-text-field-helper-text" id="my-helper-id" aria-hidden="true">Masukkan diskon (max. 10 angka)</div>
							</div>
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
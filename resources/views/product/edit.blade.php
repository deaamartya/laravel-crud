@extends('selectfield')
@section('kontent')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		  		<h3 class="m-0 font-weight-bold text-primary">Tambahkan Data Produk</h3>
		    </div>
			<div class="card-body" style="margin: 20px;">
				<form method="post" action="{{ route('product.update', $product->product_id) }}" id="catForm">
					@METHOD('PUT')
					@csrf
					<h6>Nama Kategori Produk</h6>
					<div class="row" style="margin-bottom: 20px">
						<div class="col-9">
						<select class="selectpicker" data-live-search="true" name="category_id" required>
								<option disabled="true" selected="">Pilih kategori</option>
								@foreach($categories as $c)
									@if($c -> category_id == $product -> category_id)
										<option value="{{$c -> category_id}}" selected>{{$c -> category_name}}</option>
										@else
										<option value="{{$c -> category_id}}">{{$c -> category_name}}</option>
									@endif
									
								@endforeach
							</select>
							</div>
					</div>
					<div class="row" style="margin-bottom: 10px">
						<div class="col-6">
							@field
							    @slot('icon') perm_identity @endslot
							    @slot('type') text @endslot
							    @slot('onkey') return lettersOnlySpace(event) @endslot
							    @slot('name') product_name @endslot
							    @slot('req') true @endslot
							    @slot('maxl') 50 @endslot
							    @slot('max') 50 @endslot
							    @slot('value') {{$product->product_name}} @endslot
							    @slot('label') Nama Produk @endslot
							    @slot('help') Masukkan nama produk dengan huruf (Aa-Zz) @endslot
							    @slot('char') 0 / 50 @endslot
						    @endfield
						</div>
					</div>
					<div class="row" style="margin-bottom: 10px">
						<div class="col-3">
						    <label class="mdc-text-field mdc-text-field--outlined" style="width: 100%;">
							  <input id="currency" type="text" class="mdc-text-field__input" aria-labelledby="my-label-id" name="product_price" required onkeypress="return numOnly(event)" maxlength="16" value="{{$product->product_price}}">
							  <div class="mdc-notched-outline">
							   <div class="mdc-notched-outline__leading"></div>
							    <div class="mdc-notched-outline__notch">
							      <span class="mdc-floating-label" id="my-label-id">Harga Produk</span>
							    </div>
							    <div class="mdc-notched-outline__trailing"></div>
							  </div>
							</label>
							<div class="mdc-text-field-helper-line">
							  <div class="mdc-text-field-helper-text" id="my-helper-id" aria-hidden="true">Masukkan harga (max. 10 angka)</div>
							</div>
							
						</div>
					</div>
					<div class="row" style="margin-bottom: 10px">
						<div class="col-2">
							@field
							    @slot('icon') perm_identity @endslot
							    @slot('type') text @endslot
							    @slot('onkey') return numOnly(event) @endslot
							    @slot('name') product_stock @endslot
							    @slot('req') true @endslot
							    @slot('maxl') 3 @endslot
							    @slot('value') {{$product->product_stock}} @endslot
							    @slot('label') Stok Produk @endslot
							    @slot('help') Masukkan stok produk (0-999) @endslot
							    @slot('char') 0 / 50 @endslot
						    @endfield
						</div>
					</div>
					<div class="row" style="margin-bottom: 10px">
						<div class="col-9">
							<div class="mdc-text-field text-field mdc-text-field--textarea" style="width: 100%;">
								<div class="mdc-text-field-character-counter">0 / 100</div>

								<textarea class="mdc-text-field__input" maxlength="100" name="explanation" value="{{$product->explanation}}"></textarea>

								<div class="mdc-notched-outline mdc-notched-outline--upgraded">
									<div class="mdc-notched-outline__leading"></div>
									<div class="mdc-notched-outline__notch" style="">
										<label class="mdc-floating-label" for="textarea-2d" style="">Deskripsi</label>
									</div>
									<div class="mdc-notched-outline__trailing"></div>
								</div>
							</div>
							<div class="mdc-text-field-helper-line">
								<p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg" id="textarea-2d-helper-text">Deskripsikan produk ini</p>
							</div>
						</div>
					</div>
					<h6 class="m-10 font-italic text-danger">(*) Wajib diisi</h3>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
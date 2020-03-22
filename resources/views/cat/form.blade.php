@extends('inputmaster')
@section('kontent')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		  		<h3 class="m-0 font-weight-bold text-primary">Tambahkan Data Kategori</h3>
		    </div>
			<div class="card-body">
				<form method="post" action="{{ route('categories.store') }}" id="catForm">
					@csrf
					<div class="col-6" style="margin-bottom: 10px; padding-left: 0px;">
						@field
							@slot('err') @error('category_name') mdc-text-field--invalid @enderror @endslot
							@slot('help') 
								@if ($errors->has('category_name'))
						      	Nama kategori harus diisi dengan huruf(Aa-Zz)
						    	@else
						      	Masukkan huruf(Aa-Zz)
						    	@endif
						    @endslot
						    @slot('err2') @error('category_name','mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg') @enderror @endslot
						    @slot('icon') dns @endslot
						    @slot('type') text @endslot
						    @slot('onkey') return lettersOnlySpace(event) @endslot
						    @slot('name') category_name @endslot
						    @slot('maxl') 50 @endslot
						    @slot('max') 50 @endslot
						    @slot('value') @endslot
						    @slot('label') Nama Kategori @endslot
						    @slot('char') 0 / 50 @endslot
					    @endfield
					</div>
					<h6 class="m-10 font-italic text-danger">(*) Wajib diisi</h6>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
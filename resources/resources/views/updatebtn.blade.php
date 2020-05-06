<form action="{{ url('/categories/updateStatus/'.$id) }}" id="form{{$id}}" method="get">
	<div class="custom-control custom-switch">
		@if($status == 1)
		<input type="checkbox" class="custom-control-input switch" id="{{$id}}" checked>
		@else
		<input type="checkbox" class="custom-control-input switch" id="{{$id}}">
		@endif
		@if($status == 1)
		<label id="label{{$id}}" class="custom-control-label" for="{{$id}}">Nonaktifkan</label>
		@else
		<label id="label{{$id}}" class="custom-control-label" for="{{$id}}">Aktifkan</label>
		@endif
	</div>
</form>
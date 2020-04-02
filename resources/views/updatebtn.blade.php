<form id="switch{{$id}}" action="{{ url($dellink.'/updateStatus/'.$id) }}" method="post">
	@csrf
	<div class="custom-control custom-switch">
		@if($status == 1)
		<input type="checkbox" class="custom-control-input" id="c{{$id}}" onclick="submit({{$id}})" name="status{{$id}}" value="{{$status}}" checked>
		@else
		<input type="checkbox" class="custom-control-input" id="c{{$id}}" onclick="submit({{$id}})" name="status{{$id}}" value="{{$status}}">
		@endif
		@if($status == 1)
		<label class="custom-control-label" for="c{{$id}}">Nonaktifan</label>
		@else
		<label class="custom-control-label" for="c{{$id}}">Aktifkan</label>
		@endif
	</div>
</form>
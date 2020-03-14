<a href="{{route( $editlink , $id)}}" class="btn btn-warning btn-icon-split btn-sm">
        <span class="icon text-white-30">
          <i class="material-icons">edit</i>
        </span>
        <span class="text">Edit</span>
    </a>
<button class="btn btn-danger btn-icon-split btn-sm" type="button" data-toggle="modal" data-target=".deleteModal{{$id}}">
  <span class="icon text-white-30">
          <i class="material-icons">delete</i>
        </span>
        <span class="text">Delete</span>
</button>

<div class="modal fade deleteModal{{$id}}" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Hapus {{$Entity}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah anda yakin ingin menghapus {{$entity}} {{$name}} ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" style="padding: 2px 6px" data-dismiss="modal">Cancel</button>
      <form action="{{ route($dellink, $id) }}" method="post" style="width: 200px;">
      @csrf
      @method('DELETE')
        <button type="submit" class="btn btn-primary btn-sm" style="padding: 2px 6px">
          Ya
        </button>
    </form>
      </div>
    </div>
  </div>
  </div>
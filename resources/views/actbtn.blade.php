<a href="{{route( $editlink , $id)}}" class="btn btn-warning btn-icon-split btn-sm">
        <span class="icon text-white-30">
          <i class="material-icons">edit</i>
        </span>
        <span class="text">Edit</span>
</a>
<a href="{{ url($dellink.'/delete/'.$id) }}" class="btn btn-danger btn-icon-split btn-sm delete-confirm">
    <span class="icon text-white-30">
          <i class="material-icons">delete</i>
        </span>
    <span class="text">Delete</span>
</a>
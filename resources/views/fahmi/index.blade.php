@extends('master/customer/template')

@section('title','Halaman Customer')
@section('konten')

<div class="container">
   <div class="row">
      <div class="col-12">
  <h2 class ="mt-3">Data Customer</h2>
  
   <!-- Button trigger modal -->
<button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#exampleModal2">
Tambah Data Customer
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Insert Data Customer</font></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
  <form method="post" action="/customer/store">
      {{ csrf_field() }}
  <div class="form-row">
    <div class="col">
    <label for="first_name"><font size="4">First Name</font></label>
    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
     id="first_name" placeholder="First name " name="first_name" value="{{ old('first_name') }}">
     @error('first_name')
  <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
      @enderror
  </div>

    <div class="col">
    <label for="last_name"><font size="4">Last Name</font></label>
    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
     id="last_name" placeholder="Last name" name="last_name" value="{{ old('last_name') }}">
     @error('last_name')
  <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
      @enderror  
    </div>
  </div>
    <div class="form-group">
      <label for="phone"><font size="4">Phone</font></label>
      <input type="text" class="form-control @error('phone') is-invalid @enderror" 
      id="phone" placeholder="08xxxxxxxx
      " name="phone" value="{{ old('phone') }}">
      @error('phone')
    <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
        @enderror
    </div>

  <div class="form-group">
  
    <label for="email"><font size="4">Email</font></label>
    <input type="text" class="form-control @error('email') is-invalid @enderror" 
    id="email" placeholder="email@example.com" name="email" value="{{ old('email') }}">
    @error('email')
  <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
      @enderror
  </div>

  <div class="form-group">
    <label for="street"><font size="4">Street</font></label>
    <input type="text" class="form-control @error('street') is-invalid @enderror" 
    id="street" placeholder=" Jalan " name="street" value="{{ old('street') }}">
    @error('street')
  <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
      @enderror
  </div>
  
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="city"><font size="4">City</font></label>
        <input type="text" class="form-control @error('city') is-invalid @enderror" 
        id="city" name="city" placeholder="Kota" value="{{ old('city') }}">
        @error('city')
    <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="state"><font size="4">State</font></label>
        <select id="state" name="state" class="form-control @error('state') is-invalid @enderror"
        placeholder="Kota" value="{{ old('state') }}">
          <option disabled selected>Pilih Negara</option>
          <option>Indonesia</option>
          <option>Singapore</option>
          <option>Amerika</option>
          <option>Malaysia</option>
        </select>
        @error('state')
      <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
          @enderror
        </div>
          <div class="form-group col-md-4">
            <label for="zip_code"><font size="4">Zip Code</font></label>
            <input type="text" class="form-control @error('zip_code') is-invalid @enderror" id="zip_code" name="zip_code"
            placeholder="Kodepos" value="{{ old('zip_code') }}">
            @error('zip_code')
            <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
                @enderror
          </div>
      
      </div>
        </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-danger">Reset</button>
        <button type="submit" class="btn btn-success">Insert</button>
        </form>
      </div>
    </div>
  </div>
</div> 

    @if (session('status'))
    <font size="4"> 
      <div class="alert alert-success">
          {{ session ('status') }} 
      </div>
    </font>
    @endif
    
    @if (session('status2'))
    <font size="4">  
      <div class="alert alert-success">
      {{ session ('status2') }}
      </div>
    </font>
    @endif


  @if(session('status3'))
    <script>
      Swal.fire(
        'Delete Success!',
        "Customer {{ @session('status3') }} telah dihapus",
        'success'
      )
    </script>
  @endif

    <font size="2">
      <table class="table table-striped table-bordered mydatatable" style="width:100%;"> </font>
    <thead class="thead-dark">
    <tr>
    <th scope="col">#</th>
      <th scope="col">ID</th>
      <th scope="col">First_Name</th>
      <th scope="col">Last_Name</th>
      <th scope="col">Phone</th>
      <th scope="col">Email</th>
      <th scope="col">Street</th>
      <th scope="col">City</th>
      <th scope="col">State</th>
      <th scope="col">Zip_Code</th>
      <th width="90%" scope="col">Action</th>
    </tr>
  </thead>

  <tbody>
  @foreach($customer as $cus )
    <tr>
      <th scope="row"> {{ $loop->iteration }}</th>
      <td>{{ $cus->customer_Id }}</td>
      <td>{{ $cus->first_name }}</td>
      <td>{{ $cus->last_name }}</td>
      <td>{{ $cus->phone }}</td>
      <td>{{ $cus->email }}</td>
      <td>{{ $cus->street }}</td>
      <td>{{ $cus->city }}</td>
      <td>{{ $cus->state }}</td>
      <td>{{ $cus->zip_code }}</td>
      <td>
<!-- Button trigger modal -->
<button type="button" class="badge badge-success" data-toggle="modal" data-target="#editModal{{ $cus->customer_Id }}">
<svg class="bi bi-pencil" width="25px" height="25px" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M13.293 3.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM14 4l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"></path>
  <path fill-rule="evenodd" d="M14.146 8.354l-2.5-2.5.708-.708 2.5 2.5-.708.708zM5 12v.5a.5.5 0 00.5.5H6v.5a.5.5 0 00.5.5H7v.5a.5.5 0 00.5.5H8v-1.5a.5.5 0 00-.5-.5H7v-.5a.5.5 0 00-.5-.5H5z" clip-rule="evenodd"></path>
</svg>Edit
</button>

<!-- Modal -->
<div class="modal fade" id="editModal{{ $cus->customer_Id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Edit Data Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="/customer/update">
      {{ csrf_field() }}
     
      <input type="hidden" name="id" value="{{ $cus->customer_Id }}">
      <div class="form-row">
    <div class="col">
    <label for="first_name"><font size="4">First Name</font></label>
    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
     id="first_name" placeholder="First name " name="first_name"
     value="{{ $cus->first_name }}" required>
     @error('first_name')
  <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
      @enderror
  </div>

    <div class="col">
    <label for="last_name"><font size="4">Last Name</font></label>
    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
     id="last_name" placeholder="Last name" name="last_name" 
     value="{{ $cus->last_name }}" required>
     @error('last_name')
  <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
      @enderror  
    </div>
  </div>

  <div class="form-group mt-3">
    <label for="phone"><font size="4">Phone</font></label>
    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
    id="phone" placeholder="08xxxxxxxx
     " name="phone" value="{{ $cus->phone }}"  required>
    @error('phone')
  <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
      @enderror
  </div>

  <div class="form-group">
    <label for="email"><font size="4">Email</font></label>
    <input type="text" class="form-control @error('email') is-invalid @enderror" 
    id="email" placeholder="email@example.com" name="email" 
    value="{{ $cus->email }}" required>
    @error('email')
  <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
      @enderror
  </div>

  <div class="form-group">
    <label for="street"><font size="4">Street</font></label>
    <input type="text" class="form-control @error('street') is-invalid @enderror" 
    id="street" placeholder="Masukkan Jalan " name="street" 
    value="{{ $cus->street }}" required>
    @error('street')
  <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
      @enderror
  </div>


  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="city"><font size="4">City</font></label>
      <input type="text" class="form-control @error('city') is-invalid @enderror" 
      id="city" name="city" placeholder="Kota"
      value="{{ $cus->city }}"  required>
      @error('city')
  <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
      @enderror
    </div>
    <div class="form-group col-md-4">
      <label for="state"><font size="4">State</font></label>
      <select id="state" name="state" class="form-control @error('state') is-invalid @enderror"
       placeholder="Kota" value="{{ $cus->state }}"  required>
        <option selected>Indonesia</aoption>
        <option>Singapore</option>
        <option>Amerika</option>
        <option>Malaysia</option>
      </select>
      @error('state')
  <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
      @enderror
    </div>
    <div class="form-group col-md-4">
      <label for="zip_code"><font size="4">Zip_Code</font></label>
      <input type="text" class="form-control @error('zip_code') is-invalid @enderror" id="zip_code" name="zip_code"
      placeholder="Kodepos"
      value="{{ $cus->zip_code }}"  required>
      @error('zip_code')
  <div clas="invalid-feedback"><font color="red" size="2">{{ $message }}</font></div>
      @enderror
    </div>
  
      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-success">Update</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Back</button>
</form>
      </div>
    </div>
  </div>
</div>
          
        <!-- Button trigger modal -->
       
<button type="button" class="badge badge-danger" data-toggle="modal" 
data-target="#exampleModal{{$cus -> customer_Id}}"><svg class="bi bi-trash-fill" width="20px" height="20px" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M4.5 3a1 1 0 00-1 1v1a1 1 0 001 1H5v9a2 2 0 002 2h6a2 2 0 002-2V6h.5a1 1 0 001-1V4a1 1 0 00-1-1H12a1 1 0 00-1-1H9a1 1 0 00-1 1H4.5zm3 4a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7a.5.5 0 01.5-.5zM10 7a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7A.5.5 0 0110 7zm3 .5a.5.5 0 00-1 0v7a.5.5 0 001 0v-7z" clip-rule="evenodd"></path>
</svg>Delete</button>
        
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$cus -> customer_Id}}" tabindex="0" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Yakin Ingin Menghapus Data ?
      </div>
      <div class="modal-footer">
        <button type="button" class="badge badge-success">
        <a href="/customer/destroy/{{ $cus->customer_Id }}">
        <font size="2" color="white">Yes</font></a></button>
        <button type="button" class="badge badge-danger" data-dismiss="modal"><font size="2">No</font></button>
      </div>
    </div>
  </div>
</div> 
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
  
<div class="container">
      <div class="text-center text-muted"><font size="4">Copyright © 2020 - M.  Fahmi Aresha</font></div>
    </div>

      </div>
   </div>
  </div>
@endsection

<!-- @section('tambahscript')
<script>
     $('.mydatatable').DataTable();
</script> > -->
<!-- @endsection --> 
@extends('admin/admin')
@section('konten')

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        
           <!-- form start -->
              <form role="form">
                <h3> &nbsp;&nbsp;Form Category</h3>
                <form class="form-horizontal form-label-left" action="CategoriesStore" method="post">
                   {{ @csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputNama">Category ID<span class="required"> * </span></label>
                    <input class="form-control" id="exampleInputCategoryID" type="text" placeholder="Enter Category ID" name="categoriesid">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputCategoryName">Category Name<span class="required"> * </span></label>
                    <input class="form-control" id="exampleInputCategoryName"type="text" placeholder="Enter Category Name" name="categoriesname">
                  </div>

                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                      <label class="custom-control-label" for="exampleCheck1">I agree</a>.</label>
                    </div>
                    <br>
                    <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Cancel</button>
                	<input  type="submit" class="btn btn-primary"></button>
                  
                </div>
              </form>
            </div>
          </form>
        </div>
      </div>

    </div>
              
  </div>
</form>
</div>
@endsection
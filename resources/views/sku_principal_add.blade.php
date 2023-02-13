
 @extends('layouts.master')

 @section('title', 'Sku Principal')

 @section('navbar')


 @section('sidebar')


 @section('content')

 
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
        <h3 class="card-title" style="font-weight: bold;">ADD NEW SKU PRINCIPAL</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          
          <div class="row">

            <div class="col-md-3">
             <form action="{{ route('sku_principal_add.store') }}" method="POST">
               @csrf
                <div class="form-group">
                  <label>Sku Principal:</label>
                  <input type="text" class="form-control" required name="principal" autofocus>
                </div>
                <div class="form-group">
                  <label>Sku Contact Number:</label>
                  <input type="text" class="form-control" required name="contact_number">
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-success btn-flat btn-block">SAVE NEW PRINCIPAL</button>
                </div>
             </form>
            </div>
            <div class="col-md-9">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="text-align: center;">ID #</th>
                    <th style="text-align: center;">PRINCIPAL</th>
                    <th style="text-align: center;">CONTACT #</th>
                    <th style="text-align: center;">EDIT</th>
                    <th style="text-align: center;">DELETE</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($skuPrincipal as $principal)
                    <tr>
                      <td style="text-align: center">{{ $principal->id }}</td>
                      <td style="text-align: center">{{ $principal->principal }}</td>
                      <td style="text-align: center">{{ $principal->contact_number }}</td>
                      <td style="text-align: center">
                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal{{ $principal->id }}">
                         EDIT
                        </button>
                        
                        <div class="modal fade" id="exampleModal{{ $principal->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">EDIT PRINCIPAL INFORMATION</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                              </div>  
                              <form action="{{ route('sku_principal_add.update', $principal->id) }}" method="POST">
                               {{--  @method('PATCH') --}}
                                @csrf
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label class="float-left">Edit Principal Name:</label>
                                    <input type="text" value="{{ $principal->principal }}" required class="form-control" name="editPrincipal">
                                  </div>
                                  <div class="form-group">
                                    <label class="float-left">Edit Contact #:</label>
                                    <input type="text" value="{{ $principal->contact_number }}" required class="form-control" name="editContactNumber">
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-warning">Save changes</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td style="text-align: center">
                         <form action="{{ route('sku_principal_add.destroy', $principal->id)}}" method="post">
                            @csrf
                            <button class="btn btn-link" style="color:red;" type="submit">DELETE</button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
         
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->

 @endsection
@section('footer')
  @parent
<script>
   var hasSuccess = '<?php echo Session::has("success"); ?>';
   if(hasSuccess)
   {
      toastr.success('New Category Saved!')
   }

   var updateSuccess = '<?php echo Session::has("updateSuccess"); ?>';
   if(updateSuccess)
   {
      toastr.info('Category Information Updated!')
   }

   var deleteSuccess = '<?php echo Session::has("deleteSuccess"); ?>';
   if(deleteSuccess)
   {
      toastr.warning('Category Information Deleted!')
   }
</script>
</body>
</html>
@endsection


 @extends('layouts.master')

 @section('title', 'Personnel Description')

 @section('navbar')


 @section('sidebar')


 @section('content')

 
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
        <h3 class="card-title" style="font-weight: bold;">ADD NEW SKU CATEGORY</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
        {{-- <div id="app">
            @include('flashMessage')


            @yield('content')
        </div> --}}
        
          <div class="row">
            <div class="col-md-4">
              <form action="{{ route('personnel_description_save.save') }}" method="post">
                @csrf
                <div class="form-group">
                  <label>Personnel Description:</label>
                  <input type="text" class="form-control" autofocus required name="personnel_description">
                </div>
                <div class="form-group">
                   <button type="submit" class="btn btn-success btn-flat btn-block">SAVE PERSONNEL DESCRIPTION</button>
                </div>
              </form>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label>DATA</label>  
                 <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID #</th>
                        <th>DESCRIPTION</th>
                        <th>CREATED AT</th>
                        <th>UPDATED AT</th>
                        <th>UPDATE</th>
                        <th>DELETE</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($personnel_description_data as $data)
                        <tr>
                          <td>{{ $data->id }}</td>
                          <td style="text-transform: uppercase;">{{ $data->personnel_description }}</td>
                          <td>{{ $data->created_at }}</td>
                          <td>{{ $data->updated_at }}</td>
                          <td>
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal{{ $data->id }}">
                              EDIT
                              </button>
                              <!-- Modal -->
                              <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">EDIT PERSONNEL DESCRIPTION INFORMATION</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <form action="{{ route('personnel_description_edit.edit', $data->id) }}" method="POST">
                                      {{-- @method('PATCH') --}}
                                      @csrf
                                      <div class="modal-body">
                            
                                          <div class="form-group">
                                            <label>Edit Personnel Description:</label>
                                            <input type="text" class="form-control" required name="edit_personnel_description" value="{{ $data->personnel_description }}">
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
                          <td>
                            <form action="{{ route('personnel_description_edit.destroy', $data->id)}}" method="post">
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
      toastr.success('NEW PERSONNEL DESCRIPTION SAVED')
   }

   var updateSuccess = '<?php echo Session::has("updateSuccess"); ?>';
   if(updateSuccess)
   {
      toastr.info('PERSONNEL DESCRIPTION UPDATED')
   }

   var deleteSuccess = '<?php echo Session::has("deleteSuccess"); ?>';
   if(deleteSuccess)
   {
      toastr.warning('PERSONNEL DESCRIPTION DELETED')
   }
</script>
</body>
</html>
@endsection

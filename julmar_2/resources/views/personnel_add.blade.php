@extends('layouts.master')
@section('title', 'Personnel Add')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">ADD NEW PERSONNEL</h3>
    </div>
    <div class="card-body">
      <form id="personnel_save" method="post">
        @csrf
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Principal:</label>
              <select name="principal_id[]" class="form-control select2" multiple="multiple" style="width:100%;" required>
                <option value="" default>Select Principal</option>
                @foreach($principals as $principal)
                <option value="{{ $principal->id }}">{{ $principal->principal }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Personnel Description</label>
              <select name="personnel_description_id" class="form-control select2" style="width:100%;" required>
                <option value="" default>Select Personnel Description</option>
                @foreach($personnel_descriptions as $data)
                <option value="{{ $data->id }}">{{ $data->personnel_description }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Full Name:</label>
              <input type="text" class="form-control" name="full_name" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Contact Number:</label>
              <input type="number" class="form-control" name="contact_number" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Gender</label>
              <select name="gender" class="form-control select2" style="width:100%;">
                <option value="" default>Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>&nbsp;</label>
              <input type="submit" value="SAVE NEW PERSONNEL" class="btn btn-success btn-flat btn-block" />
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
     <div class="table table-responsive">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>ID #</th>
            <th>DESCRIPTION</th>
            <th>PRINCIPAL</th>
            <th>FULL NAME</th>
            <th>CONTACT NUMBER</th>
            <th>GENDER</th>
            <th>EDIT</th>
            <th>DELETE</th>
          </tr>
        </thead>
        <tbody>
          @foreach($personnels as $data)
            <tr>
              <td>{{ $data->id }}</td>
              <td>{{ $data->personnel_description->personnel_description }}</td>
              <td>
            
                @foreach($data->personnel_details as $data_principal)
                  {{ $data_principal->principal->principal ."," }}
                @endforeach
              </td>
              <td>{{ $data->full_name }}</td>
              <td>{{ $data->contact_number }}</td>
              <td>{{ $data->gender }}</td>
              <td style="font-weight: bold;color:red;">WALA PA</td>
              {{-- <td style="text-align:center">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal{{ $data->id }}">
                EDIT
                </button>
                <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">EDIT PERSONNEL INFORMATION</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="{{ route('personnel_add_edit.edit', $data->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                          <div class="form-group">
                            <input type="hidden" value="{{ $data->principal_id }}" name="principal_id">
                            <input type="hidden" value="{{ $data->personnel_description_id }}" name="personnel_description_id">
                            <label>Edit Full Name:</label>
                            <input type="text" class="form-control" required name="edit_full_name" value="{{ $data->full_name }}">
                          </div>
                          <div class="form-group">
                            <label>Edit Contact Number:</label>
                            <input type="text" class="form-control" required name="edit_contact_number" value="{{ $data->contact_number }}">
                          </div>
                          <div class="form-group">
                            <label>Edit Gender:</label>
                            <input type="text" class="form-control" required name="edit_gender" value="{{ $data->gender }}">
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
              </td> --}}
               <td style="text-align:center">
              <form action="{{ route('personnel_add_destroy.destroy', $data->id)}}" method="post">
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
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@section('footer')
@parent
<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

var hasSuccess = '<?php echo Session::has("success"); ?>';
if(hasSuccess)
{
toastr.success('NEW PERSONNEL SAVED')
}
var updateSuccess = '<?php echo Session::has("updateSuccess"); ?>';
if(updateSuccess)
{
toastr.info('PERSONNEL INFORMATION EDITED')
}
var deleteSuccess = '<?php echo Session::has("deleteSuccess"); ?>';
if(deleteSuccess)
{
toastr.warning('PERSONNEL INFORMATION DELETED')
}


$("#personnel_save").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "personnel_add_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            if(data == 'saved'){
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
              })
              location.reload();
              $('.loading').hide();
            }else{
              Swal.fire(
              'Something went wrong!',
              'Redo process or contact system administrator',
              'error'
              )
              $('.loading').hide();
            }
          },
      });
    }));
</script>
</body>
</html>
@endsection
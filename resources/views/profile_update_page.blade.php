@extends('layouts.master')
@section('title', 'Profile Update')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">PROFILE UPDATE</h3>
    </div>
    <div class="card-body">
      <form id="submit_secret_key" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Position:</label>
              <select class="form-control select2" name="position" style="width:100%;" required>
                <option value="{{ $employee_name->position }}" selected>{{ $employee_name->position }}</option>
                <option value="Operations_manager">Operations Manager</option>
                <option value="Inventory_head">Inventory Head</option>
                <option value="Encoder_head">Encoder Head</option>
                <option value="Audit_head">Audit Head</option>
                <option value="Accounting_staff">Accounting Staff</option>
                <option value="Inventory_staff">Inventory Staff</option>
                <option value="Audit_staff">Audit Staff</option>
                <option value="Admin_staff">Admin Staff</option>
                <option value="Encoder">Encoder</option>
                <option value="Admin">Admin</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Secret Key:</label>
              <input type="password" name="secret_key" class="form-control" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>System Admin/OM/Audit Head Permission Key:</label>
              <input type="password" name="admin_permission_key" class="form-control" required>
            </div>
          </div>
          <div class="col-md-12">
            <button class="btn btn-success btn-block" type="submit">SUBMIT SECRET KEY</button>
          </div>
        </div>
      </form>
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

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });



  $("#submit_secret_key").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
       
        $.ajax({
          url: "profile_update_submit_secret_key",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            if(data == 'incorrect_secret_key'){
              Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Unkown or Incorrect Secret Key',
                showConfirmButton: false,
                timer: 1500
              })
              $('.loading').hide(); 
            }else{
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
              })
              location.reload();
            }
          },
        });
    }));







</script>
</body>
</html>
@endsection
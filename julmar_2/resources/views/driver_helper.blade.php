@extends('layouts.master')
@section('title', 'Driver Helper')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">ADD NEW DRIVER/HELPER</h3>
    </div>
    <div class="card-body">
      <form id="driver_helper_saved">
        <div class="row">
          <div class="col-md-3">
            <label>Full Name:</label>
            <input type="text" name="full_name" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label>Work Description:</label>
            <select required style="width:100%;" class="form-control select2" name="work_description">
              <option value="" default>Select</option>
              <option value="Driver">Driver</option>
              <option value="Helper">Helper</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>Truck Unit #:</label>
            <input type="text" name="truck_unit_number" class="form-control" required> 
          </div>
          <div class="col-md-3">
            <label>Contact #:</label>
            <input type="text" name="contact_number" class="form-control" required> 
          </div>
          <div class="col-md-6">
            <label>Full Address:</label>
            <input type="text" name="full_address" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-success btn-block">SUBMIT NEW DRIVER / HELPER</button>
          </div> 
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
     <div class="row">
       <div class="table table-responsive">
         <table class="table table-bordered table-hover">
           <thead>
             <tr>
               <th>FULL NAME</th>
               <th>CONTACT #</th>
               <th>ADDRESS</th>
               <th>WORK DESCRIPTION</th>
               <th>TRUCK UNIT #</th>
               <th>ADDED BY:</th>
               <th>CHARGES</th>
             </tr>
           </thead>
           <tbody>
             @foreach($driver_helper as $data)
              <tr>
                <td>{{ $data->full_name }}</td>
                <td>{{ $data->contact_number }}</td>
                <td>{{ $data->full_address }}</td>
                <td>{{ $data->work_description }}</td>
                <td>{{ $data->truck_unit_number }}</td>
                <td style="text-transform: uppercase;">{{ $data->user->name }}</td>
                <td><span style="color:red;">CHARGES</span></td>
              </tr>
             @endforeach
           </tbody>
         </table>
       </div>
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

$("#driver_helper_saved").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "driver_helper_saved",
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
                title: 'New Driver/Helper saved!',
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
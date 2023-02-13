@extends('layouts.master')
@section('title', 'CUSTOMER EXPORT')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">CUSTOMER EXPORT</h3>
    </div>
    <div class="card-body">
      <form id="customer_agent_export" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Location:</label>
              <select class="form-control select2" name="location_id" style="width:100%;" required>
                <option value="" default>Select</option>
                @foreach($location as $data)
                  <option value="{{ $data->id }}">{{ $data->location}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <input type="submit" value="EXPORT" id="upload_agent_sales_order" class="btn btn-block btn-info" />
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <div id="customer_agent_export_page"></div>
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


  $("#customer_agent_export").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "customer_agent_export",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
              
            $('.loading').hide();
            $('#customer_agent_export_page').html(data); 
            // if(data = "existing_file"){
            //    Swal.fire(
            //     'Existing file, Cannot Proceed!!',
            //     '',
            //     'error'
            //   )
            //   $('.loading').hide(); 
            // }else if(data = 'incorrect_file'){
            //   Swal.fire(
            //     'Incorrect_file, Cannot Proceed!!',
            //     '',
            //     'error'
            //   )
            //   $('.loading').hide(); 
            // }else if(data = "saved"){
            //    Swal.fire(
            //     'Data Uploaded Successfully',
            //     'Success',
            //     'success'
            //   )
            //   $('.loading').hide();
            //   location.reload();
            // }else{
            //   Swal.fire(
            //     'Incorrect_file, Cannot Proceed!!',
            //     '',
            //     'error'
            //   )
            //   $('.loading').hide(); 
            // }
          },
        });
    }));







</script>
</body>
</html>
@endsection
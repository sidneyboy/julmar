@extends('layouts.master')
@section('title', 'Sales Order Report')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">SALES ORDER REPORT</h3>
    </div>
    <div class="card-body">
      <form id="sales_order_report_generate_data">
        @csrf
        <div class="row">
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div>
              <input type="text" class="form-control float-right" id="reservation" name="date_range" required>
            </div>
          </div>
          <div class="col-md-4">
            <select class="form-control select2" name="agent_id" required style="width:100%;">
              <option value="" default>SELECT AGENT</option>
              @foreach($agent as $data)
              <option value="{{ $data->id }}">{{ $data->full_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <select class="form-control select2" name="principal_id" required style="width:100%;">
              <option value="" default>SELECT PRINCIPAL</option>
              @foreach($principal as $data)
              <option value="{{ $data->id }}">{{ $data->principal }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-12">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-info btn-block">GENERATE REPORT</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="sales_order_report_generate_data_page"></div>
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


  $("#sales_order_report_generate_data").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
       
        $.ajax({
          url: "sales_order_report_generate_data",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){

            $('#sales_order_report_generate_data_page').html(data);

            // if(data == 'file_already_uploaded'){
            //   Swal.fire(
            //   'ERROR INPUT',
            //   'FILE ALREADY UPLOADED',
            //   'error'
            //   )
            //   $('.loading').hide(); 
            // }else if(data == 'incorrect_file_uploaded'){
            //   Swal.fire(
            //   'ERROR INPUT',
            //   'INCORRECT FILE UPLOADED',
            //   'error'
            //   )
            //   $('.loading').hide(); 
            // }else{
            //   $('.loading').hide(); 
            //   $('#sales_order_upload_page').html(data);
            // }
          },
        });
    }));







</script>
</body>
</html>
@endsection
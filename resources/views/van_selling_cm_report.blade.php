@extends('layouts.master')
@section('title', 'VS CM REPORT')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">VAN SELLING CM REPORT</h3>
    </div>
    <div class="card-body">
      <form id="van_selling_cm_report_generate" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
          <div class="col-md-12">
            <label>Date Range:</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div>
              <input type="text" class="form-control float-right" name="date_range" id="reservation">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>&nbsp;</label>
              
              <input type="submit" value="GENERATE DATA" id="upload_agent_sales_order" class="btn btn-block btn-info" />
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="van_selling_cm_report_generate_page"></div>
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


  $("#van_selling_cm_report_generate").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "van_selling_cm_report_generate",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            if (data == 'no_data_found') {
              $('.loading').hide();
              Swal.fire(
                'No Data Found!!',
                'Cannot Proceed!',
                'error'
              )
            }else{
              $('.loading').hide();
              $('#van_selling_cm_report_generate_page').html(data);
            }
          },
        });
    }));







</script>
</body>
</html>
@endsection
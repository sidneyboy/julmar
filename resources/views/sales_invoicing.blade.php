@extends('layouts.master')
@section('title', 'Sales Invoicing')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">SALES INVOICING</h3>
    </div>
    <div class="card-body">
      <form id="generate_dr_form" enctype="multipart/form-data" method="post">
        @csrf
       <div class="row">
          <div class="col-md-12">
            <label>DR NUMBER:</label>
            <input type="text" name="input" class="form-control" required>
          </div> 
          <div class="col-md-12">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-info btn-block">GENERATE DR </button>
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

   <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">Generated Summary</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div id="sales_invoicing_generate_dr"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
       
    </div>
    <!-- /.card-footer-->
  </div>
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


  $("#generate_dr_form").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
       // $('#sales_order_migrate_summary_page').show();
        $.ajax({
          url: "sales_invoicing_generate_dr",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);

            $('#sales_invoicing_generate_dr').html(data);
            // if(data == 'existing sales_order_number'){
            //    Swal.fire(
            //   'Existing Sales Order Number, Cannot Proceed!!',
            //   '',
            //   'error'
            //   )
            //   $('.loading').hide(); 
            // }else{
            //   $('.loading').hide();

            //   $('#sales_order_migrate_summary_page').html(data);
            // }
          },
        });
    }));







</script>
</body>
</html>
@endsection
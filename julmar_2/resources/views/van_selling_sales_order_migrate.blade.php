@extends('layouts.master')
@section('title', 'Van Selling SO')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">VAN SELLLING SALES ORDER</h3>
    </div>
    <div class="card-body">
      <form id="van_selling_upload_form" enctype="multipart/form-data" method="post">
        @csrf
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputFile">File input</label>
              <input type="file" name="agent_csv_file" required class="form-control">
              {{-- <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="exampleInputFile">
                  <label class="custom-file-label" name="file" for="exampleInputFile">Choose file</label>
                </div>
              </div> --}}
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <input type="submit" value="UPLOAD AGENT SALES ORDER" id="upload_agent_sales_order" class="btn btn-block btn-success" />
            </div>
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
            <div id="van_selling_sales_order_migrate_summary_page"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
       
    </div>
    <!-- /.card-footer-->
  </div>

  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">Calculated Summary</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div id="van_selling_sales_order_migrate_summary_page"></div>
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


  
     


  $("#van_selling_upload_form").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
      
        $.ajax({
          url: "van_selling_sales_order_upload",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            
            if(data == 'existing sales_order_number'){
               Swal.fire(
              'Existing Sales Order Number, Cannot Proceed!!',
              '',
              'error'
              )
              $('.loading').hide(); 
            }else{
              $('.loading').hide();

              $('#van_selling_sales_order_migrate_summary_page').html(data);
            }
          },
        });
    }));







</script>
</body>
</html>
@endsection
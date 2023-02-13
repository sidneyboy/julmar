@extends('layouts.master')
@section('title', 'Sales Control')
@section('navbar')
@section('sidebar')
@section('content')
<br />
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">SALES CONTROL</h3>
    </div>
    <div class="card-body">
      <form id="sales_control_proceed">
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
            <select class="form-control select2" style="width:100%;" required name="agent_id">
              <option value="" default>SELECT AGENT</option>
              @foreach($agent as $data)
                <option value="{{ $data->id }}">{{ $data->full_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <select class="form-control select2" style="width:100%;" required name="sku_type">
              <option value="" default>SELECT SKU TYPE</option>
              <option value="Case">Case</option>
              <option value="Butal">Butal</option>
            </select>
          </div>
          <div class="col-md-12">
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-info btn-block">GENERATE AGENT SALES CONTROL</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div id="sales_control_proceed_page"></div>
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
  


  $("#sales_control_proceed").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
       
        $.ajax({
          url: "sales_control_proceed",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){


            console.log(data);
             
            if(data == 'no_data_found'){
              Swal.fire(
              'ERROR INPUT',
              'NO DATA FOUND',
              'error'
              )
              $('#sales_control_proceed_page').hide();
              $('.loading').hide(); 
            }else{
              $('.loading').hide(); 
              $('#sales_control_proceed_page').html(data);
            }

          },
        });
    }));







</script>
</body>
</html>
@endsection


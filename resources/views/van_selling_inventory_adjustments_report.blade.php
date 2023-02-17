@extends('layouts.master')
@section('title', 'VS INV ADJ REPORT')
@section('navbar')
@section('sidebar')
@section('content')
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="font-weight: bold;">VS INVENTORY ADJUSTMENTS REPORT</h3>
    </div>
    <div class="card-body">
      <form id="van_selling_inventory_adjustments_report_generate_data">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>SALESMAN:</label>
              <select class="form-control select2bs4" name="customer" style="width:100%;" required>
                <option value="" default>SELECT SALESMAN</option>
                @foreach($customer as $data)
                  <option value="{{ $data->id ."-". $data->store_name  }}">{{ $data->store_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <label>Date Range:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control float-right" id="reservation" name="date_range" required>
                </div>
          </div>
          <div class="col-md-12">
            <div id="van_selling_report_show_input_page"></div>
          </div>
          <div class="col-md-12">
            <label>&nbsp;</label>
            <button type="submit" id="generate" class="btn btn-info btn-sm float-right">Generate</button>
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
      <h3 class="card-title" style="font-weight: bold;">REPORT DATA</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div id="van_selling_inventory_adjustments_report_generate_data_page"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div class="row">
        <div class="col-md-12">
          <div id="van_selling_report_date_range_itemized_page"></div>
        </div>
      </div>
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

  $("#van_selling_inventory_adjustments_report_generate_data").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "van_selling_inventory_adjustments_report_generate_data",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
             if (data == 'no_data_found') {
              Swal.fire(
                'NO DATA FOUND!',
                'CANNOT PROCEED!',
                'error'
              )
              $('.loading').hide();
             }else{
              $('#van_selling_inventory_adjustments_report_generate_data_page').html(data);
              $('#van_selling_report_date_range_itemized_page').hide();
              $('.loading').hide();
             }
            
          },
        });
    }));

</script>
</body>
</html>
@endsection
 @extends('layouts.master')

 @section('title', 'SO Converted Report')

 @section('navbar')


 @section('sidebar')


 @section('content')
  
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">SALES ORDER CONVERTED REPORT</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <form id="generate_date_form_for_sales_order_report">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Date Range</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" name="date_range" id="reservation">
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Select Salesman</label>
                  <select class="form-control select2" name="agent_id" style="width:100%;">
                    <option value="" default>Select</option>
                    @foreach($select_all_agent_from_personnel as $data)
                    <option value="{{ $data->id ."-". $data->full_name }}">{{ $data->full_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <button type="submit" class="btn btn-info btn-block">GENERATE DATA</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <div id="sales_order_converted_report_show_generate_page"></div>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

       <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">DETAILED REPORT</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
           <div id="sales_order_converted_report_show_dr"></div>
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
  
  


  $("#generate_date_form_for_sales_order_report").on('submit',(function(e){
      e.preventDefault();
       $('.loading').show();
     
        $.ajax({
          url: "sales_order_converted_report_generate_data",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            $('.loading').hide();
            $('#sales_order_converted_report_show_generate_page').html(data);
          },
        });
    }));



</script>
</body>
</html>
@endsection

























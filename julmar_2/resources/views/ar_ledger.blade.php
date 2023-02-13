 @extends('layouts.master')

 @section('title', 'Customer Payment')

 @section('navbar')


 @section('sidebar')


 @section('content')
  
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">AR LEDGER</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
        <form id="ar_ledger_generate_data">
            @csrf
            <div class="row">
              <div class="col-md-4">
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
              <div class="col-md-4">
                <label>Agent</label>
                <select class="form-control select2" name="agent_id" style="width:100%;" id="agent_id">
                  <option value="" default>SELECT</option>
                  @foreach($agent as $data)  
                    <option value="{{ $data->id }}">{{ $data->full_name }}</option>
                  @endforeach
                </select> 
              </div>
              <div class="col-md-4">
                <label>Select Report</label>
                <select class="form-control select2" name="select_report" style="width:100%;" id="select_report">
                  <option value="" default>SELECT</option>
                  <option value="AR_LEDGER_PER_DR">AR_LEDGER_PER_DR</option> 
                  <option value="AR_LEDGER_PER_CUSTOMER">AR_LEDGER_PER_CUSTOMER</option> 
                  <option value="AR_CONTROL">AR_CONTROL</option> 
                </select> 
              </div>
              <div class="col-md-12">
                <div id="ar_ledger_select_report_page"></div>
              </div>
              <div class="col-md-12">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-info btn-block">GENERATE DATA</button>
              </div>
            </div>
          </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
         <div id="ar_ledger_generate_data_page"></div>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

      <!-- Default box -->
     
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

 $("#ar_ledger_generate_data").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "ar_ledger_generate_data",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            
            console.log(data);
            if(data == 'NO_DR'){
              Swal.fire(
              'NO DATA FOUND',
              'NO DELIVERY RECEIPT',
              'error'
              )
              $('.loading').hide(); 
            }else if(data == 'NO_DATA_FOUND'){
              Swal.fire(
              'NO DATA FOUND',
              'FOR THIS CUSTOMER',
              'error'
              )
              $('.loading').hide(); 
            }else{
              $('.loading').hide();
              $('#ar_ledger_generate_data_page').html(data);
            }
          },
        });
    }));

  $("#select_report" ).change(function() {
     var select_report = $(this).val(); 
     var agent_id = $('#agent_id').val(); 
     //$('.loading').show();       
      $.post({
      type: "POST",
      url: "/ar_ledger_select_report",
      data: 'select_report=' + select_report + '&agent_id=' + agent_id,
      success: function(data){

      //console.log(data);
      $('.loading').hide();
      $('#ar_ledger_select_report_page').html(data);

      },
      error: function(error){
        console.log(error);
      }
    });
  });




</script>
</body>
</html>
@endsection

























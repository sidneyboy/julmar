 @extends('layouts.master')

 @section('title', 'VS')

 @section('navbar')


 @section('sidebar')


 @section('content')
  
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">VAN AR LEDGER</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
        <form id="van_selling_ledger_generate">
            @csrf
            <div class="row">
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
              <div class="col-md-6">
                <label>Select Agent:</label>
                <select class="form-control select2" name="customer_id" style="width:100%;" id="customer_id">
                  <option value="" default>SELECT</option>
                  @foreach($customer as $data)  
                    <option value="{{ $data->id }}">{{ $data->store_name }}</option>
                  @endforeach
                </select> 
              </div>
              <div class="col-md-12">
                <label>&nbsp;</label>
                <button type="submit" id="generate_data" class="btn btn-info btn-block">GENERATE DATA</button>
              </div>
            </div>
          </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
         <div id="van_selling_ledger_generate_page"></div>
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

 $("#van_selling_ledger_generate").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "van_selling_ledger_generate",
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
              $('#van_selling_ledger_generate_page').html(data);
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

























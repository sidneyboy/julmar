 @extends('layouts.master')
 @section('title', 'Bo Allowance Total')
 @section('navbar')
 @section('sidebar')


 @section('content')
  
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">BO ALLOWANCE TOTAL</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
         
          <form id="bo_allowance_total_generate">
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
                      <input type="text" class="form-control float-right" id="reservation" name="date_range">
                    </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                   <label>Select Principal:</label>
                    <select class="form-control" name="principal" style="width:100%;">
                      <option value="" default>Select Principal</option>
                      @foreach ($principals as $principal)
                        <option value="{{ $principal->id}}">{{ $principal->principal }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                   <label>Remarks</label>
                   <input type="text" name="remarks" required class="form-control">
                  </div>
                </div>
              </div>
          </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button type="submit" class="btn btn-info btn-sm float-right">Generate</button><br />
          <div id="bo_allowance_total_generate_page"></div>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">BO ALLOWANCE TOTAL</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <div id="bo_allowance_total_proceed_to_final_summary_page"></div>
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
  
  // $("#received_id" ).change(function() {
  //    var received_id = $(this).val(); 
  //    $('.loading').show();       
  //     $.post({
  //     type: "POST",
  //     url: "/bo_allowance_adjustments_inputs",
  //     data: 'received_id=' + received_id,
  //     success: function(data){

  //     //console.log(data);
  //     $('.loading').hide();
  //     $('#show_bo_allowance_adjustments').html(data);

  //     },
  //     error: function(error){
  //       console.log(error);
  //     }
  //   });
  // });




  $("#bo_allowance_total_generate").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
       //$('#sales_order_migrate_summary_page').show();
        $.ajax({
          url: "bo_allowance_total_generate_page",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){

            $('#bo_allowance_total_generate_page').html(data);
            
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

























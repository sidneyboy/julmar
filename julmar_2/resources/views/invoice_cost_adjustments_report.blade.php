 @extends('layouts.master')

 @section('title', 'Cost Adjustment Report')

 @section('navbar')


 @section('sidebar')


 @section('content')
  
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">COST ADJUSTMENT REPORT</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
              <div class="col-md-6">
                 <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" id="reservation">
                  </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <select class="form-control select2" id="principal" style="width:100%;">
                    <option value="" default>Select Principal</option>
                    @foreach ($principals as $principal)
                      <option value="{{ $principal->id ."=". $principal->principal}}">{{ $principal->principal }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button class="btn btn-block btn-success" id="generate" style="border-radius: 0px;">GENERATE REPORT</button>
              </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">LIST</h3>
        </div>
        <div class="card-body">
          <div id="show_report_list"></div>
        </div>
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
  
   var hasSuccess = '<?php echo Session::has("success"); ?>';
   if(hasSuccess)
   {
      toastr.success('New Sku Information Saved!')
   }

   var deleteSuccess = '<?php echo Session::has("deleteSuccess"); ?>';
   if(deleteSuccess)
   {
      toastr.warning('Sku Information Deleted!')
   }

     $('#generate').on('click',function(e){
                var date = $('#reservation').val();
                var principal = $('#principal').val();
                $.post({
                  type: "POST",
                  url: "/invoice_cost_adjustments_report_show_list",
                  data: 'date=' + date + '&principal=' + principal,
                  success: function(data){

                    console.log(data);
                    $('#show_report_list').html(data);

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

























 @extends('layouts.master')

 @section('title', 'Insert Invoice Image')

 @section('navbar')


 @section('sidebar')


 @section('content')
  
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">Insert Principal Invoice Image</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
       	  <div class="form-group">
            <label>DR #</label>
            <select name="received_id" id="received_id" class="form-control select2" style="width:100%;">
              <option value="" default>Select DR</option>
              @foreach ($received as $data)
                <option value="{{ $data->id }}">{{ "RR - ". $data->id ." | ". $data->dr_si }}</option>
              @endforeach
            </select>
          </div>
          <div id="show_inputs"></div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <div id="show_final_summary"></div>
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
  
  $("#received_id" ).change(function() {
    $('.loading').show();
     var received_id = $(this).val();        
      $.post({
      type: "POST",
      url: "received_invoice_show_inputs",
      data: 'received_id=' + received_id,
      success: function(data){

        $('.loading').hide();
        $('#show_inputs').html(data);

      },
      error: function(error){
        console.log(error);
      }
    });
  });

   var hasSuccess = '<?php echo Session::has("success"); ?>';
   if(hasSuccess)
   {
      toastr.success('NEW INVOICE IMAGE SUCCESSFULLY UPLOADED')

   }

   var deleteSuccess = '<?php echo Session::has("error"); ?>';
   if(deleteSuccess)
   {
      toastr.danger('SOMETHING WENT WRONG, PLEASE REDO PROCESS')
   }

  var notification = '<?php echo Session::has("notification"); ?>';
   if(notification)
   {
      toastr.warning('PLEASE SELECT RR FIRST THANK YOU!')
   }

</script>
</body>
</html>
@endsection

























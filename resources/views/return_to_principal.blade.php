 @extends('layouts.master')

 @section('title', 'Return To Principal')

 @section('navbar')


 @section('sidebar')


 @section('content')
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">RETURN TO PRINCIPAL</h3>

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
            <select name="received_id" id="received_id" class="form-control select2bs4" style="width:100%;">
              <option value="" default>Select DR</option>
              @foreach ($received_id as $data)
                <option value="{{ $data->id ."=". $data->principal_id ."=". $data->purchase_order->purchase_id ."=". $data->dr_si }}">{{ "RR - ". $data->id ." | POID ". $data->purchase_order->purchase_id }}</option>
              @endforeach
            </select>
          </div>
          <div id="show_return_inputs"></div>
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
     var received_id = $(this).val();        
     $('.loading').show();
      $.post({
      type: "POST",
      url: "/return_show_inputs",
      data: 'received_id=' + received_id,
      success: function(data){

      //console.log(data);
      
        if(data == 'no_personnel'){
          toastr.error('PLEASE ADD PERSONNEL DESCRIPTION AND PERSONNEL INFO FIRST. THANK YOU!')
        }else{
          $('.loading').hide();
          $('#show_return_inputs').html(data);
        }

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


























 @extends('layouts.master')

 @section('title', 'Principal Add Discount')

 @section('navbar')


 @section('sidebar')


 @section('content')

 
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
        <h3 class="card-title" style="font-weight: bold;">ADD NEW SKU CATEGORY</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <form action="#" method="post">
                @csrf
                <div class="form-group">
                  <label>Principal:</label>
                  <select class="form-control select2" name="principal" id="principal" style="width:100%;">
                    <option value="" default>Select Principal</option>
                    @foreach ($principals as $data)
                    <option value="{{ $data->id ."=". $data->principal }}">{{ $data->principal }}</option>
                    @endforeach
                  </select>
                </div>
              </form>
            </div>
            
          </div>
          <div id="show_inputs"></div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        
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
        $('#principal').on('change',function(e){
                var principal = $(this).val();
                
                $.post({
                  type: "POST",
                  url: "/principal_discount_show_inputs",
                  data: 'principal=' + principal,
                  success: function(data){

                    //console.log(data);
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
      toastr.success('SUCCESSFULLY SAVED NEW DISCOUNTS')
   }

   var updateSuccess = '<?php echo Session::has("updateSuccess"); ?>';
   if(updateSuccess)
   {
      toastr.info('PRINCIPAL DISCOUNT DATA UPDATED')
   }

   var deleteSuccess = '<?php echo Session::has("deleteSuccess"); ?>';
   if(deleteSuccess)
   {
      toastr.warning('PRINCIPAL DISCOUNT DATA DELETED')
   }
</script>
</body>
</html>
@endsection

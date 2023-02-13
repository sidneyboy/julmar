 @extends('layouts.master')

 @section('title', 'VS ADJ')

 @section('navbar')


 @section('sidebar')


 @section('content')
  
    <br />
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">VAN SELLING ADJUSTMENTS</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
        <form id="van_selling_adjustments_generate">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <label>DR #:</label>
                <select class="form-contorl select2" style="width:100%;" name="van_selling_printed_id" required>
                  <option value="" default>SELECT</option>
                  @foreach($van_selling_printed as $data)
                  <option value="{{ $data->id ."-". $data->principal_id ."-". $data->sku_type }}">{{ $data->delivery_receipt ." / ". $data->customer->store_name  ." / ". $data->principal->principal ." / ". $data->date }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label>OM / AUDIT ACCESS KEY:</label>
                <input type="password" name="access_key" class="form-control" required>
              </div>
            </div>
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-info btn-block">GENERATE SALES ORDER DATA</button>
          </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
         <div id="van_selling_adjustments_generate_page"></div>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">VAN SELLING FOR FINAL SUMMARY</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <div id="van_selling_adjustments_final_summary_page"></div>
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

 $("#van_selling_adjustments_generate").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "van_selling_adjustments_generate",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            
            console.log(data);
            if(data == 'INCORRECT_ACCESS_KEY'){
              Swal.fire(
              'INCORRECT ACCESS KEY',
              'CANNOT PROCEED!',
              'error'
              )
              $('.loading').hide(); 
            }else{
              $('.loading').hide();
              $('#van_selling_adjustments_generate_page').html(data);
            }
          },
        });
    }));

 




</script>
</body>
</html>
@endsection

























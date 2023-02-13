 @extends('layouts.master')

 @section('title', 'Customer Update')

 @section('navbar')


 @section('sidebar')


 @section('content')
  
    <br />
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" style="font-weight: bold;">CUSTOMER UPDATE</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
         	<form id="customer_update_generate">
         		@csrf
         		<div class="row">
         			<div class="col-md-6">
         				<div class="form-group">
		         			<label>Store Code</label>
		         			<input type="text" name="store_code" class="form-control" required>
		         		</div>
         			</div>
         			<div class="col-md-6">
         				<div class="form-group">
         					<label>&nbsp;</label>
         					<button type="submit" id="trigger_customer_update_generate" class="btn btn-info btn-block">GENERATE</button>
         				</div>
         			</div>
         		</div>
         	</form>
        </div>
          <!-- /.card-body -->
        <div class="card-footer">
            <div id="customer_update_generate_page"></div>
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

   $('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
    $('[class=integer-default]').maskNumber({integer: true});
    $('[class=integer-data-attribute]').maskNumber({integer: true});
    $('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});
  


  $("#customer_update_generate").on('submit',(function(e){
        e.preventDefault();
        $('.loading').show();
          $.ajax({
            url: "customer_update_generate",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
              console.log(data);
              $('#customer_update_generate_page').html(data);
              $('.loading').hide();
            },
      });
    }));


</script>
</body>
</html>
@endsection

























@extends('layouts.master')
@section('title', 'Category Discount')
@section('navbar')
@section('sidebar')
@section('content')

<br />
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="card">
		<div class="card-header">
			<h3 class="card-title" style="font-weight: bold;">CATEGORY DISCOUNT</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
				<i class="fas fa-minus"></i></button>
				<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
				<i class="fas fa-times"></i></button>
			</div>
		</div>
		
			<div class="card-body">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Location</label>
							<select name="location" style="width:100%;" id="location_id" required class="form-control select2"  style="width:100%;">
								<option value="" default>Select</option>
								@foreach($location as $data)
								<option value="{{ $data->id }}">{{ $data->location }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div id="show_location_details_page"></div>		
					</div>
				</div>
        <div id="show_last_inputs_page"></div>

			</div>
      <!-- /.card-body -->
      <div class="card-footer">
        <div id="show_generated_data"></div>
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


  
  $("#location_id" ).change(function() {
     var location_id = $(this).val(); 
     $('.loading').show();       
      $.post({
      type: "POST",
      url: "/customer_category_discount_show_location_details_input",
      data: 'location_id=' + location_id,
      success: function(data){

      console.log(data);
     
      $('.loading').hide();
      $('#show_location_details_page').html(data);

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

























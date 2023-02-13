@extends('layouts.master')
@section('title', 'Customer discount')
@section('navbar')
@section('sidebar')
@section('content')

<br />
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="card">
		<div class="card-header">
			<h3 class="card-title" style="font-weight: bold;">CUSTOMER DISCOUNT</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
				<i class="fas fa-minus"></i></button>
				<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
				<i class="fas fa-times"></i></button>
			</div>
		</div>
		<form id="customer_discount_save" method="post">
		<div class="card-body">
			
				@csrf
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Principal</label>
							<select name="principal" id="principal" required class="form-control select2"  style="width:100%;">
								<option value="" default>Select</option>
								@foreach($select_principal as $data)
									<option value="{{ $data->id }}">{{ $data->principal }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Store</label>
							<select name="store" id="store"  required class="form-control select2"  style="width:100%;">
								<option value="" default>Select</option>
								@foreach($select_store as $data)
									<option value="{{ $data->id }}">{{ $data->store_name ." - ". $data->location->location  }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label># of Discounts</label>
							<select class="form-control select2" style="width:100%;" name="number_of_discounts" id="number_of_discounts">
								<option value="" default>Select</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</div>
					</div>
				</div>
			
		</div>
		<!-- /.card-body -->
		<div class="card-footer">
			<div id="customer_discount_show_input_page"></div>
			<br />
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<button type="submit" id="save_new_discount" style="display: none;" class="btn btn-success btn-block">SAVE CUSTOMER DISCOUNT</button>
					</div>
				</div>
			</div>
		</div>

		</form>
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


  
  $("#number_of_discounts" ).change(function() {
     var number_of_discounts = $(this).val(); 
     $('#customer_discount_show_input_page').show();
     $('.loading').show();       
      $.post({
      type: "POST",
      url: "/customer_discount_show_input",
      data: 'number_of_discounts=' + number_of_discounts,
      success: function(data){

      console.log(data);
      $('#save_new_discount').show();
      $('.loading').hide();
      $('#customer_discount_show_input_page').html(data);

      },
      error: function(error){
        console.log(error);
      }
    });
  });


  $("#customer_discount_save").on('submit',(function(e){
        e.preventDefault();

        $('.loading').show();
          $.ajax({
            url: "customer_discount_save",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
              console.log(data);
                if(data != 'error'){
                 Swal.fire({
				  position: 'top-end',
				  icon: 'success',
				  title: 'Your work has been saved',
				  showConfirmButton: false,
				  timer: 1500
				})
                 $('#customer_discount_save')[0].reset();
				 $('#principal').select2('val',0);
				 $('#store').select2('val',0);
				 $('#number_of_discounts').select2('val',0);
				 $('#customer_discount_show_input_page').hide();
				 
                 $('.loading').hide();
                  
                }else{
                  Swal.fire(
                  'Something went wrong!',
                  'Redo process or contact system administrator',
                  'error'
                  )
                  $('.loading').hide();
                }
            },
      });
    }));


</script>
</body>
</html>
@endsection

























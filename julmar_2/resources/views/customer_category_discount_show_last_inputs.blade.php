<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<label>Principal</label>
			<select class="form-control select2" style="width:100%;" name="principal_id" id="principal_id">
				<option value="" default>Select Principal</option>
				@foreach($principal as $data)
				<option value="{{ $data->id }}">{{ $data->principal }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="col-md-3">
		<div class="form-group">
			<label>Category</label>
			<select class="form-control select2" style="width:100%;" name="category_id" id="category_id">
				<option value="" default>Select Category</option>
				@foreach($category as $data)
				<option value="{{ $data->id }}">{{ $data->category }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="col-md-3">
		<div class="form-group">
			<label>Customer</label>
			<select class="form-control select2" style="width:100%;" name="customer_id" id="customer_id">
				<option value="" default>Select Customer</option>
				@foreach($customer as $data)
				<option value="{{ $data->id }}">{{ $data->store_name }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="col-md-1">
		<div class="form-group">
			<label># of discounts</label>
			<input type="number" class="form-control" name="number_of_discounts" id="number_of_discounts">
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
			<label>&nbsp;</label>
			<button class="btn btn-info btn-block" id="generate">Generate</button>
		</div>
	</div>
</div>


<script type="text/javascript">
	$('.select2').select2();

	$("#generate" ).click(function(e) {
		e.preventDefault();
		var	principal_id = $('#principal_id').val();
		var	category_id = $('#category_id').val();
		var	customer_id = $('#customer_id').val();
		var	number_of_discounts = $('#number_of_discounts').val();

		//$('.loading').show();
			$.post({
			type: "POST",
			url: "/customer_category_discount_generate_discount",
			data: 'principal_id=' + principal_id + '&category_id=' + category_id + '&customer_id=' + customer_id + '&number_of_discounts=' + number_of_discounts,
			success: function(data){
			console.log(data);

			// $('.loading').hide();
			$('#show_generated_data').html(data);
			},
			error: function(error){
			console.log(error);
			}
		});
	});
</script>
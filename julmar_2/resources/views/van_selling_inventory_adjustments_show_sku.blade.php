<div class="row">
	<div class="col-md-6">
		<label>SELECT SKU:</label>
		<select class="form-control select2" id="sku_code" style="width:100%;" name="sku_code" required>
			<option value="" default>SELECT SKU</option>
			option
			@foreach($van_selling_ledger as $data)
				<option value="{{ $data->sku_code  }}">{{ $data->sku_code ." - ". $data->description }}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-6">
		<label>QUANTITY:</label>
		<input type="number" name="quantity" id="quantity" class="form-control" required>
	</div>
	<div class="col-md-12">
		<label>REMARKS:</label>
		<input type="text" class="form-control" id="remarks" name="remarks">
	</div>
</div>

<script type="text/javascript">
	$('.select2').select2()
</script>
<div class="form-group">
	<label>Customer:</label>
	<select class="form-control select2" name="customer_id" style="width:100%;" required>
		<option value="" default>SELECT CUSTOMER</option>
		@foreach($customer as $data)
			<option value="{{ $data->id }}">{{ $data->store_name }}</option>
		@endforeach
	</select>
</div>

<script type="text/javascript">
	$('.select2').select2()
</script>
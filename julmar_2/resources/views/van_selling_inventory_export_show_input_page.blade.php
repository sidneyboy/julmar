<div class="form-group">
	<br />
	<label>SELECT VAN SELLING DR:</label>
	<select class="form-control select2" name="customer_id" style="width:100%;">
		<option value="" default>SELECT VAN SELLING DR</option>
		@foreach($customer as $data)
		<option value="{{ $data->id }}">{{ $data->store_name }}</option>
		@endforeach
	</select>

</div>

<script type="text/javascript">
	    $('.select2').select2()
</script>

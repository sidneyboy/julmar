<label>VAN SELLING DR:</label>
<select class="form-control select2" name="van_selling_id" style="width:100%" required>
	<option value="" default>SELECT DR</option>
	@foreach($van_selling as $data)
		<option value="{{ $data->id }}">{{ $data->delivery_receipt ."[". $data->customer->store_name ." - ". $data->date ."] - ". number_format($data->total_amount,2,".",",")  }}</option>
	@endforeach
</select>

<script type="text/javascript">
	$('.select2').select2()
</script>
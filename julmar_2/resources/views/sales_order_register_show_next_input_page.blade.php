<label>Sales Order</label>
<select class="form-control select2" name="sales_invoice_id" style="width:100%;" required>
	<option value="" default>SELECT CUSTOMER</option>
	@foreach($sales_order as $data)
		<option value="{{ $data->id }}">{{ $data->principal->principal ." - ". $data->customer->store_name ." - ". number_format($data->total,2,".",",")   }}</option>
	@endforeach
</select>

<script type="text/javascript">
    $('.select2').select2()
</script>
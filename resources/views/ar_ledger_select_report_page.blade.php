@if($select_report == 'AR_LEDGER_PER_DR')
	
	<div class="form-group">
		<label>Delivery_receipt</label>
		<input type="text" name="delivery_receipt" class="form-control" style="width:100%;" required>
	</div>

@elseif($select_report == 'AR_LEDGER_PER_CUSTOMER')
	
	<div class="form-group">
		<label>Customer</label>
		<select class="form-control select2" name="customer_id" style="width:100%;" required>
			<option value="" default>SELECT CUSTOMER</option>
			@foreach($agent_applied_customer as $data)
				<option value="{{ $data->customer_id }}">{{ $data->customer->store_name }}</option>
			@endforeach
		</select>
	</div>

@else

@endif

<script type="text/javascript">
	 $('.select2').select2()
</script>
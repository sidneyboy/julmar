<div class="form-group">
	<div class="row">
		<div class="col-md-6">
			<label>Customer</label>
			<select class="form-control select2" name="customer" required style="width:100%;">
				<option value="" default>SELECT CUSTOMER</option>
				@foreach($customer as $data)
					<option value="{{ $data->id }}">{{ $data->store_name }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-6">
			<label>Sku</label>
			<select class="form-control select2" multiple="multiple" name="sku[]" required style="width:100%;">
				@foreach($sku as $data)
					<option value="{{ $data->id }}">{{ $data->sku_code ." - ". $data->description  }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-12" >
            <label>&nbsp;</label>
            <button type="submit" class="btn btn-info btn-block">PROCEED TO QTY FORM</button>
        </div>
	</div>
</div>

<script type="text/javascript">
 

   $('.select2').select2()
	
</script>

	<label>Sku:</label>
	<select class="form-control select2" name="sku[]" multiple="multiple" required style="width:100%;">
		@foreach($sku as $data)
		<option value="{{ $data->id }}">{{ $data->sku_code ." - ". $data->description ." - ". $data->sku_type }}</option>
		@endforeach
	</select>

	<script type="text/javascript">
		 $('.select2').select2()
	</script>

<label>Sku</label>
<select class="form-control select2" name="sku[]" required multiple style="width:100%;text-transform: uppercase;">
	@foreach($sku as $data)
	<option value="{{ $data->id }}">{{ $data->sku_code ." - ". $data->description ." - ". $data->sku_type  }}</option>
	@endforeach
</select>
<br />
	<button type="submit" class="btn btn-success btn-block">GENERATE TO SUMMARY</button>

<script type="text/javascript">
		$('.select2').select2()
</script>
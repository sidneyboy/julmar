<label>Sub Category</label>
<select name="sub_category_id" class="form-control select2bs4" id="sub_category_id" required>
	<option value="" default>Select</option>
	@foreach($sub_category as $data)
	<option value="{{ $data->id }}">{{ $data->sub_category }}</option>
	@endforeach
</select>


<script>
	 $('.select2bs4').select2({
                  theme: 'bootstrap4'
                })


</script>

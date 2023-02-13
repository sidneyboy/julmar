<label>Main Category</label>
<select name="main_category_id" class="form-control select2bs4" style="width: 100%;" id="main_category_id" required>
	<option value="" default>Select</option>
	@foreach($principal_select_main_category->main_category as $data)
	<option value="{{ $data->id }}">{{ $data->category }}</option>
	@endforeach
</select>


<script>
	 $('.select2bs4').select2({
                  theme: 'bootstrap4'
                })

</script>

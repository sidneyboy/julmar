<div class="col-md-12">
	<div class="form-group">
		<label>Location Details</label>
		<select class="form-control select2" name="location_details_id" style="width:100%;">
			<option value="" default>Select</option>
			@foreach($location_id as $details)
			<option value="{{ $details->id }}">{{ $details->barangay ." ( ". $details->street ." ) " }}</option>
			@endforeach
		</select>
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
		<label>Details Address</label>
		<textarea class="form-control" name="detailed_location"></textarea>
	</div>
</div>


<script type="text/javascript">
	 $('.select2').select2()
</script>
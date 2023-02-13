<div class="form-group">
	<label>Select Location Details</label>
	<input type="hidden" name="location_id" id="location_id" value="{{ $location_id }}">
	<select class="form-control select2" style="width:100%;" name="location_details_id" id="location_details_id">
		<option value="" default>Select Location Details</option>
		@foreach($location_details as $data)
		<option value="{{ $data->id }}">{{ $data->barangay }}</option>
		@endforeach
	</select>
</div>


<script type="text/javascript">
	$('.select2').select2()

	$("#location_details_id" ).change(function() {
     var location_details_id = $(this).val(); 
     var location_id = $('#location_id').val();
     $('.loading').show();       
      $.post({
      type: "POST",
      url: "/customer_category_discount_show_last_inputs",
      data: 'location_details_id=' + location_details_id + '&location_id=' + location_id,
      success: function(data){

      console.log(data);
     
      $('.loading').hide();
      $('#show_last_inputs_page').html(data);

      },
      error: function(error){
        console.log(error);
      }
    });
  });

</script>
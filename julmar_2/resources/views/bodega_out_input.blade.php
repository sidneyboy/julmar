<form class="myform" name="myform" id="myform">
	@csrf
	<div class="row">
		<div class="col-md-5">
			<div class="form-group">
				<label>Sku</label>
				<select name="sku" id="sku" class="form-control select2" style="width:100%;">
					<option value="" default>Select Sku</option>
					@foreach ($sku_add as $data)
						<option value="{{ $data->id }}">{{ $data->sku_code ." - ". $uom ." - ". $data->description}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label>Equivalent</label>
				<input type="number" id="equivalent" style="text-align: center" class="form-control" disabled>
				<input type="hidden" value="{{ $uom }}" name="uom">
				<input type="hidden" value="{{ $principal_id }}" name="principal_id">
				<input type="hidden" value="{{ $data->category_id }}" name="category_id">
				<input type="hidden" value="{{ $data->sku_type }}" name="sku_type">
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<label>Convert</label>
				<input type="number" class="form-control" name="convert">
			</div>
		</div>
		<div class="col-md-12">
			<button class="float-right btn btn-info btn-flat btn-sm btn-block" type="button" onclick="return generate()" style="font-weight: bold;">GENERATE DATA</button>
		</div>
	</div>
</form>


<script>
	  $('.select2').select2();

	   $('#sku').on('change',function(e){
                var sku = $(this).val();
                $.post({
                  type: "POST",
                  url: "/show_equivalent",
                  data: 'sku=' + sku,
                  success: function(data){

                    //console.log(data);
                   $('#equivalent').val(data);
                   $('#equivalent_data').val(data);

                  },
                  error: function(error){
                    console.log(error);
                  }
                });
        });

	function generate() {
    
    var form = document.myform;
    var dataString = $(form).serialize();
   

    $('.loading').show();
        $.ajax({
            type:'POST',
            url:'/bodega_out_summary',
            data: dataString,
            success: function(data){
              
              console.log(data);   
              
              if (data == 'There is no equivalent butal for this SKU') {
              	 $('.loading').hide();
              	 Swal.fire({
				  position: 'top-end',
				  icon: 'error',
				  title: data,
				  showConfirmButton: false,
				  timer: 1500
				})
              }else if(data == 'There is no equivalent case for this SKU'){
              	$('.loading').hide();
              	 Swal.fire({
				  position: 'top-end',
				  icon: 'error',
				  title: data,
				  showConfirmButton: false,
				  timer: 1500
				})
              }else{
              	$('.loading').hide();
              	$('#show_bodega_out_summary').html(data);
              }
            }
        });
        return false;
    }

    
</script>
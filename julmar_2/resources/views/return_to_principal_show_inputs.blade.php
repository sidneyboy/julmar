<form class="myform" name="myform" id="myform">
	@csrf
	<div class="form-group">
		<label>Remarks</label>
		<select name="remarks" id="remarks" class="form-control select2" style="width:100%;">
			<option value="" default>Select Remarks</option>
			<option value="Good Stock">Good Stock</option>
			<option value="Bad Stock">Bad Stock</option>
			<option value="Expire">Expire</option>
			<option value="Near Expire">Near Expire</option>
		</select>
	</div>
	<div class="form-group">
		<label>Driver</label>
		<select name="personnel" id="personnel" class="form-control select2" style="width:100%;">
			<option value="" default>Select Driver</option>
			@foreach ($personnels as $data)
			<option value="{{ $data->id }}">{{ $data->full_name }}</option>
			@endforeach
		</select>
	</div>
	<input type="hidden" value="{{ $principal_id }}" name="return_principal_id">
	<input type="hidden" value="{{ $received_id }}" name="received_id">
	<input type="hidden" value="{{ $purchase_id }}" name="purchase_id">
	<input type="hidden" value="{{ $dr_si }}" name="dr_si">
	<label>SKU DATA</label>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th style="text-align: center">Code</th>
				<th style="text-align: center">Description</th>
				<th style="text-align: center">UOM</th>
				<th style="text-align: center">Quantity Received</th>
				<th style="text-align: center">Quantity Return</th>
				<th style="text-align: center">Cost</th>
				<th style="text-align: center;"><input type="checkbox" onclick="toggle(this);"  class="big-checkbox"/></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($sku_add_details as $data)
			<tr>
				<td style="text-align: center;text-transform: uppercase;">{{ $data->sku->sku_code }}</td>
				<td style="text-align: center;text-transform: uppercase;">{{ $data->sku->description }}</td>
				<td style="text-align: center;text-transform: uppercase;">{{ $data->sku->unit_of_measurement }}</td>
				<td style="text-align: center;text-transform: uppercase;">
					@if ($data->quantity_per_sku == $data->quantity_return_per_sku)
					{{ 0 }}
					@else
					{{ $data->quantity_per_sku - $data->quantity_return_per_sku}}
					@endif
				</td>
				<td style="text-align: center;text-transform: uppercase;"><input type="number" name="quantity_return_per_sku[{{ $data->sku_id }}]" style="display: block;
				    width: 100%;
				    height: calc(2.25rem + 2px);
				    padding: .375rem .75rem;
				    font-size: 1rem;
				    font-weight: 400;
				    line-height: 1.5;
				    color: #495057;
				    background-color: #fff;
				    background-clip: padding-box;
				    border: 1px solid #ced4da;
				    border-radius: .25rem;
				    box-shadow: inset 0 0 0 transparent;
				    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
				</td>

				<td style="text-align: right;"><input type="hidden" name="unit_cost[{{ $data->sku_id }}]" value="{{ $data->unit_cost_per_sku }}">{{ number_format($data->unit_cost_per_sku,2,".",",")}}</td>
				<td><center><input type="checkbox"  name="checkbox_entry[]" value="{{ $data->sku->id }}" class="big-checkbox" /></center>
				
				<input type="hidden" name="code[{{ $data->sku_id }}]" value="{{ $data->sku->sku_code }}">
				<input type="hidden" name="description[{{ $data->sku_id }}]" value="{{ $data->sku->description }}">
				<input type="hidden" name="unit_of_measurement[{{ $data->sku_id }}]" value="{{ $data->sku->unit_of_measurement }}">
				<input type="hidden" name="principal_id[{{ $data->sku_id }}]" value="{{ $data->sku->principal_id }}">
				<input type="hidden" name="category_id[{{ $data->sku_id }}]" value="{{ $data->sku->category_id }}">
				<input type="hidden" name="sku_type[{{ $data->sku_id }}]" value="{{ $data->sku->sku_type }}">
				
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</form>
<button class="float-right btn btn-info btn-flat btn-sm btn-block" type="button" onclick="return generate_summary()" style="font-weight: bold;">GENERATE SUMMARY</button>
<script>

$('.select2').select2();

	function toggle(source) {
var checkboxes = document.querySelectorAll('input[type="checkbox"]');
for (var i = 0; i < checkboxes.length; i++) {
if (checkboxes[i] != source)
checkboxes[i].checked = source.checked;
}
}
 function generate_summary() {
    
    var form = document.myform;
    var dataString = $(form).serialize();
     $('.loading').show();
   
        $.ajax({
            type:'POST',
            url:'/return_to_principal_summary',
            data: dataString,
            success: function(data){
              
              
              
               
              if(data == 'no_quantity'){
              	    $('.loading').hide();
		        	toastr.warning('PLEASE ADD QUANTITY TO BE RETURN');
		        	$('#show_final_summary').hide(data);
		      }else if(data == 'no remarks'){
		      		$('.loading').hide();
		        	toastr.warning('PLEASE SELECT REMARKS FIRST');
		        	$('#show_final_summary').hide(data);
		      }else if(data == 'no personnel'){
		      		$('.loading').hide();
		        	toastr.warning('PLEASE SELECT PERSONNEL FIRST');
		        	$('#show_final_summary').hide(data);
		      }else{
		       	   
		            toastr.info('PROCEEDING');
		             $('.loading').hide();
		             $('#show_final_summary').show(data);
		            $('#show_final_summary').html(data);
		       }
             
            }
        });
        return false;
    }


</script>
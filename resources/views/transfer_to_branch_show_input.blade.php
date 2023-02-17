<form name="myform" class="myform" id="myform">
	<table class="table table-bordered table-hover table-sm">
		<thead>
			<tr>
				<td colspan="2" style="text-align: center;font-weight: bold;">RECEIVED ID: <span style="color:blue;">{{ $id }}</span></td>
				<td colspan="1" style="text-align: center;font-weight: bold;">PURCHASED ID: <span style="color:blue">{{ $purchase_id }}</span>
					<input type="hidden" name="received_id" value="{{ $id }}">
					<input type="hidden" name="purchase_id" value="{{ $purchase_id }}">
					<input type="hidden" name="principal_id" value="{{ $principal_id }}">
					<input type="hidden" name="dr_si" value="{{ $dr_si }}">
					<input type="hidden" name="id" value="{{ $id }}">
					<input type="hidden" name="principal_name" value="{{ $principal_name->principal }}
					">
					<input type="hidden" name="branch" value="{{ $branch }}">
				</td>
				<td colspan="3" style="text-align: center;font-weight: bold;">
					{{ $branch }}
				</td>
			</tr>
			<tr>
				<th>Code</th>
				<th>Description</th>
				<th>Received</th>
				<th>Final Unit Cost</th>
				<th>Total Amount</th>
				<th><input type="checkbox" onclick="toggle(this);"  class="big-checkbox"/></th>
			</tr>
		</thead>
		<tbody>
			@foreach($sku_details as $data)
			<tr>
				<td>{{ $data->sku->sku_code }}</td>
				<td>{{ $data->sku->description }}</td>
				<td>
					{{ $data->quantity }}
					<input type="hidden" name="quantity[{{ $data->sku_id }}]" value="{{ $data->quantity }}">
				</td>
				<td style="text-align: right;">
					{{ number_format($data->final_unit_cost,2,".",",") }}
					<input type="hidden" name="last_final_unit_cost_case[{{ $data->sku_id }}]" value="{{ $data->final_unit_cost }}">
				</td>
				<td style="text-align: right;">
					@php
						$sum_total_amount[] = $data->quantity * $data->final_unit_cost;
					@endphp
					{{ number_format($data->quantity * $data->final_unit_cost,2,".",",") }}
					
				</td>
				<td><center><input type="checkbox"  name="checkboxEntry[{{ $data->sku_id }}]" value="{{ $data->sku_id }}" class="big-checkbox" /></center></td>
			</tr>
			@endforeach
			<tr>
				<th colspan="4">GRAND TOTAL</th>
				<th style="text-align: right;">{{ number_format(array_sum($sum_total_amount),2,".",",") }}</th>
				<th></th>
			</tr>
		</tbody>
	</table>
	<table class="table bordered table-hover">
		<thead>
			<tr>
				<th></th>
				<th></th>
				<th>DEBIT</th>
				<th>CREDIT</th>
			</tr>
			<tr>
				<th>INVENTORY - {{ $principal_name->principal }} - {{ $branch }}</th>
				<th></th>
				<th>{{ number_format(array_sum($sum_total_amount),2,".",",") }}</th>
				<th></th>
			</tr>
			<tr>
				<th></th>
				<th>INVENTORY - {{ $principal_name->principal }}</th>
				<th></th>
				<th>{{ number_format(array_sum($sum_total_amount),2,".",",") }}</th>
			</tr>
		</thead>
	</table>
</form>
	

	<button class="btn btn-success btn-sm float-right" type="button" onclick="return save()">Proceed</button>


<script>


	function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
        }
    }

    function save() {
        var form = document.myform;
        var dataString = $(form).serialize();
        //var show_data_updated_form = $('#show_data_updated_form');
           
        $.get({
            type:'GET',
            url:'/transfer_to_branch_saved',
            data: dataString,
            success: function(data){
               
             	 if(data == 'Saved'){
	                toastr.success('TRANSFER TO BRANCH DATA SUCCESSFULLY SAVED!');
	                $('.loading').show();
	                setTimeout(function(){
		              location.reload();
		            }, 2000);
		                
		          }else{
		                toastr.error('Something went wrong, please redo process');
		          }
            }
        });
        return false;
    }
</script>
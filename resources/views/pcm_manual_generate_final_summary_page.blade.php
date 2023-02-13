<form id="pcm_manual_save">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<td colspan="7">
					<input type="hidden" name="returned_by" value="{{ $returned_by }}">
					<p>Returned By:{{ $returned_by }}</p>
				</td>
			</tr>
			<tr>
				<th style="text-align: center;">CODE</th>
				<th style="text-align: center;">DESC</th>
				<th style="text-align: center;">UOM</th>
				<th style="text-align: center;">RGS QTY</th>
				<th style="text-align: center;">BO QTY</th>
				<th style="text-align: center;">U/P</th>
				<th style="text-align: center;">TOTAL</th>
				<th style="text-align: center;">REMARKS</th>
			</tr>
		</thead>
		<tbody>
			@foreach($sku as $data)
			<tr>
				<td>
					<input type="hidden" name="sku[]" value="{{ $data }}">
					{{ $sku_code[$data] }}
				</td>
				<td>{{ $description[$data] }}</td>
				<td>{{ $unit_of_measurement[$data] }}</td>
				<td>
					<input type="hidden" name="rgs_quantity[{{ $data }}]" value="{{ $rgs_quantity[$data] }}">
					{{ $rgs_quantity[$data] }}
				</td>
				<td>
					<input type="hidden" name="bo_quantity[{{ $data }}]" value="{{ $bo_quantity[$data] }}">
					{{ $bo_quantity[$data] }}
				</td>
				<td>
					<input type="hidden" name="unit_price[{{ $data }}]" value="{{ $unit_price[$data] }}">
					{{ number_format($unit_price[$data],2,".",",")  }}
				</td>
				<td>
					@php
						$total = ($rgs_quantity[$data] + $bo_quantity[$data]) * $unit_price[$data];
						echo number_format($total,2,".",",");  
						$sum_total[] = $total;
					@endphp
				</td>
				<td>
					<input type="hidden" name="remarks[{{ $data }}]" value="{{ $remarks[$data] }}">
					{{ $remarks[$data] }}
				</td>
			</tr>
			@endforeach
			<tfoot>
			<tr>
				<td colspan="8">
					<input type="hidden" name="agent_id" value="{{ $agent_id }}">
					<input type="hidden" name="customer_id" value="{{ $customer_id }}">
					<input type="hidden" name="principal_id" value="{{ $principal_id }}">
					<input type="hidden" name="delivery_receipt" value="{{ $delivery_receipt }}">
					<button type="submit" class="btn btn-info btn-block">PROCEED TO FINAL SUMMARY</button>
				</td>
			</tr>
			</tfoot>
		</tbody>
	</table>
</form>
<script type="text/javascript">
	$("#pcm_manual_save").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "pcm_manual_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            
           	if (data == 'saved') {
           		Swal.fire({
				  position: 'top-end',
				  icon: 'success',
				  title: 'Your work has been saved, Reloading page',
				  showConfirmButton: false,
				  timer: 1500
				})
           		$('.loading').hide();
           		location.reload();
           	}else{
           		$('.loading').hide();
           	}
          },
        });
    }));
</script>
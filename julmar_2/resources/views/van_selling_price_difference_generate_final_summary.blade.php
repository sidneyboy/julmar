<form id="van_selling_price_difference_save">
	<div class="table table-responsive">
		@foreach($customer_data as $customer)
			<table class="table table-bordered table-hover example2">
				<thead>
					<tr>
						<th colspan="11" style="text-align: center;">{{ $customer->store_name }} <span style="color:blue;">{{ $date_from }}</span> TO <span style="color:blue;">{{ $date_to }}</span></th>
					</tr>
					<tr>
						<th>CODE</th>
						<th>DESC</th>
						<th>UOM</th>
						<th>QTY</th>
						<th>BUTAL QTY</th>
						<th>TOTAL QTY (<span style="color:blue">IF CASE</span>)</th>
						<th>U/P</th>
						<th>ORIG VL AMNT</th>
						<th>PRICE DIFF</th>
						<th>NEW VL AMNT</th>
						<th>DIFFERENCE</th>
					</tr>
				</thead>
				<tbody>
					@foreach($id[$customer->id] as $data_id)
						<tr>
							<td>{{ $sku_code[$customer->id][$data_id] }}</td>
							<td>{{ $description[$customer->id][$data_id] }}</td>
							<td>{{ $unit_of_measurement[$customer->id][$data_id] }}</td>
							<td style="text-align: right">{{ $total_van_load[$customer->id][$data_id] }}</td>
							<td style="text-align: right">{{ $butal_equivalent[$customer->id][$data_id] }}</td>
							<td style="text-align: right">{{ $total_quantity[$customer->id][$data_id] }}</td>
							<td style="text-align: right">
								{{ $unit_price[$customer->id][$data_id] }}
								@php
									$sum_amount_per_sku[$customer->id][] = $unit_price[$customer->id][$data_id] * $total_quantity[$customer->id][$data_id];
								@endphp
							</td>
							<td style="text-align: right">{{ $orig_vl_amount[$customer->id][$data_id] }}</td>
							<td style="text-align: right">{{ $price_update[$customer->id][$data_id] }}</td>
							<td style="text-align: right">
								@php
									$new_vl_amount = $price_update[$customer->id][$data_id] * $total_quantity[$customer->id][$data_id];
									$sum_new_vl_amount[$customer->id][] = $new_vl_amount;
									echo number_format($new_vl_amount,4,".",",");
								@endphp
							</td>
							<td style="text-align: right">
								@if($price_update[$customer->id][$data_id])
									@php	
										$difference = ($price_update[$customer->id][$data_id] - $unit_price[$customer->id][$data_id])*$total_quantity[$customer->id][$data_id];
										echo number_format($difference,4,".",",");
									@endphp
								@else
									@php	
										$difference = 0;
										echo number_format($difference,4,".",",");
									@endphp
								@endif
								@php
									$sum_difference[$customer->id][] = $difference;
								@endphp
							</td>

						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<th colspan="7" style="text-align: center;">GRAND TOTAL</th>

						<th style="text-align: right;color:green;">{{ number_format(array_sum($sum_amount_per_sku[$customer->id]),4,".",",") }}
						</th>
						<th></th>
						<th style="text-align: right;color:blue;">
							{{ number_format(array_sum($sum_new_vl_amount[$customer->id]),4,".",",") }}
						</th>
						<th style="text-align: right;color:red;">
							{{ number_format(array_sum($sum_difference[$customer->id]),4,".",",") }}
						</th>

					</tr>
				</tfoot>
			</table>
		@endforeach
		<button type="submit" class="btn btn-block btn-info">PROCEED TO FINAL SUMMARY</button>
	</div>
</form>

<script type="text/javascript">
	$("#van_selling_price_difference_save").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "van_selling_price_difference_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
             if (data == 'saved') {
             	Swal.fire({
							  position: 'top-end',
							  icon: 'success',
							  title: 'Your work has been saved',
							  showConfirmButton: false,
							  timer: 1500
							})
							location.reload();
             }else{
             	Swal.fire(
							  data,
							  'Something went wrong!',
							  'error'
							)
             }	
          },
        });
    }));
</script>
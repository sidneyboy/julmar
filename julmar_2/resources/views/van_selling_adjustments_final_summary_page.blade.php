<form id="van_selling_adjusutments_save">
	<div class="table table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th colspan="7" style="text-align: center;">UPDATED SKU LIST FOR DR (<span style="color:blue">{{ $delivery_receipt }}</span>)</th>
				</tr>
				<tr>
					<th>CODE</th>
					<th>DESCRIPTION</th>
					<th>UOM</th>
					<th>QUANTITY</th>
					<th>BUTAL QUANTITY</th>
					<th>PRICE</th>
					<th>SUB-TOTAL</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sku_id as $data)
						<tr>
							<td>
								<input type="hidden" name="sku_id[]" value="{{ $data }}">
								{{ $sku_code[$data] }}
								<input type="hidden" name="sku_code[{{ $data }}]" value="{{ $sku_code[$data] }}">
							</td>
							<td>{{ $description[$data] }}</td>
							<td>{{ $uom[$data] }}</td>
							<td style="text-align: right;">
								@php
									$final_adjustment_quantity = $quantity[$data] + $adjustment_quantity[$data];
									echo $final_adjustment_quantity;
								@endphp
								<input type="hidden" name="quantity[{{ $data }}]" value="{{ $quantity[$data] + $adjustment_quantity[$data] }}">
								<input type="hidden" name="original_quantity[{{ $data }}]" value="{{ $original_quantity[$data] }}">
								<input type="hidden" name="adjustment_quantity[{{ $data }}]" value="{{ $adjustment_quantity[$data] }}">
							</td>
							<td style="text-align: right;">
								{{ $butal_quantity[$data] }}
								<input type="hidden" name="butal_quantity[{{ $data }}]" value="{{ $butal_quantity[$data] }}">
							</td>
							<td style="text-align: right;">
								{{ number_format($price[$data],2,".",",") }}
								<input type="hidden" name="price[{{$data}}]" value="{{ $price[$data] }}">
							</td>
							<td style="text-align: right;">
								@if($sku_type == 'Case' OR $sku_type == 'CASE')
										@php
											$sub_total = ($butal_quantity[$data] * $final_adjustment_quantity) * $price[$data];
											$sum_sub_total[] = $sub_total;
											$sum_quantity[] = $quantity[$data];
											echo number_format($sub_total,2,".",",");
										@endphp
								@else
									@php
											$sub_total = $price[$data] *  $quantity[$data];
											$sum_sub_total[] = $sub_total;
											$sum_quantity[] = $quantity[$data];
											echo number_format($sub_total,2,".",",");
										@endphp
								@endif
								<input type="hidden" name="amount_per_sku[{{$data}}]" value="{{ $sub_total }}">
							</td>
						</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td style="text-align: center;font-weight: bold;" colspan="3">GRAND TOTAL</td>
					<td style="text-align: right;font-weight: bold;">{{ array_sum($sum_quantity) }}</td>
					<td colspan="2"></td>
					<td style="text-align: right;font-weight: bold;">
						{{ number_format(array_sum($sum_sub_total),2,".",",") }}
						<input type="hidden" name="total" value="{{ array_sum($sum_sub_total) }}">
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<input type="hidden" name="customer_id" value="{{ $customer_id }}">
	<input type="hidden" name="van_selling_printed_id" value="{{ $van_selling_printed_id }}">
	<input type="hidden" name="principal_name" value="{{ $principal_name }}">
	<input type="hidden" name="principal_id" value="{{ $principal_id }}">
	<input type="hidden" name="approved_by" value="{{ $approved_by }}">
	<button type="submit" class="btn btn-success btn-block">UPDATE VAN SELLING DR DATA</button>
</form>



<script type="text/javascript">
	$("#van_selling_adjusutments_save").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "van_selling_adjusutments_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            
            console.log(data);
            if(data == 'saved'){
              Swal.fire({
							  position: 'top-end',
							  icon: 'success',
							  title: 'Your work has been saved, Reloading Page!',
							  showConfirmButton: false,
							  timer: 1500
							})
							location.reload();
              $('.loading').hide(); 
            }else{
              Swal.fire(
							  'Error. Contact Admin!',
							  'Something went wrong cannot proceed!',
							  'error'
							)
            }
          },
        });
    }));
</script>
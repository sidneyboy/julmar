<div class="table table-responsive">
	<form id="van_selling_pcm_save">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th colspan="6" style="text-align: center;">PCM #: <span style="color:blue;">{{ strtoupper($pcm_number) }}</span></th>
				</tr>
				<tr>
					<th>PRINCIPAL</th>
					<th>CODE</th>
					<th>DESCRIPTION</th>
					<th>PCM QTY</th>
					<th>U/P</th>
					<th>SUB-TOTAL</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($sku_code as $data)
				@if($pcm_quantity[$data] != 0)
				<tr>
					<td>
						{{ $principal[$data] }}
						<input type="hidden" name="principal[{{ $data }}]" value="{{ $principal[$data] }}">
					</td>
					<td>{{ $data }}</td>
					<td>
						{{ $description[$data] }}
						<input type="hidden" name="description[{{ $data }}]" value="{{ $description[$data] }}">
					</td>
					<td style="text-align: right;">
						{{ $pcm_quantity[$data] }}
						<input type="hidden" name="sku_code[]" value="{{ $data }}">
						<input type="hidden" name="pcm_quantity[{{ $data }}]" value="{{ $pcm_quantity[$data] }}">
					</td>
					<td style="text-align: right;">
						{{ number_format($unit_price[$data],4,".",",") }}
						<input type="hidden" name="unit_price[{{ $data }}]" value="{{ $unit_price[$data] }}">
					</td>
					<td style="text-align: right;">
							@php
								$sub_total = $unit_price[$data] * $pcm_quantity[$data];
								$sum_sub_total[] = $sub_total;
								echo number_format($sub_total,4,".",",");
							@endphp

					</td>
				</tr>
				@endif
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5" style="text-align: center;">GRAND TOTAL</td>
					<td style="text-align: right;">{{ number_format(array_sum($sum_sub_total),2,".",",") }}</td>
				</tr>
				<tr>
					<td colspan="6">
						<input type="hidden" name="customer_id" value="{{ $customer_id }}">
						<input type="hidden" name="pcm_number" value="{{ $pcm_number }}">
						<input type="hidden" name="amount" value="{{ array_sum($sum_sub_total) }}">
						<button type="submit" class="btn btn-success btn-block">SUBMIT TRANSACTION</button>
					</td>
				</tr>
			</tfoot>
		</table>
	</form>
</div>

<script>
	 $("#van_selling_pcm_save").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "van_selling_pcm_save",
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
							location.reload();
            }else{
            	Swal.fire(
							  'Something went wrong!',
							  data,
							  'error'
							)
            }
          },
        });
    }));
</script>
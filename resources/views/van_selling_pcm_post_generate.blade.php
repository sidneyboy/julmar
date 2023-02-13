<div class="table table-responsive">
	<form id="van_selling_pcm_post_save">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th colspan="7" style="text-align: center;">PCM #: <span style="color:blue;">{{ strtoupper($van_selling_pcm->pcm_number) }}</span></th>
				</tr>
				<tr>
					<th style="text-align:center;" colspan="2">CM</th>
					<th style="text-align:center;" colspan="2">RUNNING BALANCE</th>
					<th style="text-align:center;" colspan="2">(OVER)/SHORT</th>
					<th style="text-align:center;" colspan="1">OUTSTANDING BALANCE</th>
				</tr>
				<tr>
					<th style="text-align: right" colspan="2">{{ $van_selling_pcm->amount }}</th>
					<th style="text-align: right" colspan="2">{{ number_format($van_search->running_balance - $van_selling_pcm->amount ,2,".",",") }}</th>
					<th style="text-align: right" colspan="2">{{ number_format($van_search->over_short ,2,".",",") }}</th>
					<th style="text-align: right" colspan="1">{{ number_format($van_search->outstanding_balance - $van_selling_pcm->amount ,2,".",",") }}</th>
				</tr>
				<tr>
				<th colspan="2" style="text-align: center;text-transform: transform">PCM TYPE: <span style="color:blue;">{{ $van_selling_pcm->pcm_type }} BO</span></th>
					<th colspan="2" style="text-align: center;">SALESMAN: <span style="color:blue;">{{ $van_selling_pcm->customer->store_name }}</span></th>
					<th colspan="2" style="text-align: center;">PCM BY: <span style="color:blue;">{{ strtoupper($van_selling_pcm->user->name) }}</span></th>
					<th colspan="1" style="text-align: center;">DATE: <span style="color:blue;">{{ $van_selling_pcm->date }}</span></th>
				</tr>
				<tr>
					<th>PRINCIPAL</th>
					<th>CODE</th>
					<th>DESCRIPTION</th>
					<th>PCM QTY</th>
					<th>U/P</th>
					<th>SUB-TOTAL</th>
					<th>Remarks</th>
				</tr>
			</thead>
			<tbody>
				@foreach($van_selling_pcm->van_selling_pcm_details as $data)
					<tr>
						<td>
							{{ $data->principal }}
							<input type="hidden" name="principal[{{ $data->sku_code }}]" value="{{ $data->principal }}">
						</td>
						<td>
							{{ $data->sku_code }}
							<input type="hidden" name="sku_code[]" value="{{ $data->sku_code }}">
						</td>
						<td>
							{{ $data->description }}
							<input type="hidden" name="description[{{ $data->sku_code }}]" value="{{ $data->description }}">
						</td>
						<td style="text-align: right;">
							{{ $data->quantity }}
							<input type="hidden" name="quantity[{{ $data->sku_code }}]" value="{{ $data->quantity }}">
						</td>
						<td style="text-align: right;">
							{{ number_format($data->unit_price,2,".",",") }}
							<input type="hidden" name="unit_price[{{ $data->sku_code }}]" value="{{ $data->unit_price }}">
						</td>
						<td style="text-align: right;">
							@php
								$total = $data->unit_price * $data->quantity;
								$sum_total[] = round($total,2);
								echo number_format($total,2,".",",")
							@endphp
						</td>
						<td>{{ $data->remarks }}</td>
					</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="5" style="text-align: center;">GRAND TOTAL</th>
					<th style="text-align: right;">
						{{ number_format(array_sum($sum_total),2,".",",") }}
						<input type="hidden" name="cm_amount" value="{{ array_sum($sum_total) }}">
					</th>
				</tr>
				<tr>
					<th colspan="7">
						<input type="hidden" name="van_selling_pcm_id" value="{{ $van_selling_pcm->id }}">
						<input type="hidden" name="customer_id" value="{{ $van_selling_pcm->customer_id }}">
						<input type="hidden" name="pcm_number" value="{{ $van_selling_pcm->pcm_number }}">
						<input type="hidden" name="pcm_type" value="{{ $van_selling_pcm->pcm_type }}">
						<input type="hidden" name="running_balance" value="{{ $van_search->running_balance }}">
						<input type="hidden" name="outstanding_balance" value="{{ $van_search->outstanding_balance }}">
						<input type="hidden" name="over_short" value="{{ $van_search->over_short }}">
						<button type="submit" class="btn btn-success btn-block">POST</button>
					</th>
				</tr>
			</tfoot>
		</table>
	</form>
</div>

<script>
	 $("#van_selling_pcm_post_save").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "van_selling_pcm_post_save",
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
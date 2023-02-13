<div class="table table-responsive">
	<table class="table table-hover table-bordered">
		<thead>
			<tr>
				<th>DATE</th>
				<th>PRINCIPAL</th>
				<th>CODE</th>
				<th>DESCRIPTION</th>
				<th>REFERENCE</th>
				<th>BUTAL EQUIVALENT</th>
				<th>QTY CASE</th>
				<th>IN AS</th>
				<th>SKU TYPE</th>
				<th>BEG</th>
				<th>T - VAN LOAD</th>
				<th>T - SALES</th>
				<th>ADJUSTMENTS</th>
				<th>PCM</th>
				<th>CLRNG</th>
				<th>END</th>
				<th>U/P</th>
				<th>RUNNING BALANCE</th>
				<th>USER</th>
			</tr>
		</thead>
		<tbody>
			@foreach($van_selling_ledger as $data)
			<tr>
				<td>{{ $data->date }}</td>
				<td>{{ $data->principal }}</td>
				<td>{{ $data->sku_code }}</td>
				<td>{{ $data->description }}</td>
				<td>{{ $data->reference }}</td>
				<td>{{ $data->butal_equivalent }}</td>
				<td style="text-align: right">
					@if($data->butal_equivalent == '0')
					NO BUTAL EQUIVALENT
					@else
					{{ number_format(($data->beg + $data->van_load - $data->sales) / $data->butal_equivalent,2,".",",") }}
					@endif
				</td>
				<td style="text-transform: uppercase;">{{ $data->sku_type }}</td>
				<td>BUTAL</td>
				<td style="text-align: right;">{{ $data->beg }}</td>
				<td style="text-align: right;">
					@php
					$total_van_load[] = $data->van_load;
					@endphp
					{{ $data->van_load }}
				</td>
				<td style="text-align: right;">
					@php
					$total_sales[] = $data->sales;
					@endphp
					{{ $data->sales }}
				</td>
				<td style="text-align: right;">
				{{-- 	@if($data->inventory_adjustments < 0)					
						@php
							$explode = explode('-', $data->inventory_adjustments);
							$adjusted_quantity = $explode[1];
						@endphp
						({{ $adjusted_quantity }})
					@else
						@php
							$adjusted_quantity = $data->inventory_adjustments;
						@endphp
						{{ $data->inventory_adjustments }}
					@endif --}}
					@php
						echo $adjusted_quantity = $data->inventory_adjustments;
						$total_adjustments[] = $adjusted_quantity;
					@endphp
				</td>
				<td style="text-align: right;">
					@php
					$total_pcm[] = $data->pcm;
					@endphp
					{{ $data->pcm }}
				</td>
				<td style="text-align: right;">
					@php
					$total_clear[] = $data->clearing;
					@endphp
					{{ $data->clearing }}
				</td>
				<td style="text-align: right;">
					@php
						$total_end[] = $data->beg + $data->van_load - $data->sales + $adjusted_quantity - $data->pcm + $data->clearing;
						$end = $data->beg + $data->van_load - $data->sales + $adjusted_quantity - $data->pcm + $data->clearing;
					@endphp
					{{ $end }}
				</td>
				<td style="text-align: right;">{{ number_format($data->unit_price,4,".",",")  }}</td>
				{{-- <td style="text-align: right;">{{ number_format($data->total,2,".",",")  }}</td> --}}
				<td style="text-align: right;">{{ number_format($data->running_balance,2,".",",") }}</td>
				<td>{{ $data->remarks }}</td>
			</tr>
			@endforeach
			<tr>
				<th colspan="9" style="font-weight: bold;text-align: center;">OVERALL</th>
				<th style="text-align: right;">{{ $van_selling_ledger[0]->beg }}</th>
				<th style="text-align: right;">{{ array_sum($total_van_load) }}</th>
				<th style="text-align: right;">{{ array_sum($total_sales) }}</th>
				<th style="text-align: right;">{{ array_sum($total_adjustments) }}</th>
				<th style="text-align: right;">{{ array_sum($total_pcm) }}</th>
				<th style="text-align: right;">{{ array_sum($total_clear) }}</th>
				<th style="text-align: right;">{{  $van_selling_ledger[0]->beg + array_sum($total_van_load) - array_sum($total_sales) + array_sum($total_adjustments) - array_sum($total_pcm) + array_sum($total_clear) }}</th>
			</tr>
		</tbody>
	</table>
</div>
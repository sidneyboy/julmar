<table class="table table-bordered table-hovered">
	<thead>
		<tr>
			<th style="text-align: center;text-transform: uppercase;">Principal</th>
			<th style="text-align: center;text-transform: uppercase;">Principal Invoice</th>
			<th style="text-align: center;text-transform: uppercase;">Transaction</th>
			<th style="text-align: center;text-transform: uppercase;">Doc. Ref</th>
			<th style="text-align: center;text-transform: uppercase;">AP / Beg</th>
			<th style="text-align: center;text-transform: uppercase;">Received</th>
			<th style="text-align: center;text-transform: uppercase;">Returned</th>
			<th style="text-align: center;text-transform: uppercase;">Adjustment</th>
			<th style="text-align: center;text-transform: uppercase;">Payment</th>
			<th style="text-align: center;text-transform: uppercase;">AP / End</th>
			<th style="text-align: center;text-transform: uppercase;">Date</th>
		</tr>
	</thead>
	<tbody>
		@foreach($principal_ledger as $data)
			<tr>
				<td>{{ $data->principal->principal }}</td>
				<td style="text-align: center;text-transform: uppercase;">{{ $data->principal_invoice }}</td>
				<td style="text-align: center;text-transform: uppercase;">{{ $data->transaction }}</td>
				<td style="text-align: center;text-transform: uppercase;">
					@if($data->transaction == 'received')
						{{ 'RR - '.$data->rr_dr }}
					@elseif($data->transaction == 'returned')
						{{ 'RET - '.$data->rr_dr }}
					@elseif($data->transaction == 'bo adjustment')
						{{ 'DM-BO '.$data->rr_dr }}
					@elseif($data->transaction == 'invoice cost adjustment')
						{{ 'INV-ADJ '.$data->rr_dr }}
					@else
						{{ 'P - '.$data->rr_dr }}
					@endif
				</td>
				<td style="text-align: right;font-weight: bold;">{{ number_format($data->accounts_payable_beginning,2,".",",") }}</td>
				<td style="text-align: right;font-weight: bold;">{{ number_format($data->received,2,".",",") }}</td>
				<td style="text-align: right;font-weight: bold;">{{ number_format($data->returned,2,".",",") }}</td>
				<td style="text-align: right;font-weight: bold;">
					{{-- @if($data->transaction == 'bo adjustment')
						<span style="color:red;">{{ " (".  number_format($data->adjustment,2,".",",") .")" }}</span>
					@elseif($data->transaction == 'bo total adjustments')
						<span style="color:red;">{{ " (".  number_format($data->adjustment,2,".",",") .")" }}</span>
					@else
						
					@endif

				 --}}

					@if($data->adjustment < 0)
						<span style="color:red;">{{ " (".  number_format($data->adjustment*-1,2,".",",") .")" }}</span>
					@else
						{{ number_format($data->adjustment,2,".",",") }}
					@endif
				</td>
				<td style="text-align: right;font-weight: bold;">{{ number_format($data->payment,2,".",",") }}</td>
				<td style="text-align: right;font-weight: bold;">{{ number_format($data->accounts_payable_end,2,".",",") }}</td>
				<td style="text-align: center;font-weight: bold;">{{ $data->date }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
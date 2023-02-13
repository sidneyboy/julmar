<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th style="text-align: center;">ID #</th>
			<th style="text-align: center;">Received ID #</th>
			<th style="text-align: center;">Particulars</th>
			<th style="text-align: center;">Bo<br />Allowance<br>Deduction</th>
			<th style="text-align: center;">Vat<br />Deduction</th>
			<th style="text-align: center;">Net<br />Deduction</th>
			<th style="text-align: center;">Date</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($bo_adjustments_data as $data)
			<tr>
				<td style="text-align: center"><a href="{{ route('bo_allowance_adjustments_show_details', $data->id ."=". $data->principal->principal ."=". $data->particulars) }}" target="_blank">DM - BO {{ $data->id }}</a></td>
				<td style="text-align: center"><a href="{{ route('received_order_report_show_details', $data->received_id ."=". $data->principal->principal) }}" target="_blank">RR - {{ $data->received_id }}</a></td>
				<td style="text-transform: uppercase;text-align: center;">{{ $data->particulars }}</td>
				<td style="text-align: right;font-weight: bold;">
					{{ number_format($data->bo_allowance_deduction,2,".",",")  }}
				</td>
				<td style="text-align: right;font-weight: bold;">
			
					{{ number_format($data->vat_deduction,2,".",",") }}
				</td>
				<td style="text-align: right;font-weight: bold;">
					
					{{ number_format($data->net_deduction,2,".",",") }}
				</td>
				<td style="text-align: center;">{{ $data->date }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
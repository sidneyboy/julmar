<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th style="text-align: center">ID #</th>
			<th style="text-align: center">Received ID #</th>
			<th style="text-align: center">Particulars</th>
			<th style="text-align: center">Total Adjusted Invoice</th>
			<th style="text-align: center">Bo Allowance</th>
			<th style="text-align: center">Date</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($invoice_adjustments_data as $data)
			<tr>
				<td style="text-align: center;"><a href="{{ route('invoice_cost_adjustments_show_details', $data->id ."=". $data->principal->principal ."=". $data->particulars) }}" target="_blank">{{ $data->id }}</a></td>
				<td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $data->received_id ."=". $data->principal->principal) }}" target="_blank">{{ $data->received_id }}</a></td>
				<td style="text-transform: uppercase;">{{ $data->particulars }}</td>
				<td style="text-align: right;">{{ number_format($data->total_invoice_adjusted,2,".",",") }}</td>
				<td style="text-align: right;">{{ number_format($data->total_bo_allowance,2,".",",") }}</td>
				<td style="text-align: center;">{{ $data->date }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
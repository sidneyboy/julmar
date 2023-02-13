<link rel="stylesheet" href="{{ asset('/adminLte/dist/css/adminlte.min.css') }}">
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Van Load</th>
			<th>Principal</th>
			<th>Code</th>
			<th>Description</th>
			<th>Uom</th>
			<th>Withdrawn</th>
			<th>Sold</th>
			<th>Van Bal</th>
			<th>Unit Price</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		@foreach($van_selling_with_details as $data)
			<tr>
				
				<td>{{ $data->date }}</td>
				<td>{{ $data->principal->principal }}</td>
				<td></td>
				<td>{{ $data->sku->description }}</td>
				<td>{{ $data->sku->unit_of_measurement }}</td>
				<td style="text-align: right;">{{ $data->quantity }}</td>
				<td style="text-align: right;">{{ $data->sold }}</td>
				<td style="text-align: right;">{{ $data->running_balance }}</td>
				<td style="text-align: right;">
					{{ number_format($data->price,2,".",",")  }}
				</td>
				<td style="text-align: right;">{{ number_format($data->quantity * $data->price,2,".",",")  }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
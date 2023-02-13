<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th style="text-align: center;">ID #</th>
			<th style="text-align: center;">Principal</th>
			<th style="text-align: center;">Remarks</th>
			<th style="text-align: center;">Date</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($bodega_out as $data)
			<tr>
				<td style="text-align: center;"><a href="{{ route('bodega_out_show_details', $data->id ."=". $data->principal->principal ."=". $data->remarks) }}" target="_blank">{{ $data->id }}</a></td>
				<td style="text-align: center">{{ $data->principal->principal }}</td>
			    <td style="text-align: center">{{ $data->remarks }}</td>
			    <td style="text-align: center">{{ $data->date }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
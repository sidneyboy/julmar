<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th style="text-align: center;">ID #</th>
			<th style="text-align: center;">Principal</th>
			<th style="text-align: center;">Staff</th>
			<th style="text-align: center;">Branch</th>
			<th style="text-align: center;">Date</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($transfer_to_bran as $data)
			<tr>
				<td style="text-align: center;"><a href="{{ route('transfer_to_branch_show_details', $data->id ."=". $data->principal->principal ) }}" target="_blank">{{ $data->id }}</a></td>
				<td style="text-align: center;">{{ $data->principal->principal }}</td>
				<td style="text-align: center;">{{ $data->user->name }}</td>
				<td style="text-align: center;">{{ $data->branch }}</td>
				<td style="text-align: center;">{{ $data->date }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
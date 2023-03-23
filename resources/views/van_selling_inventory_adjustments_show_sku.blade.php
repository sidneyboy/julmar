<div class="table table-responsive">
	<table class="table table-bordered table-hover table-sm" id="example1">
		<thead>
			<tr>
				<th>Desc</th>
				<th>Ending Inventory</th>
				<th>Confirmed Quantity</th>
				<th>Remarks</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($inventory_ledger as $data)
				<tr>
					<td>{{ $data->sku_code }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
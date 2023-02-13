<div class="row">
	@foreach($store_name as $store_data)
		<div class="col-md-12">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>

						<th>Code</th>
						<th>QOH</th>
						<th>QOR</th>
						<th>TOTAL</th>
					</tr>
				</thead>
				<tbody>
				{{-- 	@foreach(array_combine($sku_code[$store_data], $quantity_on_hand) as $code => $quantity) --}}
						@foreach($sku_code[$store_data] as $code)
						<tr>
							<td>{{ $quantity_on_hand }}</td>
							<td>{{ $code }}</td>
						</tr>
						@endforeach
				</tbody>
			</table>
		</div>
	@endforeach
</div>

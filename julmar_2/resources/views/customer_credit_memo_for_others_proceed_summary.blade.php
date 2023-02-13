<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Code</th>
			<th>Description</th>
			<th>Type</th>
			<th>Price</th>
		</tr>
	</thead>
	<tbody>
		@foreach($sku as $data)
			<tr>
				<td>{{ $data->sku_code }}</td>
				<td>{{ $data->description }}</td>
				<td>{{ $data->sku_type }}</td>
				<td>
					<select class="form-control select2">
						<option value="" default>Select Price</option>
						@foreach($data->sku_price_details as $price_details)
							@if($price_level == 'price_1')
								<option value="{{ $price_details->id }}">
									{{ number_format($price_details->price_1,2,",",".") }}
								</option>
							@elseif($price_level == 'price_2')
								<option value="{{ $price_details->id }}">
									{{ number_format($price_details->price_2,2,",",".") }}
								</option>
							@elseif($price_level == 'price_3')
								<option value="{{ $price_details->id }}">
									{{ number_format($price_details->price_3,2,",",".") }}
								</option>
							@else
								<option value="{{ $price_details->id }}">
									{{ number_format($price_details->price_4,2,",",".") }}
								</option>
							@endif
						@endforeach
					</select>	
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
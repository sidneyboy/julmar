<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>SO NUMBER</th>
					<th>CUSTOMER</th>
					<th>DR NO</th>
					<th>ITEM CODE</th>
					<th>DESCRIPTION</th>
					<th>UOM</th>
					<th>SO QTY</th>
					<th>DR QTY</th>
					<th>QTY SHORTAGE</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sales_order as $data)
					@php
						$print_details_counter = count($data->sales_order_print_details);
						$order_details_counter = count($data->sales_order_details);
					@endphp
			    	@for ($i=0; $i < $print_details_counter; $i++) 
			    		<tr>
			    			<td>{{ $data->sales_order_number }}</td>
			    			<td>{{ $data->customer->store_name }}</td>
			    			<td>{{ $data->sales_order_print->dr }}</td>
			    			<td>{{ $data->sales_order_details[$i]->sku->sku_code }}</td>
							<td>{{ $data->sales_order_details[$i]->sku->description }}</td>
							<td>{{ $data->sales_order_details[$i]->sku->unit_of_measurement }}</td>
							<td>{{ $data->sales_order_details[$i]->quantity }}</td>
							<td>{{ $data->sales_order_print_details[$i]->quantity }}</td>
							<td>
								@php
									echo $data->sales_order_details[$i]->quantity - $data->sales_order_print_details[$i]->quantity;
								@endphp
							</td>
			    		</tr>
			    	@endfor	
				@endforeach
			</tbody>
		</table>
	</div>
</div>
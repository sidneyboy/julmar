<form id="van_selling_sales_order_save">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th colspan="2">SOLD TO: {{ $customer->store_name }}
					<input type="hidden" name="sold_to" value="{{ $customer->id }}">
				</th>
				<td style="text-align: center;font-weight: bold;text-transform: uppercase;">
					{{ $sales_order_agent_data->sales_order_number }}
					<input type="hidden" name="delivery_receipt" value="{{ $sales_order_agent_data->sales_order_number }}">
				</td>
				<th colspan="2">AGENT: {{ $agent->store_name }}
					<input type="hidden" name="customer_id" value="{{ $agent->id }}">
					<input type="hidden" name="store_code" value="{{ $agent->store_code }}">
				</th>
			</tr>
			<tr>
				<th>Code</th>
				<th>Description</th>
				<th>Qty</th>
				<th>Price</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			@foreach($sales_order_agent_data->sales_order_agent_details_holder as $data)
			<tr>
				<td>
					{{ $data->sku->sku_code }}
					<input type="hidden" name="sku[]" value="{{ $data->sku_id }}">
					<input type="hidden" name="principal_id[{{ $data->sku_id }}]" value="{{ $data->sku->principal_id }}">
					<input type="hidden" name="sku_type[{{ $data->sku_id }}]" value="{{ $data->sku->sku_type }}">
					<input type="hidden" name="category_id[{{ $data->sku_id }}]" value="{{ $data->sku->category_id }}">
				</td>
				<td>{{ $data->sku->description }}</td>
				<td style="text-align: right;">
					@php
					$sum_quantity[] = $data->quantity;
					@endphp
					{{ $data->quantity }}
					<input type="hidden" name="quantity[{{ $data->sku_id }}]" value="{{ $data->quantity }}">
				</td>
				<td style="text-align: right;">
					{{ number_format($data->price,2,".",",") }}
					<input type="hidden" name="price[{{ $data->sku_id }}]" value="{{ $data->price }}">
				</td>
				<td style="text-align: right;">
					@php
					$amount_per_sku = $data->quantity * $data->price;
					$sum_amount_per_sku[] = $amount_per_sku;
					echo number_format($amount_per_sku,2,".",",");
					@endphp
				</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="2">GRAND TOTAL</td>
				<td style="text-align: right;">{{ array_sum($sum_quantity) }}</td>
				<td></td>
				<td style="text-align: right;">
					{{ number_format(array_sum($sum_amount_per_sku) ,2,".",",") }}
					<input type="hidden" name="total_customer_payable_amount" value="{{ array_sum($sum_amount_per_sku) }}">
					
				</td>
			</tr>
			<tr>
				<td colspan="5"><button type="submit" class="btn btn-success btn-block">SUBMIT VAN SELLING</button></td>
			</tr>
		</tbody>
	</table>
</form>
<script type="text/javascript">
  $("#van_selling_sales_order_save").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
      
        $.ajax({
          url: "van_selling_sales_order_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            
            console.log(data);
            // if(data == 'existing sales_order_number'){
            //    Swal.fire(
            //   'Existing Sales Order Number, Cannot Proceed!!',
            //   '',
            //   'error'
            //   )
            //   $('.loading').hide(); 
            // }else{
            //   $('.loading').hide();

            //   $('#van_selling_sales_order_migrate_summary_page').html(data);
            // }
          },
        });
    }));

</script>
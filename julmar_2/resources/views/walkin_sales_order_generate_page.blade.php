<form id="walkin_sales_order_generate_final_summary">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th style="text-align: center;">CODE</th>
				<th style="text-align: center;">DESC</th>
				<th style="text-align: center;">SKU TYPE</th>
				<th style="text-align: center;">PRICE</th>
				<th style="text-align: center;">RB</th>
				<th style="text-align: center;">QTY</th>
				<th style="text-align: center;">LINE DISC 1</th>
				<th style="text-align: center;">LINE DISC 2</th>
			</tr>
		</thead>
		<tbody>
			@foreach($sku_data as $data)
				<tr>
					<td>
						<input type="hidden" name="sku[]" value="{{ $data->id }}">
						<input type="hidden" name="sku_code[{{ $data->id }}]" value="{{ $data->sku_code }}">
						<input type="hidden" name="category_id[{{ $data->id }}]" value="{{  $data->category_id }}">
						{{ $data->sku_code }}</td>
					<td>
						<input type="hidden" name="description[{{ $data->id }}]" value="{{ $data->description }}">
						{{ $data->description }}
					</td>
					<td>
						<input type="hidden" name="sku_type[{{ $data->id }}]" value="{{ $data->sku_type }}">
						{{ $data->sku_type }}
					</td>
					<td>
						@if($customer_principal_price->price_level == 'price_1')
							@php
								$sku_price = $data->sku_price_details_one->price_1;
							@endphp
						@elseif($customer_principal_price->price_level == 'price_2')
							@php
								$sku_price =  $data->sku_price_details_one->price_2;
							@endphp
						@elseif($customer_principal_price->price_level == 'price_3')
							
							@php
								$sku_price =  $data->sku_price_details_one->price_3;
							@endphp
						@elseif($customer_principal_price->price_level == 'price_4')
							@php
								$sku_price =  $data->sku_price_details_one->price_4;
							@endphp
						@else
							@php
								$sku_price =  $data->sku_price_details_one->price_5;
							@endphp
						@endif
						{{ number_format($sku_price,2,",",".") }}
						<input type="hidden" name="sku_price[{{ $data->id }}]" value="{{ $sku_price }}">
					</td>
					<td>
						<input type="hidden" name="remaining_balance[{{ $data->id }}]" value="{{ $data->sku_ledger_latest->running_balance }}">
						{{ $data->sku_ledger_latest->running_balance }}
					</td>
					<td style="text-align: center;">
						<input type="number" name="quantity[{{ $data->id }}]" class="form-control" required min="0" value="0" style="text-align: center;">
					</td>
					<td>
						<input type="text" class="currency-default" name="line_discount_rate_1[{{ $data->id }}]" style="display: block;
						    width: 100%;
						    height: calc(2.25rem + 2px);
						    padding: .375rem .75rem;
						    font-size: 1rem;
						    font-weight: 400;
						    line-height: 1.5;
						    color: #495057;
						    background-color: #fff;
						    background-clip: padding-box;
						    border: 1px solid #ced4da;
						    border-radius: .25rem;
						    box-shadow: inset 0 0 0 transparent;
						    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center;" value="0">
					</td>
					<td>
						<input type="text" class="currency-default" name="line_discount_rate_2[{{ $data->id }}]" style="display: block;
							width: 100%;
							height: calc(2.25rem + 2px);
							padding: .375rem .75rem;
							font-size: 1rem;
							font-weight: 400;
							line-height: 1.5;
							color: #495057;
							background-color: #fff;
							background-clip: padding-box;
							border: 1px solid #ced4da;
							border-radius: .25rem;
							box-shadow: inset 0 0 0 transparent;
							transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center;" value="0">
					</td>
				</tr>
			@endforeach
			<tr>
				<td colspan="8">
					<label>Customer discount</label>
					<select class="form-control select2" name="customer_discount[]" multiple="multiple" data-placeholder="Customer Discounts" style="width: 100%;">
						@foreach($customer_discount as $discount_data)
						<option selected value="{{ $discount_data->customer_discount }}">{{ $discount_data->customer_discount }}</option>
						@endforeach
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="principal_id" value="{{ $principal_id }}">
	<input type="hidden" name="principal_name" value="{{ $principal_name }}">
	<input type="hidden" name="customer_id" value="{{ $customer_id }}">
	<input type="hidden" name="store_name" value="{{ $store_name }}">
	<input type="hidden" name="type" value="{{ $type }}">
	<button type="submit" class="btn btn-info btn-block">PROCEED TO FINAL SUMMARY</button>
</form>

<script type="text/javascript">

	 
   $('.select2').select2()
     

	$('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
    $('[class=integer-default]').maskNumber({integer: true});
    $('[class=integer-data-attribute]').maskNumber({integer: true});
    $('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});

	 $("#walkin_sales_order_generate_final_summary").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
      
        $.ajax({
          url: "walkin_sales_order_generate_final_summary",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
             $('#walkin_sales_order_generate_final_summary_page').html(data);
          },
        });
    }));

</script>
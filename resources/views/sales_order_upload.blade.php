<form id="sales_order_proceed_to_summary">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th style="text-align: center;">
					{{ $sales_order->customer->store_name }}
					<input type="hidden" value="{{ $sales_order->customer->store_name }}" name="store_name">
					<input type="hidden" value="{{ $sales_order->id }}" name="sales_order_id">
					<input type="hidden" value="{{ $sales_order->customer_id }}" name="customer_id">
					<input type="hidden" value="{{ $sales_order->principal_id }}" name="principal_id">
					<input type="hidden" value="{{ $sales_order->sales_order_number }}" name="sales_order_number">
					<input type="hidden" value="{{ $sales_order->agent_id }}" name="agent_id">
				</th>
				<th style="text-align: center;">
					{{ $sales_order->customer->location->location }}
					<input type="hidden" value="{{ $sales_order->customer->location->location }}" name="location">
				</th>
				<th style="text-align: center;">
					{{ $sales_order->principal->principal }}
					<input type="hidden" value="{{ $sales_order->principal->principal }}" name="principal">
				</th>
				<th style="text-align: center;">
					{{ $sales_order->mode_of_transaction }}
					<input type="hidden" value="{{ $sales_order->mode_of_transaction }}" name="mode_of_transaction">
				</th>
				<th style="text-align: center;">
					{{ $sales_order->sku_type }}
					<input type="hidden" value="{{ $sales_order->sku_type }}" name="sku_type">
				</th>
				<th colspan="2" style="text-align: center;">{{ $sales_order->created_at }}</th>
			</tr>
			<tr>
				<th>CODE</th>
				<th>DESCRIPTION</th>
				<th>RUNNING BALANCE</th>
				<th>QUANTITY</th>
				<th>FINAL QUANTITY</th>
				<th>LINE DISCOUNT RATE 1</th>
				<th>LINE DISCOUNT RATE 2</th>
			</tr>
		</thead>
		<tbody>
			@foreach($sales_order->sales_order_details as $data)
			<tr>
				<td>
					@if($data->sku->sku_ledger_quantity->running_balance != 0)
						<input type="hidden" name="sku[]" value="{{ $data->sku_id }}">
						<input type="hidden" name="sku_code[{{ $data->sku_id }}]" value="{{ $data->sku->sku_code }}">
						{{ $data->sku->sku_code }}
					@else
						{{ $data->sku->sku_code }}
					@endif
				</td>
				<td>
					@if($data->sku->sku_ledger_quantity->running_balance != 0)
						{{ $data->sku->description }}
						<input type="hidden" name="description[{{ $data->sku_id }}]" value="{{ $data->sku->description }}">
					@else
						{{ $data->sku->description }}
					@endif
				</td>
				<td>
					@if($data->sku->sku_ledger_quantity->running_balance != 0)
						{{ $data->sku->sku_ledger_quantity->running_balance }}
						<input type="hidden" name="running_balance[{{ $data->sku_id }}]" value="{{ $data->sku->sku_ledger_quantity->running_balance }}">
					@else
						{{ $data->sku->sku_ledger_quantity->running_balance }}
					@endif
				</td>
				<td>
					@if($data->sku->sku_ledger_quantity->running_balance != 0)
						{{ $data->quantity }}
						<input type="hidden" name="quantity[{{ $data->sku_id }}]" value="{{ $data->quantity }}">
					@else
						{{ $data->quantity }}
					@endif
				</td>
				
				<td>
					@if($data->sku->sku_ledger_quantity->running_balance != 0 )
						<input type="number" style="text-align: center;" value="0" min="0" name="final_quantity[{{ $data->sku_id }}]" required class="form-control">
					@else
						<input type="number" style="text-align: center;" value="0" min="0" disabled name="final_quantity[{{ $data->sku_id }}]" required class="form-control">
					@endif
					

				</td>
				<td>
					@if($data->sku->sku_ledger_quantity->running_balance != 0)
						<input type="text" required name="line_discount_rate_1[{{ $data->sku_id }}]" value="0" min="0" class="currency-default" style="display: block;
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
						transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center;">
					@else
						<input type="text" required name="line_discount_rate_1[{{ $data->sku_id }}]" disabled value="0" min="0" class="currency-default" style="display: block;
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
						transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center;">
					@endif
				</td>
				<td>
					@if($data->sku->sku_ledger_quantity->running_balance != 0)
						<input type="text" required name="line_discount_rate_2[{{ $data->sku_id }}]" value="0" min="0" class="currency-default" style="display: block;
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
				transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center;">
					@else
						<input type="text" required name="line_discount_rate_2[{{ $data->sku_id }}]" disabled value="0" min="0" class="currency-default" style="display: block;
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
						transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center;">
					@endif
				</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="7">
					<label>Customer discount:</label>
					<select class="form-control select2" name="customer_discount[]" multiple="multiple" data-placeholder="Customer Discounts" style="width: 100%;">
						@foreach($customer_discount as $data)
						<option value="{{ $data->customer_discount }}" selected>{{ $data->customer_discount }}</option>
						@endforeach
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="7"><button type="submit" class="btn btn-info btn-block">PROCEED</button></td>
			</tr>
		</tbody>
	</table>
</form>

<script type="text/javascript">
	$('.select2').select2();
      //Initialize Select2 Elements

    $('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
    $('[class=integer-default]').maskNumber({integer: true});
    $('[class=integer-data-attribute]').maskNumber({integer: true});
    $('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});

     $("#sales_order_proceed_to_summary").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "sales_order_proceed_to_summary",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            if(data == 'FINAL QUANTITY IS GREATER THAN RUNNING BALANCE'){
              Swal.fire(
              'ERROR INPUT',
              'FINAL QUANTITY IS GREATER THAN RUNNING BALANCE',
              'error'
              )
              $('.loading').hide(); 
            }else{
              $('.loading').hide(); 
              $('#sales_order_proceed_to_summary_page').html(data);
            }
          },
        });
    }));

</script>
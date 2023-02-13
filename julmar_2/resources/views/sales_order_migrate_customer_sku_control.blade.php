<form target="_blank" action="{{ route('sales_order_migrate_print_salesman_control') }}" enctype="multipart/form-data" method="post">
	@csrf
	<table class="table table-bordered table-hovered">
		<thead>
			<tr>
				<th colspan="4">
					SALESMAN: {{ $salesman }}
					<input type="hidden" name="salesman" value="{{ $salesman }}">
				</th>
				<th colspan="4" style="text-align: right;"><button type="submit" class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i> PRINT SALES MAN CONTROL</button></th>
			</tr>
			<tr>
				<th style="text-align: center;">DR NO</th>
				<th style="text-align: center;">CUSTOMER</th>
				<th style="text-align: center;">TRANSACTION</th>
				<th style="text-align: center;">AMOUNT</th>
				<th style="text-align: center;">CUSTOMER DISC</th>
				<th style="text-align: center;">CATEGORY DISC</th>
				<th style="text-align: center;">NET AMOUNT</th>
				<th style="text-align: center;">DRIVER</th>
			</tr>
		</thead>
		<tbody>
			@foreach($select_sales_order_printed as $data)
			<tr>
				<td style="text-align: center;">
					{{ $data->delivery_receipt }}
					<input type="hidden" name="sales_order_number" value="{{ $sales_order_number }}">
					<input type="hidden" name="delivery_receipt[]" value="{{ $data->delivery_receipt }}">
				</td>
				<td style="text-align: center;text-transform: uppercase;">
					{{ $data->customer->store_name }}
					<input type="hidden" name="store_name[]" value="{{ $data->customer->store_name }}">
				</td>
				<td style="text-align: center;">
					{{ $data->mode_of_transaction }}
					<input type="hidden" name="mode_of_transaction[]" value="{{ $data->mode_of_transaction }}">
				</td>
				<td style="text-align: right;">
					@php
					$total_amount = $data->total_customer_payable_amount + $data->total_category_discount_amount + $data->total_customer_discount_amount;
					$total_amount_array[] = $total_amount;
					@endphp
					{{ number_format($total_amount,2,".",",")  }}
					<input type="hidden" name="total_amount[]" value="{{ $total_amount }}">
				</td>
				<td style="text-align: right;">
					@php
					$total_customer_discount_amount_array[] = $data->total_customer_discount_amount;
					@endphp
					{{ number_format($data->total_customer_discount_amount,2,".",",") }}
					<input type="hidden" name="total_customer_discount_amount[]" value="{{ $data->total_customer_discount_amount }}">
				</td>
				<td style="text-align: right;">
					@php
					$total_category_discount_amount_array[] = $data->total_category_discount_amount;
					@endphp
					{{ number_format($data->total_category_discount_amount,2,".",",") }}
					<input type="hidden" name="total_category_discount_amount[]" value="{{ $data->total_category_discount_amount }}">
				</td>
				<td style="text-align: right;">
					@php
					$total_payable_amount_array[] = $data->total_customer_payable_amount;
					@endphp
					{{ number_format($data->total_customer_payable_amount,2,".",",") }}
					<input type="hidden" name="total_customer_payable_amount[]" value="{{ $data->total_customer_payable_amount }}">
				</td>
				<td></td>
			</tr>
			@endforeach
			<tr>
				<td colspan="3" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
				<td style="text-align: right;font-weight: bold;">
					{{ number_format(array_sum($total_amount_array),2,".",",") }}
					<input type="hidden" name="total_amount_array" value="{{ array_sum($total_amount_array) }}">
				</td>
				<td style="text-align: right;font-weight: bold;">
					{{ number_format(array_sum($total_customer_discount_amount_array),2,".",",") }}
					<input type="hidden" name="total_customer_discount_amount_array" value="{{ array_sum($total_customer_discount_amount_array) }}">
				</td>
				<td style="text-align: right;font-weight: bold;">
					{{ number_format(array_sum($total_category_discount_amount_array),2,".",",") }}
					<input type="hidden" name="total_category_discount_amount_array" value="{{ array_sum($total_category_discount_amount_array) }}">
				</td>
				<td style="text-align: right;font-weight: bold;">
					{{ number_format(array_sum($total_payable_amount_array),2,".",",") }}
					<input type="hidden" name="total_payable_amount_array" value="{{ array_sum($total_payable_amount_array) }}">
				</td>
				<td></td>
			</tr>
		</tbody>
	</table>
</form>
<form target="_blank" action="{{ route('sales_order_migrate_print_sku_control') }}" enctype="multipart/form-data" method="post">
	@csrf
	<table class="table table-bordered table-hovered">
		<thead>
			<tr>
				<th colspan="5" style="text-align: right;"><button type="submit" class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i> PRINT SKU CONTROL</button></th>
			</tr>
			<tr>
				<th style="text-align: center;">CODE</th>
				<th style="text-align: center;">DESCRIPTION</th>
				<th style="text-align: center;">UOM</th>
				<th style="text-align: center;">QTY</th>
				<th style="text-align: center;">NET AMOUNT
					<input type="hidden" name="salesman" value="{{ $salesman }}">
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach($select_sku_group_by as $sku_group)
			<tr>
				<td style="text-align: center;">
					{{ $sku_group->sku->sku_code }}
					<input type="hidden" name="sku[]" value="{{ $sku_group->sku->sku_code }}">
				</td>
				<td style="text-align: center;">
					{{ $sku_group->sku->description }}
					<input type="hidden" name="description[]" value="{{ $sku_group->sku->description }}">
				</td>
				<td style="text-align: center;">
					{{ $sku_group->sku->unit_of_measurement }}
					<input type="hidden" name="unit_of_measurement[]" value="{{ $sku_group->sku->unit_of_measurement }}">
				</td>
				<td style="text-align: center;">
					{{ $sku_quantity_array[$sku_group->sku_id] }}
					<input type="hidden" name="sku_quantity[]" value="{{ $sku_quantity_array[$sku_group->sku_id] }}">
				</td>
				<td style="text-align: right;">
					@php
					$sku_total_amount_array[] = $sku_final_amount_per_sku[$sku_group->sku_id];
					@endphp
					{{  number_format($sku_final_amount_per_sku[$sku_group->sku_id],2,".",",")  }}
					<input type="hidden" name="sku_final_amount_per_sku[]" value="{{ $sku_final_amount_per_sku[$sku_group->sku_id] }}">
				</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="4" style="text-align: center;font-weight: bold;">TOTAL</td>
				<td style="text-align: right;font-weight: bold;">
					{{ number_format(array_sum($sku_total_amount_array),2,".",",") }}
					<input type="hidden" name="sku_total_amount_array" value="{{ array_sum($sku_total_amount_array) }}">
				</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: center;font-weight: bold;">TOTAL CUSTOMER DISCOUNT</td>
				<td style="text-align: right;font-weight: bold;">
					({{ number_format(array_sum($total_customer_discount_amount_array),2,".",",") }})
					<input type="hidden" name="total_customer_discount_amount_array" value="{{ array_sum($total_customer_discount_amount_array) }}">
				</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
				<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sku_total_amount_array) - array_sum($total_customer_discount_amount_array),2,".",",") }}</td>
				<input type="hidden" name="grand_total" value="{{ array_sum($sku_total_amount_array) - array_sum($total_customer_discount_amount_array) }}">
			</tr>
		</tbody>
	</table>
	
</form>
<form id="save_control_form">
	<input type="hidden" name="sales_order_number" value="{{ $sales_order_number }}">
	<button class="btn btn-block btn-success" type="submit">SAVE AND END TRANSACTION</button>
</form>

<script type="text/javascript">
	 $.ajaxSetup({
	      headers: {
	          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	      }
	  });
	 $("#save_control_form").on('submit',(function(e){
	      e.preventDefault();
	      $('.loading').show();
	        $.ajax({
	          url: "sales_order_upload_save_control",
	          type: "POST",
	          data:  new FormData(this),
	          contentType: false,
	          cache: false,
	          processData:false,
	          success: function(data){
	          	console.log(data);
	            if(data == 'saved'){
	               Swal.fire(
	              'Successfully printed sales order',
	              '',
	              'success'
	              )
	               location.reload();
	              
	            }else{
	              $('.loading').hide();

	              $('#sales_order_migrate_summary_page').html(data);
	            }
	          },
	        });
	    }));
</script>
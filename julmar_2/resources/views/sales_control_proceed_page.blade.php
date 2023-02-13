<form action="{{ route('sales_control_proceed_to_print_dr') }}" method="get" target="_blank">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th colspan="7" style="text-align: center;">SKU CONTROL FROM ALL CUSTOMERS</th>
			</tr>
			<tr>
				<th>SKU</th>
				<th>DESCRIPTION</th>
				<th>SKU TYPE</th>
				<th>QUANTITY</th>
				<th>AMOUNT</th>
				<th>LINE DISC</th>
				<th>SUB-TOTAL</th>
			</tr>
		</thead>
		<tbody>
			@foreach($details as $data)
			<tr>
				<td>
					<input type="hidden" name="sku_id[]" value="{{ $data->sku_id }}">
					<input type="hidden" name="sku_code[{{ $data->sku_id }}]" value="{{ $data->sku->sku_code }}">
					{{ $data->sku->sku_code }}
				</td>
				<td>
					<input type="hidden" name="description[{{ $data->sku_id }}]" value="{{ $data->sku->description }}">
					{{ $data->sku->description }}
				</td>
				<td>
					<input type="hidden" name="sku_type[{{ $data->sku_id }}]" value="{{ $data->sku->sku_type }}">
					{{ $data->sku->sku_type }}
				</td>
				<td style="text-align:right;">
					<input type="hidden" name="quantity[{{ $data->sku_id }}]" value="{{ $quantity[$data->sku_id] }}">
					{{ $quantity[$data->sku_id] }}
				</td>
				<td style="text-align:right;">
					@php
					$sum_amount[] = $amount[$data->sku_id];
					@endphp
					{{ number_format($amount[$data->sku_id],2,".",",") }}
					<input type="hidden" name="amount[{{ $data->sku_id }}]" value="{{ $amount[$data->sku_id] }}">
				</td>
				<td style="text-align:right;">
					@php
					$sum_line_discount[] = $line_discount[$data->sku_id];
					@endphp
					{{ number_format($line_discount[$data->sku_id],2,".",",")  }}
					<input type="hidden" name="line_discount[{{ $data->sku_id }}]" value="{{ $line_discount[$data->sku_id] }}">
				</td>
				<td style="text-align:right;">
					@php
					$sum_sub_total[] = $sub_total[$data->sku_id];
					@endphp
					{{ number_format($sub_total[$data->sku_id],2,".",",")  }}
					<input type="hidden" name="sub_total[{{ $data->sku_id }}]" value="{{ $sub_total[$data->sku_id] }}">
				</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="4"></td>
				<td style="text-align: right;font-weight: bold">
					{{ number_format(array_sum($sum_amount),2,".",",")  }}
					<input type="hidden" name="sum_amount" value="{{ array_sum($sum_amount) }}">
				</td>
				<td style="text-align: right;font-weight: bold">
					{{ number_format(array_sum($sum_line_discount),2,".",",")  }}
					<input type="hidden" name="sum_line_discount" value="{{ array_sum($sum_line_discount) }}">
				</td>
				<td style="text-align: right;font-weight: bold">
					{{ number_format(array_sum($sum_sub_total),2,".",",") }}
					<input type="hidden" name="sum_sub_total" value="{{ array_sum($sum_sub_total) }}">
				</td>
			</tr>
			@foreach($sales_order_print as $print)
			<tr>
				<td colspan="2">
					{{ $print->customer->store_name }}
					<input type="hidden" name="print_id[]" value="{{ $print->id }}">
					<input type="hidden" name="store_name[{{ $print->id }}]" value="{{ $print->customer->store_name }}">
				</td>
				<td>
					{{ $print->sales_order_number }}
					<input type="hidden" name="sales_order_number[{{ $print->id }}]" value="{{ $print->sales_order_number }}">
				</td>
				<td>
					{{ $print->mode_of_transaction }}
					<input type="hidden" name="mode_of_transaction[{{ $print->id }}]" value="{{ $print->mode_of_transaction }}">
				</td>
				<td>
					{{ $print->dr }}
					<input type="hidden" name="dr[{{ $print->id }}]" value="{{ $print->dr }}">
				</td>
				<td>
					{{ $print->principal->principal }}
					<input type="hidden" name="principal[{{ $print->id }}]" value="{{ $print->principal->principal }}">
				</td>
				<td style="text-align: right;">
					@php
					$sum_total_customer_discount_top[] = $print->total_customer_discount;
					@endphp
					{{ number_format($print->total_customer_discount,2,".",",") }}
					<input type="hidden" name="total_customer_discount_top[{{ $print->id }}]" value="{{ $print->total_customer_discount }}">
				</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="6" style="text-align: center;font-weight: bold">SKU CONTROL GRAND TOTAL</td>
				<td style="text-align: right;font-weight: bold">
					{{ number_format(array_sum($sum_sub_total) - array_sum($sum_total_customer_discount_top),2,".",",") }}
					<input type="hidden" name="grand_total" value="{{ array_sum($sum_sub_total) - array_sum($sum_total_customer_discount_top) }}">
				</td>
			</tr>
		</tbody>
	</table>


	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<td colspan="8" style="font-weight: bold;text-align: center;">SALESMAN CONTROL LIST OF CUSTOMER</td>
			</tr>
			<tr>
				<th style="text-align: center;">DR NO</th>
				<th style="text-align: center;">CUSTOMER</th>
				<th style="text-align: center;">MOT</th>
				<th style="text-align: center;">AMOUNT</th>
				<th style="text-align: center;">LINE DISC</th>
				<th style="text-align: center;">CUSTOMER DISC</th>
				<th style="text-align: center;">NET AMOUNT</th>
				<th style="text-align: center;">DRIVER</th>
			</tr>
		</thead>
		<tbody>
			@foreach($sales_order_print as $data)
			<tr>
				<td>
					<input type="hidden" name="so_id[]" value="{{ $data->id }}">
					<input type="hidden" name="so_dr[{{ $data->id }}]" value="{{ $data->dr }}">
					{{ $data->dr }}
				</td>
				<td>
					{{ $data->customer->store_name }}
					<input type="hidden" name="so_store_name[{{ $data->id }}]" value="{{ $data->customer->store_name }}">
				</td>
				<td>
					{{ $data->mode_of_transaction }}
					<input type="hidden" name="so_mode_of_transaction[{{ $data->id }}]" value="{{ $data->mode_of_transaction }}">
				</td>
				<td  style="text-align: right;">
					{{ number_format($print->total_amount + $print->total_line_discount + $print->total_customer_discount,2,".",",") }}
					@php
						$sum_customer_total_amount[] = $print->total_amount + $print->total_line_discount + $print->total_customer_discount;
					@endphp
					<input type="hidden" name="so_amount[{{ $data->id }}]" value="{{ $print->total_amount + $print->total_line_discount + $print->total_customer_discount }}">

				</td>
				<td style="text-align: right;">
					@php
					$sum_total_line_discount[] = $data->total_line_discount;
					@endphp
					{{ number_format($data->total_line_discount,2,".",",") }}
					<input type="hidden" name="so_total_line_discount[{{ $data->id }}]" value="{{ $data->total_line_discount }}">
				</td>
				<td style="text-align: right;">
					@php
					$sum_total_customer_discount_below[] = $data->total_customer_discount;
					@endphp
					{{ number_format($data->total_customer_discount,2,".",",") }}
					<input type="hidden" name="so_total_customer_discount[{{ $data->id }}]" value="{{ $data->total_customer_discount }}">
				</td>
				<td style="text-align: right;">
					@php
					$sum_total_amount[] = $data->total_amount;
					@endphp
					{{ number_format($data->total_amount,2,".",",") }}
					<input type="hidden" name="so_total_amount[{{ $data->id }}]" value="{{ $data->total_amount }}">
				</td>
				<td style="text-align: right;"></td>
			</tr>
			@endforeach
			<tr>
				<td colspan="3" style="text-align: center;font-weight: bold">SALESMAN CONTROL GRANDTOTAL</td>
				<td style="text-align: right;font-weight: bold">
					{{ number_format(array_sum($sum_customer_total_amount),2,".",",") }}
				</td>
				<td style="text-align: right;font-weight: bold">
					{{ number_format(array_sum($sum_total_line_discount),2,".",",") }}
					<input type="hidden" name="so_sum_total_line_discount" value="{{ array_sum($sum_total_line_discount) }}">
				</td>
				<td style="text-align: right;font-weight: bold">
					{{ number_format(array_sum($sum_total_customer_discount_below),2,".",",") }}
					<input type="hidden" name="so_sum_total_customer_discount_below" value="{{ array_sum($sum_total_customer_discount_below) }}">
				</td>
				<td style="text-align: right;font-weight: bold">
					{{ number_format(array_sum($sum_total_amount),2,".",",") }}
					<input type="hidden" name="so_sum_total_amount" value="{{ array_sum($sum_total_amount) }}">
				</td>
			</tr>
		</tbody>
	</table>
	<div class="row">
		<div class="col-md-12">
			<label>&nbsp;</label>
			<button type="submit" class="btn btn-success btn-block" target="_blank"><span class="fas fa-print"></span> PRINT DR AND SALESMAN CONTROL</button>
		</div>
	</div>
</form>


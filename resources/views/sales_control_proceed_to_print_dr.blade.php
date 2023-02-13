<link rel="stylesheet" href="{{ asset('/adminLte/dist/css/adminlte.min.css') }}">
<link rel="stylesheet" href="{{ asset('/adminLte/plugins/fontawesome-free/css/all.min.css') }}">
<br />
<div class="row">
	<div class="col-md-6">
		<button onclick="print_sku_control()" class="float-left btn btn-primary btn-flat btn-sm">PRINT SKU CONTROL</button>
	</div>
	<div class="col-md-6">
		<button onclick="print_salesman_control()" class="float-right btn btn-success btn-flat btn-sm">PRINT SALESMAN CONTROL</button>
	</div>
</div>
<br />
<div class="row">
	<div class="col-md-12">
		<table {{-- class="table table-bordered table-hover table-sm" --}} id="print_sku_control" width="100%" border="1" cellpadding="1">
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
				@foreach($sku_id as $data)
				<tr>
					<td>{{ $sku_code[$data] }}</td>
					<td>{{ $description[$data] }}</td>
					<td>{{ $sku_type[$data] }}</td>
					<td style="text-align: right">{{ number_format($quantity[$data],2,".",",")  }}</td>
					<td style="text-align: right">{{ number_format($amount[$data],2,".",",")  }}</td>
					<td style="text-align: right">{{ number_format($line_discount[$data],2,".",",")  }}</td>
					<td style="text-align: right">{{ number_format($sub_total[$data],2,".",",")  }}</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="4"></td>
					<td style="text-align: right;font-weight: bold">
						{{ number_format($sum_amount,2,".",",")  }}
						
					</td>
					<td style="text-align: right;font-weight: bold">
						{{ number_format($sum_line_discount,2,".",",")  }}
						
					</td>
					<td style="text-align: right;font-weight: bold">
						{{ number_format($sum_sub_total,2,".",",") }}
						
					</td>
				</tr>
				@foreach($print_id as $data)
				<tr>
					<td colspan="2">
						{{ $store_name[$data] }}
					</td>
					<td>
						{{ $sales_order_number[$data] }}
					</td>
					<td>
						{{ $mode_of_transaction[$data] }}
					</td>
					<td>
						{{ $dr[$data] }}
					</td>
					<td>
						{{ $principal[$data] }}
					</td>
					<td style="text-align: right;">
						{{ number_format($total_customer_discount_top[$data],2,".",",") }}
						
					</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="6" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
					<td style="text-align: right;font-weight: bold">
						{{ number_format($grand_total,2,".",",") }}
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<br /><br />

<div class="row">
	<div class="col-md-12">
		<table {{-- class="table table-bordered table-hover table-sm" --}}id="print_salesman_control" width="100%" border="1" cellpadding="1">
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
				@foreach($so_id as $data)
				<tr>
					<td>
						
						{{ $so_dr[$data] }}
					</td>
					<td>
						{{ $so_store_name[$data] }}
						
					</td>
					<td>
						{{ $so_mode_of_transaction[$data] }}
						
					</td>
					<td style="text-align: right">
						{{ number_format($so_amount[$data],2,".",",") }}
						@php
							$grantotal_amount[] = $so_amount[$data];
						@endphp
						
					</td>
					<td style="text-align: right">
						
						{{ number_format($so_total_line_discount[$data],2,".",",") }}
						
					</td>
					<td style="text-align: right">
						
						{{ number_format($so_total_customer_discount[$data],2,".",",") }}
						
					</td>
					<td style="text-align: right">
						
						{{ number_format($so_total_amount[$data],2,".",",") }}
						
					</td>
					<td></td>
				</tr>
				@endforeach
				<tr>
					<td colspan="3" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
					<td style="text-align: right;font-weight: bold">
						{{ number_format(array_sum($grantotal_amount),2,".",",") }}
						
					</td>
					<td style="text-align: right;font-weight: bold">
						{{ number_format($so_sum_total_line_discount,2,".",",") }}
						
					</td>
					<td style="text-align: right;font-weight: bold">
						{{ number_format($so_sum_total_customer_discount_below,2,".",",") }}
						
					</td>
					<td style="text-align: right;font-weight: bold">
						{{ number_format($so_sum_total_amount,2,".",",") }}
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>









<script type="text/javascript">
	function print_sku_control()
	{
	   var divToPrint=document.getElementById("print_sku_control");
	   newWin= window.open("");
	   newWin.document.write(divToPrint.outerHTML);
	   newWin.print();
	   newWin.close();
	}

	function print_salesman_control()
	{
	   var divToPrint=document.getElementById("print_salesman_control");
	   newWin= window.open("");
	   newWin.document.write(divToPrint.outerHTML);
	   newWin.print();
	   newWin.close();
	}
</script>
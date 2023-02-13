  <link rel="stylesheet" href="{{ asset('/adminLte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/adminLte/dist/css/adminlte.min.css') }}">
  <style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        margin: 10;  /* this affects the margin in the printer settings */
    }
  </style>
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <center>
           <h2 class="page-header">
            <img src="{{ asset('/adminLte/julmar.png') }}" style="width:50px;" alt=""> JULMAR COMMERCIAL. INC,
           </h2>
        </center>
      </div>
      <!-- /.col -->
    </div><br />
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-12 invoice-col">
		<table class="table table-bordered table-hovered">
			<thead>
				<tr>
					<th colspan="8" style="text-transform: uppercase;">SALESMAN: {{ $agent_name }}</th>
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
						<td style="text-align: center;">{{ $data->delivery_receipt }}</td>
						<td style="text-align: center;">{{ $data->customer->store_name }}</td>
						<td style="text-align: center;">{{ $data->mode_of_transaction }}</td>
						<td style="text-align: right;">
							@php
								$total_amount = $data->total_customer_payable_amount + $data->total_category_discount_amount + $data->total_customer_discount_amount;
								$sum_total_amount[] = $total_amount;
							@endphp
							{{ number_format($total_amount,2,".",",") }}
						</td>
						<td style="text-align: right;">
							@php
								$total_customer_discount_amount = $data->total_customer_discount_amount;
								$sum_total_customer_discount_amount[] = $total_customer_discount_amount;
							@endphp
							{{ number_format($total_customer_discount_amount,2,".",",") }}
						</td>
						<td style="text-align: right;">
							@php
								$total_category_discount_amount = $data->total_category_discount_amount;
								$sum_total_category_discount_amount[] = $total_category_discount_amount;
							@endphp
							{{ number_format($total_category_discount_amount,2,".",",") }}
						</td>
						<td style="text-align: right;">
							@php
								$total_customer_payable_amount = $data->total_customer_payable_amount;
								$sum_total_customer_payable_amount[] = $total_customer_payable_amount;
							@endphp
							{{ number_format($total_customer_payable_amount,2,".",",") }}
						</td>
						<td></td>
					</tr>
				@endforeach
					<tr>
						<td style="text-align: center;font-weight: bold" colspan="3">GRAND TOTAL</td>
						<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_total_amount),2,".",",") }}</td>
						<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_total_customer_discount_amount),2,".",",") }}</td>
						<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_total_category_discount_amount),2,".",",") }}</td>
						<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_total_customer_payable_amount),2,".",",") }}</td>
						<td></td>
					</tr>
			</tbody>
		</table>
		<table class="table table-bordered table-hovered">
			<thead>
				<tr>
					<th style="text-align: center;">CODE</th>
					<th style="text-align: center;">DESCRIPTION</th>
					<th style="text-align: center;">UOM</th>
					<th style="text-align: center;">QTY</th>
					<th style="text-align: center;">NET AMOUNT</th>
				</tr>
			</thead>
			<tbody>
				@foreach($select_sku_group_by as $sku_group)
				<tr>
					<td style="text-align: center;">{{ $sku_group->sku->sku_code }}</td>
					<td style="text-align: center;">{{ $sku_group->sku->description }}</td>
					<td style="text-align: center;">{{ $sku_group->sku->unit_of_measurement }}</td>
					<td style="text-align: center;">{{ $sku_quantity_array[$sku_group->sku_id] }}</td>
					<td style="text-align: right;">
						@php
						$sku_total_amount_array[] = $sku_final_amount_per_sku[$sku_group->sku_id];
						@endphp
						{{  number_format($sku_final_amount_per_sku[$sku_group->sku_id],2,".",",")  }}
					</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="4" style="text-align: center;font-weight: bold;">TOTAL</td>
					<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sku_total_amount_array),2,".",",") }}</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align: center;font-weight: bold;">TOTAL CUSTOMER DISCOUNT</td>
					<td style="text-align: right;font-weight: bold;">({{ number_format(array_sum($sum_total_customer_discount_amount),2,".",",") }})</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
					<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sku_total_amount_array) - array_sum($sum_total_customer_discount_amount),2,".",",") }}</td>
				</tr>
			</tbody>
		</table>
      </div>
    </div>
   
    <!-- /.row -->
    <br /><br />
 
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>

<script type="text/javascript"> 
     //window.addEventListener("load", window.print());
</script>
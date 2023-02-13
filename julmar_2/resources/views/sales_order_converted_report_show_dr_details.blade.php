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
           		<button class="btn btn-danger" id="cancel_dr" value="{{ $delivery_receipt }}" style="font-weight: bold;">CANCEL DR</button>
           </h2>
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
       	<center>
				<h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5>
				<h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
				</center>
				<br />
				<h5 style="text-align: center;font-weight: bold;">Delivery Receipt</h5>
			<table class="table table-borderless" style="border:none;"> {{-- class='table table-borderless' --}}
				<thead>
					<tr>
						<th  style="width:20%;line-height:0px"><span class="float-right">Bill To:</span></th>
						<th  style="width:30%;line-height:0px;text-transform: uppercase;">{{ $store_name }}</th>
						<th  style="width:20%;line-height:0px"><span class="float-right">Dr Number:</span></th>
						<th  style="width:30%;line-height:0px">{{ $delivery_receipt }}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="line-height:0px;"><span class="float-right">Store Code:</span></td>
						<td style="line-height:0px;">{{ $store_code }}</td>
						<td style="line-height:0px;"><span class="float-right">DR Date :</span></td>
						<td style="line-height:0px;">{{ $date }}</td>
					</tr>
					<tr>
						<td style="line-height:0px;"><span class="float-right">Address:</span></td>
						<td style="line-height:0px;">{{ ucfirst($detailed_location) }}</td>
						<td style="line-height:0px;"><span class="float-right">SO No:</span></td>
						<td style="line-height:0px;">{{ $sales_order_number }}</td>
					</tr>
					<tr>
						<td style="line-height:0px;"><span class="float-right">Area:</span></td>
						<td style="line-height:0px;">{{ ucfirst($area) }}</td>
						<td style="line-height:0px;"><span class="float-right">CUSTOMER PO NO::</span></td>
						<td style="line-height:0px;">N/a</td>
					</tr>
					<tr>
						<td colspan="4"></td>
					</tr>
					<tr>
						<td style="line-height:0px;"><span class="float-right">Transaction:</span></td>
						<td style="line-height:0px;">{{ $mode_of_transaction }}
						</td>
						<td style="line-height:0px;"><span class="float-right">Salesman:</span></td>
						<td style="line-height:0px;">{{ $agent_name }}</td>
					</tr>
					<tr>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"><span class="float-right">Payment Terms:</span></td>
						<td style="line-height:0px;">{{ $credit_term_days }}</td>
					</tr>
					<tr>
						@php
						$due_date = date('Y-m-d', strtotime($date. $credit_term_days));
						@endphp
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"><span class="float-right">Due Date:</span></td>
						<td style="line-height:0px;">{{ $due_date }}</td>
					</tr>
				</tbody>
			</table>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th style="text-align: center;">Code</th>
						<th style="text-align: center;">Description</th>
						<th style="text-align: center;">Quantity</th>
						<th style="text-align: center;">Price</th>
						<th style="text-align: center;">Amount</th>
						@foreach($select_sales_order_printed_details as $details)
							@if($details->category_discount_rate_1 == 0.0000)

							@else
								<th>Category Discount Rate</th>
							@endif

							@if($details->category_discount_rate_2 == 0.0000)

							@else
								<th>Category Discount Rate</th>
							@endif

							@if($details->category_discount_rate_3 == 0.0000)

							@else
								<th>Category Discount Rate</th>
							@endif

							@if($details->category_discount_rate_4 == 0.0000)

							@else
								<th>Category Discount Rate</th>
							@endif
						@endforeach
						<th style="text-align: center;color:green;">Total<br />Category<br />Disc</th>
						<th style="text-align: center;color:green;">Net<br />Amount</th>
					</tr>
				</thead>
				<tbody>
					@foreach($select_sales_order_printed_details as $details)
						<tr>
							<td style="text-align: center;">{{ $details->sku->sku_code }}</td>
							<td style="text-align: center;">{{ $details->sku->description }}</td>
							<td style="text-align: center;">{{ $details->quantity }}</td>
							<td style="text-align: center;">{{ $details->price }}</td>
							<td style="text-align: right;font-weight: bold">
								@php
									$total_amount_per_sku = $details->quantity * $details->price;
									$sum_total_amount_per_sku[] = $total_amount_per_sku;
								@endphp
								{{ number_format($total_amount_per_sku,2,",",".") }}
							</td>
							@if($details->category_discount_rate_1
							 == 0)
								@php
								$category_discount_line_rate_1 = 0;
								@endphp
							@else
							<td style="text-align: right;">
								@php
								$category_discount_rate_1 = $total_amount_per_sku - $total_amount_per_sku * $details->category_discount_rate_1/100;
								$category_discount_line_rate_1 = $total_amount_per_sku * $details->category_discount_rate_1/100;
								echo number_format($category_discount_line_rate_1,2,".",",");
								@endphp
							</td>
							@endif
							@if($details->category_discount_rate_2 == 0)
								@php
								$category_discount_line_rate_2 = 0;
								@endphp
							@else
							<td style="text-align: right;">
								@php
								$category_discount_rate_2 = $category_discount_rate_1 - $category_discount_rate_1 * $details->category_discount_rate_2/100;
								$category_discount_line_rate_2 = $category_discount_rate_1 * $details->category_discount_rate_2/100;
								echo number_format($category_discount_line_rate_2,2,".",",");
								@endphp
							</td>
							@endif
							@if($details->category_discount_rate_3 == 0)
								@php
								$category_discount_line_rate_3 = 0;
								@endphp
							@else
							<td style="text-align: right;">
								@php
								$category_discount_rate_3 = $category_discount_rate_2 - $category_discount_rate_2 * $details->category_discount_rate_3/100;
								$category_discount_line_rate_3 = $category_discount_rate_2 * $details->category_discount_rate_3/100;
								echo number_format($category_discount_line_rate_3,2,".",",");
								@endphp
							</td>
							@endif
							@if($details->category_discount_rate_4 == 0)
								@php
								$category_discount_line_rate_4 = 0;
								@endphp
							@else
							<td style="text-align: right;">
								@php
								$category_discount_rate_4 = $category_discount_rate_3 - $category_discount_rate_3 * $details->category_discount_rate_4/100;
								$category_discount_line_rate_4 = $category_discount_rate_3 * $details->category_discount_rate_4/100;
								echo number_format($category_discount_line_rate_4,2,".",",");
								@endphp
							</td>
							@endif
							@if($category_discount_line_rate_1 != 0 OR $category_discount_line_rate_2 != 0 OR $category_discount_line_rate_3 != 0 OR $category_discount_line_rate_4 != 0)
								@php
								$final_category_discount_amount_per_sku = $category_discount_line_rate_1 + $category_discount_line_rate_2 + $category_discount_line_rate_3 + $category_discount_line_rate_4;
								$total_category_discount_array[] = $final_category_discount_amount_per_sku;
								@endphp
								<td style="text-align: right;font-weight: bold;">{{ number_format($final_category_discount_amount_per_sku,2,".",",") }}
									
								</td>
							@else
								@php
								$final_category_discount_amount_per_sku = 0;
								$total_category_discount_array[] = 0;
								@endphp
								<td style="text-align: right;font-weight: bold;">{{ number_format($final_category_discount_amount_per_sku,2,".",",") }}
								</td>
							@endif
							<td style="text-align: right;font-weight: bold;">
								@php
								$final_net_amount_per_sku =  $total_amount_per_sku - $final_category_discount_amount_per_sku;
								$final_net_amount_per_sku_array[] = $final_net_amount_per_sku;
								@endphp
								{{ number_format($final_net_amount_per_sku,2,".",",") }}
							</td>
						</tr>
					@endforeach
						<tr>
							<td style="text-align: center;font-weight: bold" colspan="4">GRAND TOTAL</td>
							<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_total_amount_per_sku),2,".",",") }}</td>
							<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($total_category_discount_array),2,".",",") }}</td>
							<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($final_net_amount_per_sku_array),2,".",",") }}</td>
						</tr>
				</tbody>
			</table>
			<table class="table table-borderless" style="border:none;">
				<thead>
					<tr>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">QUANTITY:</span></td>
						<td style="line-height:0px;font-weight: bold;">
							{{ $sum_sku_quantity }}
						</td>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">TOTAL DR AMOUNT: </span></td>
						<td style="line-height: 0px;"></td>
						<td style="line-height:0px;font-weight: bold;">
							@php
							$total_dr_amount = array_sum($total_category_discount_array) + array_sum($final_net_amount_per_sku_array);
							$total_dr_amount_array[] = $total_dr_amount;
							@endphp
							{{ number_format($total_dr_amount,2,".",",") }}
						</td>
					</tr>
					<tr>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">TOTAL CATEGORY DISC: </span></td>
						<td style="line-height: 0px;"></td>
						<td style="line-height:0px;font-weight: bold;">
							@php
							$total_category_discount_amount = array_sum($total_category_discount_array);
							$total_category_discount_array[] = $total_category_discount_amount;
							@endphp
							
							{{ number_format($total_category_discount_amount,2,".",",") }}
						</td>
					</tr>
					<tr>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">NET AMOUNT</span></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;text-decoration:overline;">
							@php
							$total_for_dr_and_category_amount = $total_dr_amount - $total_category_discount_amount;
							@endphp
							{{ number_format($total_for_dr_and_category_amount,2,".",",") }}
							
						</td>
					</tr>
					<tr>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">LESS: CUSTOMER DISCOUNT</span></td>
						<td style="line-height:0px;"></td>
					</tr>
					@php
					$total = $total_for_dr_and_category_amount;
					$deducted_total = $total;
					$deducted_total_history = [];
					@endphp
					@for ($i=0; $i < $customer_discount_rate_array_counter; $i++)
					
					<tr>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">CUSTOMER DISC {{ $customer_discount_rate_array[$i] / 100 }}</span></td>
						
						<td style="line-height:0px;font-weight: bold;">
							@php
							$deducted_total_dummy = $deducted_total;
							$less_percentage_by = ($customer_discount_rate_array[$i] / 100);
							$deducted_total = $deducted_total_dummy - ($deducted_total_dummy * $less_percentage_by);
							echo $answer = round($deducted_total_dummy * $less_percentage_by,2);
							$deducted_total_history[] = $answer;
							@endphp
							
						</td>
					</tr>
					@endfor
					<tr>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">TOTAL CUSTOMER DISC: </span></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;">
							@php
							$total_customer_discount_amount = array_sum($deducted_total_history);
							$total_category_discount_per_sku_array[] = $total_customer_discount_amount;
							@endphp
							
							{{ number_format($total_customer_discount_amount,2,".",",") }}
						</td>
					</tr>
					<tr>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">TOTAL PAYABLE AMOUNT: </span></td>
						<td style="line-height:0px;font-weight: bold;">
							
						</td>
						<td style="line-height:0px;font-weight: bold;text-decoration:overline;">
							@php
							$total_payable_amount = $total_dr_amount - $total_category_discount_amount - $total_customer_discount_amount;
							@endphp
							{{  number_format($total_payable_amount,2,".",",") }}
							
							
						</td>
					</tr>
				</thead>
			</table>
			<table class="table table-borderless" style="border:none;">
				<thead>
					<tr>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
						<td style="line-height:0px;font-weight: bold;">
							
						</td>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">VATABLE AMOUNT </span></td>
						<td style="line-height: 0px;"></td>
						<td style="line-height:0px;font-weight: bold;">
							@php
								$vatable_amount = $total_payable_amount / 1.12;
							@endphp	
							{{ number_format($vatable_amount,2,".",",") }}
							<input type="hidden" name="vatable_amount" value="{{ $vatable_amount }}">
						</td>
					</tr>
					<tr>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">VAT AMOUNT</span></td>
						<td style="line-height: 0px;"></td>
						<td style="line-height:0px;font-weight: bold;">
							@php
								$vat_amount = $vatable_amount * 0.12;
							@endphp
							{{ number_format($vat_amount,2,".",",") }}
							<input type="hidden" name="vat_amount" value="{{ $vat_amount }}">
						</td>
					</tr>
					<tr>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">TOTAL DR AMOUNT</span></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;text-decoration:overline;">
							@php
							$total_vatable_dr_amount = $vatable_amount + $vat_amount;
							@endphp
							{{ number_format($total_vatable_dr_amount,2,".",",") }}
							
						</td>
					</tr>
				
				</thead>
			</table>

			<center>
				<div class="container float-left" style="width:50%;" >
					<i>RECEIVED FROM JULMAR COMMERCIAL, INC. (GREEN CROSS DIVISION)<br />
					THE FOLLOWING MERCHANDISE AS ORDERED ABOVE IN GOOD ORDER<br />
					AND MERCHANTIBLE CONDITION</i>
				</div>
				<table class="table table-borderless" style="border:none;">
					<thead>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th>Prepared By:</th>
							<th>Released By:</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th>Delivered By:</th>
							<th>Received By/Customer:</th>
						</tr>
						<tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>_______________________________</td>
								<td>_______________________________</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>_______________________________</td>
								<td>_______________________________</td>
							</tr>
						</tr>
					</thead>
				</table>
			</center>

				

      </div>
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      
    </div>
    <!-- /.row -->
    <br /><br />
    
   {{--    <div class="row invoice-info" style="width:100%;text-align: center;">
        <div class="col-sm-6 invoice-col">
        <span style="text-align: center;">
          Purchased By: <br />
          <u style="font-weight: bold;"></u>
        </span>
        </div>
        <div class="col-sm-6 invoice-col">
          <span style="text-align: center;">
            Prepared By:<br />
            <u style="font-weight: bold;"> {{ $prepared_by->name }}</u>
          </span>
        </div>
      </div>
      <div class="row invoice-info" style="width:100%;text-align: center;">
        <div class="col-sm-12 invoice-col">
        <span style="text-align: center;">
          Date: <br />
          <u style="font-weight: bold;">
            {{ $date }}
          </u>
        </span>
        </div>
      </div> --}}
    
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>

{{-- <script type="text/javascript"> 
     //window.addEventListener("load", window.print());
</script> --}}
<script src="{{ asset('adminLte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">

	$("#cancel_dr").click(function() {
		var delivery_receipt = $(this).val();
	  Swal.fire({
	  title: 'Are you sure?',
	  text: "You won't be able to revert this!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
		      $.post({
			      type: "GET",
			      url: "/sales_order_converted_report_cancel_dr",
			      data: 'delivery_receipt=' + delivery_receipt,
			      success: function(data){
			      	console.log(data);
			      },
			      error: function(error){
			        console.log(error);
			      }
			    });
		  // if (result.isConfirmed) {
		  //   Swal.fire(
		  //     'Deleted!',
		  //     'Your file has been deleted.',
		  //     'success'
		  //   )
		  // }
		})
	});

	
</script>
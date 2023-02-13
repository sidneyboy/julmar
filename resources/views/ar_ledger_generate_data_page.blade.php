@if($select_report == 'AR_LEDGER_PER_DR')

	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th colspan="9" style="text-align: center;font-size: 20px;">AR LEDGER PER DR</th>
			</tr>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th style="text-align: right;font-size: 20px;">DR AMOUNT</th>
				<th style="text-align: right;font-size: 20px;">{{ number_format($sales_order_print->total_amount,2,".",",") }}</th>
			</tr>
			<tr>
				<th style="text-align: center;">DATE DELIVERED</th>
				<th style="text-align: center;">STORE NAME</th>
				<th style="text-align: center;">DATE</th>
				<th style="text-align: center;">REFERENCE</th>
				<th style="text-align: center;">CASH</th>
				<th style="text-align: center;">CHECK</th>
				<th style="text-align: center;">CHECK DETAILS</th>
				<th style="text-align: center;">CM</th>
				<th style="text-align: center;">TOTAL</th>
			</tr>
		</thead>
		<tbody>
			@foreach($ar_ledger as $data)
				<tr>
					<td>{{ $data->sales_order_print->date_delivered }}</td>
					<td>{{ $data->customer->store_name }}</td>
					<td>{{ $data->date }}</td>
					<td>
	
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_for_reference_number{{ $data->id }}">
						  @if($data->customer_payment_details_id != NULL)
							{{ 'OR-'.$data->customer_payment_details->or_number }}
							@elseif($data->cm_for_bo_id != NULL)
								{{ 'PCM-'.$data->cm_for_bo->pcm_number }}
							@elseif($data->cm_for_rgs_id != NULL)
								{{ 'PCM-'.$data->cm_for_rgs->pcm_number }}
							@endif
						</button>

						<!-- Modal -->
						<div class="modal fade" id="modal_for_reference_number{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						 <div class="modal-dialog mw-100 w-100" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">REFERENCE DATA</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						        @if($data->customer_payment_details_id != NULL)
									<div class="table table-responsive">
										<table class="table table-bordered table-hover">
								        	<thead>
								        		<tr>
													<th>DR</th>
													<th>STORENAME</th>
													<th>OR</th>
													<th>CASH</th>
													<th>CHECK</th>
													<th>CHECK DETAILS</th>
													<th>refer_remarks</th>
													<th>amount</th>
													<th>balance</th>
													<th>remarks</th>
								        		</tr>
								        	</thead>
								        	<tbody>
								        		
								        			<tr>
								        				<td>{{ $data->customer_payment_details->sales_order_print->dr }}</td>
								        				<td>{{ $data->customer->store_name }}</td>
								        				<td>{{ 'OR-'.$data->customer_payment_details->or_number }}</td>
								        				<td>{{ number_format($data->customer_payment_details->cash_amount + $data->customer_payment_details->refer_cash_amount,2,".",",")  }}</td>
								        				<td>{{ number_format($data->customer_payment_details->check_amount + $data->customer_payment_details->refer_check_amount,2,".",",")  }}</td>
								        				<td>{{ $data->customer_payment_details->check_number .",". $data->customer_payment_details->check_date .",". $data->customer_payment_details->refer_check_number .",". $data->customer_payment_details->refer_check_date  }}</td>
								        				<td>
								        					{{ $data->customer_payment_details->refer_remarks  }}
								        				</td>
								        				<td>
								        					{{ number_format($data->customer_payment_details->amount,2,".",",")  }}
								        				</td>
								        				<td>
								        					{{ number_format($data->customer_payment_details->balance,2,".",",")  }}
								        				</td>
								        				<td>
								        					{{ $data->customer_payment_details->remarks  }}
								        				</td>
								        			</tr>
								        	
								        	</tbody>
								        </table>
									</div>
								@elseif($data->cm_for_bo_id != NULL)
								{{-- 	<div class="table table-responsive">
										<table class="table table-bordered table-hover">
								        	<thead>
								        		<tr>
													<th colspan="2">CUSTOMER</th>
													<th>Agent</th>
													<th>PCM #</th>
													<th>DR</th>
													<th>LINE DISC 1</th>
													<th>LINE DISC 2</th>
													<th>CONVERTED BY</th>
													<th colspan="3">DATE CONFIRMED</th>
												</tr>
												<tr>
													<td colspan="2" style="color:blue;">{{ $data->cm_for_bo->customer->store_name }}</td>
													<td style="color:blue;">{{ $data->cm_for_bo->agent->full_name }}</td>
													<td style="color:blue;">{{ $data->cm_for_bo->pcm_number }}</td>
													<td style="color:blue;">{{ $data->cm_for_bo->sales_order_print->dr }}</td>
													
													@if($data->cm_for_bo->sales_order_print->total_line_discount_1 != 0)
														<td style="color:blue;" colspan="1">{{ $data->cm_for_bo->status }}</td>
													@elseif($data->cm_for_bo->sales_order_print->total_line_discount_2 != 0)
														<td style="color:blue;" colspan="2">{{ $data->cm_for_bo->status }}</td>
													@endif
													<td></td>
													<td></td>
													<td colspan="" style="color:blue;text-transform: uppercase;">{{ $data->cm_for_bo->converted_by }}</td>
													<td colspan="3" style="color:blue;">{{ $data->cm_for_bo->date_confirmed }}</td>
												</tr>
												<tr>
													<th style="text-align: center;">CODE</th>
													<th style="text-align: center;">DESCRIPTION</th>
													<th style="text-align: center;">QUANTITY</th>
													<th style="text-align: center;">PRICE</th>
													<th style="text-align: center;">AMOUNT</th>
													<th></th>
													<th></th>
													{{-- @if($counter != 0)
														@for ($i=0; $i < $counter; $i++)
															<th>CUST D {{ $i + 1 }}</th>
														@endfor
													@endif
													<th style="text-align: center;color:green;">NET<br />AMOUNT</th>
													<th style="text-align: center;">REMARKS</th>
												</tr>
											</thead>
								        	<tbody>
								        		
								        	</tbody>
								        </table>
									</div> --}}
								@elseif($data->cm_for_rgs_id != NULL)
									
								@endif
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						        <button type="button" class="btn btn-primary">Save changes</button>
						      </div>
						    </div>
						  </div>
						</div>
					</td>
					<td style="text-align: right;">
						@if($data->customer_payment_details_id != NULL)
							@php
								$all_cash_amount = $data->customer_payment_details->cash_amount + $data->customer_payment_details->refer_cash_amount;
							@endphp
						@else
							@php
								$all_cash_amount = 0;
							@endphp
						@endif
						@php
							$sum_all_cash_amount[] = $all_cash_amount;
						@endphp
						{{ number_format($all_cash_amount,2,".",",") }}
					</td>
					<td style="text-align: right;">
						
						
						@if($data->customer_payment_details_id != NULL)
							@php
								$all_check_amount = $data->customer_payment_details->check_amount + $data->customer_payment_details->refer_check_amount;
							@endphp
						@else
							@php
								$all_check_amount = 0;
							@endphp
						@endif
						@php
							$sum_all_check_amount[] = $all_check_amount;
						@endphp

						{{ number_format($all_check_amount,2,".",",") }}
					</td>
					<td style="text-align: right;">
						@if($data->customer_payment_details_id != NULL)
							{{ $data->customer_payment_details->check_number ." , ". $data->customer_payment_details->check_date  }} <br />
							{{ $data->customer_payment_details->refer_check_number ." , ". $data->customer_payment_details->refer_check_date  }}
						@endif
					</td>
					<td style="text-align: right;">
						@php
							if ($data->cm_for_bo_id != NULL) {
								$cm_bo_amount = $data->cm_for_bo->total_bo_amount;
							}else{
								$cm_bo_amount = 0;
							}
							
							if ($data->cm_for_rgs_id != NULL) {
								$cm_for_rgs_amount = $data->cm_for_rgs->total_rgs_amount;
							}else{
								$cm_for_rgs_amount = 0;
							}

							$all_cm_amount = $cm_bo_amount + $cm_for_rgs_amount;
							$sum_all_cm_amount[] = $all_cm_amount;
						@endphp
						{{ number_format($all_cm_amount,2,".",",")   }}
					</td>
					<td style="text-align: right;">
						@php
							$total = $all_cash_amount + $all_check_amount + $all_cm_amount;
							$sum_total[] = $total;
						@endphp
						{{ number_format($total,2,".",",")   }}
					</td>
				</tr>
			@endforeach
				<tr>
					<th colspan="4">TOTAL</th>
					<th style="text-align: right;">{{ number_format(array_sum($sum_all_cash_amount),2,".",",") }}</th>
					<th style="text-align: right;">{{ number_format(array_sum($sum_all_check_amount),2,".",",") }}</th>
					<th></th>
					<th style="text-align: right;">{{ number_format(array_sum($sum_all_cm_amount),2,".",",") }}</th>
					<th style="text-align: right;">{{ number_format(array_sum($sum_total),2,".",",") }}</th>
				</tr>
				<tr>
					<th colspan="8" style="text-align: right;font-size: 20px;">OUTSTANDING BALANCE</th>
					<th style="text-align: right;font-size: 20px;">{{ number_format($sales_order_print->total_amount - array_sum($sum_total),2,".",",") }}</th>
				</tr>
		</tbody>
	</table>


@elseif($select_report == 'AR_LEDGER_PER_CUSTOMER')
	
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th colspan="8" style="text-align: center;font-size: 20px;">AR LEDGER PER CUSTOMER</th>
			</tr>
			<tr>
				<th style="text-align: center;">DATE DELIVERED</th>
				<th style="text-align: center;">DR NO</th>
				<th style="text-align: center;">TOTAL</th>
				<th style="text-align: center;">COLLECTION</th>
				<th style="text-align: center;">CM</th>
				<th style="text-align: center;">BALANCE</th>
			</tr>
		</thead>
		<tbody>
			@foreach($ar_ledger as $data)
				<tr>
					<td>{{ $data->sales_order_print->date_delivered }}</td>
					<td>

					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_for_delivery_receipt{{ $data->id }}">
					{{ $data->sales_order_print->dr }}
					</button>
					<div class="modal fade" id="modal_for_delivery_receipt{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog mw-100 w-75" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">DR DETAILS</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<center>
									<h4 style="font-weight: bold;">JULMAR COMMERCIAL INC.</h4>
									<h5>St Ignatius St, Cagayan de Oro, Misamis Oriental</h5>
									<h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
									</center>
									<br />
									<h5 style="text-align: center;font-weight: bold;">Delivery Receipt</h5>
									<div class="table table-responsive">
										<table class="table table-borderless" style="border:none;">
											<thead>
												<tr>
													<th  style="width:20%;line-height:0px"><span class="float-right">Bill To:</span></th>
													<th  style="width:30%;line-height:0px;text-transform: uppercase;">{{ $data->sales_order_print->customer->store_name }}</th>
													<th  style="width:20%;line-height:0px"><span class="float-right">Dr Number:</span></th>
													<th  style="width:30%;line-height:0px">{{ $data->sales_order_print->dr }}</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td style="line-height:0px;"><span class="float-right">Store Code:</span></td>
													<td style="line-height:0px;">{{-- {{ $customer_principal_code->store_code }} --}}</td>
													<td style="line-height:0px;"><span class="float-right">DR Date :</span></td>
													<td style="line-height:0px;">{{ $data->sales_order_print->date }}</td>
												</tr>
												<tr>
													<td style="line-height:0px;"><span class="float-right">Address:</span></td>
													<td style="line-height:0px;">{{ $data->sales_order_print->customer->detailed_location  }}</td>
													<td style="line-height:0px;"><span class="float-right">SO No:</span></td>
													<td style="line-height:0px;">{{ $data->sales_order_print->sales_order_number }}</td>
												</tr>
												<tr>
													<td style="line-height:0px;"><span class="float-right">Area:</span></td>
													<td style="line-height:0px;">{{ $data->sales_order_print->customer->location->location }}</td>
													<td style="line-height:0px;"><span class="float-right">CUSTOMER PO NO::</span></td>
													<td style="line-height:0px;">N/a</td>
												</tr>
												<tr>
													<td style="line-height:0px;"><span class="float-right">Transaction:</span></td>
													<td style="line-height:0px;">{{ $data->sales_order_print->mode_of_transaction }}
													</td>
													<td style="line-height:0px;"><span class="float-right">Salesman:</span></td>
													<td style="line-height:0px;">{{ $data->sales_order_print->agent->full_name}}</td>
												</tr>
												<tr>
													<td style="line-height:0px;"></td>
													<td style="line-height:0px;"></td>
													<td style="line-height:0px;"><span class="float-right">Payment Terms:</span></td>
													<td style="line-height:0px;">{{ $data->sales_order_print->customer->credit_term }}</td>
												</tr>
												<tr>
													<td style="line-height:0px;"></td>
													<td style="line-height:0px;"></td>
													<td style="line-height:0px;"><span class="float-right">Due Date:</span></td>
													<td style="line-height:0px;">{{ date('Y-m-d', strtotime($data->sales_order_print->date. ' + '. $data->sales_order_print->customer->credit_term)) }}</td>
												</tr>
											</tbody>
										</table>
										<table class="table table-bordered table-hover">
											<thead>
												<tr>
													<th style="text-align: center;">CODE</th>
													<th style="text-align: center;">DESCRIPTION</th>
													<th style="text-align: center;">FINAL QUANTITY</th>
													<th style="text-align: center;">PRICE</th>
													<th style="text-align: center;">AMOUNT</th>
													@if($data->sales_order_print->total_line_discount_1 != 0)
													<th style="text-align: center;">LINE DISCOUNT 1</th>
													@endif
													@if($data->sales_order_print->total_line_discount_2 != 0)
													<th style="text-align: center;">LINE DISCOUNT 2</th>
													@endif
													@if($data->sales_order_print->total_line_discount_1 != 0 OR $data->sales_order_print->total_line_discount_2 != 0)
													<th style="text-align: center;">TOTAL LINE DISCOUNT</th>
													@endif
													@if($data->sales_order_print->line_discount_1 AND $data->sales_order_print->line_discount_2 != 0)
													<th style="text-align: center;">SUB - TOTAL</th>
													@elseif($data->sales_order_print->line_discount_1 != 0)
													<th style="text-align: center;" colspan="2">SUB - TOTAL</th>
													@elseif($data->sales_order_print->line_discount_2 != 0)
													<th style="text-align: center;" colspan="2">SUB - TOTAL</th>
													@else
													<th style="text-align: center;" colspan="3">SUB - TOTAL</th>
													@endif
												</tr>
											</thead>
											<tbody>
												@foreach($data->sales_order_print->sales_order_print_details as $details)
												@if($details->quantity != 0)
												<tr>
													<td>{{ $details->sku->sku_code }}</td>
													<td>{{ $details->sku->description }}</td>
													<td>
														@php
														$sum_quantity[] = $details->quantity;
														@endphp
														{{ $details->quantity }}
													</td>
													<td>{{ number_format($details->price,2,".",",") }}</td>
													<td>
														@php
														$amount_per_sku = $details->quantity * $details->price;
														$sum_amount_per_sku[] = $amount_per_sku;
														echo number_format($amount_per_sku,2,".",",")
														@endphp
													</td>
													@if($data->sales_order_print->total_line_discount_1 != 0)
													@if($details->line_discount_1 == 0)
													<td style="text-align: right;">
														@php
														echo $line_discount_1 = 0;
														@endphp
													</td>
													@else
													<td style="text-align: right;">
														@php
														$line_discount_1 = $details->line_discount_1;
														echo number_format($line_discount_1,2,".",",");
														@endphp
													</td>
													@endif
													@else
													@php
													$line_discount_1 = 0;
													@endphp
													@endif
													@if($data->sales_order_print->total_line_discount_2 != 0)
													@if($details->line_discount_2 == 0)
													<td style="text-align: right;">
														@php
														echo $line_discount_2 = 0;
														@endphp
													</td>
													@else
													<td style="text-align: right;">
														@php
														$line_discount_2 = $details->line_discount_2;
														echo number_format($line_discount_2,2,".",",");
														@endphp
													</td>
													@endif
													@else
													@php
													$line_discount_2 = 0;
													@endphp
													@endif
													@if($data->sales_order_print->total_line_discount_1 != 0 OR $data->sales_order_print->total_line_discount_2 != 0)
													<td style="text-align: right">
														@php
														$total_line_discount_amount = $line_discount_1 + $line_discount_2;
														echo number_format($total_line_discount_amount,2,".",",");
														$total_category_discount_array[] = $total_line_discount_amount;
														@endphp
													</td>
													@else
													@php
													$total_line_discount_amount = 0;
													$total_category_discount_array[] = $total_line_discount_amount;
													@endphp
													@endif
													
													
													<td style="text-align: right;font-weight: bold;">
														@php
														$final_net_amount_per_sku =  $details->sub_total;
														$final_net_amount_per_sku_array[] = $final_net_amount_per_sku;
														echo number_format($final_net_amount_per_sku,2,".",",");
														@endphp
													</td>
												</tr>
												@else
												@endif
												@endforeach
												<tr>
													<td colspan="4"></td>
													<td>{{ number_format(array_sum($sum_amount_per_sku),2,".",",") }}</td>
													@if($data->sales_order_print->total_line_discount_1 != 0)
													<td></td>
													@else
													
													@endif
													@if($data->sales_order_print->total_line_discount_2 != 0)
													<td></td>
													@else
													
													@endif
													@if($data->sales_order_print->total_line_discount_1 != 0 OR $data->sales_order_print->total_line_discount_2 != 0)
													<td style="text-align: right;font-weight: bold;color:green;">
														{{  number_format($data->sales_order_print->total_line_discount,2,".",",") }}
													</td>
													@else
													@endif
													<td style="text-align: right;font-weight: bold;color:green;">
														{{  number_format(array_sum($sum_amount_per_sku) - $data->sales_order_print->total_line_discount,2,".",",") }}
														
													</td>
												</tr>
											</tbody>
										</table>
										@php
										$customer_discount_rate = explode('-', $data->sales_order_print->customer_discount_rate);
										$customer_discount_counter = count($customer_discount_rate);
										@endphp
										<table class="table table-bordered table-sm table-hover">
											<thead>
												<tr>
													<th style="text-align: right;">QUANTITY:</th>
													<th style="text-align: left">
														@php
														echo array_sum($sum_quantity);
														@endphp
													</th>
													<th style="text-align: right;">TOTAL DR AMOUNT:</th>
													<th></th>
													<th style="text-align: right;">
														@php
														$total_dr_amount = array_sum($sum_amount_per_sku);
														$total_dr_amount_array[] = $total_dr_amount;
														@endphp
														{{ number_format($total_dr_amount,2,".",",") }}
													</th>
												</tr>
												<tr>
													<th></th>
													<th></th>
													<th style="text-align: right;">TOTAL CATEGORY DISC:</th>
													<th></th>
													<th style="text-align: right;">
														@php
														$total_category_discount_amount = array_sum($total_category_discount_array);
														$total_category_discount_array[] = $total_category_discount_amount;
														@endphp
														{{ number_format($total_category_discount_amount,2,".",",") }}
													</th>
												</tr>
												<tr>
													<th></th>
													<th></th>
													<th style="text-align: right;">NET AMOUNT:</th>
													<th></th>
													<th style="text-align: right;">
														@php
														$total_for_dr_and_category_amount = $total_dr_amount - $total_category_discount_amount;
														@endphp
														{{ number_format($total_for_dr_and_category_amount,2,".",",") }}
													</th>
												</tr>
												<tr>
													<th></th>
													<th></th>
													<th style="text-align: right;">LESS: CUSTOMER DISCOUNT</th>
													<th></th>
													<th></th>
												</tr>
												@if($customer_discount_counter == 0)
												<tr>
													<th></th>
													<th></th>
													<th style="text-align: right;">CUSTOMER DISC</th>
													<th></th>
													<th>
														@php
														echo $answer = 0.00;
														$deducted_total_history[] = $answer;
														@endphp
													</th>
												</tr>
												<tr>
													<th></th>
													<th></th>
													<th style="text-align: right;">TOTAL CUSTOMER DISC:</th>
													<th></th>
													<th style="text-align: right;">
														@php
														$total_customer_discount_amount = array_sum($deducted_total_history);
														$total_category_discount_per_sku_array[] = $total_customer_discount_amount;
														@endphp
														
														{{ number_format($total_customer_discount_amount,2,".",",") }}
													</th>
												</tr>
												<tr>
													<th></th>
													<th></th>
													<th style="text-align: right;">TOTAL PAYABLE AMOUNT:</th>
													<th></th>
													<th style="text-align: right;">
														@php
														$total_payable_amount = $total_dr_amount - $total_category_discount_amount - $total_customer_discount_amount;
														@endphp
														{{  number_format($total_payable_amount,2,".",",") }}
													</th>
												</tr>
												@else
												@php
												$total = $total_for_dr_and_category_amount;
												$deducted_total = $total;
												$deducted_total_history = [];
												@endphp
												@for ($i=0; $i < $customer_discount_counter; $i++)
												<tr>
													<th></th>
													<th></th>
													<th style="text-align: right;">
														<span class="float-right">CUSTOMER DISC {{ $customer_discount_rate[$i] / 100 }}</span>
													</th>
													<th style="text-align: right;">
														@php
														$deducted_total_dummy = $deducted_total;
														$less_percentage_by = ($customer_discount_rate[$i] / 100);
														$deducted_total = $deducted_total_dummy - ($deducted_total_dummy * $less_percentage_by);
														echo $answer = round($deducted_total_dummy * $less_percentage_by,2);
														$deducted_total_history[] = $answer;
														@endphp
													</th>
													<th></th>
												</tr>
												@endfor
												<tr>
													<th></th>
													<th></th>
													<th style="text-align: right;">
														TOTAL CUSTOMER DISC:
													</th>
													<th >
													</th>
													<th style="text-align: right;">
														@php
														$total_customer_discount_amount = array_sum($deducted_total_history);
														$total_category_discount_per_sku_array[] = $total_customer_discount_amount;
														@endphp
														<input type="hidden" name="total_customer_discount_amount" value="{{ $total_customer_discount_amount }}">
														{{ number_format($total_customer_discount_amount,2,".",",") }}
													</th>
												</tr>
												<tr>
													<th></th>
													<th></th>
													<th style="text-align: right;">
														TOTAL PAYABLE AMOUNT:
													</th>
													<th >
													</th>
													<th style="text-align: right;">
														@php
														$total_payable_amount = $total_dr_amount - $total_category_discount_amount - $total_customer_discount_amount;
														@endphp
														{{  number_format($total_payable_amount,2,".",",") }}
														<input type="hidden" name="total_customer_payable_amount" value="{{ $total_payable_amount }}">
													</th>
												</tr>
												@endif
											</thead>
										</table>
										<table class="table table-bordered table-sm">
											<thead>
												<tr>
													<th></th>
													<th></th>
													<th style="text-align: right;">VATABLE AMOUNT:</th>
													<th></th>
													<th style="text-align: right;">
														@php
														$vatable_amount = $total_payable_amount / 1.12;
														@endphp
														{{ number_format($vatable_amount,2,".",",") }}
														<input type="hidden" name="vatable_amount" value="{{ $vatable_amount }}">
													</th>
												</tr>
												<tr>
													<th></th>
													<th></th>
													<th style="text-align: right;">VAT AMOUNT:</th>
													<th></th>
													<th style="text-align: right;">
														@php
														$vat_amount = $vatable_amount * 0.12;
														@endphp
														{{ number_format($vat_amount,2,".",",") }}
														<input type="hidden" name="vat_amount" value="{{ $vat_amount }}">
													</th>
												</tr>
												<tr>
													<th></th>
													<th></th>
													<th style="text-align: right;">TOTAL DR AMOUNT:</th>
													<th></th>
													<th style="text-align: right;">
														@php
														$total_vatable_dr_amount = $vatable_amount + $vat_amount;
														@endphp
														{{ number_format($total_vatable_dr_amount,2,".",",") }}
													</th>
												</tr>
											</thead>
										</table>
										<table class="table table-bordered table-hover">
											<thead>
												<tr>
													<th colspan="4" style="text-align: center;font-weight: bold;">SALES TRANSACTION JOURNAL ENTRY</th>
												</tr>
												<tr>
													<th></th>
													<th style="text-align: center;">DEBIT</th>
													<th></th>
													<th style="text-align: center;">CREDIT</th>
												</tr>
												<tr>
													<th style="text-align: center;text-transform: uppercase;">ACCOUNTS RECEIVABLE - {{ $data->sales_order_print->customer->store_name }}</th>
													<th style="text-align: right;">
														{{ number_format($total_vatable_dr_amount,2,".",",") }}
														<input type="hidden" name="accounts_receivable" value="{{ $total_vatable_dr_amount }}">
													</th>
													<th></th>
													<th></th>
												</tr>
												<tr>
													<th></th>
													<th></th>
													<th style="text-align: center;">VAT PAYABLE </th>
													<th style="text-align: right;">
														{{ number_format($vat_amount,2,".",",") }}
														<input type="hidden" name="vat_amount" value="{{ $vat_amount }}">
													</th>
												</tr>
												<tr>
													<th></th>
													<th></th>
													<th style="text-align: center;">SALES </th>
													<th style="text-align: right;">
														{{ number_format($vatable_amount,2,".",",") }}
														<input type="hidden" name="vatable_amount" value="{{ $vatable_amount }}">
													</th>
												</tr>
											</thead>
										</table>
										<div class="container float-left" style="width:50%;" >
											<i>RECEIVED FROM JULMAR COMMERCIAL, INC. (<span style="color:blue;font-weight: bold;">{{ $data->sales_order_print->principal->principal }}</span>)<br />
											THE FOLLOWING MERCHANDISE AS ORDERED ABOVE IN GOOD ORDER<br />
											AND MERCHANTIBLE CONDITION</i>
										</div>
										<table class="table table-borderless" style="border:none;">
											<thead>
												<tr>
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
														<td>{{ $data->sales_order_print->user->name }}</td>
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
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary">Save changes</button>
								</div>
							</div>
						</div>
					</div>
					</td>
					<td style="text-align: right;">
						@php
							$total_amount = $data->sales_order_print->total_amount;
							$sum_total_amount[] = $total_amount;
						@endphp
						{{ number_format($total_amount,2,".",",") }}
					</td>
					<td style="text-align: right;">
						@php
							$all_collection = $data->sales_order_print->customer_payment_details->sum('amount');
							$sum_all_collection[] = $all_collection;
						@endphp
						{{ number_format($all_collection,2,".",",")  }}

					</td>
					<td style="text-align: right;">
						@php
							$all_cm = $data->sales_order_print->cm_for_rgs->sum('total_rgs_amount') + $data->sales_order_print->cm_for_bo->sum('total_bo_amount');
							$sum_all_cm[] = $all_cm;
						@endphp
						{{ number_format($all_cm,2,".",",")  }}
					</td>
					<td style="text-align: right;">
						@php
							$balance = $total_amount - ($all_collection + $all_cm);
							$sum_balance[] = $balance;
						@endphp
						{{ number_format($balance,2,".",",")  }}
					</td>
				</tr>
			@endforeach
				<tr>
					<th colspan="2">TOTAL</th>
					<th style="text-align: right;">{{ number_format(array_sum($sum_total_amount),2,".",",") }}</th>
					<th style="text-align: right;">{{ number_format(array_sum($sum_all_collection),2,".",",") }}</th>
					<th style="text-align: right;">{{ number_format(array_sum($sum_all_cm),2,".",",") }}</th>
					<th style="text-align: right;">{{ number_format(array_sum($sum_balance),2,".",",") }}</th>
				</tr>
		</tbody>
	</table>

@else


	<table class="table table-bordered table-hover" id="export_table">
		<thead>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th style="text-align: center;font-size: 20px;">AR CONTROL</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				
			</tr>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th style="text-align: center;">EXPORT_CODE{{ $time }}</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
		
			</tr>
			<tr>
				<th>AGENT ID</th>
				<th>CUSTOMER ID</th>
				<th style="text-align: center;">DATE DELIVERED</th>
				<th style="text-align: center;">STORE NAME</th>
				<th style="text-align: center;">ADDRESS</th>
				<th style="text-align: center;">DR</th>
				<th style="text-align: center;">AMOUNT</th>
				<th style="text-align: center;">COLLECTED</th>
				<th style="text-align: center;">BALANCE</th>
				<th style="text-align: center;">TOTAL CM</th>
				<th style="text-align: center;">BALANCE</th>
				<th style="text-align: center;">AGING</th>
			</tr>
		</thead>
		<tbody>
			@foreach($ar_ledger as $data)
				<tr>
					<td>{{ $data->id }}</td>
					<td>{{ $data->customer_id }}</td>
					<td>{{ $data->sales_order_print->date_delivered }}</td>
					<td>{{ $data->customer->store_name }}</td>
					<td>{{ $data->customer->location->location }}</td>
					<td>
						{{ $data->sales_order_print->dr }}
						
					</td>
					<td style="text-align: right;">
						@php
							$total_amount = $data->sales_order_print->total_amount;
							$sum_total_amount[] = $total_amount;
						@endphp
						{{ $total_amount  }}
					</td>
					<td style="text-align: right;">
						{{-- @if($data->customer_payment_id != NULL)
							@php
								$collection = $data->customer_payment_details->sum('amount');
								$sum_collection[] = $collection; 
							@endphp
						@else
							@php
								$collection = 0;
								$sum_collection[] = $collection; 
							@endphp
						@endif --}}
						@php
							$collection = $data->sales_order_print->customer_payment_details->sum('amount');
							$sum_collection[] = $collection; 
						@endphp
						
						{{ $collection }}
					</td>
					<td style="text-align: right;">
						@php
							$balance = $total_amount - $collection;
							$sum_balance[] = $balance; 
						@endphp
						{{ $balance }}
					</td>
					<td style="text-align: right;">
						@php
							$total_cm = $data->sales_order_print->cm_for_rgs->sum('total_rgs_amount') + $data->sales_order_print->cm_for_bo->sum('total_bo_amount');
							$sum_total_cm[] = $total_cm; 
						@endphp
						{{ $total_cm }}
					</td>
					<td style="text-align: right;">
						@php
							$final_balance = $balance - $total_cm;
							$sum_final_balance[] = $final_balance; 
						@endphp
						{{ $final_balance }}
					</td>
					
						@php
							$aging = (new DateTime($data->sales_order_print->date_delivered))->diff(new DateTime($date))->days;	
						@endphp
						@if($aging < 35)
							<td style="font-weight: bold;text-align: center;background-color: #99FF33;">{{ $aging }}</td>
						@else
							<td style="font-weight: bold;text-align: center;background-color: red;">{{ $aging }}</td>
						@endif
				</tr>
			@endforeach
				<tr>
					<th style="font-size: 20px;">TOTAL</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th style="text-align: right;font-size: 20px;">{{ array_sum($sum_total_amount) }}</th>
					<th style="text-align: right;font-size: 20px;">{{ array_sum($sum_collection) }}</th>
					<th style="text-align: right;font-size: 20px;">{{ array_sum($sum_balance) }}</th>
					<th style="text-align: right;font-size: 20px;">{{ array_sum($sum_total_cm) }}</th>
					<th style="text-align: right;font-size: 20px;">{{ array_sum($sum_final_balance) }}</th>
					<th></th>
				</tr>
		</tbody>
	</table>

	<button onclick="exportTableToCSV('{{ strtoupper($ar_ledger[0]->agent->full_name) }} - AR CONTROL - {{ $date_from }} - {{ $date_to }}.csv')">Export HTML Table To CSV File</button>

@endif


<script>
	function downloadCSV(csv, filename) {
	    var csvFile;
	    var downloadLink;

	    // CSV file
	    csvFile = new Blob([csv], {type: "text/csv"});

	    // Download link
	    downloadLink = document.createElement("a");

	    // File name
	    downloadLink.download = filename;

	    // Create a link to the file
	    downloadLink.href = window.URL.createObjectURL(csvFile);

	    // Hide download link
	    downloadLink.style.display = "none";

	    // Add the link to DOM
	    document.body.appendChild(downloadLink);

	    // Click download link
	    downloadLink.click();
	}

	function exportTableToCSV(filename) {
	    var csv = [];
	    var rows = document.querySelectorAll("#export_table tr");
	    
	    for (var i = 0; i < rows.length; i++) {
	        var row = [], cols = rows[i].querySelectorAll("td, th");
	        
	        for (var j = 0; j < cols.length; j++) 
	            row.push(cols[j].innerText);
	        
	        csv.push(row.join(","));        
	    }

	    // Download CSV file
	    downloadCSV(csv.join("\n"), filename);
	}
</script>
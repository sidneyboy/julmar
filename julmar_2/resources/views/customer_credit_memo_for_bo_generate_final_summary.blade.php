
<style type="text/css">
	@page { 
    size: auto;
    margin: 20mm 0 10mm 0;
	}
	body {
	    margin:0;
	    padding:0;
	}
</style>

<form id="save_cm_for_bo">
	@csrf
	<div class="table table-responsive">
		<input type="hidden" name="pcm_number" value="{{ $pcm_number }}">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align: center;" colspan="6">PCM #: <span style="color:red;">{{ $pcm_number }}</span></th>
					<th style="text-align: center;" colspan="3">GROSS AMOUNT</th>
					<th style="text-align: center;" colspan="3">CAT DISC</th>
					@for($i=0; $i < $counter; $i++)
						<th colspan="2" style="text-align: center;">CUST DISC {{ $i +1  }}</th>
					@endfor
					<th></th>
					<th style="text-align: center;" colspan="3">NET AMOUNT</th>
					<th></th>
				</tr>
				<tr>
					<th style="text-align: center;">CODE</th>
					<th style="text-align: center;">DESCRIPTION</th>
					<th style="text-align: center;">BO QTY</th>
					<th style="text-align: center;">BO EXP QTY</th>
					<th style="text-align: center;">TOTAL QTY</th>
					<th style="text-align: center;">PRICE</th>
					<th style="text-align: center;">BO</th>
					<th style="text-align: center;">EXP</th>
					<th style="text-align: center;">TOTAL</th>
					<th style="text-align: center;">BO</th>
					<th style="text-align: center;">EXP</th>
					<th style="text-align: center;">TOTAL</th>
					@for($i=0; $i < $counter; $i++)
						<th>BO</th>
						<th>EXP</th>
					@endfor
					<th style="text-align: center;">TOTAL DISC</th>
					<th style="text-align: center;">BO</th>
					<th style="text-align: center;">EXP</th>
					<th style="text-align: center;">TOTAL</th>
					<th style="text-align: center;">RMRKS</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sku_id as  $data)
					@if($bad_order_quantity[$data] != 0)
						<tr>
							<td style="text-align: center;">
								{{ $sku_code[$data] }}
								<input type="hidden" name="sku_id[]" value="{{ $data }}">
								<input type="hidden" name="personnel_id" value="{{ $personnel_id }}">
								<input type="hidden" name="customer_id" value="{{ $customer_id }}">
								<input type="hidden" name="sales_order_printed_id" value="{{ $sales_order_printed_id }}">
								<input type="hidden" name="delivery_receipt" value="{{ $delivery_receipt }}">
								<input type="hidden" name="principal_id" value="{{ $principal_id }}">
								<input type="hidden" name="store_code" value="{{ $store_code }}">
							</td>
							<td style="text-align: center;">
								{{ $description[$data] }}
							</td>
							<td style="text-align: center;">
								@php
									$sum_bad_order_quantity[] = $bad_order_quantity[$data];
								@endphp
								{{ $bad_order_quantity[$data] }}
								<input type="hidden" name="bad_order_quantity[{{ $data }}]" value="{{ $bad_order_quantity[$data] }}">
							</td>
							<td style="text-align: center;">
								@php
									$sum_bad_order_quantity_expired[] = $bad_order_quantity_expired[$data];
									echo $bad_order_quantity_expired[$data];
								@endphp
								<input type="hidden" name="bad_order_quantity_expired[{{ $data }}]" value="{{ $bad_order_quantity_expired[$data] }}">
							</td>
							<td style="text-align: center;">
								@php
									echo $total_bo_quantity = $bad_order_quantity[$data] + $bad_order_quantity_expired[$data];
									$sum_total_bo_quantity[] = $total_bo_quantity;
								@endphp
							</td>
							<td style="text-align: right;">
								{{ number_format($price[$data],2,".",",")  }}
								<input type="hidden" name="price[{{ $data }}]" value="{{ $price[$data] }}">
							</td>
							<td style="text-align: right;">
								@php
									$gross_amount_bo = $bad_order_quantity[$data] * $price[$data];
									$sum_gross_amount_bo[] = $gross_amount_bo;
									echo number_format($gross_amount_bo,2,".",",")
								@endphp
							</td>
							<td style="text-align: right;">
								@php
									$gross_amount_expired = $bad_order_quantity_expired[$data] * $price[$data];
									$sum_gross_amount_expired[] = $gross_amount_expired;
									echo number_format($gross_amount_expired,2,".",",");
								@endphp
							</td>
							<td style="text-align: right;">
								@php
									$gross_amount_total = $gross_amount_bo + $gross_amount_expired;
									$sum_gross_amount_total[$data] = $gross_amount_total;
									echo number_format($gross_amount_total,2,".",",");
								@endphp
							</td>
							@if($category_discount_rate_1[$data] == 0)
								@php
									$category_discount_line_rate_1 = 0;
								@endphp
							@else
								@php
									$category_discount_line_rate_1 = $gross_amount_bo * $category_discount_rate_1[$data];
								@endphp
							@endif

							@if($category_discount_rate_2[$data] == 0)
								@php
									$category_discount_line_rate_2 = 0;
								@endphp
							@else
								@php
									 $category_discount_line_rate_2 =( $gross_amount_bo - $category_discount_line_rate_1) * $category_discount_rate_2[$data];
								@endphp
							@endif

							@if($category_discount_rate_3[$data] == 0)
								@php
									$category_discount_line_rate_3 = 0;
								@endphp
							@else
								@php
									 $category_discount_line_rate_3 =( $gross_amount_bo - $category_discount_line_rate_2) * $category_discount_rate_3[$data];
								@endphp
							@endif

							@if($category_discount_rate_4[$data] == 0)
								@php
									$category_discount_line_rate_4 = 0;
								@endphp
							@else
								@php
									 $category_discount_line_rate_4 =( $gross_amount_bo - $category_discount_line_rate_3) * $category_discount_rate_4[$data];
								@endphp
							@endif

							@if($category_discount_line_rate_1 != 0 OR $category_discount_line_rate_2 != 0 OR $category_discount_line_rate_3 != 0 OR $category_discount_line_rate_4 != 0)

								<td style="text-align: right;">
									@php
										$final_category_discount_amount_per_sku_bo = $category_discount_line_rate_1 + $category_discount_line_rate_2 + $category_discount_line_rate_3 + $category_discount_line_rate_4;
										$total_category_discount_array_bo[] = $final_category_discount_amount_per_sku_bo;

										echo number_format($final_category_discount_amount_per_sku_bo,2,".",",")
									@endphp
								</td>


							@else

								@php
									$final_category_discount_amount_per_sku_bo = 0;
									$total_category_discount_array_bo[] = 0;

									number_format($final_category_discount_amount_per_sku_bo,2,".",",")
								@endphp

							@endif
							{{-- bo expired napud ni diri --}}
							@if($category_discount_rate_1[$data] == 0)
								@php
									$category_discount_line_rate_1 = 0;
								@endphp
							@else
								@php
									$category_discount_line_rate_1 = $gross_amount_expired * $category_discount_rate_1[$data];
								@endphp
							@endif

							@if($category_discount_rate_2[$data] == 0)
								@php
									$category_discount_line_rate_2 = 0;
								@endphp
							@else
								@php
									 $category_discount_line_rate_2 =( $gross_amount_expired - $category_discount_line_rate_1) * $category_discount_rate_2[$data];
								@endphp
							@endif

							@if($category_discount_rate_3[$data] == 0)
								@php
									$category_discount_line_rate_3 = 0;
								@endphp
							@else
								@php
									 $category_discount_line_rate_3 =( $gross_amount_expired - $category_discount_line_rate_2) * $category_discount_rate_3[$data];
								@endphp
							@endif

							@if($category_discount_rate_4[$data] == 0)
								@php
									$category_discount_line_rate_4 = 0;
								@endphp
							@else
								@php
									 $category_discount_line_rate_4 =( $gross_amount_expired - $category_discount_line_rate_3) * $category_discount_rate_4[$data];
								@endphp
							@endif

							@if($category_discount_line_rate_1 != 0 OR $category_discount_line_rate_2 != 0 OR $category_discount_line_rate_3 != 0 OR $category_discount_line_rate_4 != 0)

								<td style="text-align: right;">
									@php
										$final_category_discount_amount_per_sku_expired = $category_discount_line_rate_1 + $category_discount_line_rate_2 + $category_discount_line_rate_3 + $category_discount_line_rate_4;
										$total_category_discount_array_expired[] = $final_category_discount_amount_per_sku_expired;

										echo number_format($final_category_discount_amount_per_sku_expired,2,".",",")
									@endphp
								</td>


							@else

								@php
									$final_category_discount_amount_per_sku_expired = 0;
									$total_category_discount_array_expired[] = 0;

									echo number_format($final_category_discount_amount_per_sku_expired,2,".",",")
								@endphp

							@endif

							<td style="text-align: right;">
								@php
									$total_category_discount = $final_category_discount_amount_per_sku_bo + $final_category_discount_amount_per_sku_expired;
									$sum_total_category_discount[$data] = $total_category_discount;
									echo number_format($total_category_discount,2,".",",")
								@endphp
							</td>

							@php
							  $total_bo = $gross_amount_bo - $final_category_discount_amount_per_sku_bo;
					          $data_keeper_bo = $total_bo;
					          $sum_data_keeper_bo = [];

					          $total_expired = $gross_amount_expired - $final_category_discount_amount_per_sku_expired;
					          $data_keeper_expired = $total_expired;
					          $sum_data_keeper_expired = [];
					          
					          for ($i=0; $i < $counter; $i++) {
					          
					            $data_keeper_bo_dummy = $data_keeper_bo;
					            $customer_discount_bo = ($customer_discount_rate[$i] / 100);
					            $data_answer_bo = $data_keeper_bo * $customer_discount_bo;
					            $data_keeper_bo =  $data_keeper_bo_dummy - ($data_keeper_bo_dummy * $customer_discount_bo);

					            $data_keeper_expired = $data_keeper_expired;
					            $customer_discount_expired = ($customer_discount_rate[$i] / 100);
					            $data_answer_expired = $data_keeper_expired * $customer_discount_expired;
					            $data_keeper_expired =  $data_keeper_expired - ($data_keeper_expired * $customer_discount_expired);
					            
					        @endphp
					        	<td style="text-align: right;">{{ number_format($data_answer_bo,2,".",",")  }}</td>
					        	<td style="text-align: right;">{{ number_format($data_answer_expired,2,".",",")  }}</td>
					        @php   
					            
					            $sum_data_keeper_bo[] = $data_answer_bo;
					            $sum_data_keeper_expired[] = $data_answer_expired;
					            

					          }
							@endphp

							<td style="text-align: right;">
								@php
									$sum_total_discount[] = array_sum($sum_data_keeper_bo) + array_sum($sum_data_keeper_expired);
								@endphp
								{{ number_format(array_sum($sum_data_keeper_bo) + array_sum($sum_data_keeper_expired)  ,2,".",",") }}
							</td>
							<td style="text-align: right;">
								@php
									$net_amount_bo = $gross_amount_bo - $final_category_discount_amount_per_sku_bo - array_sum($sum_data_keeper_bo);
									$sum_net_amount_bo[$data] = $net_amount_bo;
									echo number_format($net_amount_bo,2,".",",")
								@endphp
							</td>
							<td style="text-align: right;">
								@php
									$net_amount_expired = $gross_amount_expired - $final_category_discount_amount_per_sku_expired - array_sum($sum_data_keeper_expired);
									$sum_net_amount_expired[] = $net_amount_expired;
									echo number_format($net_amount_expired,2,".",",")
								@endphp
							</td>
							<td style="text-align: right;">
								@php
									$total_net_amount = $net_amount_bo + $net_amount_expired;
									$sum_total_net_amount[] = $total_net_amount;
									echo number_format($total_net_amount,2,".",",")

								@endphp
							</td>
							<td style="text-align: center;">{{ $remarks[$data] }}</td>
						</tr>
					@else

					@endif
				@endforeach
					<tr>
						<td colspan="2" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
						<td style="text-align: center;">{{ array_sum($sum_bad_order_quantity) }}</td>
						<td style="text-align: center;">{{ array_sum($sum_bad_order_quantity_expired) }}</td>
						<td style="text-align: center;">{{ array_sum($sum_total_bo_quantity) }}</td>
						<td></td>
						<td style="text-align: right;">{{ number_format(array_sum($sum_gross_amount_bo),2,".",",") }}</td>
						<td style="text-align: right;">{{ number_format(array_sum($sum_gross_amount_expired),2,".",",") }}</td>
						<td style="text-align: right;">{{ number_format(array_sum($sum_gross_amount_total),2,".",",") }}</td>
						<td style="text-align: right;">{{ number_format(array_sum($total_category_discount_array_bo),2,".",",") }}</td>
						<td style="text-align: right;">{{ number_format(array_sum($total_category_discount_array_expired),2,".",",") }}</td>
						<td style="text-align: right;">{{ number_format(array_sum($sum_total_category_discount),2,".",",") }}</td>
						@for($i=0; $i < $counter; $i++)
						<td colspan="2" style="text-align: center;"></td>
						@endfor
						<td style="text-align: right;">{{ number_format(array_sum($sum_total_discount),2,".",",") }}</td>
						<td style="text-align: right;">{{ number_format(array_sum($sum_net_amount_bo),2,".",",") }}</td>
						<td style="text-align: right;">{{ number_format(array_sum($sum_net_amount_expired),2,".",",") }}</td>
						<td style="text-align: right;">{{ number_format(array_sum($sum_total_net_amount),2,".",",") }}</td>
					</tr>
			</tbody>
		</table>
	</div>

	{{-- @php
						$sum_bo_data_amount_bo = [];
						$sum_bo_data_amount_bo_print [];
					@endphp --}}
	


	<table class="table table-bordered table-sm float-right" style="width:20%">
				<thead>
					<tr>
						<th colspan="2" style="text-align: center;">BO SUMMARY</th>
					</tr>

					@if($principal == 'PFC')
						@foreach($sku_id as  $data)
							@if($remarks[$data] == "EXPIRED")
								@php
									$bo_data_amount_expired = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_expired[] = $bo_data_amount_expired;
								@endphp
							@elseif($remarks[$data] == "BO")
								@php	
									$bo_data_amount_bo = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_bo[] = $bo_data_amount_bo;
								@endphp
							@else
								@php
									$sum_bo_data_amount_expired[] = 0;
									$sum_bo_data_amount_bo[] = 0;
								@endphp
							@endif
						@endforeach
						<tr>
							<th style="text-align: center;">EXPIRED</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_expired))
									{{ number_format(array_sum($sum_bo_data_amount_expired),2,".",",") }}
								@else
									{{ number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">BO</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_bo))
									{{ number_format(array_sum($sum_bo_data_amount_bo),2,".",",") }}
								@else
									{{ number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">BO EXPIRED</th>
							<th style="text-align: right;">
								@if(isset($sum_net_amount_expired))
									{{ number_format(array_sum($sum_net_amount_expired),2,".",",") }}
								@else
									{{ number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">TOTAL</th>
							<th style="text-align: right;">
								{{ number_format(array_sum($sum_net_amount_expired) + array_sum($sum_bo_data_amount_bo) + array_sum($sum_bo_data_amount_expired) ,2,".",",") }}
							</th>
						</tr>
					@elseif($principal == 'PPMC')
						@foreach($sku_id as  $data)
							@if($remarks[$data] == "BAR")
								@php
									$bo_data_amount_bar = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_bar[] = $bo_data_amount_bar;
								@endphp
							@elseif($remarks[$data] == "POWDER")
								@php	
									$bo_data_amount_powder = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_powder[] = $bo_data_amount_powder;
								@endphp
							@elseif($remarks[$data] == "PLC")
								@php
									$bo_data_amount_plc = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_plc[] = $bo_data_amount_plc;
								@endphp
							@endif
						@endforeach
						<tr>
							<th style="text-align: center;">BAR</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_bar))
									{{  number_format(array_sum($sum_bo_data_amount_bar),2,".",",") }}
								@else
									{{  number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">POWDER</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_powder))
									{{  number_format(array_sum($sum_bo_data_amount_powder),2,".",",") }}
								@else
									{{  number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">PLC</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_plc))
									{{  number_format(array_sum($sum_bo_data_amount_plc),2,".",",") }}
								@else
									{{  number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">BO EXPIRED</th>
							<th style="text-align: right;">
								@if(isset($sum_net_amount_expired))
									{{ number_format(array_sum($sum_net_amount_expired),2,".",",") }}
								@else
									{{ number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">TOTAL</th>
							<th style="text-align: right;">
								{{ number_format(array_sum($sum_bo_data_amount_bar) + array_sum($sum_bo_data_amount_powder) + array_sum($sum_bo_data_amount_plc) + array_sum($sum_net_amount_expired) ,2,".",",") }}
							</th>
						</tr>
					@elseif($principal == "CIFPI")
						@foreach($sku_id as  $data)
							@if($remarks[$data] == "CONFECTIONARY")
								@php
									$bo_data_amount_confectionary = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_confectionary[] = $bo_data_amount_confectionary;
								@endphp
							@elseif($remarks[$data] == "SNACKS")
								@php	
									$bo_data_amount_snacks = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_snacks[] = $bo_data_amount_snacks;
								@endphp
							@elseif($remarks[$data] == "EXPIRED")
								@php
									$bo_data_amount_expired = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_expired[] = $bo_data_amount_expired;
								@endphp
							@endif
						@endforeach
						<tr>
							<th style="text-align: center;">CONFEC</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_confectionary))
									{{  number_format(array_sum($sum_bo_data_amount_confectionary),2,".",",") }}
								@else
									{{  number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">SNACKS</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_snacks))
									{{  number_format(array_sum($sum_bo_data_amount_snacks),2,".",",") }}
								@else
									{{  number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">EXPIRED</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_expired))
									{{  number_format(array_sum($sum_bo_data_amount_expired),2,".",",") }}
								@else
									{{  number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">BO EXPIRED</th>
							<th style="text-align: right;">
								@if(isset($sum_net_amount_expired))
									{{ number_format(array_sum($sum_net_amount_expired),2,".",",") }}
								@else
									{{ number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">TOTAL</th>
							<th style="text-align: right;">
								{{ number_format(array_sum($sum_bo_data_amount_confectionary) + array_sum($sum_bo_data_amount_snacks) + array_sum($sum_bo_data_amount_expired) + array_sum($sum_net_amount_expired) ,2,".",",") }}
							</th>
						</tr>
					@else
						@foreach($sku_id as  $data)
							@if($remarks[$data] == "BO")
								@php
									$bo_data_amount = $sum_net_amount_bo[$data];
									$sum_bo_data_amount[] = $bo_data_amount;
								@endphp
							@else

							@endif
						@endforeach
						<tr>
							<th style="text-align: center;">BO</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount))
									{{  number_format(array_sum($sum_bo_data_amount),2,".",",") }}
								@else
									{{  number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">BO EXPIRED</th>
							<th style="text-align: right;">
								@if(isset($sum_net_amount_expired))
									{{ number_format(array_sum($sum_net_amount_expired),2,".",",") }}
								@else
									{{ number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>

						<tr>
							<th style="text-align: center;">TOTAL</th>
							<th style="text-align: right;">
								{{ number_format(array_sum($sum_bo_data_amount) + array_sum($sum_net_amount_expired) ,2,".",",") }}
							</th>
						</tr>
					@endif
				</thead>
	</table>
	<table class="table table-bordered table-hover table-sm" id="charge_over_form">
			<thead>
				<tr>
					<th>Personnels</th>
					<th>Charge / Over</th>
					<th>Amount</th>
					<th>Gen Summary</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input type="text" name="personnels_involved" id="personnels_involved" class="form-control" required></td>
					<td>
						<select class="form-control select2" id="involved_in" name="involved_in" style="width:100%;">
							<option value="" default>Select</option>
							<option value="None">None</option>
							<option value="Charged">Charge</option>
							<option value="Over Payment">Over Payment</option>
						</select>
					</td>
					<td><input type="text" name="amount_involved" id="amount_involved"  class="currency-default" required style="    display: block;
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
					    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;"></td>
					<td><a id="generate_summary"  class="btn btn-info btn-block">Generate Summary</a></td>
				</tr>
			</tbody>
	</table>

	
	<div id="print">
		<center style="" id="table_print_4" >
			<h4 style="font-weight: bold;">JULMAR COMMERCIAL INC.</h4>
			<h5 style="font-weight: bold;">GENERAL MERCHANDISE WHOLESALE & RETAIL</h5>
			<h6>Osmena St., Cogon Market Cagayan de Oro City</h6>
			<h6>TEL# 857-6197, 858-5771</h6>
			<h6>Vat Reg. TIN 486-701-947-000</h6>
			<br />
			<h6 style="font-weight: bold;">CREDIT MEMO FOR BAD ORDER</h6>
		<br />
		<table class="table table-borderless table-sm" style="text-transform: uppercase; width:60%" >
			<tr>
				<th colspan="2"></th>
				<th>PCM#:</th>
				<th>{{ $pcm_number }}</th>
			</tr>
			<tr>
				<th>Customer Name:</th>
				<th>{{ $store_name }}</th>
				<th>Salesman Name:</th>
				<th>{{ $salesman }}</th>
			</tr>
			<tr>
				<th>Address:</th>
				<th>{{ $address }}</th>
				<th>Date:</th>
				<th>{{ $date }}</th>
			</tr>
		</table>
		</center>
		<table class="table table-bordered table-sm" id="table_print_1"  style="">
			<thead>
				<tr>
					<th style="text-align: center;">DESC</th>
					<th style="text-align: center;">TOTAL QTY</th>
					<th style="text-align: center;">PRICE</th>
					<th style="text-align: center;">GROSS AMOUNT</th>
					<th style="text-align: center;">CAT DISC</th>
					<th style="text-align: center;">AMOUNT</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sku_id as  $data)
					@if($bad_order_quantity[$data] != 0)
						<tr>
							<td style="text-align: center;">{{ $description[$data] }}</td>
							<td style="text-align: right;">
								{{ $bad_order_quantity[$data] + $bad_order_quantity_expired[$data] }}
							</td>
							<td style="text-align: right;">{{ number_format($price[$data],2,".",",")  }}</td>
							<td style="text-align: right;">
								@php
									$gross_amount = $sum_gross_amount_total[$data];
									$sum_gross_amount[] = $gross_amount;
								@endphp
								{{ number_format($gross_amount,2,".",",")  }}
							</td>
							<td style="text-align: right;">
								@php
									$category_discount = $sum_total_category_discount[$data];
									$sum_category_discount[] = $category_discount;
								@endphp
								{{ number_format($category_discount,2,".",",")  }}
							</td>
							<td style="text-align: right;">
								@php
									$amount = $gross_amount - $category_discount;
									$sum_amount[] = $amount;
								@endphp
								{{ number_format($amount,2,".",",")  }}
							</td>
						</tr>
					@else

					@endif
				@endforeach
				<tr>
					<td style="text-align: right;"></td>
					<td style="text-align: right;">{{ number_format(array_sum($sum_total_bo_quantity),2,".",",") }}</td>
					<td style="text-align: right;"></td>
					<td style="text-align: right;">{{ number_format(array_sum($sum_gross_amount),2,".",",")  }}</td>
					<td style="text-align: right;">{{ number_format(array_sum($sum_category_discount),2,".",",") }}</td>
					<td style="text-align: right;">{{ number_format(array_sum($sum_amount),2,".",",")  }}</td>
				</tr>
			</tbody>
		</table>
		<table class="table table-bordered table-hover table-sm" id="table_print_2"  style="">
			<thead>
				<tr>
					<th style="text-align: center;">TOTAL GROSS BO</th>
					<th style="text-align: right;">{{ number_format(array_sum($sum_gross_amount),2,".",",")  }}</th>
				</tr>
				<tr>
					<th style="text-align: center;">TOTAL CATEGORY DISCOUNT</th>
					<th style="text-align: right;">{{ number_format(array_sum($sum_category_discount),2,".",",") }}</th>
				</tr>
				<tr>
					<th style="text-align: center;">NET AMOUNT</th>
					<th style="text-align: right;">{{ number_format(array_sum($sum_amount),2,".",",") }}</th>
				</tr>
				<tr>
					<th style="text-align: center;">LESS CUSTOMER DISCOUNT:</th>
					<th style="text-align: right;">{{ number_format(array_sum($sum_total_discount),2,".",",") }}</th>
				</tr>
				<tr>
					<th style="text-align: center;">TOTAL CM:</th>
					<th style="text-align: right;">
						@php
							$total_cm = array_sum($sum_amount) - array_sum($sum_total_discount);
						@endphp
						{{ number_format($total_cm,2,".",",") }}
						<input type="hidden" id="total_cm" value="{{ $total_cm }}">
					</th>
				</tr>
			</thead>
		</table>
		<div id="show_net_cm_summary"></div>
		<table class="table table-bordered table-sm float-right" style="width:20%;" id="table_print_3">
				<thead>
					<tr>
						<th colspan="2" style="text-align: center;">BO SUMMARY</th>
					</tr>
					@if($principal == 'PFC')
						@foreach($sku_id as  $data)
							@if($remarks[$data] == "EXPIRED")
								@php
									$bo_data_amount_expired_print = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_expired_print[] = $bo_data_amount_expired_print;
								@endphp
							@elseif($remarks[$data] == "BO")
								@php	
									$bo_data_amount_bo_print = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_bo_print[] = $bo_data_amount_bo_print;
								@endphp
							@else
								@php
									$sum_bo_data_amount_expired_print[] = 0;
									$sum_bo_data_amount_bo_print[] = 0;
								@endphp
							@endif
						@endforeach
						<tr>
							<th style="text-align: center;">EXPIRED</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_expired_print))
									{{ number_format(array_sum($sum_bo_data_amount_expired_print),2,".",",") }}
								@else
									{{ number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">BO</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_bo_print))
									{{ number_format(array_sum($sum_bo_data_amount_bo_print),2,".",",") }}
								@else
									{{ number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">BO EXPIRED</th>
							<th style="text-align: right;">
								@if(isset($sum_net_amount_expired))
									{{ number_format(array_sum($sum_net_amount_expired),2,".",",") }}
								@else
									{{ number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">TOTAL</th>
							<th style="text-align: right;">
								{{ number_format(array_sum($sum_net_amount_expired) + array_sum($sum_bo_data_amount_bo_print) + array_sum($sum_bo_data_amount_expired_print) ,2,".",",") }}
							</th>
						</tr>
					@elseif($principal == 'PPMC')
						@foreach($sku_id as  $data)
							@if($remarks[$data] == "BAR")
								@php
									$bo_data_amount_bar_print = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_bar_print[] = $bo_data_amount_bar_print;
								@endphp
							@elseif($remarks[$data] == "POWDER")
								@php	
									$bo_data_amount_powder_print = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_powder_print[] = $bo_data_amount_powder_print;
								@endphp
							@elseif($remarks[$data] == "PLC")
								@php
									$bo_data_amount_plc_print = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_plc_print[] = $bo_data_amount_plc_print;
								@endphp
							@endif
						@endforeach
						<tr>
							<th style="text-align: center;">BAR</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_bar_print))
									{{  number_format(array_sum($sum_bo_data_amount_bar_print),2,".",",") }}
								@else
									{{  number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">POWDER</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_powder_print))
									{{  number_format(array_sum($sum_bo_data_amount_powder_print),2,".",",") }}
								@else
									{{  number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">PLC</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_plc_print))
									{{  number_format(array_sum($sum_bo_data_amount_plc_print),2,".",",") }}
								@else
									{{  number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">BO EXPIRED</th>
							<th style="text-align: right;">
								@if(isset($sum_net_amount_expired))
									{{ number_format(array_sum($sum_net_amount_expired),2,".",",") }}
								@else
									{{ number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">AMOUNT</th>
							<th style="text-align: right;">
								<input type="text" id="short_over_amount" class="form-control">
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">TOTAL</th>
							<th style="text-align: right;">
								{{-- {{ number_format(array_sum($sum_bo_data_amount_bar_print) + array_sum($sum_bo_data_amount_powder_print) + array_sum($sum_bo_data_amount_plc_print) + array_sum($sum_net_amount_expired) ,2,".",",") }} --}}
								<input type="text" id="total_cm_amount" class="form-control">
							</th>
						</tr>
					@elseif($principal == "CIFPI")
						@foreach($sku_id as  $data)
							@if($remarks[$data] == "CONFECTIONARY")
								@php
									$bo_data_amount_confectionary_print = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_confectionary_print[] = $bo_data_amount_confectionary_print;
								@endphp
							@elseif($remarks[$data] == "SNACKS")
								@php	
									$bo_data_amount_snacks_print = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_snacks_print[] = $bo_data_amount_snacks_print;
								@endphp
							@elseif($remarks[$data] == "EXPIRED")
								@php
									$bo_data_amount_expired_print = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_expired_print[] = $bo_data_amount_expired_print;
								@endphp
							@endif
						@endforeach
						<tr>
							<th style="text-align: center;">CONFEC</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_confectionary_print))
									{{  number_format(array_sum($sum_bo_data_amount_confectionary_print),2,".",",") }}
								@else
									{{  number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">SNACKS</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_snacks_print))
									{{  number_format(array_sum($sum_bo_data_amount_snacks_print),2,".",",") }}
								@else
									{{  number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">EXPIRED</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_expired_print))
									{{  number_format(array_sum($sum_bo_data_amount_expired_print),2,".",",") }}
								@else
									{{  number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">BO EXPIRED</th>
							<th style="text-align: right;">
								@if(isset($sum_net_amount_expired))
									{{ number_format(array_sum($sum_net_amount_expired),2,".",",") }}
								@else
									{{ number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">TOTAL</th>
							<th style="text-align: right;">
								{{ number_format(array_sum($sum_bo_data_amount_confectionary_print) + array_sum($sum_bo_data_amount_snacks_print) + array_sum($sum_bo_data_amount_expired_print) + array_sum($sum_net_amount_expired) ,2,".",",") }}
							</th>
						</tr>
					@else
						@foreach($sku_id as  $data)
							@if($remarks[$data] == "BO")
								@php
									$bo_data_amount_print = $sum_net_amount_bo[$data];
									$sum_bo_data_amount_print[] = $bo_data_amount_print;
								@endphp
							@else

							@endif
						@endforeach
						<tr>
							<th style="text-align: center;">BO</th>
							<th style="text-align: right;">
								@if(isset($sum_bo_data_amount_print))
									{{  number_format(array_sum($sum_bo_data_amount_print),2,".",",") }}
								@else
									{{  number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>
						<tr>
							<th style="text-align: center;">BO EXPIRED</th>
							<th style="text-align: right;">
								@if(isset($sum_net_amount_expired))
									{{ number_format(array_sum($sum_net_amount_expired),2,".",",") }}
								@else
									{{ number_format(0,2,".",",") }}
								@endif
							</th>
						</tr>

						<tr>
							<th style="text-align: center;">TOTAL</th>
							<th style="text-align: right;">
								{{ number_format(array_sum($sum_bo_data_amount_print) + array_sum($sum_net_amount_expired) ,2,".",",") }}
							</th>
						</tr>
					@endif
				</thead>
		</table>
	
		
	</div>
	

	<div class="form-group">
		<button type="submit" class="btn btn-success btn-block">SUBMIT CM FOR BO</button>
	</div>
</form>
<script type="text/javascript">
	 $('.select2').select2();
	$('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
    $('[class=integer-default]').maskNumber({integer: true});
    $('[class=integer-data-attribute]').maskNumber({integer: true});
    $('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});

    $( "#generate_summary" ).click(function() {
    	var involved_in = $('#involved_in').val();
    	var amount_involved = $('#amount_involved').val();


    	var total_cm = $('#total_cm').val();
    	var personnels_involved = $('#personnels_involved').val();
    	var	sum = amount_involved.replace(",", "");
    	var	sum_1 = parseFloat(total_cm) + parseFloat(sum) ;
    	var	sum_2 = parseFloat(total_cm) - parseFloat(sum);	
    	var	sum_3 = parseFloat(total_cm);
		$.ajax({
			url: "customer_credit_memo_for_bo_generate_final_computation",
			type: "POST",
			data: 'involved_in=' + involved_in + '&amount_involved=' + amount_involved + '&total_cm=' + total_cm + '&personnels_involved=' + personnels_involved,
            success: function(data){
            	$('#short_over_amount').val(amount_involved);
            	
            	
            	if (involved_in == 'Charged') {
            		
            		$('#total_cm_amount').val(sum_1);
            	}else if(involved_in == 'Over Payment'){
            		
            		$('#total_cm_amount').val(sum_2);
            	}else{
            		var sum = total_cm;
            		$('#total_cm_amount').val(sum_3);
            	}

            	$('#show_net_cm_summary').html(data);
            }
		});
	});




	$("#save_cm_for_bo").on('submit',(function(e){
		e.preventDefault();	
		$('.loading').show();

		mao_nani = new FormData(this);
		$('#charge_over_form').hide();
		$('#table_print_1').show();
		$('#table_print_2').show();
		$('#table_print_3').show();
		$('#table_print_4').show();
		
		// $.ajax({
		// 				url: "customer_credit_memo_for_bo_save",
		// 				type: "POST",
		// 				data:  mao_nani,
		// 				contentType: false,
		// 				cache: false,
		// 				processData:false,
		// 				success: function(data){
							
		// 					console.log(data);

		// 				},
		// 			});


		var printContents = document.getElementById('print').innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
		setTimeout(function(){
			const swalWithBootstrapButtons = Swal.mixin({
			  customClass: {
			    confirmButton: 'btn btn-success',
			    cancelButton: 'btn btn-danger'
			  },
			  buttonsStyling: false
			})

			swalWithBootstrapButtons.fire({
			  title: 'Are you sure?',
			  text: "After transaction page will be reloaded!",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonText: 'Yes, save it!',
			  cancelButtonText: 'No, cancel!',
			  reverseButtons: true
			}).then((result) => {
			  if (result.isConfirmed) {
			  	Swal.fire({
				  position: 'top-end',
				  icon: 'success',
				  title: 'Your work is being save!',
				  showConfirmButton: false,
				  timer: 1500
				})


			    	$.ajax({
						url: "customer_credit_memo_for_bo_save",
						type: "POST",
						data:  mao_nani,
						contentType: false,
						cache: false,
						processData:false,
						success: function(data){
							Swal.fire({
							  position: 'top-end',
							  icon: 'success',
							  title: 'Your work has been saved',
							  showConfirmButton: false,
							  timer: 1500
							})
							location.reload();
						},
					});

			  } else if (
			    /* Read more about handling dismissals below */
			    result.dismiss === Swal.DismissReason.cancel
			  ) {
			    Swal.fire({
				  position: 'top-end',
				  icon: 'success',
				  title: 'Work cancelled, Reloading Page!',
				  showConfirmButton: false,
				  timer: 1500
				})
				location.reload();
			  }
			})

		}, 1000);
	}));
</script>
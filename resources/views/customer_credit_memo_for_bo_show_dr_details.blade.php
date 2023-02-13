<form id="customer_credit_memo_for_bo_save">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th colspan="2">CUSTOMER</th>
				<th>Agent</th>
				<th>PCM #</th>
				<th>DR</th>
				
				@if(array_sum($line_discount_1) != 0)
					<th colspan="1">STATUS</th>
				@elseif(array_sum($line_discount_2) != 0)
					<th colspan="2">STATUS</th>
				@endif
				<th colspan="{{ $counter }}">CONVERTED BY</th>
				<th colspan="3">DATE CONFIRMED</th>
			</tr>
			<tr>
				<td colspan="2" style="color:blue;">{{ $cm_for_bo->customer->store_name }}</td>
				<td style="color:blue;">{{ $cm_for_bo->agent->full_name }}</td>
				<td style="color:blue;">{{ $cm_for_bo->pcm_number }}</td>
				<td style="color:blue;">{{ $cm_for_bo->sales_order_print->dr }}</td>
				
				@if(array_sum($line_discount_1) != 0)
					<td style="color:blue;" colspan="1">{{ $cm_for_bo->status }}</td>
				@elseif(array_sum($line_discount_2) != 0)
					<td style="color:blue;" colspan="2">{{ $cm_for_bo->status }}</td>
				@endif
				<td colspan="{{ $counter }}" style="color:blue;text-transform: uppercase;">{{ $cm_for_bo->converted_by }}</td>
				<td colspan="3" style="color:blue;">{{ $cm_for_bo->date_confirmed }}</td>
			</tr>
			<tr>
				<th style="text-align: center;">CODE</th>
				<th style="text-align: center;">DESCRIPTION</th>
				<th style="text-align: center;">QUANTITY</th>
				<th style="text-align: center;">PRICE</th>
				<th style="text-align: center;">AMOUNT</th>
				@if(array_sum($line_discount_1) != 0)
					<th style="text-align: center;">LINE D 1</th>
				@endif
				@if(array_sum($line_discount_2) != 0)
					<th style="text-align: center;">LINE D 2</th>
				@endif
				@if($counter != 0)
					@for ($i=0; $i < $counter; $i++)
						<th>CUST D {{ $i + 1 }}</th>
					@endfor
				@endif
				<th style="text-align: center;color:green;">NET<br />AMOUNT</th>
				<th style="text-align: center;">REMARKS</th>
			</tr>
		</thead>
		<tbody>
			@foreach($cm_for_bo->cm_for_bo_details as $data)
				<tr>
					<td>{{ $data->sku->sku_code }}</td>
					<td>{{ $data->sku->description }}</td>
					<td>
						@php
							$sum_quantity[] = $data->quantity;
						@endphp
						{{ $data->quantity }}
					</td>
					<td>{{ $data->price }}</td>
					<td style="text-align: right;">
						@php
							$amount = $data->price * $data->quantity;
							$sum_amount[$data->sku_id] = $amount;
							echo number_format($amount,2,".",",");
						@endphp
					</td>
					@if(array_sum($line_discount_1) != 0)
						<td style="text-align: right;">
							@php
								$sku_line_discount_1 = $amount * $line_discount_1[$data->sku_id] /100;
							@endphp
							{{ number_format($sku_line_discount_1,2,".",",") }}
						</td>
					@else
						@php
							$sku_line_discount_1 = 0;
						@endphp
					@endif
					@if(array_sum($line_discount_2) != 0)
						<td style="text-align: right;">

							@php
								$sku_line_discount_2 = ($amount - $sku_line_discount_1) * $line_discount_2[$data->sku_id] /100;
								
							@endphp
							{{ number_format($sku_line_discount_2,2,".",",") }}
						</td>
					@else
						@php
							$sku_line_discount_2 = 0;
						@endphp
					@endif
					@php
						$total_line_discount = $sku_line_discount_1 + $sku_line_discount_2;
						$sum_sku_line_discount_1[$data->sku_id] = $sku_line_discount_1;
						$sum_sku_line_discount_2[$data->sku_id] = $sku_line_discount_2;
					@endphp
					@if($counter != 0)
						@php
								$total_bo = $amount - $total_line_discount;
						        $data_keeper_bo = $total_bo;
						        $sum_data_keeper_bo = [];
						@endphp
						        @for ($i=0; $i < $counter; $i++) 
						          	@php
						          		$data_keeper_bo_dummy = $data_keeper_bo;
							            $customer_discount_bo = ($customer_discount_rate[$i] / 100);
							            $data_answer_bo = $data_keeper_bo * $customer_discount_bo;
							            $data_keeper_bo =  $data_keeper_bo_dummy - ($data_keeper_bo_dummy * $customer_discount_bo);
							            $sum_data_keeper_bo[] = $data_answer_bo;
						          	@endphp
						            <td style="text-align: right;">{{ number_format($data_answer_bo,2,".",",")  }}</td>
								@endfor
					@endif
					<td style="text-align: right;">
						@php
							$net_amount =  $amount - $total_line_discount - array_sum($sum_data_keeper_bo);
							$sum_net_amount[$data->sku_id] = $net_amount;
							echo number_format($net_amount,2,".",",");
						@endphp
					</td>
					<td>{{ $data->remarks }}</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
				<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_amount),2,".",",") }}</td>
				@if(array_sum($line_discount_1) != 0)
					<td style="text-align: right;font-weight: bold;">
						{{ number_format(array_sum($sum_sku_line_discount_1),2,".",",") }}
					</td>
				@endif
				@if(array_sum($line_discount_2) != 0)
					<td style="text-align: right;font-weight: bold;">
						{{ number_format(array_sum($sum_sku_line_discount_2),2,".",",") }}
					</td>
				@endif
				<td colspan="{{ $counter }}"></td>
				<td style="text-align: right;font-weight: bold;">
					{{ number_format(array_sum($sum_net_amount),2,".",",") }}
					<input type="hidden" name="total_cm" id="total_cm" value="{{ array_sum($sum_net_amount) }}">
				</td>
				<td></td>
			</tr>
		</tfoot>
	</table>


	<table class="table table-bordered table-sm float-right" style="width:20%">
		<thead>
			<tr>
				<th colspan="2" style="text-align: center;">BO SUMMARY</th>
			</tr>
				@if($cm_for_bo->sales_order_print->principal->principal == 'PFC')
					@foreach($cm_for_bo->cm_for_bo_details as  $data)
						@if($data->remarks == "EXPIRED")
							@php
								$bo_data_amount_expired = $sum_net_amount[$data->sku_id];
								$sum_bo_data_amount_expired[] = $bo_data_amount_expired;
							@endphp
						@elseif($data->remarks == "BO")
							@php
								$bo_data_amount_bo = $sum_net_amount[$data->sku_id];
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
						<th style="text-align: center;">TOTAL</th>
						<th style="text-align: right;">
							{{ number_format(array_sum($sum_bo_data_amount_bo) + array_sum($sum_bo_data_amount_expired) ,2,".",",") }}
						</th>
					</tr>
				@elseif($cm_for_bo->sales_order_print->principal->principal == 'PPMC')
					@foreach($cm_for_bo->cm_for_bo_details as  $data)
						@if($data->remarks == "BAR")
							@php
								$bo_data_amount_bar = $sum_net_amount[$data->sku_id];
								$sum_bo_data_amount_bar[] = $bo_data_amount_bar;
							@endphp
						@elseif($data->remarks == "POWDER")
							@php
								$bo_data_amount_powder = $sum_net_amount[$data->sku_id];
								$sum_bo_data_amount_powder[] = $bo_data_amount_powder;
							@endphp
						@elseif($data->remarks == "PLC")
							@php
								$bo_data_amount_plc = $sum_net_amount[$data->sku_id];
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
						<th style="text-align: center;">TOTAL</th>
						<th style="text-align: right;">
							{{ number_format(array_sum($sum_bo_data_amount_bar) + array_sum($sum_bo_data_amount_powder) + array_sum($sum_bo_data_amount_plc),2,".",",") }}
						</th>
					</tr>
				@elseif($cm_for_bo->sales_order_print->principal->principal == "CIFPI")
					@foreach($cm_for_bo->cm_for_bo_details as  $data)
						@if($data->remarks == "CONFECTIONARY")
							@php
								$bo_data_amount_confectionary = $sum_net_amount[$data->sku_id];
								$sum_bo_data_amount_confectionary[] = $bo_data_amount_confectionary;
							@endphp
						@elseif($data->remarks == "SNACKS")
							@php
								$bo_data_amount_snacks = $sum_net_amount[$data->sku_id];
								$sum_bo_data_amount_snacks[] = $bo_data_amount_snacks;
							@endphp
						@elseif($data->remarks == "EXPIRED")
							@php
								$bo_data_amount_expired = $sum_net_amount[$data->sku_id];
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
						<th style="text-align: center;">TOTAL</th>
						<th style="text-align: right;">
							{{ number_format(array_sum($sum_bo_data_amount_confectionary) + array_sum($sum_bo_data_amount_snacks) + array_sum($sum_bo_data_amount_expired),2,".",",") }}
						</th>
					</tr>
			@else
				@foreach($cm_for_bo->cm_for_bo_details as  $data)
					@if($data->remarks == "BO")
						@php
							$bo_data_amount = $sum_net_amount[$data->sku_id];
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
					<th style="text-align: center;">TOTAL</th>
					<th style="text-align: right;">
						{{ number_format(array_sum($sum_bo_data_amount),2,".",",") }}
					</th>
				</tr>
			@endif
		</thead>
	</table>

	<table class="table table-bordered table-hover table-sm" >
		<thead>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td style="text-align: right;font-weight: bold;">SUMMARY FOR DEDUCTION:</td>
				
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td style="text-align: right;font-weight: bold;">SALES DEDUCTION</td>
				
				<td style="text-align: right;font-weight: bold;">
					@php
						$sales_deduction = array_sum($sum_net_amount) / 1.12;
						echo number_format($sales_deduction,2,".",",");
					@endphp
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td style="text-align: right;font-weight: bold;">VAT DEDUCTION</td>
				<td style="text-align: right;font-weight: bold;">
					@php
						$vat_deduction = $sales_deduction * .12;
						echo number_format($vat_deduction,2,".",",");
					@endphp
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td style="text-align: right;font-weight: bold;">NET CM DEDUCTION</td>
				<td style="text-align: right;font-weight: bold;">
					@php
						$net_cm_deduction = $sales_deduction + $vat_deduction;
						echo number_format($net_cm_deduction,2,".",",") 
					@endphp
				</td>
			</tr>
		</thead>
	</table>

	<table class="table table-bordered table-hover table-sm" >
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

	<div id="show_net_cm_summary"></div>
	<input type="hidden" name="customer_id" value="{{ $cm_for_bo->customer_id }}">
	<input type="hidden" name="principal_id" value="{{ $cm_for_bo->sales_order_print->principal_id }}">
	<input type="hidden" name="delivery_receipt" value="{{ $cm_for_bo->sales_order_print->dr }}">
	<input type="hidden" name="sales_order_number" value="{{ $cm_for_bo->sales_order_print->sales_order_number }}">
	<input type="hidden" name="sales_order_print_id" value="{{ $cm_for_bo->sales_order_print->id }}">
	<input type="hidden" name="agent_id" value="{{ $cm_for_bo->sales_order_print->agent_id }}">
	<input type="hidden" name="principal_id" value="{{ $cm_for_bo->sales_order_print->principal_id }}">
	<input type="hidden" name="cm_for_bo_id" value="{{ $cm_for_bo->id }}">
	<input type="hidden" name="posted_by" value="{{ $posted_by }}">
	<input type="hidden" name="pcm_number" value="{{ $cm_for_bo->pcm_number }}">
	<button type="submit" class="btn btn-success btn-block">POST CM FOR BO</button>
</form>

<script type="text/javascript">


	$("#customer_credit_memo_for_bo_save").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "customer_credit_memo_for_bo_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            //$('.loading').hide();
              console.log(data);
            if (data == 'saved') {
				Swal.fire({
				  position: 'top-end',
				  icon: 'success',
				  title: 'Your work has been saved',
				  showConfirmButton: false,
				  timer: 1500
				})

				location.reload();
          	}else{
          		Swal.fire(
					'Something went wrong',
					'error',
					'error'
				)
				$('.loading').hide();
          	}
          },
        });
    }));




		$('.select2').select2();
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

</script>
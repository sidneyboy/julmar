<form id="customer_credit_memo_for_rgs_save">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>CUSTOMER</th>
				<th>Agent</th>
				<th>PCM #</th>
				<th>DR</th>
				<th>STATUS</th>
				<th>CONVERTED BY</th>
				<th colspan="3">DATE CONFIRMED</th>
			</tr>
			<tr>
				<td style="color:blue;">{{ $cm_for_rgs->customer->store_name }}</td>
				<td style="color:blue;">{{ $cm_for_rgs->agent->full_name }}</td>
				<td style="color:blue;">{{ $cm_for_rgs->pcm_number }}</td>
				<td style="color:blue;">{{ $cm_for_rgs->sales_order_print->dr }}</td>
				<td style="color:blue;">{{ $cm_for_rgs->status }}</td>
				<td style="color:blue;text-transform: uppercase;">{{ $cm_for_rgs->converted_by }}</td>
				<td style="color:blue;text-align: center;" colspan="3">{{ $cm_for_rgs->date_confirmed }}</td>
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
				<th style="text-align: center;color:green;">NET<br />AMOUNT</th>
				<th style="text-align: center;">REMARKS</th>
			</tr>
		</thead>
		<tbody>
			@foreach($cm_for_rgs->cm_for_rgs_details as $data)
				<tr>
					<td>
						{{ $data->sku->sku_code }}
					</td>
					<td>{{ $data->sku->description }}</td>
					<td style="text-align: right;">
						@php
							$sum_quantity[] = $data->quantity;
						@endphp
						{{ $data->quantity }}
					</td>
					<td style="text-align: right;">{{ $data->price }}</td>
					<td style="text-align: right;">
						@php
							$amount = $data->price * $data->quantity;
							$sum_amount[] = $amount;
							echo number_format($amount,2,".",",");
						@endphp
					</td>
					@if(array_sum($line_discount_1) != 0)
						<td style="text-align: right;">
							@php
								$sku_line_discount_1 = $amount*$line_discount_1[$data->sku_id]/100;
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
								$sku_line_discount_2 = ($amount - $sku_line_discount_1) *$line_discount_2[$data->sku_id]/100;
								
							@endphp
							{{ number_format($sku_line_discount_2,2,".",",") }}
						</td>
					@else
						@php
							$sku_line_discount_2 = 0;
						@endphp
					@endif
					@php
						$sum_sku_line_discount_1[] = $sku_line_discount_1;
						$sum_sku_line_discount_2[] = $sku_line_discount_2;
					@endphp
					<td style="text-align: right;">
						@php
							$net_amount =  $amount - $sku_line_discount_1 - $sku_line_discount_2;
							$sum_net_amount[] = $net_amount;
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
				<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_net_amount),2,".",",") }}</td>
				<td></td>
			</tr>
		</tfoot>
	</table>

	<table class="table table-bordered table-hover table-sm">
		<tr>
			<td style="text-align: right;">QUANTITY:</td>
			<td>{{ array_sum($sum_quantity) }}</td>
			<td style="text-align: right;">TOTAL CM AMOUNT:</td>
			<td></td>
			<td style="text-align: right;">
				@php
					$total_dr_amount = array_sum($sum_sku_line_discount_1) + array_sum($sum_sku_line_discount_2) + array_sum($sum_net_amount);
					$total_dr_amount_array[] = $total_dr_amount;
				@endphp
				{{ number_format($total_dr_amount,2,".",",") }}
			</td>
		</tr>
		<tr>
			<td style="text-align: right;"></td>
			<td></td>
			<td style="text-align: right;">TOTAL CATEGORY DISC:</td>
			<td></td>
			<td style="text-align: right;">
				@php
					$total_category_discount_amount = array_sum($sum_sku_line_discount_1) + array_sum($sum_sku_line_discount_2);
					$total_category_discount_array[] = $total_category_discount_amount;
				@endphp

				{{ number_format($total_category_discount_amount,2,".",",") }}
			</td>
		</tr>
		<tr>
			<td style="text-align: right;"></td>
			<td></td>
			<td style="text-align: right;">NET AMOUNT:</td>
			<td></td>
			<td style="text-align: right;">
				@php
					$total_for_dr_and_category_amount = $total_dr_amount - $total_category_discount_amount;
				@endphp
				{{ number_format($total_for_dr_and_category_amount,2,".",",") }}
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td style="text-align: right;">LESS: CUSTOMER DISCOUNT:</td>
			<td></td>
			<td></td>
		</tr>
		@if($counter == 0)
			<tr>
				<td></td>
				<td></td>
				<td style="text-align: right;">CUSTOMER DISC:</td>
				<td>
					@php
						$deducted_total_history[] = 0;
					@endphp
				</td>
				<td></td>
			</tr>
		@else
			@php
				$total = $total_for_dr_and_category_amount;
				$deducted_total = $total;
				$deducted_total_history = [];
			@endphp
			@for ($i=0; $i < $counter; $i++)
				<tr>
					<td></td>
					<td></td>
					<td style="text-align: right;"><span class="float-right">CUSTOMER DISC {{ $customer_discount_rate[$i] / 100 }}</span></td>
				
					<td style="text-align: right;">
						@php
							$deducted_total_dummy = $deducted_total;
							$less_percentage_by = ($customer_discount_rate[$i] / 100);
							$deducted_total = $deducted_total_dummy - ($deducted_total_dummy * $less_percentage_by);
							echo $answer = round($deducted_total_dummy * $less_percentage_by,2);
						$deducted_total_history[] = $answer;
						@endphp
					</td>
					<td></td>
				</tr>
			@endfor
		@endif
		<tr>
			<td></td>
			<td></td>
			<td style="text-align: right;">TOTAL CUSTOMER DISC:</td>
			<td></td>
			<td style="text-align: right;">
				@php
					$total_customer_discount_amount = array_sum($deducted_total_history);
					$total_category_discount_per_sku_array[] = $total_customer_discount_amount;
				@endphp

				{{ number_format($total_customer_discount_amount,2,".",",") }}
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td style="text-align: right;">NET CM DEDUCTION:</td>
			<td></td>
			<td style="text-align: right;">
				@php
					$total_payable_amount = $total_dr_amount - $total_category_discount_amount - $total_customer_discount_amount;
				@endphp
				{{  number_format($total_payable_amount,2,".",",") }}
			</td>
		</tr>
	</table>

	<table class="table table-bordered table-hover table-sm" >
					<thead>
						<tr>
							<td></td>
							<td></td>
							<td style="text-align: right;">SUMMARY FOR DEDUCTION:</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td style="text-align: right;">SALES DEDUCTION</td>
							<td></td>
							<td style="text-align: right;">
								@php
									$sales_deduction = $total_payable_amount/1.12;
									echo number_format($sales_deduction,2,".",",")
								@endphp
							</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td style="text-align: right;">VAT DEDUCTION</td>
							<td></td>
							<td style="text-align: right;">
								@php
									 $vat_deduction = $sales_deduction*.12;
									echo number_format($vat_deduction,2,".",",")
								@endphp
							</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td style="text-align: right;">NET CM DEDUCTION</td>
							<td></td>
							<td style="text-align: right;">
								@php
									$net_cm_deduction = $sales_deduction + $vat_deduction;
									echo number_format($net_cm_deduction,2,".",",")
								@endphp
							</td>
						</tr>
					</thead>
	</table>

	<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th style="text-align: center;">TOTAL DR ORIGINAL AMOUNT</th>
						<th style="text-align: center;">PREV COLL</th>
						<th style="text-align: center;">PREV BO</th>
						<th style="text-align: center;">PREV RGS</th>
						<th style="text-align: center;">CURRENT RGS INPUT</th>
						<th style="text-align: center;">TOTAL COLLECTIBLE</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="text-align: right;font-weight: bold">
							@php
								$orginal_dr_amount = $cm_for_rgs->sales_order_print->total_amount;
								echo number_format($orginal_dr_amount ,2,".",",");
							@endphp
						</td>
						<td style="text-align: right;font-weight: bold">
							@if(is_null($customer_payment_prev_collection))
								@php
									$prev_coll = 0;
								@endphp
								{{  number_format($prev_coll,2,".",",") }}
							@else
								@php
									$prev_coll = $customer_payment_prev_collection;
								@endphp
								{{  number_format($prev_coll,2,".",",") }}
							@endif
						</td>
						<td style="text-align: right;font-weight: bold">
							{{ number_format($bo_prev_collection,2,".",",") }}
						</td>
						<td style="text-align: right;font-weight: bold">
							{{ number_format($rgs_prev_collection,2,".",",") }}
						</td>
						<td style="text-align: right;font-weight: bold;">
							{{ number_format($net_cm_deduction,2,".",",") }}
						</td>
						<td style="text-align: right;font-weight: bold;">
							@php	
								 $total_collectible = $orginal_dr_amount - $prev_coll - $bo_prev_collection -$rgs_prev_collection - $net_cm_deduction;
								echo number_format($total_collectible,2,".",",");
							@endphp
						</td>
					</tr>
				</tbody>
	</table>

	@if($prev_coll != 0)
		<input type="hidden" name="cm_for_rgs_id" value="{{ $cm_for_rgs->id }}">
		<input type="hidden" name="net_cm_deduction" value="{{ $net_cm_deduction }}">
		<input type="hidden" name="posted_by" value="{{ $posted_by }}">
		<input type="hidden" name="principal_id" value="{{ $cm_for_rgs->sales_order_print->principal_id }}">
		<input type="hidden" name="customer_id" value="{{ $cm_for_rgs->customer_id }}">
		<input type="hidden" name="delivery_receipt" value="{{ $cm_for_rgs->sales_order_print->dr }}">
		<input type="hidden" name="pcm_number" value="{{ $cm_for_rgs->pcm_number}}">
		<input type="hidden" name="sales_order_number" value="{{ $cm_for_rgs->sales_order_print->sales_order_number }}">
		<input type="hidden" name="sales_order_print_id" value="{{ $cm_for_rgs->sales_order_print->id }}">
		<input type="hidden" name="agent_id" value="{{ $cm_for_rgs->sales_order_print->agent_id }}">
		<button type="submit" class="btn btn-block btn-success">POST CM FOR RGS</button>
	@else
		<button type="submit" class="btn btn-block btn-success" disabled>POST CM FOR RGS</button>
	@endif
</form>

<script type="text/javascript">
    $("#customer_credit_memo_for_rgs_save").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "customer_credit_memo_for_rgs_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            $('.loading').hide();
            console.log(data);
            location.reload();
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
</script>
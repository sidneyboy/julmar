<form id="save_cm_for_rgs">
	@csrf
	<div class="table table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
		
				<tr>
					<th style="text-align: center;">CODE</th>
					<th style="text-align: center;">DESCRIPTION</th>
					<th style="text-align: center;">QUANTITY</th>
					<th style="text-align: center;">PRICE</th>
					<th style="text-align: center;">AMOUNT</th>
					{{-- @foreach($sku_id as $data)
					@if($category_discount_rate_1[$data] == 0.0000)
					@else
					<th style="text-align: center;">Category Discount Rate</th>
					@endif
					@if($category_discount_rate_2[$data] == 0.0000)
					@else
					<th style="text-align: center;">Category Discount Rate</th>
					@endif
					@if($category_discount_rate_3[$data] == 0.0000)
					@else
					<th style="text-align: center;">Category Discount Rate</th>
					@endif
					@if($category_discount_rate_4[$data] == 0.0000)
					@else
					<th style="text-align: center;">Category Discount Rate</th>
					@endif
					@endforeach --}}
					<th style="text-align: center;color:green;">TOTAL<br />CATEG<br />DISC</th>
					<th style="text-align: center;color:green;">NET<br />AMOUNT</th>
					<th style="text-align: center;">RGS QTY</th>
					<th style="text-align: center;">RGS AMOUNT</th>
					<th style="text-align: center;">REMARKS</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sku_id as  $data)
					@if($rgs_quantity[$data] != 0)
						<tr>
						<td>
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
								$sum_sku_quantity[] = $quantity[$data];
							@endphp
							{{ $quantity[$data] }}

						</td>
						<td style="text-align: right;">
							{{ number_format($price[$data],2,".",",")  }}
							<input type="hidden" name="price[{{ $data }}]" value="{{ $price[$data] }}">
						</td>
						<td style="text-align: right;">
							@php
							$total_amount_per_sku = $quantity[$data] * $price[$data];
							$sum_total_amount_per_sku[] = $total_amount_per_sku;
							echo  number_format($total_amount_per_sku,2,".",",")
							@endphp
						</td>

						@if($category_discount_rate_1[$data] == 0)
							@php
								$category_discount_line_rate_1 = 0;
							@endphp
						@else
							@php
								$category_discount_line_rate_1 = $category_discount_rate_1[$data];
							@endphp
						@endif

						@if($category_discount_rate_2[$data] == 0)
							@php
								$category_discount_line_rate_2 = 0;
							@endphp
						@else
							@php
								$category_discount_line_rate_2 = $category_discount_rate_2[$data];
							@endphp
						@endif	

						@if($category_discount_rate_3[$data] == 0)
							@php
								$category_discount_line_rate_3 = 0;
							@endphp
						@else
							@php
								$category_discount_line_rate_3 = $category_discount_rate_3[$data];
							@endphp
						@endif

						@if($category_discount_rate_4[$data] == 0)
							@php
								$category_discount_line_rate_4 = 0;
							@endphp
						@else
							@php
								$category_discount_line_rate_4 = $category_discount_rate_4[$data];
							@endphp
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
								<td style="text-align: right;font-weight: bold;">
									{{ number_format($final_category_discount_amount_per_sku,2,".",",") }}
								</td>
						@endif

						<td style="text-align: right;font-weight: bold;">
							@php
								$final_net_amount_per_sku =  $total_amount_per_sku - $final_category_discount_amount_per_sku;
								$final_net_amount_per_sku_array[] = $final_net_amount_per_sku;
							@endphp
							{{ number_format($final_net_amount_per_sku,2,".",",") }}
						</td>
						<td style="text-align: center;font-weight: bold;color:red;">
							@php
								$sum_rgs_quantity[] = $rgs_quantity[$data];
							@endphp
							{{ $rgs_quantity[$data] }}
							<input type="hidden" name="rgs_quantity[{{ $data }}]" value="{{ $rgs_quantity[$data] }}">
						</td>
						<td style="text-align: right;font-weight: bold;color:red;">
							@php
								$rgs_amount = $rgs_quantity[$data
								] * $price[$data];
								$sum_rgs_amount[] = $rgs_amount;
							@endphp
							{{ number_format($rgs_amount,2,".",",") }}
							<input type="hidden" name="rgs_amount[{{ $data }}]" value="{{ $rgs_amount }}">
						</td>
						<td>
							{{ $remarks[$data] }}
							<input type="hidden" name="remarks[{{ $data }}]" value="{{ $remarks[$data] }}">
						</td>
					</tr>
					@else

					@endif
					
				@endforeach
				<tr>
					<td style="text-align: center;font-weight: bold" colspan="4">GRAND TOTAL</td>
					<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_total_amount_per_sku),2,".",",") }}</td>
					{{-- @foreach($sku_id as $data)
					@if($category_discount_rate_1[$data] == 0.0000)
					@else
					<th style="text-align: center;">Category Discount Rate</th>
					@endif
					@if($category_discount_rate_2[$data] == 0.0000)
					@else
					<th style="text-align: center;">Category Discount Rate</th>
					@endif
					@if($category_discount_rate_3[$data] == 0.0000)
					@else
					<th style="text-align: center;">Category Discount Rate</th>
					@endif
					@if($category_discount_rate_4[$data] == 0.0000)
					@else
					<th style="text-align: center;">Category Discount Rate</th>
					@endif
					@endforeach --}}
					<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($total_category_discount_array),2,".",",") }}</td>
					<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($final_net_amount_per_sku_array),2,".",",") }}</td>
					<td style="text-align: center;color:red;">{{ array_sum($sum_rgs_quantity) }}</td>
					<td style="text-align: right;color:red;">
						{{ number_format(array_sum($sum_rgs_amount),2,".",",") }}
						<input type="hidden" name="total_rgs_amount" value="{{ array_sum($sum_rgs_amount) }}">
					</td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<table class="table table-borderless" style="border:none;">
			<thead>
				<tr>
					<td style="line-height:0px;font-weight: bold;"><span class="float-right">QUANTITY:</span></td>
					<td style="line-height:0px;font-weight: bold;">
						{{ array_sum($sum_sku_quantity) }}
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
				@if($counter == 0)
						<tr>
							<td style="line-height:0px;"></td>
								<td style="line-height:0px;"></td>
							<td style="line-height:0px;font-weight: bold;"><span class="float-right">CUSTOMER DISC:</span></td>
							<td style="line-height:0px;font-weight: bold;">N/A </td>
							<input type="hidden" name="counter" value="{{ $counter }}">
							<input type="hidden" name="customer_discount_rate[]" value="{{ 0 }}">
							@php
								$deducted_total_history[] = 0;
							@endphp
						</tr>
					@else
						@php
							$total = $total_for_dr_and_category_amount;
							$deducted_total = $total;
							$deducted_total_history = [];
						@endphp
						<input type="hidden" name="counter" value="{{ $counter }}">
						@for ($i=0; $i < $counter; $i++)
							<tr>
								<td style="line-height:0px;"></td>
								<td style="line-height:0px;"></td>
								<td style="line-height:0px;font-weight: bold;"><span class="float-right">CUSTOMER DISC {{ $customer_discount_rate[$i] / 100 }}</span></td>
								
								<td style="line-height:0px;font-weight: bold;">
									@php
									$deducted_total_dummy = $deducted_total;
									$less_percentage_by = ($customer_discount_rate[$i] / 100);
									$deducted_total = $deducted_total_dummy - ($deducted_total_dummy * $less_percentage_by);
									echo $answer = round($deducted_total_dummy * $less_percentage_by,2);
									$deducted_total_history[] = $answer;

									@endphp	

									<input type="hidden" name="customer_discount_rate[]" value="{{ $customer_discount_rate[$i] }}">				
								</td>
							</tr>
						@endfor
					@endif
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
							<input type="hidden" name="total_payable_amount" value="{{ $total_payable_amount }}">
						</td>
					</tr>
			</thead>
		</table>

		<div id="print" style="display:none;margin: 0px;">
			<table class="table table-borderless table-sm" style="padding:0px;font-size: 25px;width:50%;height:50%;">
				<thead>
					<tr>
						<th style="text-align: center;font-weight: bold;font-size: 25px;">JULMAR COMMERCIAL INC.</th>
					</tr>
					<tr>
						<th style="text-align: center;font-weight: bold;">GENERAL MERCHANDISE WHOLESALE & RETAIL</th>
					</tr>
					<tr>
						<td style="text-align: center">Osmena St., Cogon Market Cagayan de Oro City</td>
					</tr>
					<tr>
						<td style="text-align: center">TEL# 857-6197, 858-5771</td>
					</tr>
					<tr>
						<td style="text-align: center">Vat Reg. TIN 486-701-947-000</td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td style="text-align: center;font-weight: bold;">PROPOSAL for CREDIT MEMO (PCM)</td>
					</tr>
				</thead>
			</table>
			<table class="table table-borderless table-sm" style="width:50%;height:50%;font-size: 20px">
				<thead>
					<tr>
						<td style="text-align: right;">Bad Stocks <input type="radio" name="remarks"></td>
						<td></td>
						<td>Expired Stocks <input type="radio" name="remarks"></td>
					</tr>
					<tr>
						<td style="text-align: right;">Good Stocks <input type="radio" name="remarks"></td>
						<td></td>
						<td>Expiring Stocks <input type="radio" name="remarks"></td>
					</tr>
				</thead>
			</table>
			<table class="table table-bordered table-hover" style="width:50%;height:50%;font-size: 20px">
				<thead>
					<tr>
						<th style="text-align: center;">Code</th>
						<th style="text-align: center;">Description</th>
						<th style="text-align: center;">Qty</th>
						<th style="text-align: center;">Price</th>
						<th style="text-align: center;">Amount</th>
						<th style="text-align: center;">Remarks</th>
					</tr>
				</thead>
				<tbody>
					@foreach($sku_id as  $data)
					@if($rgs_quantity[$data] != 0)
						<tr>
							<td style="text-align: center;">
								{{ $sku_code[$data] }}
							</td>
							<td style="text-align: center;">
								{{ $description[$data] }}
							</td>
							<td style="text-align: center;">
								{{ $rgs_quantity[$data] }}
							</td>
							<td style="text-align: right;">
								{{ number_format($price[$data],2,".",",")  }}
							</td>
							<td style="text-align: right;">
								{{ number_format($price[$data] * $rgs_quantity[$data],2,".",",")  }}
							</td>
							<td style="text-align: center;">
								{{ $remarks[$data] }}
							</td>
						</tr>
					@else

					@endif
					
					@endforeach
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;font-weight: bold;">TOTAL CM</td>
						<td style="text-align: center;font-weight: bold;">{{ array_sum($sum_rgs_quantity) }}  </td>
						<td></td>
						<td style="text-align: right;font-weight: bold;">
							{{ number_format(array_sum($sum_rgs_amount),2,".",",")  }}  

						</td>
						<td></td>
					</tr>
				</tbody>
			</table>
			<table class="table table-borderless" style="border:none;width:50%;height:50%;font-size: 20px">
				<thead>
					{{-- <tr>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">QUANTITY:</span></td>
						<td style="line-height:0px;font-weight: bold;">
							{{ array_sum($sum_sku_quantity) }}
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
					</tr> --}}
					<tr>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">SUMMARY FOR DEDUCTION:</span></td>
						<td style="line-height: 0px;"></td>
						<td style="line-height:0px;font-weight: bold;">
							{{-- @php
							$total_category_discount_amount = array_sum($total_category_discount_array);
							$total_category_discount_array[] = $total_category_discount_amount;
							@endphp
							
							{{ number_format($total_category_discount_amount,2,".",",") }} --}}
						</td>
					</tr>
					<tr>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">VATABLE SALES</span></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;">
							@php
							$vatable_sales = array_sum($sum_rgs_amount)/1.12
							@endphp
							{{ number_format($vatable_sales,2,".",",") }}
							
						</td>
					</tr>
					<tr>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">VAT PAYABLE</span></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;text-decoration:underline;">
							@php
							$vat_payable = $vatable_sales*0.12;
							@endphp
							{{ number_format($vat_payable,2,".",",") }}
							
						</td>
					</tr>
					<tr>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;"><span class="float-right">TOTAL CM AMOUNT</span></td>
						<td style="line-height:0px;"></td>
						<td style="line-height:0px;font-weight: bold;text-decoration:underline;">
							@php
							$total_cm_amount = $vatable_sales + $vat_payable;
							@endphp
							{{ number_format($total_cm_amount,2,".",",") }}
							
						</td>
					</tr>
					
				</thead>
			</table>
		</div>

		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align: center;">TOTAL AMOUNT</th>
					<th style="text-align: center;">PREV COLL</th>
					<th style="text-align: center;">PREV BO</th>
					<th style="text-align: center;">PREV RGS</th>
					<th style="text-align: center;">CURRENT RGS INPUT</th>
					<th style="text-align: center;">GRAND TOTAL</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="text-align: right;font-weight: bold;">{{ number_format($total_payable_amount,2,".",",")  }}</td>
					<td style="text-align: right;font-weight: bold;">
						@if(is_null($customer_payment_details))
							@php
								$prev_coll = 0;
							@endphp
							{{  number_format($prev_coll,2,".",",") }}
						@else
							@php
								$prev_coll = $customer_payment_details;
							@endphp
							{{  number_format($prev_coll,2,".",",") }}
						@endif
					</td>
					<td style="text-align: right;font-weight: bold;">
						@if(is_null($cm_for_bo))
							@php
								$prev_bo = 0;
							@endphp
							{{  number_format($prev_bo,2,".",",") }}
						@else
							@php
								$prev_bo = $cm_for_bo;
							@endphp
							{{  number_format($prev_bo,2,".",",") }}
						@endif
					</td>
					<td style="text-align: right;font-weight: bold;">
						@if(is_null($cm_for_rgs))
							@php
								$prev_rgs = 0;
							@endphp
							{{  number_format($prev_rgs,2,".",",") }}
						@else
							@php
								$prev_rgs = $cm_for_rgs;
							@endphp
							{{  number_format($prev_rgs,2,".",",") }}
						@endif
					</td>
					<td style="text-align: right;font-weight: bold;">
						{{ number_format(array_sum($sum_rgs_amount),2,".",",") }}
					</td>
					<td style="text-align: right;font-weight: bold;">
						@php	
							$grand_total = $total_payable_amount - $prev_coll - $prev_bo - $prev_rgs - array_sum($sum_rgs_amount);
							echo number_format($grand_total,2,".",",");
						@endphp
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-success btn-block">SUBMIT CM FOR BO</button>
	</div>
</form>
<script type="text/javascript">



	$("#save_cm_for_rgs").on('submit',(function(e){
         e.preventDefault();
         $('.loading').show();
   	
		mao_nani = new FormData(this);


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
						url: "customer_credit_memo_for_rgs_save",
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
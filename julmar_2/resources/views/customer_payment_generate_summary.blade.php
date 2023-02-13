<form id="customer_payment_save">
	<div class="row">
		<div class="col-md-12">
			<label>Remitted By:</label>
			<input type="text" name="remitted_by" required class="form-control">
		</div>
	</div>
	<br />
	<div class="table table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align: center;">OR #</th>
					<th style="text-align: center;">DR #</th>
					<th style="text-align: center;">DUE DATE</th>
					<th style="text-align: center;">OUTSTANDING BALANCE</th>
					<th style="text-align: center;">CASH</th>
					<th style="text-align: center;">CHECK</th>
					<th style="text-align: center;">CHECK DETAILS <br />(<span style="color:blue">CHECK # AND CHECK DATE</span>)</th>
					<th style="text-align: center;">NEW BALANCE</th>
					<th style="text-align: center;">DATE DELIVERED</th>
					<th style="text-align: center;">REMARKS</th>
				</tr>
			</thead>
			<tbody>
				@foreach($id as $data)
				<tr>
					<td>
						{{ $or_number[$data] }}
						<input type="hidden" name="or_number[{{ $data }}]" value="{{ $or_number[$data]}}">
						<input type="hidden" name="agent_id[{{ $data }}]" value="{{ $agent_id[$data]}}">
					</td>
					<td style="text-align: center;">
						{{ $delivery_receipt[$data] }}
						<input type="hidden" name="delivery_receipt[{{ $data }}]" value="{{ $delivery_receipt[$data]}}">
						<input type="hidden" name="sales_order_printed_id[]" value="{{ $data }}">
						<input type="hidden" name="customer_id[{{ $data }}]" value="{{ $customer_id[$data]}}">
						<input type="hidden" name="principal_id[{{ $data }}]" value="{{ $principal_id[$data]}}">
						<input type="hidden" name="sales_order_number[{{ $data }}]" value="{{ $sales_order_number[$data]}}">
					</td>
					<td style="text-align: center;">{{ $due_date[$data] }}</td>
					<td style="text-align: right;">
						@php
						$sum_total_dr_amount[] = $total_dr_amount[$data];
						@endphp

						@php
						$sum_prev_collection[] = $prev_collection[$data];
						@endphp

						@php
						$sum_bo_prev_collection[] = $bo_prev_collection[$data];
						@endphp

						@php
						$sum_rgs_prev_collection[] = $rgs_prev_collection[$data];
						@endphp

						@php
						$sum_outstanding_balance[] = $outstanding_balance[$data];
						@endphp
						{{ number_format($outstanding_balance[$data],2,".",",") }}
					</td>
					<td style="text-align: right;">
						@php
						$sum_cash_amount[] = $cash_amount[$data];
						@endphp
						{{ number_format($cash_amount[$data],2,".",",") }}
						<input type="hidden" name="cash_amount[{{ $data }}]" value="{{ $cash_amount[$data]}}">
					</td>
					<td style="text-align: right;">
						@php
						$sum_check_amount[] = $check_amount[$data];
						@endphp
						{{ number_format($check_amount[$data],2,".",",") }}
						<input type="hidden" name="check_amount[{{ $data }}]" value="{{ $check_amount[$data]}}">
						<input type="hidden" name="total_collected[{{ $data }}]" value="{{ $cash_amount[$data] + $check_amount[$data] }}">
					</td>
					<td style="text-align: center;">
						{{ $check_number[$data] ." , ". $check_date[$data] }}
						<input type="hidden" name="check_number[{{ $data }}]" value="{{ $check_number[$data]}}">
						<input type="hidden" name="check_date[{{ $data }}]" value="{{ $check_date[$data]}}">
					</td>
					<td style="text-align: right;">
						@php
							$new_balance = $outstanding_balance[$data] - ($check_amount[$data] + $cash_amount[$data]);
						@endphp
						{{ number_format($outstanding_balance[$data]  - ($check_amount[$data] + $cash_amount[$data]),2,".",",") }}
						
					</td>
					<td style="text-align: center;">
						{{ $date_delivered[$data] }}
						<input type="hidden" name="date_delivered[{{ $data }}]" value="{{ $date_delivered[$data] }}">
					</td>
					<td>
						{{ $remarks[$data] }}
						<input type="hidden" name="remarks[{{ $data }}]" value="{{ $remarks[$data] }}">
					</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align: right;font-weight: bold;color:blue">ADD REFER:</td>
					<td style="text-align: right;">
						{{ number_format($refer_cash_amount[$data],2,".",",")  }}
						<input type="hidden" name="refer_cash_amount[{{ $data }}]" value="{{ $refer_cash_amount[$data] }}">
						@php
							$sum_refer_cash_amount[] = $refer_cash_amount[$data];
						@endphp
					</td>
					<td style="text-align: right;">
						{{ number_format($refer_check_amount[$data],2,".",",")  }}
						<input type="hidden" name="refer_check_amount[{{ $data }}]" value="{{ $refer_check_amount[$data] }}">
						@php
							$sum_refer_check_amount[] = $refer_check_amount[$data];
						@endphp
					</td>
					<td style="text-align: center;">
						{{ $refer_check_number[$data] ." , ". $refer_check_date[$data]   }}
						<input type="hidden" name="refer_check_number[{{ $data }}]" value="{{ $refer_check_number[$data] }}">
						<input type="hidden" name="refer_check_date[{{ $data }}]" value="{{ $refer_check_date[$data] }}">
					</td>
					<td style="text-align: right;">
						{{ number_format($new_balance - ($refer_check_amount[$data] + $refer_cash_amount[$data]),2,".",",")  }}
						@php
							$sum_new_balance[] = $new_balance - ($refer_check_amount[$data] + $refer_cash_amount[$data]);
						@endphp
						<input type="hidden" name="balance[{{ $data }}]" value="{{ $new_balance - ($refer_check_amount[$data] + $refer_cash_amount[$data]) }}">
					</td>
					<td></td>
					<td>
						{{ $refer_remarks[$data] }}
						<input type="hidden" name="refer_remarks[{{ $data }}]" value="{{ $refer_remarks[$data] }}">
					</td>
				</tr>
				
				@endforeach
			</tbody>
			<tfoot>
			<tr>
				<td colspan="3" style="text-align: center;font-weight: bold;">GRAND TOTAL</td>
				<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_outstanding_balance),2,".",",") }}</td>
				<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_cash_amount) + array_sum($sum_refer_cash_amount),2,".",",") }}</td>
				<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_check_amount)  + array_sum($sum_refer_check_amount),2,".",",") }}</td>
				<td></td>
				<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_new_balance),2,".",",") }}</td>
				<td></td>
				<td></td>
				
			</tr>
			</tfoot>
		</table>
	</div>
	<div class="row">
		<div class="col-md-12">
		
			<button type="submit" class="btn btn-success btn-block">SUBMIT COLLECTION</button>
		</div>
	</div>
</form>


<script type="text/javascript">
 $("#customer_payment_save").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "customer_payment_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            
            console.log(data);
            if(data == 'saved'){
	            Swal.fire({
				  position: 'top-end',
				  icon: 'success',
				  title: 'Your work has been saved, Reloading Page. Please Wait',
				  showConfirmButton: false,
				  timer: 1500
				})
             location.reload();
            }else{
              Swal.fire(
              'SOMETHING WENT WRONG',
              'PLEASE CONTACT ADMIN',
              'error'
              )
              $('.loading').hide(); 
            }
          },
        });
    }));
</script>
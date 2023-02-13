<form id="walkin_sales_order_save">
<input type="hidden" name="customer_id" value="{{ $customer_id }}">
<input type="hidden" name="principal_id" value="{{ $principal_id }}">
<input type="hidden" name="sales_order_number" value="{{ $sales_order_number }}">
<input type="hidden" name="sales_order_number" value="{{ $sales_order_number }}">
<input type="hidden" name="delivery_receipt" value="{{ $delivery_receipt }}">
<input type="hidden" name="price_level" value="{{ $price_level }}">
<input type="hidden" name="store_code" value="{{ $customer_store_code->store_code }}">
<input type="hidden" name="sku_type" value="{{ $type }}">
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label>Mode of Transaction:</label>
			<select class="form-control select2" name="mode_of_transaction" required style="width:100%;">
				<option value="" default>Select Mode of Transaction</option>
				<option value="COD">COD</option>
				<option value="PDC">PDC</option>
				<option value="VALE">VALE</option>
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>Salesman:</label>
			<select class="form-control select2" name="agent_id" required style="width:100%;">
				<option value="" default>Select Salesman</option>
				@foreach($agent as $data)
					<option value="{{ $data->id }}">{{ $data->full_name }}</option>
				@endforeach
			</select>
		</div>
	</div>
</div>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th colspan="2" style="text-align: center">{{ $store_name }}</th>
			<th colspan="2" style="text-align: center">STORE CODE: {{ $customer_store_code->store_code }}</th>
			<th style="text-align: center" colspan="2">SO #: {{ $sales_order_number }}</th>
			<th style="text-align: center" colspan="3">DR #: {{ $delivery_receipt }}</th> 
		</tr>
		<tr>
			<th style="text-align: center;">CODE</th>
			<th style="text-align: center;">DESC</th>
			<th style="text-align: center;">SKU TYPE</th>
			<th style="text-align: center;">QTY</th>
			<th style="text-align: center;">PRICE</th>
			<th style="text-align: center;">AMOUNT</th>
			@if(array_sum($line_discount_rate_1) != 0)
				<th style="text-align: center;">LINE DISC 1</th>
			@endif
			@if(array_sum($line_discount_rate_2) != 0)
				<th style="text-align: center;">LINE DISC 2</th>
			@endif
			<th style="text-align: center;">TOTAL</th>
		</tr>
	</thead>
	<tbody>
		@foreach($sku as $data)
			
			@if($quantity[$data] != 0)
				<tr>
					<td>
						<input type="hidden" name="sku[]" value="{{ $data }}">
						{{ $sku_code[$data] }}
					</td>
					<td>{{ $description[$data] }}</td>
					<td>{{ $sku_type[$data] }}</td>
					<td>
						@php
							$sum_quantity[] = $quantity[$data];
						@endphp
						{{ $quantity[$data] }}
						<input type="hidden" name="quantity[{{ $data }}]" value="{{ $quantity[$data] }}">
					</td>
					<td>
						{{ $sku_price[$data] }}
						<input type="hidden" name="price[{{ $data }}]" value="{{ $sku_price[$data] }}">
					</td>
					<td style="text-align: right">
						@php
							$amount = $quantity[$data] * $sku_price[$data];
							echo number_format($amount,2,".",",");
							$sum_amount[] = $amount;
						@endphp

						<input type="hidden" name="amount[{{ $data }}]" value="{{ $amount }}">
					</td>

						@if(array_sum($line_discount_rate_1) != 0)
							<td style="text-align: right;">
								@php
									$line_discount_1 = $amount * $line_discount_rate_1[$data] / 100;
									$sum_line_discount_1[] = $line_discount_1;
									echo number_format($line_discount_1,2,".",",");
								@endphp
							</td>
						@else	
							@php
								$line_discount_1 = 0;
								$sum_line_discount_1[] = $line_discount_1;
							@endphp
						@endif

						@if(array_sum($line_discount_rate_2) != 0)
							<td style="text-align: right;">
								@php
									$line_discount_2 = ($amount - $line_discount_1) * $line_discount_rate_2[$data] / 100;
									$sum_line_discount_2[] = $line_discount_2;
									echo number_format($line_discount_2,2,".",",") 
								@endphp
							</td>
						@else	
							@php
								$line_discount_2 = 0;
								$sum_line_discount_2[] = $line_discount_2;
							@endphp
						@endif
						<td style="text-align: right">
							@php
								$total_amount_per_sku = $amount - $line_discount_1 - $line_discount_2;
								$sum_total_amount_per_sku[] = $total_amount_per_sku;
								echo number_format($total_amount_per_sku,2,".",",");
							@endphp
							<input type="hidden" name="sub_total[{{ $data }}]" value="{{ $total_amount_per_sku }}">
							<input type="hidden" name="line_discount_1[{{ $data }}]" value="{{ $line_discount_1 }}">
							<input type="hidden" name="line_discount_rate_1[{{ $data }}]" value="{{ $line_discount_rate_1[$data] }}"> 
							<input type="hidden" name="line_discount_2[{{ $data }}]" value="{{ $line_discount_2 }}">
							<input type="hidden" name="line_discount_rate_2[{{ $data }}]" value="{{ $line_discount_rate_2[$data] }}">
						</td>
				</tr>
			@endif
			
		@endforeach
			<tr>
				<td colspan="3" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
				<td style="text-align: center;font-weight: bold">{{ array_sum($sum_quantity) }}</td>
				<td></td>
				<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_amount),2,".",",") }}</td>
				@if(array_sum($line_discount_rate_1) != 0)
					<td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_line_discount_1),2,".",",") }}</td>
				@endif
				@if(array_sum($line_discount_rate_2) != 0)
					<td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_line_discount_2),2,".",",") }}</td>
				@endif
				<td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_total_amount_per_sku),2,".",",") }}</td>
			</tr>
	</tbody>
</table>
<div class="container float-right" style="width:20%;" >
	<table class="table table-sm table-bordered">
		<thead>
			<tr>
				<th>TOTAL DR AMOUNT</th>
				<th style="text-align: right;">
					@php
						$total_dr_amount = array_sum($sum_amount);
						echo number_format($total_dr_amount,2,".",",");
					@endphp
				</th>
			</tr>
			<tr>
				<th>TOTAL SKU LINE DISC</th>
				<th style="text-align: right;">
					@php
						$total_line_discount = array_sum($sum_line_discount_1) + array_sum($sum_line_discount_2);
						echo number_format($total_line_discount,2,".",",");
					@endphp
					<input type="hidden" name="total_line_discount" value="{{ $total_line_discount }}">
				</th>
			</tr>
			<tr>
				<th>NET AMOUNT</th>
				<th style="text-align: right;">
					@php
						$total_net_amount = $total_dr_amount - $total_line_discount;
						echo number_format($total_net_amount,2,".",",");
					@endphp
				</th>
			</tr>
			@if($customer_discount_counter == 0)
			<tr>
				<th>CUSTOMER DISCOUNT</th>
				<th style="text-align: right;">
					@php
						$customer_discount = 0;
						echo number_format($customer_discount,2,".",",");
					@endphp
					<input type="hidden" name="customer_discount_rate" value="0">
				</th>
			</tr>
			@else
				@php
	                $total = $total_net_amount;
	                $deducted_total = $total;
	                $deducted_total_history = [];
	            @endphp
              @for ($i=0; $i < $customer_discount_counter; $i++)  
                <tr>
                  <th>CUSTOMER DISCOUNT ( {{ $customer_discount[$i] }} %)</th>
                  <th style="text-align: right;">
                    @php
                    $deducted_total_dummy = $deducted_total;
                    $less_percentage_by = ($customer_discount[$i] / 100);
                    $deducted_total = $deducted_total_dummy - ($deducted_total_dummy * $less_percentage_by);
                    $answer = round($deducted_total_dummy * $less_percentage_by,2);
                    $deducted_total_history[] = $answer;

                    echo number_format($answer,2,".",",");
                    @endphp
                    <input type="hidden" name="customer_discount_rate[]" value="{{ $customer_discount[$i] }}">
                  </th>
                </tr>
              @endfor
			@endif
			<tr>
				<th>TOTAL CUSTOMER DISC</th>
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
             	<th>TOTAL CUSTOMER PAYABLE</th>
                <th style="font-weight: bold;text-decoration:overline;text-align: right;">
                  @php
                  $total_payable_amount = $total_dr_amount - array_sum($sum_line_discount_1) - array_sum($sum_line_discount_2) - $total_customer_discount_amount;
                  @endphp
                  {{  number_format($total_payable_amount,2,".",",") }}
                  <input type="hidden" name="total_amount" value="{{ $total_payable_amount }}">
                  
                </th>
              </tr>
		</thead>
	</table>
	<table class="table table-bordered table-sm">
		<thead>
			<tr>
				<th>VATABLE AMOUNT</th>
				@php
	                $vatable_amount = $total_payable_amount / 1.12;
	            @endphp 
             	<th>{{ number_format($vatable_amount,2,".",",") }}</th>
              	<input type="hidden" name="vatable_amount" value="{{ $vatable_amount }}">			
         	</tr>
         	<tr>
         		<th>VAT AMOUNT</th>
         		@php
                	$vat_amount = $vatable_amount * 0.12;
	            @endphp
	            <th>{{ number_format($vat_amount,2,".",",") }}</th>
	            <input type="hidden" name="vat_amount" value="{{ $vat_amount }}">
         	</tr>
         	<tr>
         		<th>TOTAL DR AMOUNT</th>
         		@php
	              $total_vatable_dr_amount = $vatable_amount + $vat_amount;
	            @endphp
	            <th>{{ number_format($total_vatable_dr_amount,2,".",",") }}</th>
         	</tr>
		</thead>
	</table>


</div>

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
            <th style="text-align: center;text-transform: uppercase;">ACCOUNTS RECEIVABLE - {{ $store_name }}</th>
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
              <input type="hidden" name="sales" value="{{ $vatable_amount }}">
            </th>
          </tr>
        </thead>
 </table>
<div class="form-group">
	<button type="submit" class="btn btn-success btn-block">SAVE END TRANSACTION</button>
</div>
</form>

<script type="text/javascript">
	$("#walkin_sales_order_save").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
      
        $.ajax({
          url: "walkin_sales_order_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
             if (data == 'saved') {
             	Swal.fire({
				  position: 'top-end',
				  icon: 'success',
				  title: 'Your work has been saved, Reloading Page',
				  showConfirmButton: false,
				  timer: 1500
				})
				location.reload();
             }
          },
        });
    }));

    $('.select2').select2()

</script>
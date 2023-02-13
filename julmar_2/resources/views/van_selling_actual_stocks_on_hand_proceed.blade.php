<div class="table table-responsive">
	<form id="van_selling_actual_stocks_on_hand_final_summary">
		@csrf
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align: center;">DATE</th>
					<th style="text-align: center;">PRINCIPAL</th>
					<th style="text-align: center;">STORE NAME</th>
					<th style="text-align: center;">NEW VL</th>
					<th style="text-align: center;">COLLECTED</th>
					<th style="text-align: center;">CM</th>
					<th style="text-align: center;">ACTUAL STOCKS ON HAND</th>
					<th style="text-align: center;">OUTSTANDING BALANCE</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						{{ $van_selling_ledger->date }}
						<input type="hidden" name="date" value="{{ $van_selling_ledger->date }}">
					</td>
					<td>
						@if($van_selling_ledger->principal != '')
			            	@php
			            		echo $reference = $van_selling_ledger->principal->principal;
			            	@endphp
						@elseif($van_selling_ledger->collection != '' OR $van_selling_ledger->collection != 0)
						  	@php
		            			echo $reference = 'COLLECTION';
		            		@endphp
		            	@else
		            		@php
		            			echo $reference = 'BEGINNING';
		            		@endphp
						@endif
						<input type="hidden" name="reference" value="{{ $reference }}">
					</td>
					<td>
							{{ $van_selling_ledger->customer->store_name}}
							<input type="hidden" name="store_name" value="{{ $van_selling_ledger->customer->store_name }}">
					</td>
					<td style="text-align: right;">
						{{ number_format($van_selling_ledger->amount,2,".",",") }}
						<input type="hidden" name="amount" value="{{ $van_selling_ledger->amount }}">
					</td>
					<td style="text-align: right;">
						{{ number_format($van_selling_ledger->collection,2,".",",") }}
						<input type="hidden" name="collection" value="{{ $van_selling_ledger->collection }}">
					</td>
					<td style="text-align: right;">
						{{ number_format($van_selling_ledger->cm_amount,2,".",",") }}
						<input type="hidden" name="cm_amount" value="{{ $van_selling_ledger->cm_amount }}">
					</td>
					<td style="text-align: right;"><input type="text" name="actual_stocks_on_hand" class="currency-default" required style="display: block;
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
					<td style="text-align: right;">
						{{ number_format($van_selling_ledger->running_balance,2,".",",") }}
						<input type="hidden" name="running_balance" value="{{ $van_selling_ledger->running_balance }}">
					</td>
				</tr>
			</tbody>
		</table>
		<label>AUDIT ACCESS KEY:</label>
		<input type="password" name="password" class="form-control" required>
		<input type="hidden" name="customer_id" value="{{ $customer_id }}">
		<label>&nbsp;</label>
		<button type="submit" class="btn btn-info btn-block">PROCEED TO FINAL SUMMARY</button>
	</form>
</div>

<script>
		$('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
    $('[class=integer-default]').maskNumber({integer: true});
    $('[class=integer-data-attribute]').maskNumber({integer: true});
    $('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});
    $('.select2').select2()

    $("#van_selling_actual_stocks_on_hand_final_summary").on('submit',(function(e){
      e.preventDefault();
       $('.loading').show();
        $.ajax({
          url: "van_selling_actual_stocks_on_hand_final_summary",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
           
            if(data == 'access_denied'){
               Swal.fire(
              'ACCESS DENIED!!',
              'CANNOT PROCEED!!',
              'error'
              )
              $('.loading').hide(); 
            }else{
              $('.loading').hide();
            	$('#van_selling_actual_stocks_on_hand_final_summary_page').html(data);
            }
          },
        });
    }));

</script>
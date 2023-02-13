<div class="table table-responsive">
	<form id="van_selling_actual_stocks_on_hand_save">
		@csrf
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align: center;">DATE</th>
					<th style="text-align: center;">PRINCIPAL</th>
					<th style="text-align: center;">STORE NAME</th>
					<th style="text-align: center;">AMOUNT</th>
					<th style="text-align: center;">COLLECTED</th>
					<th style="text-align: center;">CM</th>
					<th style="text-align: center;">ACTUAL STOCKS ON HAND</th>
					<th style="text-align: center;">OUTSTANDING BALANCE</th>
					<th style="text-align: center;">(OVER)/SHORT</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{ $date }}</td>
					<td>{{ $reference }}</td>
					<td>{{ $store_name }}</td>
					<td style="text-align: right;">{{ number_format($amount,2,".",",") }}</td>
					<td style="text-align: right;">{{ number_format($collection,2,".",",") }}</td>
					<td style="text-align: right;">{{ number_format($cm_amount,2,".",",") }}</td>
					<td style="text-align: right;">
						{{ number_format($actual_stocks_on_hand,2,".",",") }}
						<input type="hidden" name="actual_stocks_on_hand" value="{{ $actual_stocks_on_hand }}">
					</td>
					<td style="text-align: right;">
						{{ number_format($running_balance,2,".",",") }}
						<input type="hidden" name="running_balance" value="{{ $running_balance }}">
					</td>
					<td style="text-align: right;">
						@php
							$over_short = $running_balance - $actual_stocks_on_hand;
							echo number_format($over_short,2,".",",");
						@endphp
						<input type="hidden" name="over_short" value="{{ $over_short }}">
					</td>
				</tr>
			</tbody>
		</table>
	
		<input type="hidden" name="customer_id" value="{{ $customer_id }}">
		<label>&nbsp;</label>
		<button type="submit" class="btn btn-success btn-block">SAVE FINAL ACTUAL STOCKS ON HAND</button>
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

    $("#van_selling_actual_stocks_on_hand_save").on('submit',(function(e){
      e.preventDefault();
       $('.loading').show();
        $.ajax({
          url: "van_selling_actual_stocks_on_hand_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
          	// console.log(data);
          	Swal.fire(
								  'Good job!',
								  'Reloading Page',
								  'success'
								)
								location.reload();
        //     if (data == 'saved') {
        //       		Swal.fire(
								//   'Good job!',
								//   'Reloading Page',
								//   'success'
								// )
								// location.reload();
	       //    }else{
	       //    	Swal.fire(
        //       'ERROR!!, CALL SYSTEM ADMIN!',
        //       data,
        //       'error'
        //       )
        //       $('.loading').hide(); 
	       //    }
          },
        });
    }));

</script>
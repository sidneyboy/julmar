<form id="bo_allowance_total_save">
	@csrf
	<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th colspan="3">{{ $remarks }}
				<input type="hidden" name="remarks" value="{{ $remarks }}">
			</th>
		</tr>
		<tr>
			<th style="text-align: center;">Invoice #</th>
			<th style="text-align: center;">Invoice Date</th>
			<th style="text-align: center;">Amount</th>
			
		</tr>
	</thead>
	<tbody>
		@foreach($received as $data)
			<tr>
				<td style="text-transform: uppercase;">{{ $data->dr_si }}</td>
				<td style="text-align: center;">{{ $data->invoice_date }}</td>
				<td style="text-align: right;">
					@php
						$sum_grandtotal[] = $data->grand_total_final_cost;
					@endphp
					{{ number_format( $data->grand_total_final_cost,2,".",",") }}
				</td>
			
			</tr>
		@endforeach
		<tr>
			<td colspan="2" style="text-align: center;font-weight: bold">GRANDTOTAL</td>
			<td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_grandtotal),2,".",",") }}</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center;font-weight: bold">TOTAL BO ALLOWANCE</td>
			<td style="text-align: right;font-weight: bold">
				@php
					$discounted_amount = array_sum($sum_grandtotal) * $bo_rate/100;
					echo number_format($discounted_amount,2,".",",");
				@endphp
				<input type="hidden" name="bo_allowance_total_adjustment" value="{{ $discounted_amount }}">
			</td>
		</tr>
	</tbody>
</table>
	<input type="hidden" name="remarks" value="{{ $remarks }}">
	<input type="hidden" name="principal" value="{{ $principal }}">
	<input type="hidden" name="date_range" value="{{ $date_range }}">
<button type="submit" class="btn btn-success btn-block">SAVE</button>
</form>

<script type="text/javascript">
	

  $("#bo_allowance_total_save").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
       //$('#sales_order_migrate_summary_page').show();
        $.ajax({
          url: "bo_allowance_total_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){

            console.log(data);
            // if(data == 'existing sales_order_number'){
            //    Swal.fire(
            //   'Existing Sales Order Number, Cannot Proceed!!',
            //   '',
            //   'error'
            //   )
            //   $('.loading').hide(); 
            // }else{
            //   $('.loading').hide();

            //   $('#sales_order_migrate_summary_page').html(data);
            // }
          },
        });
    }));
</script>
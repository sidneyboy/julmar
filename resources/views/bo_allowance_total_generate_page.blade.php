<form id="bo_allowance_total_proceed_to_final_summary">
	@csrf
	<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th colspan="4">{{ $remarks }}
				<input type="hidden" name="remarks" value="{{ $remarks }}">
			</th>
		</tr>
		<tr>
			<th style="text-align: center;">Invoice #</th>
			<th style="text-align: center;">Invoice Date</th>
			<th style="text-align: center;">Amount</th>
			<th></th>
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
				<td><input type="checkbox" name="dr_id[]" value="{{ $data->id }}" class="form-control" checked></td>
			</tr>
		@endforeach
	
	</tbody>
</table>

<div class="form-group float-right">
	<label>BO RATE %:</label>
	<input type="text" name="bo_rate" class="currency-default" required style="text-align: center;display: block;
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
	transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
</div>
		
<div class="form-group">
	
	<input type="hidden" name="remarks" value="{{ $remarks }}">
	<input type="hidden" name="principal" value="{{ $principal }}">
	<input type="hidden" name="date_range" value="{{ $date_range }}">
	<label>&nbsp;</label>
	<button type="submit" class="btn btn-info btn-block">PROCEED TO FINAL SUMMARY</button>
</div>

</form>

<script type="text/javascript">
	$('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
    $('[class=integer-default]').maskNumber({integer: true});
    $('[class=integer-data-attribute]').maskNumber({integer: true});
    $('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});



  $("#bo_allowance_total_proceed_to_final_summary").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
       //$('#sales_order_migrate_summary_page').show();
        $.ajax({
          url: "bo_allowance_total_proceed_to_final_summary",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){

            $('#bo_allowance_total_proceed_to_final_summary_page').html(data);
            
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
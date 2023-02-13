<form id="princpal_payment_save">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th colspan="8" style="text-align: center;font-weight: bold">PRINCIPAL PAYMENT FINAL SUMMARY</th>
			</tr>
			<tr>
				<th style="text-align: center;">Date</th>
				<th style="text-align: center;">Paid By</th>
				<th style="text-align: center;">Principal</th>
				<th style="text-align: center;">Cheque #</th>
				<th style="text-align: center;">Disbursement #</th>
				<th style="text-align: center;">Current Accounts Payable</th>
				<th style="text-align: center;">Amount</th>
				<th style="text-align: center;">Total</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="text-align: center;">{{ $date }}</td>
				<td style="text-align: center;text-transform: uppercase;">{{ $employee_name->name }}</td>
				<td style="text-align: center;">{{ $principal->principal }}</td>
				<td style="text-align: center;">{{ $cheque_number }}</td>
				<td style="text-align: center;">{{ $disbursement_number }}</td>
				<td style="text-align: right;">{{ number_format($current_accounts_payable_final,2,".",",")  }}</td>
				<td style="text-align: right;">{{ number_format($amount,2,".",",")  }}</td>
				<td style="text-align: right;">{{ number_format($current_accounts_payable_final - $amount,2,".",",")  }}</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="amount" value="{{ $amount }}">
	<input type="hidden" name="current_accounts_payable_final" value="{{ $current_accounts_payable_final }}">
	<input type="hidden" name="principal_id" value="{{ $principal_id }}">
	<input type="hidden" name="date" value="{{ $date }}">
	<input type="hidden" name="employee_id" value="{{ $employee_name->id }}">
	<input type="hidden" name="cheque_number" value="{{ $cheque_number }}">
	<input type="hidden" name="disbursement_number" value="{{ $disbursement_number }}">

	<div class="form-group">
		<button type="submit" class="btn btn-success btn-block">SAVE PRINCIPAL PAYMENT</button>
	</div>
</form>
<script type="text/javascript">
	$.ajaxSetup({
	  headers: {
	 	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  }
	});
  

	$("#princpal_payment_save").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "princpal_payment_save",
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
				  title: 'Your work has been saved, Reloading Page!',
				  showConfirmButton: false,
				  timer: 1500
				})

				location.reload();
           	}
          },
        });
    }));
</script>
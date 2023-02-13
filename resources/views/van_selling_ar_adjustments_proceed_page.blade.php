<form id="van_selling_ar_adjustments_save">
	<div class="table table-responsive">
	<table class="table table-bordered table-sm table-hover">
		<thead>
			<tr>
				<th colspan="5" style="text-align: center;">NEW AR LEDGER</th>
			</tr>
			<tr>
				<th>ADJUSTMENTS</th>
				<th>RUNNING BALANCE</th>
				<th>OUTSTANDING BALANCE</th>
				<th>REMARKS</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="text-align: right;">{{ number_format($ar_adjustments,2,".",",") }}</td>
				<td style="text-align: right;">{{ number_format($van_selling_ar_ledger->running_balance + $ar_adjustments,2,".",",") }}</td>
				<td style="text-align: right;">{{ number_format($van_selling_ar_ledger->over_short,2,".",",") }}</td>
				<td style="text-align: right;">   
          @if ($van_selling_ar_ledger->outstanding_balance == 0)
            @php
              $outstanding_balance = $van_selling_ar_ledger->running_balance + $ar_adjustments;
            @endphp
          @else
            @php
              $outstanding_balance = $van_selling_ar_ledger->outstanding_balance + $ar_adjustments;
            @endphp
          @endif
          {{ number_format($outstanding_balance,2,".",",") }}
          <input type="hidden" value="{{ $outstanding_balance }}" name="outstanding_balance">
        </td>
				<td style="text-align: center;">
					{{ $remarks }}
					<input type="hidden" name="ar_adjustments" value="{{ $ar_adjustments }}">
					<input type="hidden" name="remarks" value="{{ $remarks }}">
          <input type="hidden" name="running_balance" value="{{ $van_selling_ar_ledger->running_balance + $ar_adjustments }}">
					<input type="hidden" name="adjusted_running_balance" value="{{ $van_selling_ar_ledger->running_balance + $ar_adjustments }}">
					<input type="hidden" name="over_short" value="{{ $van_selling_ar_ledger->over_short }}">
					<input type="hidden" name="customer_id" value="{{ $customer_id }}">
				</td>
			</tr>
		</tbody>
	</table>
</div>
<button type="submit" class="btn btn-block btn-success">SUBMIT ADJUSTMENTS</button>
</form>

<script type="text/javascript">
    $("#van_selling_ar_adjustments_save").on('submit',(function(e){
      e.preventDefault();
     $('.loading').show();
        $.ajax({
          url: "van_selling_ar_adjustments_save",
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
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
              })

              location.reload();
            }else{
              Swal.fire(
                'SOMETHING WENT WRONG! PLEASE CONTACT ADMIN',
                data,
                'ERROR'
              )
              $('.loading').hide();
            }
          },
        });
    }));
</script>
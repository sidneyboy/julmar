<div class="col-md-12">
	<form id="van_selling_ar_proceed_to_final_summary">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>RUNNING BALANCE</th>
					<th>ACTUAL STOCKS ON HAND</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input required type="text" name="running_balance" class="currency-default" style="display: block;
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
					</td>
					<td><input required type="text" name="actual_stocks_on_hand" class="currency-default" style="display: block;
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
					</td>
					
				</tr>
			</tbody>
			<tfoot>
			<tr>
				<td colspan="2">
					<input type="hidden" name="customer_id" value="{{ $customer_id }}">
					<input type="hidden" name="store_name" value="{{ $store_name }}">
					<button type="submit" class="btn btn-block btn-info">PROCEED TO FINAL SUMMARY</button>
				</td>
			</tr>
			</tfoot>
		</table>
	</form>
</div>

<script type="text/javascript">
	$('[class=currency-default]').maskNumber();
	$('[class=currency-data-attributes]').maskNumber();
	$('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
	$('[class=integer-default]').maskNumber({integer: true});
	$('[class=integer-data-attribute]').maskNumber({integer: true});
	$('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});

	$("#van_selling_ar_proceed_to_final_summary").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "van_selling_ar_proceed_to_final_summary",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            if (data == 'no_data_found') {
              $('.loading').hide();
              Swal.fire(
                'No Data Found!!',
                'Cannot Proceed!',
                'error'
              )
            }else{
              $('.loading').hide();
              $('#van_selling_ar_proceed_to_final_summary_page').html(data);
            }
          },
        });
    }));
</script>
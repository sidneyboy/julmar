<div class="table table-responsive">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Store Code</th>
				<th>Store Name</th>
				<th>KOB</th>
				<th>Location</th>
				<th>Detailed Location</th>
				<th>Delivery Receipt</th>
				<th>Trans Ref</th>
				<th>CLM</th>
				<th>AR Prev</th>
				<th>Sales</th>
				<th>CLB</th>
				<th>Update CLM</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>{{ $customer->store_code }}</th>
				<th>{{ $customer->store_name }}</th>
				<th>{{ $customer->kind_of_business }}</th>
				<th>{{ $customer->location->location }}</th>
				<th>{{ $customer->location_details->barangay ." ". $customer->location_details->street }}</th>
				<th>{{ $customer_ledger->delivery_receipt }}</th>
				<th>{{ $customer_ledger->transaction_reference }}</th>
				<th>{{ number_format($customer->credit_line_amount,2,".",",") }}</th>
				<th>{{ number_format($customer_ledger->accounts_receivable_previous,2,".",",") }}</th>
				<th>{{ number_format($customer_ledger->sales,2,".",",") }}</th>
				<th>{{ number_format($customer_ledger->credit_line_balance,2,".",",") }}</th>
				<th>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
					  CLICK ME !
					</button>

					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Update CLM</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
						    <form id="customer_update_save">
						    	@csrf
						      	<input type="hidden" name="customer_id" value="{{ $customer->id }}">
						      	<input type="hidden" name="store_code" value="{{ $customer->store_code }}">
						      <div class="modal-body">
						        	<div class="row">
						        		<div class="col-md-6">
						        			<div class="form-group">
						        				<label>Current CLA</label>
						        				<input type="text" class="form-control" value="{{  number_format($customer_ledger->credit_line_amount,2,".",",")  }}" disabled>
						        			</div>
						        		</div>
						        		<div class="col-md-6">
						        			<div class="form-group">
						        				<label>Current CLB</label>
						        				<input type="text" class="form-control" value="{{ number_format($customer_ledger->credit_line_balance,2,".",",") }}" disabled>
						        				<input type="hidden" name="update_credit_line_balance" value="{{ $customer_ledger->credit_line_balance }}">
						        			</div>
						        		</div>
						        		<div class="col-md-12">
						        			<div class="form-group">
						        				<label>Current AR PREV</label>
						        				<input type="text" class="form-control" value="{{ number_format($customer_ledger->accounts_receivable_previous,2,".",",") }}" disabled>
						        				
						        			</div>
						        		</div>
						        		<div class="col-md-12">
						        			<div class="form-group">
						        				<label>Update CLA</label>
						        				<input type="text" class="currency-default" name="update_credit_line_amount" required style="display: block;
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
						        		</div>
						        		<div class="col-md-12">
						        			<div class="form-group">
						        				<label>OM Access Key:</label>
						        				<input type="password" name="om_access_key" required class="form-control">
						        			</div>
						        		</div>
						        	</div>
						      
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						        <button type="submit" class="btn btn-primary">Save changes</button>
						      </div>
						    </form>
					    </div>
					  </div>
					</div>
				</th>
			</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	 $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  

    $('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
    $('[class=integer-default]').maskNumber({integer: true});
    $('[class=integer-data-attribute]').maskNumber({integer: true});
    $('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});


  $("#customer_update_save").on('submit',(function(e){
        e.preventDefault();
        $('.loading').show();
          $.ajax({
            url: "customer_update_save",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
              console.log(data);
              if (data == 'incorrect_credentials') {
              	Swal.fire({
				  position: 'top-end',
				  icon: 'error',
				  title: 'Incorrect Credentials',
				  showConfirmButton: false,
				  timer: 1500
				})
				 $('.loading').hide();
              }else{
              	 $('.loading').hide();
              	Swal.fire({
				  position: 'top-end',
				  icon: 'success',
				  title: 'Your work has been saved',
				  showConfirmButton: false,
				  timer: 1500
				})
				
				location.reload();
				 
              }
            },
      });
    }));
</script>
<div class="table table-responsive">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th style="text-transform: uppercase;text-align: center;">Customer</th>
				<th style="text-transform: uppercase;text-align: center;">Area</th>
				<th style="text-transform: uppercase;text-align: center;">Detailed Location</th>
				<th style="text-transform: uppercase;text-align: center;">Credit Term</th>
				<th style="text-transform: uppercase;text-align: center;">Credit Line Amount</th>
				<th style="text-transform: uppercase;text-align: center;">Credit Line Balance</th>
				<th style="text-transform: uppercase;text-align: center;">Contact Person</th>
				<th style="text-transform: uppercase;text-align: center;">Contact #</th>
					@foreach($customer_principal_code as $data)
						<th>{{ $data->principal->principal }}</th>
					@endforeach	
				<th style="text-transform: uppercase;text-align: center;">KOB</th>
				<th style="text-transform: uppercase;text-align: center;">OPTION</th>
				<th style="text-transform: uppercase;text-align: center;">STATUS 
						<span>({{ $store_name->status }})</span>
						@if($store_name->status == 'LOCKED')
							<span style="color:green">UNCLOCKED</span>
						@else
							<span style="color:red">LOCKED</span>
						@endif
				</th>
				<th>Update</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="text-transform: uppercase;text-align: center;"><a href="{{ route('customer_profile_show_details', $store_name->id ."=". $principal_id ."=". $store_name->store_name) }}" target="_blank">
					{{ $store_name->store_name }}
				</a></td>
				<td style="text-transform: uppercase;text-align: center;">{{ $store_name->location->location }}</td>
				<td style="text-transform: uppercase;text-align: center;">{{ $store_name->detailed_location }}</td>
				<td style="text-transform: uppercase;text-align: center;">{{ $store_name->credit_term }}</td>
				<td style="text-transform: uppercase;text-align: right;">{{ number_format($store_name->credit_line_amount,2,".",",") }}</td>
				<td style="text-transform: uppercase;text-align: right;">{{ 
					number_format($store_name->customer_ledger_credit_line_balance->credit_line_balance,2,".",",")  }}</td>
				<td style="text-transform: uppercase;text-align: center;">{{ $store_name->contact_person }}</td>
				<td style="text-transform: uppercase;text-align: center;">{{ $store_name->contact_number }}</td>
				@foreach($customer_principal_code as $data)
						<td>{{ $data->store_code }}</td>
				@endforeach	
				<td style="text-transform: uppercase;text-align: center;">{{ $store_name->kind_of_business }}</td>
				<td>
					
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $store_name->id }}">
					UPDATE CREDIT LINE
					</button>
					
					<div class="modal fade" id="exampleModal{{ $store_name->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">
										{{ $store_name->store_name }} <br />
									</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<form id="customer_profile_update_credit_line">
									<div class="modal-body">
										<div class="row">
											<input type="hidden" name="customer_id" value="{{ $store_name->id }}">
											<div class="col-md-12">
												<label>{{ 
					number_format($store_name->customer_ledger_credit_line_balance->credit_line_balance,2,".",",")  }}</label><br />
												<label>Credit Line Amount:</label>
												<input type="text" class="currency-default"  name="credit_line_amount"  style="display: block;
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
												    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;" >
											</div>
											<div class="col-md-12">
												<label>OM Credentials:</label>
												<input type="password" name="om_access_key" class="form-control" required>
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
				</td>
				<td>
					@if($store_name->status == 'UNLOCKED')
						<button id="status" class="btn btn-danger btn-block" value="LOCKED">UNLOCKED <span style="color:blue"></button>
					@else
						<button id="status" class="btn btn-success btn-block" value="UNLOCKED">LOCKED <span style="color:blue"></button>
					@endif
					<input type="hidden" id="customer" value="{{ $store_name->id }}">
				</td>
				<td>
					<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
					 	UPDATE
					</button>

					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog mw-100 w-75" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;color:blue;">CUSTOMER PROFILE</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <form id="customer_profile_update">
					      	<div class="modal-body">
						        <div class="row">
						        	<div class="col-md-6">
						        		<div class="form-group">
								        	<label>Store Name:</label>
								        	<input type="text" name="store_name" value="{{ $store_name->store_name }}" class="form-control" required>
								        	<input type="hidden" name="customer_id" value="{{ $customer_id }}">
								        </div>
								        <div class="form-group">
								        	<label>Location</label>
							                <select class="form-control select2" name="location_id" id="location_id" style="width:100%;">
							                  <option value="{{ $store_name->location->location }}" selected>{{ $store_name->location->location }}</option>
							                  @foreach($location as $location_data)
							                  <option value="{{ $location_data->id }}">{{ $location_data->location }}</option>
							                  @endforeach
							                </select>
								        </div>
								        <div class="form-group">
								        	<label>Detailed Location:</label>
								        	<input type="text" name="detailed_location" class="form-control" value="{{ $store_name->detailed_location }}" required>
								        </div>
						        	</div>
						        	<div class="col-md-6">
						        		<div class="form-group">
								        	<label>Credit Term:</label>
								        	<select class="form-control select2" name="credit_term" style="width:100%;" required>
							                  <option value="{{ $store_name->credit_term }}" selected>{{ $store_name->credit_term }}</option>
							                  <option value="15 days">15 days</option>
							                  <option value="30 days">30 days</option>
							                  <option value="45 days">45 days</option>
							                  <option value="60 days">60 days</option>
							                </select>
								        </div>
						        		<div class="form-group">
								        	<label>Contact Number:</label>
								        	<input type="text" name="contact_number" value="{{ $store_name->contact_number }}" class="form-control" required>
								        </div>
								        <div class="form-group">
								        	<label>Kind of Business</label>
							                <select class="form-control select2" style="width:100%;" name="kind_of_business" required>
							                  <option vaue="{{ $store_name->kind_of_business }}" selected>{{ $store_name->kind_of_business }}</option>
							                  <option value="SSS">SSS</option>
							                  <option value="GRO">GRO</option>
							                  <option value="SM">SM</option>
							                  <option value="DS">DS</option>
							                  <option value="PMS">PMS</option>
							                  <option value="CNV">CNV</option>
							                  <option value="HWA">HWA</option>
							                  <option value="WS">WS</option>
							                  <option value="HLS">HLS</option>
							                  <option value="TER">TER</option>
							                  <option value="INST">INST</option>
							                </select>
								        </div>
						        	</div>
						        	<div class="col-md-12">
						        		<div class="form-group">
								        	<label>Contact Person:</label>
								        	<input type="text" name="contact_person" value="{{ $store_name->contact_person }}" class="form-control" required>
								        </div>
						        	</div>
						        	<hr>
						        	

									@if($selected_option == 'All')
										<div class="col-md-12">
											<div class="card">
												<div class="card-header" style="font-weight: bold;color:blue;">PRINCIPAL STORE CODE</div>
												<div class="card-body">
													<div class="row">
														@foreach($customer_principal_code as $principal_code_data)
														<div class="col-md-4">
															<label>{{ $principal_code_data->principal->principal }}</label>
															<input type="text" class="form-control" name="customer_principal_code[]" required value="{{ $principal_code_data->store_code }}">
														</div>
														@endforeach
														@if(!is_null($principal_code))
														@foreach($principal_code as $principal_data)
														<div class="col-md-4">
															<label>{{ $principal_data->principal }}</label>
															<input type="text" class="form-control" name="principal_store_code[]" required placeholder="INPUT STORE CODE PER PRINCIPAL" required>
														</div>
														@endforeach
														@endif
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="card">
												<div class="card-header" style="font-weight: bold;color:blue;">PRINCIPAL PRICE LEVEL</div>
												<div class="card-body">
													<div class="row">
														@foreach($customer_principal_price as $principal_price)
														<div class="col-md-4">
															<label>{{ $principal_price->principal->principal }}</label>
															<select class="form-control select2" name="customer_principal_price[]" required>
																<option value="{{ $principal_price->price_level }}" selected>{{ $principal_price->price_level }}</option>
																<option value="price_1">price_1</option>
																<option value="price_2">price_2</option>
																<option value="price_3">price_3</option>
																<option value="price_4">price_4</option>
															</select>
														</div>
														@endforeach
														@if(is_null($principal_price))
														@foreach($principal_price as $principal_data)
														<div class="col-md-4">
															<label>{{ $principal_data->principal }}</label>
															<input type="text" class="form-control" name="principal_price[]" required placeholder="INPUT STORE CODE PER PRINCIPAL" required>
														</div>
														@endforeach
														@endif
													</div>
												</div>
											</div>
										</div>
									@else
										<div class="col-md-12">
											<div class="card">
												<div class="card-header" style="font-weight: bold;color:blue;">PRINCIPAL STORE CODE</div>
												<div class="card-body">
													<div class="row">
														@foreach($customer_principal_code as $principal_code_data)
														<div class="col-md-4">
															<label>{{ $principal_code_data->principal->principal }}</label>
															<input type="text" class="form-control" name="customer_principal_code[]" required value="{{ $principal_code_data->store_code }}">
														</div>
														@endforeach
														
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="card">
												<div class="card-header" style="font-weight: bold;color:blue;">PRINCIPAL PRICE LEVEL</div>
												<div class="card-body">
													<div class="row">
														@foreach($customer_principal_price as $principal_price)
														<div class="col-md-4">
															<label>{{ $principal_price->principal->principal }}</label>
															<select class="form-control select2" name="customer_principal_price[]" required>
																<option value="{{ $principal_price->price_level }}" selected>{{ $principal_price->price_level }}</option>
																<option value="price_1">price_1</option>
																<option value="price_2">price_2</option>
																<option value="price_3">price_3</option>
																<option value="price_4">price_4</option>
															</select>
														</div>
														@endforeach
														
													</div>
												</div>
											</div>
										</div>
									@endif
						        	
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
				</td>
			</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
    $('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
    $('[class=integer-default]').maskNumber({integer: true});
    $('[class=integer-data-attribute]').maskNumber({integer: true});
    $('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});

     $('.select2').select2()

    $("#customer_profile_update_credit_line").on('submit',(function(e){
      e.preventDefault();
      // $('.loading').show();
        $.ajax({
          url: "customer_profile_update_credit_line",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
          },
    	});
  	}));

  	 $("#customer_profile_update").on('submit',(function(e){
      e.preventDefault();
      // $('.loading').show();
        $.ajax({
          url: "customer_profile_update",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
          },
    	});
  	}));

  	

  	$('.select2').select2()

    $( "#status" ).click(function() {
		status = $(this).val();
		customer = $('#customer').val();
		$.post({
	      type: "POST",
	      url: "customer_profile_status_changed",
	      data: 'status=' + status + '&customer=' + customer,
	      success: function(data){
		      console.log(data);
		     
		      if (data == 'saved') {
		      	Swal.fire({
				  position: 'top-end',
				  icon: 'success',
				  title: 'Your work has been saved',
				  showConfirmButton: false,
				  timer: 1500
				})
		      	 $("#trigger").click();
		      	 $('.loading').hide();
		      }
		    },
		      error: function(error){
		        console.log(error);
		    }
		})
  	});
</script>
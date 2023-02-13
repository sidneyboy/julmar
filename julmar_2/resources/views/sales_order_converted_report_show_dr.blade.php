<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th colspan="{{ 3 + $select_stores_and_method_counter }}" style="text-align: center;">ORIGINAL SALES ORDER</th>
		</tr>
		<tr>
			<th>{{ $principal }}</th>
			<th>{{ $agent_name }}</th>
			<th>{{ $location }}</th>
			@foreach($select_stores_and_method as $store_data)
				<th>{{ $store_data->store->store_name }}</th>
			@endforeach
		</tr>
		<tr>
			<th>{{ $sales_order_number }}</th>
			<th>{{ $sku_type }}</th>
			<th>{{ $price_level }}</th>
			@foreach($select_stores_and_method as $store_data)
				<th>{{ $store_data->method }}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
		@foreach($select_sku as $sku_data)
			<tr>
				<th>{{ $sku_data->sku->sku_code }}</th>
				<th>{{ $sku_data->sku->description }}</th>
				<th>{{ number_format($sku_data->price,2,".",",")  }}</th>
				@foreach($select_sales_order_details as $details)
					@if($details->sku_id == $sku_data->sku_id)
						<td>{{ $details->quantity }}</td>
					@endif
				@endforeach
			</tr>
		@endforeach
	</tbody>
</table>


	<div class="table table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th colspan="13" style="text-align: center;">SALES ORDER CONVERTED TO DR</th>
				</tr>
				<tr>
					<th colspan="4" style="text-align: center;text-transform: uppercase;">{{ $agent_name }}</th>
					<th colspan="4" style="text-align: center;">{{ $sales_order_number }}</th>
					<th style="text-align: center;" colspan="5">
						@if($select_sales_order_printed_counter != 0)
							<a class="btn btn-warning btn-block" colspan="2" href="{{ route('sales_order_converted_report_show_control', $sales_order_number .",". $agent_name ) }}" target="_blank"><i class="fas fa-print"></i> CONTROL</a>
						@else

						@endif
					</th>

				</tr>
				<tr>
					<th style="text-align: center;">STORE</th>
					<th style="text-align: center;">DELIVERY RECEIPT</th>
					<th style="text-align: center;">PRINCIPAL</th>
					<th style="text-align: center;">MOT</th>
					<th style="text-align: center;">PRICE LEVEL</th>
					<th style="text-align: center;">TOTAL CUST DISC AMNT</th>
					<th style="text-align: center;">TOTAL CATEG DISC AMNT</th>
					<th style="text-align: center;">TOTAL PAYABLE AMNT</th>
					<th style="text-align: center;">VAT AMNT</th>
					<th style="text-align: center;">VATABLE AMNT</th>
					<th style="text-align: center;">REMARKS</th>
					<th style="text-align: center;">JOURNAL ENTRY</th>
					<th style="text-align: center;">CANCEL</th>
				</tr>
			</thead>
			<tbody>
				@if($select_sales_order_printed_counter != 0)
					@foreach($select_sales_order_printed as $sales_order_data)
					<tr>
						<td style="text-align: center;text-transform: uppercase;">{{ $sales_order_data->customer->store_name }}</td>
						<td style="text-align: center;">
							<a href="{{ route('sales_order_converted_report_show_dr_details', $sales_order_data->delivery_receipt .",". $agent_name .",". $sales_order_data->customer->store_name .",". $sales_order_data->customer->location->location .",". $sales_order_data->customer->location->location_details[0]->barangay .",". $sales_order_data->date .",". $sales_order_data->sales_order_number .",". $sales_order_data->customer->store_code .",". $sales_order_data->mode_of_transaction .",". $sales_order_data->customer->credit_term .",". $sales_order_data->id .",". $sales_order_data->customer_discount_rate ) }}" target="_blank">{{ "DR - ". $sales_order_data->delivery_receipt }}</a>
						</td>
						
						<td style="text-align: center;">{{ $sales_order_data->principal->principal }}</td>
						<td style="text-align: center;">{{ $sales_order_data->mode_of_transaction }}</td>
						<td style="text-align: center;">{{ $sales_order_data->price_level }}</td>
						<td style="text-align: right;">
							@php	
								$sum_total_customer_discount_amount = $sales_order_data->total_customer_discount_amount;
							@endphp
							{{ number_format($sales_order_data->total_customer_discount_amount,2,".",",") }}
						</td>
						<td style="text-align: right;">
							@php	
								$sum_total_category_discount_amount = $sales_order_data->total_category_discount_amount;
							@endphp
							{{ number_format($sales_order_data->total_category_discount_amount,2,".",",")  }}
						</td>
						<td style="text-align: right;">
							@php	
								$sum_total_customer_payable_amount = $sales_order_data->total_customer_payable_amount;
							@endphp
							{{ number_format($sales_order_data->total_customer_payable_amount,2,".",",")  }}
						</td>
						<td style="text-align: right;">
							@php	
								$sum_vat_amount = $sales_order_data->vat_amount;
							@endphp
							{{ number_format($sales_order_data->vat_amount,2,".",",")  }}
						</td>
						<td style="text-align: right;">
							@php	
								$sum_vatable_amount = $sales_order_data->vatable_amount;
							@endphp
							{{ number_format($sales_order_data->vatable_amount,2,".",",")  }}
						</td>
						<td style="text-align: center;text-transform: uppercase;">{{ $sales_order_data->remarks }}</td>
						<td style="text-align: center"><!-- Button trigger modal -->
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $sales_order_data->id }}">
								<i class="fa fa-eye" aria-hidden="true"></i>
							</button>

							<!-- Modal -->
							<div class="modal fade" id="exampleModal{{ $sales_order_data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog mw-100 w-50" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">JOURNAL ENTRY REGISTER FOR DR <i style="color:blue;">{{ $sales_order_data->delivery_receipt }}</i></h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body">
							      	@if($sales_order_data->remarks == 'cancelled')
							      		<table class="table table-bordered table-hover">
							        		<thead>
							        			<tr>
							        				<th></th>
							        				<th>DEBIT</th>
							        				<th></th>
							        				<th>CREDIT</th>
							        			</tr>
							        			<tr>
							        				
							        				<th>SALES - {{ $sales_order_data->principal->principal }}</th>
							        				<th>{{ number_format($sales_order_data->jer->sales,2,".",",")  }}</th>
							        				<th></th>
							        				<th></th>
							        			</tr>
							        			<tr>
							        				<th></th>
							        				<th></th>
							        				<th>ACCOUNTS RECEIVABLE - {{ $sales_order_data->principal->principal }}</th>
							        				<th>{{ number_format($sales_order_data->jer->accounts_receivable,2,".",",")  }}</th>
							        			</tr>
												@foreach($sales_order_data->jer->jer_details as $jer_details)
												<tr>
													<th>INVENTORY - {{ $sales_order_data->principal->principal }}</th>
													<th>{{ number_format($jer_details->inventory,2,".",",")  }}</th>
													<th></th>
													<th></th>
												</tr>
												<tr>
													<th></th>
													<th></th>
													<th>COST OF SALES - {{ $sales_order_data->principal->principal }}
													</th>
													<th>
														{{ number_format($jer_details->cost_of_sales,2,".",",")  }}
														@php
															$sum_cost_of_sales[] = $jer_details->cost_of_sales;
														@endphp
													</th>
												</tr>
												@endforeach
												<tr>
													<th colspan="3" style="font-weight: bold;text-align: center">PROFIT</th>
													<th colspan="2" style="text-align: center;">
														@php
															$profit = $sales_order_data->jer->sales - array_sum($sum_cost_of_sales)
														@endphp
														{{ number_format($profit,2,".",",")  }}
													</th>
												</tr>
							        		</thead>
							        	</table>
							      	@else
							      		<table class="table table-bordered table-hover">
							        		<thead>
							        			<tr>
							        				<th></th>
							        				<th>DEBIT</th>
							        				<th></th>
							        				<th>CREDIT</th>
							        			</tr>
							        			<tr>
							        				<th>ACCOUNTS RECEIVABLE - {{ $sales_order_data->principal->principal }}</th>
							        				<th>{{ number_format($sales_order_data->jer->accounts_receivable,2,".",",")  }}</th>
							        				<th></th>
							        				<th></th>
							        			</tr>
							        			<tr>
							        				<th></th>
							        				<th></th>
							        				<th>SALES - {{ $sales_order_data->principal->principal }}</th>
							        				<th>{{ number_format($sales_order_data->jer->sales,2,".",",")  }}</th>
							        			</tr>
												@foreach($sales_order_data->jer->jer_details as $jer_details)
												<tr>
													<th>COST OF SALES - {{ $sales_order_data->principal->principal }}

													</th>
													<th>
														{{ number_format($jer_details->cost_of_sales,2,".",",")  }}
														@php
															$sum_cost_of_sales[] = $jer_details->cost_of_sales;
														@endphp
													</th>
													<th></th>
													<th></th>
												</tr>
												<tr>
													<th></th>
													<th></th>
													<th>INVENTORY - {{ $sales_order_data->principal->principal }}</th>
													<th>{{ number_format($jer_details->inventory,2,".",",")  }}</th>
												</tr>
												@endforeach
												<tr>
													<th colspan="3" style="font-weight: bold;text-align: center">PROFIT</th>
													<th colspan="2" style="text-align: center;">
														@php
															$profit = $sales_order_data->jer->sales - array_sum($sum_cost_of_sales)
														@endphp
														{{ number_format($profit,2,".",",")  }}
													</th>
												</tr>
							        		</thead>
							        	</table>
							      	@endif
							      </div>
							      <div class="modal-footer">
							        
							      </div>
							    </div>
							  </div>
							</div>
						</td>
						@if($sales_order_data->remarks == 'cancelled')
							<td style="text-align: center;">N/A</td>
						@elseif($sales_order_data->remarks == 'partial')
							<td style="text-align: center;">N/A</td>
						@elseif($sales_order_data->remarks == 'paid')
							<td style="text-align: center;">N/A</td>
						@else
							<td style="text-align: center;">
								<!-- Button trigger modal -->
								<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{ $sales_order_data->delivery_receipt }}">
								<i class="fa fa-times" aria-hidden="true"></i> 
								</button>
								<!-- Modal -->
								<div class="modal fade" id="exampleModal{{ $sales_order_data->delivery_receipt }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">ENTER OPERATIONS MANAGER ACCESS CODE</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<form id="cancel_dr">
													@csrf
													<div class="form-group">
														<input type="hidden" name="sales_order_printed_id" value="{{ $sales_order_data->id }}">
														<input type="hidden" name="delivery_receipt" value="{{ 'cancelled '. $sales_order_data->delivery_receipt }}">
														<input type="hidden" name="customer_id" value="{{ $sales_order_data->customer_id }}">
														<input type="hidden" name="principal_id" value="{{ $sales_order_data->principal_id }}">
														<input type="hidden" name="store_code" value="{{ $sales_order_data->customer->store_code }}">
														<input type="hidden" name="sales_order_number" value="{{ $sales_order_data->sales_order_number }}">
														<input type="hidden" name="total_customer_payable_amount" value="{{ $sales_order_data->total_customer_payable_amount }}">
														<label>Access Code:</label>
														<input type="password" name="access_code" class="form-control" required>
													</div>
													<div class="form-group">
														<button type="submit" class="btn btn-success btn-block ">Submit</button>
													</div>
												</form>
											</div>
											<div class="modal-footer">
												<i style="color:red;text-align: center">Note: You won't be able to revert this process</i>
											</div>
										</div>
									</div>
								</div>
							</td>
						@endif
					</tr>
					@endforeach
					<tr>
						<td colspan="5" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
						<td style="text-align: right;color:green;font-weight: bold;">{{ number_format($sum_total_customer_discount_amount,2,".",",")  }}</td>
						<td style="text-align: right;color:green;font-weight: bold;">{{ number_format($sum_total_category_discount_amount,2,".",",")  }}</td>
						<td style="text-align: right;color:green;font-weight: bold;">{{ number_format($sum_total_customer_payable_amount,2,".",",")  }}</td>
						<td style="text-align: right;color:green;font-weight: bold;">{{ number_format($sum_vat_amount,2,".",",")  }}</td>
						<td style="text-align: right;color:green;font-weight: bold;">{{ number_format($sum_vatable_amount,2,".",",")  }}</td>
						<td colspan="3"></td>
					</tr>
				@else
					<tr>
						<td colspan="13" style="text-align: center;font-weight: bold;color:red;">NOT YET CONVERTED TO DR!</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>

<script type="text/javascript">
  $("#cancel_dr").on('submit',(function(e){
      e.preventDefault();
       //$('.loading').show();
     
        $.ajax({
          url: "sales_order_converted_report_cancel_dr",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            if(data == 'Incorrect Access Code'){
               Swal.fire(
              'Incorrect Access Code, Cannot Proceed!!!',
              '',
              'error'
              )
              $('.loading').hide(); 
            }else{
   //            $('.loading').hide();

   //            let timerInterval
			// Swal.fire({
			//   title: 'Auto close alert!',
			//   html: 'I will close in <b></b> milliseconds.',
			//   timer: 2000,
			//   timerProgressBar: true,
			//   willOpen: () => {
			//     Swal.showLoading()
			//     timerInterval = setInterval(() => {
			//       const content = Swal.getContent()
			//       if (content) {
			//         const b = content.querySelector('b')
			//         if (b) {
			//           b.textContent = Swal.getTimerLeft()
			//         }
			//       }
			//     }, 100)
			//   },
			//   willClose: () => {
			//     clearInterval(timerInterval)
			//   }
			// }).then((result) => {
			//   /* Read more about handling dismissals below */
			//   if (result.dismiss === Swal.DismissReason.timer) {
			//     location.reload();
			//   }
			// })
              
            }
          },
        });
    }));
</script>
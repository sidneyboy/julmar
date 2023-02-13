<div class="form-group">
	<table class="table table-bordered table-hover">
		<thead>
			
			<tr>
				<th style="text-align: center;">STORE</th>
				<th style="text-align: center;">UNTITLED</th>
				<th style="text-align: center;">TOTAL AMOUNT</th>
				<th style="text-align: center;">PERSONNEL</th>
				<th style="text-align: center;">STATUS</th>
				<th style="text-align: center;">DATE</th>
			</tr>
		</thead>
		<tbody>
			@php
				if (!is_null($sales_order_printed->cm_for_bo_descending)) {	
			@endphp
				@foreach($sales_order_printed->cm_for_bo_descending as $data)
					<tr>
						<td style="text-align: center;">
							<!-- Button trigger modal -->
							<button type="button" style="text-transform: uppercase;" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal{{ $data->id }}">
							{{ $data->customer->store_name }}
							</button>

							<!-- Modal -->
							<div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog mw-100 w-75" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel">DR DATA</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body">
							      	<table class="table table-bordered table-sm table-hover">
										<thead>
											<tr>
												<th colspan="8" style="text-align: center;">PCM #: <span style="color:red;">{{ $data->pcm_number }}</span></th>
											</tr>
											<tr>
												<th>CODE</th>
												<th>DESC</th>
												<th>BO QTY</th>
												<th>BO EXPIRED</th>
												<th>PRICE</th>
												<th>CAT DISC</th>
												<th>AMNT</th>
												<th>REMARKS</th>
											</tr>
										</thead>
							      		<tbody>
							      			@foreach ($data->cm_for_bo_details as $details) 
												<tr>
													<td>{{ $details->sku->sku_code }}</td>
													<td>{{ $details->sku->description }}</td>
													<td>{{ $details->quantity }}</td>
													<td>{{ $details->bo_quantity_expired }}</td>
													<td style="text-align: right;">{{ number_format($details->price ,2,".",",") }}</td>
													<td style="text-align: right;">
														{{ number_format($details->category_discount ,2,".",",") }}
													</td>
													<td style="text-align: right;">
														@php
															$sum_bo_amount[] = $details->bo_amount;
														@endphp
														{{ number_format($details->bo_amount ,2,".",",") }}
													</td>
													<td style="text-transform: uppercase;">{{ $details->remarks }}</td>
												</tr>
											@endforeach
											<tr>
												<td colspan="6" style="text-align: center;font-weight: bold;">SUB-TOTAL</td>
												<td style="text-align: right;font-weight: bold">{{ number_format(array_sum($sum_bo_amount),2,".",",") }}</td>
												<td></td>
											</tr>
											<tr>
												<td colspan="6" style="text-align: center;font-weight: bold;">LESS DISCOUNT</td>
												<td style="text-align: right;font-weight: bold">{{ number_format($data->total_customer_discount,2,".",",") }}</td>
												<td></td>
											</tr>
											<tr>
												<td colspan="6" style="text-align: center;font-weight: bold;text-transform: uppercase;">CHARGES: {{ $data->personnels_to_be_charged }}</td>
												<td  style="text-align: right;font-weight: bold">{{ number_format($data->amount_to_be_charged,2,".",",") }}</td>
												<td></td>
											</tr>
											<tr>
												<td colspan="6" style="text-align: center;font-weight: bold">TOTAL BO AMOUNT</td>
												<td style="text-align: right;font-weight: bold">{{ number_format($data->total_bo_amount,2,".",",") }}</td>
												<td></td>
											</tr>
							      		</tbody>
							      	</table>
							      	<table class="table table-bordered table-sm table-hover float-right" style="width:20%;">
							      		<thead>
							      			<tr>
												<th colspan="2" style="text-align: center;">BO SUMMARY</th>
											</tr>
											@if($sales_order_printed->principal->principal == 'PFC')
												@foreach($data->cm_for_bo_details as $details)
													@if($details->remarks == "EXPIRED")
														@php
															$bo_data_amount_expired = $details->quantity * $details->price;
															$sum_bo_data_amount_expired[] = $bo_data_amount_expired;
														@endphp
													@elseif($details->remarks == "BO")
														@php	
															$bo_data_amount_bo = $details->quantity * $details->price;
															$sum_bo_data_amount_bo[] = $bo_data_amount_bo;
														@endphp
													@else
														@php
															$sum_bo_data_amount_expired[] = 0;
															$sum_bo_data_amount_bo[] = 0;
														@endphp
													@endif
												@endforeach
												<tr>
													<th>EXPIRED</th>
													<th>
														@if(isset($sum_bo_data_amount_expired))
															{{ number_format(array_sum($sum_bo_data_amount_expired),2,".",",") }}
														@else
															{{ number_format(0,2,".",",") }}
														@endif
													</th>
												</tr>
												<tr>
													<th>BO</th>
													<th>
														@if(isset($sum_bo_data_amount_bo))
															{{ number_format(array_sum($sum_bo_data_amount_bo),2,".",",") }}
														@else
															{{ number_format(0,2,".",",") }}
														@endif
													</th>
												</tr>
											@elseif($sales_order_printed->principal->principal == 'PPMC')
												@foreach($data->cm_for_bo_details as $details)
													@if($details->remarks == "BAR")
														@php
															$bo_data_amount_bar = ($details->quantity * $details->price) - $details->category_discount;
															
														@endphp
													@elseif($details->remarks == "POWDER")
														@php	
															$bo_data_amount_powder = $details->quantity * $details->price;
															$sum_bo_data_amount_powder[] = $bo_data_amount_powder;
														@endphp
													@elseif($details->remarks == "PLC")
														@php
															$bo_data_amount_plc = $details->quantity * $details->price;
															$sum_bo_data_amount_plc[] = $bo_data_amount_plc;
														@endphp
													@endif
												@endforeach
												<tr>
													<th>BAR</th>
													<th>
														@if(isset($sum_bo_data_amount_bar))
															{{  number_format(array_sum($sum_bo_data_amount_bar),2,".",",") }}
														@else
															{{  number_format(0,2,".",",") }}
														@endif
													</th>
												</tr>
												<tr>
													<th>POWDER</th>
													<th>
														@if(isset($sum_bo_data_amount_powder))
															{{  number_format(array_sum($sum_bo_data_amount_powder),2,".",",") }}
														@else
															{{  number_format(0,2,".",",") }}
														@endif
													</th>
												</tr>
												<tr>
													<th>PLC</th>
													<th>
														@if(isset($sum_bo_data_amount_plc))
															{{  number_format(array_sum($sum_bo_data_amount_plc),2,".",",") }}
														@else
															{{  number_format(0,2,".",",") }}
														@endif
													</th>
												</tr>
											@elseif($sales_order_printed->principal->principal == "CIFPI")
												@foreach($data->cm_for_bo_details as $details)
													@if($details->remarks == "CONFECTIONARY")
														@php
															$bo_data_amount_confectionary = $details->quantity * $details->price;
															$sum_bo_data_amount_confectionary[] = $bo_data_amount_confectionary;
														@endphp
													@elseif($details->remarks == "SNACKS")
														@php	
															$bo_data_amount_snacks = $details->quantity * $details->price;
															$sum_bo_data_amount_snacks[] = $bo_data_amount_snacks;
														@endphp
													@elseif($details->remarks == "EXPIRED")
														@php
															$bo_data_amount_expired = $details->quantity * $details->price;
															$sum_bo_data_amount_expired[] = $bo_data_amount_expired;
														@endphp
													@endif
												@endforeach
												<tr>
													<th>CONFEC</th>
													<th>
														@if(isset($sum_bo_data_amount_confectionary))
															{{  number_format(array_sum($sum_bo_data_amount_confectionary),2,".",",") }}
														@else
															{{  number_format(0,2,".",",") }}
														@endif
													</th>
												</tr>
												<tr>
													<th>SNACKS</th>
													<th>
														@if(isset($sum_bo_data_amount_snacks))
															{{  number_format(array_sum($sum_bo_data_amount_snacks),2,".",",") }}
														@else
															{{  number_format(0,2,".",",") }}
														@endif
													</th>
												</tr>
												<tr>
													<th>EXPIRED</th>
													<th>
														@if(isset($sum_bo_data_amount_expired))
															{{  number_format(array_sum($sum_bo_data_amount_expired),2,".",",") }}
														@else
															{{  number_format(0,2,".",",") }}
														@endif
													</th>
												</tr>
											@else
												@foreach($data->cm_for_bo_details as $details)
													@if($details->remarks == "BO")
														@php
															$bo_data_amount = $details->quantity * $details->price;
															$sum_bo_data_amount[] = $bo_data_amount;
														@endphp
													@else

													@endif
												@endforeach
												<tr>
													<th>BO</th>
													<th>
														@if(isset($sum_bo_data_amount))
															{{  number_format(array_sum($sum_bo_data_amount),2,".",",") }}
														@else
															{{  number_format(0,2,".",",") }}
														@endif
													</th>
												</tr>
											@endif
							      		</thead>
							      	</table>
							      </div>
							      <div class="modal-footer">
							      </div>
							    </div>
							  </div>
							</div>
						</td>
						<td style="text-align: center;text-transform: uppercase;font-weight:bold;color:orange;">CM FOR BO</th>
						<td style="text-align: center;text-transform: uppercase;">{{ number_format($data->total_bo_amount,2,".",",") }}</td>
						<td style="text-align: center;text-transform: uppercase;">{{ $data->personnel->full_name }}</td>
						<td style="text-align: center;text-transform: uppercase;">{{ $data->status }}</td>
						<td style="text-align: center;text-transform: uppercase;">{{ $data->created_at }}</td>
					</tr>
				@endforeach
			@php
				}else{

				}
			@endphp
			@php
				if (!is_null($sales_order_printed->cm_for_rgs)) {	
			@endphp
				@foreach($sales_order_printed->cm_for_rgs as $data)
					<tr>
						<td style="text-align: center;">
							<!-- Button trigger modal -->
							<button type="button" style="text-transform: uppercase;" class="btn btn-success" data-toggle="modal" data-target="#exampleModal2{{ $data->id }}">
							{{ $data->customer->store_name }}
							</button>

							<!-- Modal -->
							<div class="modal fade" id="exampleModal2{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog mw-100 w-75" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel">DR DATA</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body">
							     	 	<table class="table table-bordered table-sm table-hover">
										<thead>
											<tr>
												<th>CODE</th>
												<th>DESC</th>
												<th>QTY</th>
												<th>PRICE</th>
												<th>AMNT</th>
												<th>REMARKS</th>
											</tr>
										</thead>
							      		<tbody>
							      			@foreach ($data->cm_for_rgs_details as $details) 
												<tr>
													<td>{{ $details->sku->sku_code }}</td>
													<td>{{ $details->sku->description }}</td>
													<td>{{ $details->quantity }}</td>
													<td style="text-align: right;">{{ number_format($details->price ,2,".",",") }}</td>
													<td style="text-align: right;">
														{{ number_format($details->rgs_amount ,2,".",",") }}
													</td>
													<td style="text-transform: uppercase;">{{ $details->remarks }}</td>
												</tr>
											@endforeach
											<tr>
												<td colspan="4" style="text-align: center;font-weight: bold">TOTAL BO AMOUNT</td>
												<td style="text-align: right;font-weight: bold">{{ number_format($data->total_bo_amount,2,".",",") }}</td>
												<td></td>
											</tr>
							      		</tbody>
							      	</table>
















							
							      </div>
							      <div class="modal-footer">
							      </div>
							    </div>
							  </div>
							</div>
						</td>

						<td style="text-align: center;text-transform: uppercase;font-weight:bold;color:green;">CM FOR RGS</td>
						<td style="text-align: center;text-transform: uppercase;">{{ number_format($data->total_rgs_amount,2,".",",") }}</td>
						<td style="text-align: center;text-transform: uppercase;">{{ $data->personnel->full_name }}</td>
						<td style="text-align: center;text-transform: uppercase;">{{ $data->status }}</td>
						<td style="text-align: center;text-transform: uppercase;">{{ $data->created_at }}</td>
					</tr>
				@endforeach
			@php
				}else{

				}
			@endphp
		</tbody>
	</table>

</div>
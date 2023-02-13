<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th colspan="7" style="text-align: center;">{{ $pcm_upload->bo_rgs_export_code }}</th>
		</tr>
		<tr>
			<th style="text-align: center;">UPLOADED</th>
			<th style="text-align: center;">AGENT</th>
			<th style="text-align: center;">CUSTOMER</th>
			<th style="text-align: center;">PRINCIPAL</th>
			<th style="text-align: center;">DELIVERY RECEIPT</th>
			<th style="text-align: center;">RGS STATUS</th>
			<th style="text-align: center;">BO STATUS</th>
		</tr>
		<tr>
			<th style="text-align: center;">{{ $pcm_upload->date }}</th>
			<th style="text-align: center;">{{ $pcm_upload->agent->full_name }}</th>
			<th style="text-align: center;">{{ $pcm_upload->customer->store_name }}</th>
			<th style="text-align: center;">{{ $pcm_upload->principal->principal }}</th>
			<th style="text-align: center;">{{ $pcm_upload->delivery_receipt }}</th>
			<th style="text-align: center;">
				@if($pcm_upload->rgs_status == 'TO BE CONFIRMED BY WAREHOUSE')
					<span style="color:red;">{{ $pcm_upload->rgs_status }}</span>
				@else
					<span style="color:green;">{{ $pcm_upload->rgs_status }}</span>
				@endif
			</th>
			<th style="text-align: center;">
				@if($pcm_upload->bo_status == 'TO BE CONFIRMED BY WAREHOUSE')
					<span style="color:red;">{{ $pcm_upload->bo_status }}</span>
				@else
					<span style="color:green;">{{ $pcm_upload->bo_status }}</span>
				@endif
			</th>
		</tr>
		<tr>
			<th style="text-align: center;">CODE</th>
			<th style="text-align: center;">DESC</th>
			<th style="text-align: center;">UOM</th>
			<th style="text-align: center;">RGS QTY</th>
			<th style="text-align: center;">BO QTY</th>
			<th style="text-align: center;">PRICE</th>
			<th style="text-align: center;">AMOUNT</th>
		</tr>
	</thead>
	<tbody>
		@foreach($pcm_upload->pcm_upload_details as $data)
			<tr>
				<td>{{ $data->sku->sku_code }}</td>
				<td>{{ $data->sku->description }}</td>
				<td>{{ $data->sku->unit_of_measurement }}</td>
				<td style="text-align: right">
					@php
						$rgs_amount = $data->rgs_quantity * $data->unit_price;
						$sum_rgs_quantity[] = $data->rgs_quantity;
						echo $data->rgs_quantity;
					@endphp
				</td>
				<td style="text-align: right">
					@php
						$bo_amount = $data->bo_quantity * $data->unit_price;
						$sum_bo_quantity[] = $data->rgs_quantity;
						echo $data->bo_quantity;
					@endphp
				</td>
				<td style="text-align: right">{{ number_format($data->unit_price,2,".",",")  }}</td>
				<td style="text-align: right">
					@php
						$amount = $rgs_amount + $bo_amount;
						$sum_amount[] = $amount;
						echo number_format($amount,2,".",",");
					@endphp
				</td>
			</tr>
		@endforeach
			<tr>
				<td colspan="3" style="font-weight: bold;text-align: center;">TOTAL</td>
				<td style="text-align: right;font-weight: bold;">{{ array_sum($sum_rgs_quantity) }}</td>
				<td style="text-align: right;font-weight: bold;">{{ array_sum($sum_bo_quantity) }}</td>
				<td></td>
				<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_amount),2,".",",") }}</td>
			</tr>
	</tbody>
</table>

<div class="row">
	<div class="col-md-6">
		<form id="pcm_upload_report_rgs_save">
			<input type="hidden" name="pcm_upload_id" value="{{ $pcm_upload->id }}">
			<input type="hidden" name="sales_order_print_id" value="{{ $sales_order_print->id }}">
			<input type="hidden" name="employee_name" value="{{ $employee_name }}">
			<input type="hidden" name="customer_id" value="{{ $pcm_upload->customer_id }}">
			<input type="hidden" name="delivery_receipt" value="{{ $pcm_upload->delivery_receipt }}">
			<input type="hidden" name="sales_order_number" value="{{ $sales_order_print->sales_order_number }}">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<td colspan="7" style="font-weight: bold;text-align: center;"><span style="color:blue">PCM FOR RGS</span> {{ $pcm_upload->delivery_receipt }}</td>
					</tr>
					<tr>
						<td colspan="3">
							<input type="text" name="pcm_number" class="form-control" placeholder="Enter Pcm Number.." required>
						</td>
						<td colspan="4">
							<select class="form-control select2" name="agent_id" style="width:100%;" required>
								<option value="" option>Remitted by:</option>
								@foreach($agent as $data_agent)
									<option value="{{ $data_agent->id }}">{{ $data_agent->full_name }}</option>
								@endforeach
							</select>
						</td>
					</tr>
					<tr>
						<th style="text-align: center;">CODE</th>
						<th style="text-align: center;">DESC</th>
						<th style="text-align: center;">UOM</th>
						<th style="text-align: center;">RGS QTY</th>
						<th style="text-align: center;">PRICE</th>
						<th style="text-align: center;">AMOUNT</th>
						<th style="text-align: center;">REMARKS</th>
					</tr>
				</thead>
				<tbody>
					@foreach($pcm_upload->pcm_upload_details as $data_rgs)
						<tr>
							<td>
								<input type="hidden" name="data_rgs_sku[]" value="{{ $data_rgs->sku_id }}">

								{{ $data_rgs->sku->sku_code }}
							</td>
							<td>{{ $data_rgs->sku->description }}</td>
							<td>{{ $data_rgs->sku->unit_of_measurement }}</td>
							<td style="text-align: right">
								<input type="hidden" name="rgs_quantity[{{ $data_rgs->sku_id }}]" value="{{ $data_rgs->rgs_quantity }}">
								@php
									$rgs_amount_lower = $data_rgs->rgs_quantity * $data_rgs->unit_price;
									$sum_rgs_quantity_lower[] = $data_rgs->rgs_quantity;
									echo $data_rgs->rgs_quantity;
								@endphp
							</td>
							<td style="text-align: right">
								<input type="hidden" name="rgs_unit_price[{{ $data_rgs->sku_id }}]" value="{{ $data_rgs->unit_price }}">
								{{ number_format($data_rgs->unit_price,2,".",",")  }}
							</td>
							<td style="text-align: right">
								@php
									$amount_lower_rgs = $rgs_amount_lower;
									$sum_amount_lower_rgs[] = $amount_lower_rgs;
									echo number_format($amount_lower_rgs,2,".",",");
								@endphp
							</td>
							<td>
								<input type="text" name="rgs_remarks[{{ $data_rgs->sku_id }}]" value="NONE" required class="form-control">
							</td>
						</tr>
					@endforeach
						<tr>
							<td colspan="3" style="font-weight: bold;text-align: center;">TOTAL</td>
							<td style="text-align: right;font-weight: bold;">{{ array_sum($sum_rgs_quantity_lower) }}</td>
							<td></td>
							<td></td>
							<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_amount_lower_rgs),2,".",",") }}</td>
						</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7">
							@if($pcm_upload->rgs_status == 'CONFIRMED BY WAREHOUSE')
								<button class="btn btn-block btn-info" disabled>PRINT CM FOR RGS</button>
							@else
								<button type="submit" class="btn btn-success btn-block">CONFIRM PCM FOR RGS</button>
							@endif
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
	<div class="col-md-6">
		<form id="pcm_upload_report_bo_save">
			<input type="hidden" name="pcm_upload_id" value="{{ $pcm_upload->id }}">
			<input type="hidden" name="sales_order_print_id" value="{{ $sales_order_print->id }}">
			<input type="hidden" name="employee_name" value="{{ $employee_name }}">
			<input type="hidden" name="customer_id" value="{{ $pcm_upload->customer_id }}">
			<input type="hidden" name="delivery_receipt" value="{{ $pcm_upload->delivery_receipt }}">
			<input type="hidden" name="sales_order_number" value="{{ $sales_order_print->sales_order_number }}">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<td colspan="7" style="font-weight: bold;text-align: center;"><span style="color:blue">PCM FOR BO</span> {{ $pcm_upload->delivery_receipt }}</td>
					</tr>
					<tr>
						<td colspan="3">
							<input type="text" name="pcm_number" class="form-control" placeholder="Enter Pcm Number.." required>
						</td>
						<td colspan="4">
							<select class="form-control select2" name="agent_id" style="width:100%;" required>
								<option value="" option>Remitted by:</option>
								@foreach($agent as $data_agent)
									<option value="{{ $data_agent->id }}">{{ $data_agent->full_name }}</option>
								@endforeach
							</select>
						</td>
					</tr>
					<tr>
						<th style="text-align: center;">CODE</th>
						<th style="text-align: center;">DESC</th>
						<th style="text-align: center;">UOM</th>
						<th style="text-align: center;">BO QTY</th>
						<th style="text-align: center;">PRICE</th>
						<th style="text-align: center;">AMOUNT</th>
						<th style="text-align: center;">REMARKS</th>
					</tr>
				</thead>
				<tbody>
					@foreach($pcm_upload->pcm_upload_details as $data_bo)
						<tr>
							<td>
								<input type="hidden" name="data_bo_sku[]" value="{{ $data_bo->sku_id }}">
								{{ $data_bo->sku->sku_code }}
							</td>
							<td>{{ $data_bo->sku->description }}</td>
							<td>{{ $data_bo->sku->unit_of_measurement }}</td>
							<td style="text-align: right">
								<input type="hidden" name="bo_quantity[{{ $data_bo->sku_id }}]" value="{{ $data_bo->bo_quantity }}">
								@php
									$bo_amount_lower = $data_bo->bo_quantity * $data_bo->unit_price;
									$sum_bo_quantity_lower[] = $data_bo->bo_quantity;
									echo $data_bo->bo_quantity;
								@endphp
							</td>
							<td style="text-align: right">
								<input type="hidden" name="bo_unit_price[{{ $data_bo->sku_id }}]" value="{{ $data_bo->unit_price }}">
								{{ number_format($data_bo->unit_price,2,".",",")  }}
							</td>
							<td style="text-align: right">
								@php
									$amount_lower_bo = $bo_amount_lower;
									$sum_amount_lower_bo[] = $amount_lower_bo;
									echo number_format($amount_lower_bo,2,".",",");
								@endphp
							</td>
							<td>
						
								<select class="form-control select2" style="width:100%;" name="bo_remarks[{{ $data_bo->sku_id }}]" required>
									<option value="N/A" selected>N/A</option>
									@if($sales_order_print->principal->principal == 'PPMC')
									<option value="BAR" >BAR</option>
									<option value="POWDER" >POWDER</option>
									<option value="PLC" >PLC</option>
									@elseif($sales_order_print->principal->principal == 'CIFPI')
									<option value="CONFECTIONARY" >CONFECTIONARY</option>
									<option value="SNACKS" >SNACKS</option>
									<option value="EXPIRED" >EXPIRED</option>
									@elseif($sales_order_print->principal->principal == 'PFC')
									<option value="EXPIRED" >EXPIRED</option>
									<option value="BO" >BO</option>
									@else
									<option value="BO" >BO</option>
									@endif
								</select>
							</td>
						</tr>
					@endforeach
						<tr>
							<td colspan="3" style="font-weight: bold;text-align: center;">TOTAL</td>
							<td style="text-align: right;font-weight: bold;">{{ array_sum($sum_rgs_quantity_lower) }}</td>
							<td></td>
							<td></td>
							<td style="text-align: right;font-weight: bold;">{{ number_format(array_sum($sum_amount_lower_bo),2,".",",") }}</td>
						</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7">
							@if($pcm_upload->bo_status == 'CONFIRMED BY WAREHOUSE')
								<button class="btn btn-block btn-info" disabled>PRINT CM FOR RGS</button>
							@else
								<button type="submit" class="btn btn-success btn-block">CONFIRM PCM FOR BO</button>
							@endif
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
</div>

<script type="text/javascript">
	 $('.select2').select2()
	 

$("#pcm_upload_report_rgs_save").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "pcm_upload_report_rgs_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            if(data == 'saved'){
               Swal.fire({
				  position: 'top-end',
				  icon: 'success',
				  title: 'Your work has been saved',
				  showConfirmButton: false,
				  timer: 1500
				})
               location.reload();
              $('.loading').hide(); 
            }else if(data = 'existing_pcm_number'){
               Swal.fire(
                'Cannot Proceed',
                'Existing PCM',
                'error'
              )
              $('.loading').hide();
              // document.getElementById("pcm_upload_save").reset(); 
            }
          },
        });
    }));

	$("#pcm_upload_report_bo_save").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "pcm_upload_report_bo_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
             if(data == 'saved'){
               Swal.fire({
				  position: 'top-end',
				  icon: 'success',
				  title: 'Your work has been saved',
				  showConfirmButton: false,
				  timer: 1500
				})
               location.reload();
              $('.loading').hide(); 
            }else if(data = 'existing_pcm_number'){
               Swal.fire(
                'Cannot Proceed',
                'Existing PCM',
                'error'
              )
              $('.loading').hide();
              // document.getElementById("pcm_upload_save").reset(); 
            }
          },
        });
    }));

</script>
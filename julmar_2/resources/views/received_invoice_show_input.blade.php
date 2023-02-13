<div class="table table-responsive">
	<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th colspan="11" style="font-weight: bold;text-align: center;color:blue;">RECEIVED ORDER DATA</th>
		</tr>
		<tr>
			<th style="text-align: center;">Invoice Date</th>
			<th style="text-align: center;">RR</th>
			<th style="text-align: center;">Dr Si</th>
			<th style="text-align: center;">Principal</th>
			<th style="text-align: center;">Purchase ID</th>
			<th style="text-align: center;">Vatable Purchase</th>
			<th style="text-align: center;">Less Discount</th>
			<th style="text-align: center;">Net Discount</th>
			<th style="text-align: center;">Vat Amount</th>
			<th style="text-align: center;">Grand Total Cost</th>
			<th style="text-align: center;">Upload Invoie Image</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="text-align: center;">{{ $received_data->invoice_date }}</td>
			<td style="text-align: center;"><a href="{{ route('received_order_report_show_details', $received_data->id ."=". $received_data->principal->principal) }}" target="_blank">RR - {{ $received_data->id }}</a></td>
			<td style="text-align: center;text-transform: uppercase;">{{ $received_data->dr_si }}</td>
			<td style="text-align: center;">{{ $received_data->principal->principal }}</td>
			<td style="text-align: center;">{{ $received_data->purchase_order->purchase_id}}</td>
			<td style="text-align: right">{{ number_format($received_data->total_vatable_purchase,2,".",",")  }}</td>
			<td style="text-align: right">
				@php
					$less_discount = $received_data->total_discount + $received_data->total_bo_allowance_discount;
				@endphp
				{{ number_format($less_discount,2,".",",")  }}

			</td>
			<td style="text-align: right">
				@php
					$net_discount = $received_data->total_vatable_purchase - $less_discount;
				@endphp
				{{ number_format($net_discount,2,".",",")  }}
			</td>
			<td style="text-align: right">{{ number_format($received_data->total_vat_amount,2,".",",")  }}</td>
			<td style="text-align: right">{{ number_format($received_data->grand_total_final_cost,2,".",",")  }}</td>
			<td>
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary btn-block btn-flat" data-toggle="modal" data-target="#exampleModal">
				  INVOICE IMAGE
				</button>

				<!-- Modal -->
				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;text-align: center;text-align: center;">UPLOAD INVOICE IMAGE</h5>
				      </div>
				    <form action="{{ route('image.upload.post') }}" method="POST" enctype="multipart/form-data">
				     @csrf
				      <div class="modal-body">
					      <div class="form-group">
					      	<img id="blah" src="{{ asset('/adminLte/default_image.jpg') }}" style="width:100%;border-radius: 1px 1px 0px 0px;" alt="your image" class="img img-thumbnail"/>
					      	<input type='file' name="image" class="form-control" onchange="readURL(this);" required/>
					   
					      	<input type="hidden" name="received_id" value="{{ $received_data->id }}">
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
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>

<div class="table table-responsive">
	<table class="table table-bordered table-hover" id="example2">
		<thead>
			<tr>
				<th>STORE NAME</th>
				<th>TRANSACTED BY</th>
				<th>PCM #</th>
				<th>AMOUNT</th>
				<th>DATE</th>
				<th>REMARKS</th>
			</tr>
		</thead>
		<tbody>
			@foreach($van_selling_pcm as $data)
			<tr>
				<td>{{ $data->customer->store_name }}</td>
				<td>{{ strtoupper($data->user->name) }}</td>
				<td>
					
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModal{{ $data->pcm_number }}">
					PCM# - {{ $data->pcm_number }}
					</button>
					<!-- Modal -->
					<div class="modal fade" id="exampleModal{{ $data->pcm_number }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content ">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">LIST OF SKU WITH IN PCM <span style="color:blue;">{{ $data->pcm_number }}</span></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th>PRINCIPAL</th>
												<th>CODE</th>
												<th>DESCRIPTION</th>
												<th>QTY</th>
												<th>U/P</th>
												<th>SUB-TOTAL</th>
											</tr>
										</thead>
										<tbody>
											@if(count($data->van_selling_pcm_details) != 0)
											@foreach($data->van_selling_pcm_details as $details)
											<tr>
												<td>{{ $details->principal }}</td>
												<td>{{ $details->sku_code }}</td>
												<td>{{ $details->description }}</td>
												<td>{{ $details->quantity }}</td>
												<td style="text-align: right">{{ number_format($details->unit_price,2,".",",")  }}</td>
												<td style="text-align: right">
													@php
													$sub_total = $details->unit_price * $details->quantity;
													$sum_sub_total[] = round($sub_total,2);
													echo number_format($sub_total,2,".",",");
													@endphp
												</td>
											</tr>
											@endforeach
											@else
											@php
											
											$sum_sub_total[] =0;
											
											@endphp
											@endif
											
										</tbody>
										<tfoot>
										<tr>
											<th style="text-align: center;" colspan="5">GRAND TOTAL</th>
											<th style="text-align: right">{{ number_format(array_sum($sum_sub_total),2,".",",") }}</th>
										</tr>
										</tfoot>
									</table>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
				</td>
				<td style="text-align: right;font-weight: bold;color:blue;">{{ number_format($data->amount,2,".",",") }}</td>
				<td>{{ $data->date }}</td>
				<td>
					@if($data->remarks == 'posted')
					<span style="font-weight: bold;color:green;">POSTED</span>
					@else
					<span style="font-weight: bold;color:red;">TO BE POSTED</span>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<script>
	$("#example1").DataTable();
$('#example2').DataTable({
"paging": false,
"lengthChange": false,
"searching": true,
"ordering": true,
"info": true,
"autoWidth": false,
});
</script>
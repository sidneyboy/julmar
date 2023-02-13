<form id="van_selling_sku_price_adjustments_save">
	<div class="table table-responsive">
		<table class="table table-bordered table-hover" id="example2">
			<thead>
				<tr>
					<th>PRINCIPAL</th>
					<th>CODE</th>
					<th>DESCRIPTION</th>
					<th>UOM</th>
					<th>QUANTITY</th>
					<th>OLD PRICE</th>
					<th>UPDATED PRICE</th>
					<th>USING OLD PRICE</th>
					<th>USING UDPATED PRICE</th>
					<th>PRICE DIFFERENCE</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($sku as $data)
					<tr>
						<td>{{ $data->attributes->principal }}</td>
						<td>{{ $data->id }}</td>
						<td>{{ $data->name }}</td>
						<td>{{ $data->attributes->unit_of_measurement }}</td>
						<td style="text-align: center;">{{ $data->attributes->ending_balance }}</td>
						<td style="text-align: right">{{ $data->price }}</td>
						<td style="text-align: right">{{ $data->attributes->new_unit_price }}</td>
						<td style="text-align: right">
							{{ $data->attributes->ending_balance * $data->price }}
							@php
								$old_price = $data->attributes->ending_balance * $data->price;
								$total_old_price[] = $old_price;
							@endphp
						</td>
						<td style="text-align: right">
							{{ $data->attributes->ending_balance * $data->attributes->new_unit_price }}
							@php
								$new_price = $data->attributes->ending_balance * $data->attributes->new_unit_price;
								$total_new_price[] = $new_price;
							@endphp
						</td>
						<td style="text-align: right">
							{{ $new_price - $old_price }}
							@php
								$difference = $new_price - $old_price;
								$total_difference[] = $difference;
							@endphp
						</td>
					</tr>
				@endforeach
				<tr>
					<th colspan="7">GRANDTOTAL</th>
					<th style="text-align: right">{{ array_sum($total_old_price) }}</th>
					<th style="text-align: right">{{ array_sum($total_new_price) }}</th>
					<th style="text-align: right">
						{{ array_sum($total_difference) }}
						<input type="hidden" name="total_difference" value="{{ array_sum($total_difference) }}">
					</th>
				</tr>
			</tbody>
		</table>
	</div>
	<input type="hidden" name="customer_id" value="{{ $customer_id }}">
	<button type="submit" class="btn btn-success btn-block">SUBMIT</button>

</form>
<script type="text/javascript">

$("#van_selling_sku_price_adjustments_save").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "van_selling_sku_price_adjustments_save",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
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
								location.reload();
						}
          },
        });
    }));

</script>
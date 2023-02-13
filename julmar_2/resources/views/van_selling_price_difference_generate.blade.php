<form id="van_selling_price_difference_generate_final_summary">
	<div class='table table-responsive'>
		<table class="table table-bordered table-hover example2">
			<thead>
				<tr>
					<th>ID</th>
					<th>CODE</th>
					<th>DESC</th>
					<th>UOM</th>
					<th>QTY</th>
					<th>BUTAL QTY</th>
					<th>TOTAL QTY(<span style="color:blue">IF CASE</span>)</th>
					<th>U/P</th>
					<th>ORIG VL</th>
					<th>PRICE UPDATE</th>
				</tr>
			</thead>
			<tbody>
				@foreach($van_selling_ledger as $data)
					<tr>
						<td>
							{{ $data->customer_id }}
							<input type="hidden" name="customer_id[]" value="{{ $data->customer_id }}">
							<input type="hidden" name="id[{{ $data->customer_id }}][]" value="{{ $data->id }}">
						</td>
						<td>
							{{ $data->sku_code }}
							<input type="hidden" name="sku_code[{{ $data->customer_id }}][{{ $data->id }}]" value="{{ $data->sku_code }}">
						</td>
						<td>
							{{ $data->description }}
							<input type="hidden" name="description[{{ $data->customer_id }}][{{ $data->id }}]" value="{{ $data->description }}">
						</td>
						<td>
							{{ $data->unit_of_measurement }}
							<input type="hidden" name="unit_of_measurement[{{ $data->customer_id }}][{{ $data->id }}]" value="{{ $data->unit_of_measurement }}">
						</td>
						<td style="text-align: right;">
							{{ $data->total_van_load }}
							<input type="hidden" name="total_van_load[{{ $data->customer_id }}][{{ $data->id }}]" value="{{ $data->total_van_load }}">
						</td>
						<td style="text-align: right;">
							{{ $data->butal_equivalent }}
							<input type="hidden" name="butal_equivalent[{{ $data->customer_id }}][{{ $data->id }}]" value="{{ $data->butal_equivalent }}">
						</td>
						<td style="text-align: right;">
							@if($data->butal_equivalent != 0)
								@php
									echo $total_quantity = $data->total_van_load * $data->butal_equivalent;
								@endphp
							@else
								@php
									echo $total_quantity = $data->total_van_load;
								@endphp
							@endif
							<input type="hidden" name="total_quantity[{{ $data->customer_id }}][{{ $data->id }}]" value="{{ $total_quantity }}">
						</td>
						<td style="text-align: right;">
							{{ $data->unit_price }}
							<input type="hidden" name="unit_price[{{ $data->customer_id }}][{{ $data->id }}]" value="{{ $data->unit_price }}">
						</td>
						<td style="text-align: right;">
							{{ $total_quantity*$data->unit_price }}
							<input type="hidden" name="orig_vl_amount[{{ $data->customer_id }}][{{ $data->id }}]" value="{{ $total_quantity*$data->unit_price }}">
						</td>
						<td><input type="text" value="0" name="price_update[{{ $data->customer_id }}][{{ $data->id }}]" class="form-control" required style="text-align: center;"></td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<input type="hidden" name="date_from" value="{{ $date_from }}">
		<input type="hidden" name="date_to" value="{{ $date_to }}">
		<button type="submit" class="btn btn-block btn-info">PROCEED TO FINAL SUMMARY</button>
	</div>
	{{-- <h1 style="color:red;">UNDER CONTSTRUCTION</h1> --}}
</form>
<script type="text/javascript">
	$('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
    $('[class=integer-default]').maskNumber({integer: true});
    $('[class=integer-data-attribute]').maskNumber({integer: true});
    $('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});



    $("#van_selling_price_difference_generate_final_summary").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "van_selling_price_difference_generate_final_summary",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
             $('#van_selling_price_difference_generate_final_summary_page').html(data);
               $('.loading').hide();
          },
        });
    }));

    $(".example1").DataTable();
    $('.example2').DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": false,
    "autoWidth": false,
    });
</script>
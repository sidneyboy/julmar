<form id="van_selling_generate_final_summary">
	<div class="form-group">
		<label>Delivery Receipt:</label>
		<input type="texxt" name="delivery_receipt" class="form-control" required placeholder="Ex... VS-PFC-0001" style="text-transform: uppercase;">
	</div>
	@if($sku_type == 'Case' OR  $sku_type == 'CASE')
		<table class="table table-hovered table-bordered" id="example2">
			<thead>
				<tr>
					<th style="text-align: center;">CODE</th>
					<th style="text-align: center;">DESCRIPTION</th>
					<th style="text-align: center;">TYPE</th>
					<th style="text-align: center;">R-QTY</th>
					<th style="text-align: center;">QUANTITY</th>
					<th style="text-align: right;">PRICE</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sku as $data)
					<tr>
						<td>
							{{ $data->sku_code }}
							<input type="hidden" name="sku[]" value="{{ $data->id }}">
							<input type="hidden" name="sku_code[{{ $data->id }}]" value="{{ $data->sku_code }}">
						</td>
						<td>
							{{ $data->description }}
							<input type="hidden" name="description[{{ $data->id }}]" value="{{ $data->description }}">
						</td>
						<td style="text-transform: uppercase;">
							{{ $data->sku_type }}
							<input type="hidden" name="sku_type[{{ $data->id }}]" value="{{ $data->sku_type }}">
						</td>
						<td style="text-align: right;">
							@php
								$running_balance = $data->sku_ledger_quantity->running_balance;
							@endphp
							{{ number_format($data->sku_ledger_quantity->running_balance) }}
							<input type="hidden" name="running_balance[{{ $data->id }}]" value="{{ $running_balance }}">
						</td>
						<td ><input style="text-align: center;" type="number" min=0 value="0" name="quantity[{{ $data->id }}]" class="form-control" required></td>
						<td style="text-align: right;">
							@if($customer_principal_price->price_level == 'price_1')
								@php
									$price_butal = $sku_butal[$data->id]->sku_price_details_one->price_1;
									$price_case = $data->sku_price_details_one->price_1;
								@endphp
								
							@elseif($customer_principal_price->price_level == 'price_2')
								@php
									$price_butal = $sku_butal[$data->id]->sku_price_details_one->price_2;
									$price_case = $data->sku_price_details_one->price_2;
								@endphp
								
							@elseif($customer_principal_price->price_level == 'price_3')
								@php
									$price_butal = $sku_butal[$data->id]->sku_price_details_one->price_3;
									$price_case = $data->sku_price_details_one->price_3;
								@endphp
								
							@elseif($customer_principal_price->price_level == 'price_4')
								@php
									$price_butal = $sku_butal[$data->id]->sku_price_details_one->price_4;
									$price_case = $data->sku_price_details_one->price_4;
								@endphp
								
							@else
								@php
									$price_butal = $sku_butal[$data->id]->sku_price_details_one->price_5;
									$price_case = $data->sku_price_details_one->price_5;
								@endphp
								
							@endif
							
							<input type="text" style="display: block;
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
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center;"  name="price_butal[{{ $data->id }}]" value="{{ $price_butal }}">
							<input type="hidden" name="price_case[{{ $data->id }}]" value="{{ $price_case }}">
							<input type="hidden" name="equivalent_butal_pcs[{{ $data->id }}]" value="{{ $data->equivalent_butal_pcs }}">
						</td>
					</tr>
				@endforeach
				
			</tbody>
		</table>

		
		<input type="hidden" name="principal_id" value="{{ $principal_id }}">
		<input type="hidden" name="principal_name" value="{{ $principal_name }}">
		<input type="hidden" name="customer_id" value="{{ $customer }}">
		<input type="hidden" name="sku_type" value="{{ $sku_type }}">
		<input type="hidden" name="location_id" value="{{ $location_id }}">

		<button type="submit" class="btn btn-info btn-block">PROCEED TO FINAL SUMMARY</button>
	@else
		
		<table class="table table-hovered table-bordered" id="example2">
			<thead>
				<tr>
					<th style="text-align: center;">CODE</th>
					<th style="text-align: center;">DESCRIPTION</th>
					<th style="text-align: center;">TYPE</th>
					<th style="text-align: center;">R-QTY</th>
					<th style="text-align: center;">QUANTITY</th>
					<th style="text-align: right;">PRICE</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sku as $data)
					<tr>
						<td>
							{{ $data->sku_code }}
							<input type="hidden" name="sku[]" value="{{ $data->id }}">
							<input type="hidden" name="sku_code[{{ $data->id }}]" value="{{ $data->sku_code }}">
						</td>
						<td>
							{{ $data->description }}
							<input type="hidden" name="description[{{ $data->id }}]" value="{{ $data->description }}">
						</td>
						<td style="text-transform: uppercase;">
							{{ $data->sku_type }}
							<input type="hidden" name="sku_type[{{ $data->id }}]" value="{{ $data->sku_type }}">
						</td>
						<td style="text-align: right;">
							@php
								$running_balance = $data->sku_ledger_quantity->running_balance;
							@endphp
							{{ number_format($data->sku_ledger_quantity->running_balance) }}
							<input type="hidden" name="running_balance[{{ $data->id }}]" value="{{ $running_balance }}">
						</td>
						<td ><input style="text-align: center;" type="number" min=0 value="0" name="quantity[{{ $data->id }}]" class="form-control" required></td>
						<td style="text-align: right;">
							@if($customer_principal_price->price_level == 'price_1')
								@php
									$price_butal = $data->sku_price_details_one->price_1;
								@endphp
								
							@elseif($customer_principal_price->price_level == 'price_2')
								@php
									$price_butal = $data->sku_price_details_one->price_2;
								@endphp
								
							@elseif($customer_principal_price->price_level == 'price_3')
								@php
									$price_butal = $data->sku_price_details_one->price_3;
								@endphp
								
							@elseif($customer_principal_price->price_level == 'price_4')
								@php
									$price_butal = $data->sku_price_details_one->price_4;
								@endphp
								
							@else
								@php
									$price_butal = $data->sku_price_details_one->price_5;
								@endphp
								
							@endif
							<input type="text" style="display: block;
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
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-align: center;"  name="price_butal[{{ $data->id }}]" value="{{ $price_butal }}">
							<input type="hidden" name="equivalent_butal_pcs[{{ $data->id }}]" value="{{ $data->equivalent_butal_pcs }}">
						</td>
					</tr>
				@endforeach
				
			</tbody>
		</table>
		
		<input type="hidden" name="principal_id" value="{{ $principal_id }}">
		<input type="hidden" name="principal_name" value="{{ $principal_name }}">
		<input type="hidden" name="customer_id" value="{{ $customer }}">
		<input type="hidden" name="sku_type" value="{{ $sku_type }}">
		<input type="hidden" name="location_id" value="{{ $location_id }}">
		<button type="submit" class="btn btn-info btn-block">PROCEED TO FINAL SUMMARY</button>
	@endif


			
	
			
	
</form>


<script type="text/javascript">
	   $("#van_selling_generate_final_summary").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
      
        $.ajax({
          url: "van_selling_generate_final_summary",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
           
             if (data == 'quantity_is_greater') {
             	Swal.fire(
				  'ERROR INPUT',
				  'QUANTITY IS GREATER THAN RUNNING BALANCE',
				  'error'
				)
             	$('.loading').hide();
             }else if(data == 'existing'){
             	Swal.fire(
				  'CANNOT PROCEED',
				  'EXISTING DELIVERY RECEIPT',
				  'error'
				)
             	$('.loading').hide();
             }else{
             	$('#van_selling_generate_final_summary_page').html(data);
             	$('.loading').hide();
             }
          },
        });
    }));

	   $("#example1").DataTable();
    $('#example2').DataTable({
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    });


    $('[class=currency-default]').maskNumber();
    $('[class=currency-data-attributes]').maskNumber();
    $('[class=currency-configuration]').maskNumber({decimal: '_', thousands: '*'});
    $('[class=integer-default]').maskNumber({integer: true});
    $('[class=integer-data-attribute]').maskNumber({integer: true});
    $('[class=integer-configuration]').maskNumber({integer: true, thousands: '_'});
</script>



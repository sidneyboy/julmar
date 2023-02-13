<form id="van_selling_adjustments_final_summary">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-warning" role="alert">
			  Note: dili ta pwidi mag delete kai naka ledger ang atong van selling transactions so kong ma sayop ang isa ka sku mag butang lang tag 0 sa quantity. SALAMAT
			</div>
		</div>
	</div>
	<div class="table table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th style="text-align: center;" colspan="3">{{ $van_selling_printed->customer->store_name }} ({{ $van_selling_printed->date }})</th>
					<th style="text-align: center;" colspan="4">DR: {{ $van_selling_printed->delivery_receipt }}</th>
				</tr>
				<tr>
					<th>CODE</th>
					<th>DESCRIPTION</th>
					<th>UOM</th>
					<th>QTY</th>
					<th>BUTAL QTY</th>
					<th>ADJ QTY</th>
					<th>PRICE</th>
				</tr>
			</thead>
			<tbody>
				@foreach($van_selling_printed->van_selling_printed_details as $details)
				<tr>
					<td>
						{{ $details->sku->sku_code }}
						<input type="hidden" name="sku_code[{{ $details->sku_id }}]" value="{{  $details->sku->sku_code }}">
					</td>
					<td>
						{{ $details->sku->description }}
						<input type="hidden" name="description[{{ $details->sku_id }}]" value="{{ $details->sku->description }}">
					</td>
					<td>
						{{ $details->sku->unit_of_measurement }}
						<input type="hidden" name="uom[{{ $details->sku_id }}]" value="{{ $details->sku->unit_of_measurement }}">
					</td>
					<td>
						<input type="hidden" name="sku_id[]" value="{{ $details->sku_id }}">
						<input style="text-align: center" type="hidden" class="form-control" min="0" name="quantity[{{ $details->sku_id }}]" value="{{ $details->quantity }}">
						<input style="text-align: center" type="hidden" class="form-control" min="0" name="original_quantity[{{ $details->sku_id }}]" value="{{ $details->quantity }}">
						{{ $details->quantity }}
					</td>
					<td>
						{{ $details->butal_quantity }}
						<input type="hidden" name="butal_quantity[{{ $details->sku_id }}]" value="{{ $details->butal_quantity }}">
					</td>
					<td>
						<input type="number" class="form-control" name="adjustment_quantity[{{ $details->sku_id }}]" value="0" required>
					</td>
					<td>
						{{ $details->price }}
						<input type="hidden" name="price[{{ $details->sku_id }}]" value="{{ $details->price }}">
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<input type="hidden" name="van_selling_printed_id" value="{{ $van_selling_printed->id }}">
	<input type="hidden" name="sku_type" value="{{ $van_selling_printed->sku_type }}">
	<input type="hidden" name="delivery_receipt" value="{{ $van_selling_printed->delivery_receipt }}">
	<input type="hidden" name="customer_id" value="{{ $van_selling_printed->customer_id }}">
	<input type="hidden" name="principal_id" value="{{ $van_selling_printed->principal_id }}">
	<input type="hidden" name="principal_name" value="{{ $van_selling_printed->principal->principal }}">
	<input type="hidden" name="approved_by" value="{{ $check_access_key->name }}">
	<button type="submit" class="btn btn-info btn-block">PROCEED TO SUMMARY</button>
</form>

<script type="text/javascript">
	$('.select2').select2()


 $("#van_selling_adjustments_final_summary").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "van_selling_adjustments_final_summary",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            
            console.log(data);
            if(data == 'INCORRECT_ACCESS_KEY'){
              Swal.fire(
              'INCORRECT ACCESS KEY',
              'CANNOT PROCEED!',
              'error'
              )
              $('.loading').hide(); 
            }else{
              $('.loading').hide();
              $('#van_selling_adjustments_final_summary_page').html(data);
            }
          },
        });
    }));
</script>
<form id="pcm_manual_generate_final_summary">
	@csrf
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<td colspan="7">
					<input type="text" name="returned_by" class="form-control" placeholder="Return By..." required>
				</td>
			</tr>
			<tr>
				<th style="text-align: center;">CODE</th>
				<th style="text-align: center;">DESC</th>
				<th style="text-align: center;">UOM</th>
				<th style="text-align: center;">RGS QTY</th>
				<th style="text-align: center;">BO QTY</th>
				<th style="text-align: center;">U/P</th>
				<th style="text-align: center;">REMARKS</th>
			</tr>
		</thead>
		<tbody>
			@foreach($sales_invoice->sales_invoice_details as $data)
			<tr>
				<td>
					<input type="hidden" name="sku[]" value="{{ $data->sku_id }}">
					<input type="hidden" name="sku_code[{{ $data->sku_id }}]" value="{{ $data->sku->sku_code }}">
					{{ $data->sku->sku_code }}
				</td>
				<td>
					<input type="hidden" name="description[{{ $data->sku_id }}]" value="{{ $data->sku->description }}">
					{{ $data->sku->description }}
				</td>
				<td>
					<input type="hidden" name="unit_of_measurement[{{ $data->sku_id }}]" value="{{ $data->sku->unit_of_measurement }}">
					{{ $data->sku->unit_of_measurement }}
				</td>
				<td><input style="text-align: center" type="number" name="rgs_quantity[{{ $data->sku_id }}]" min="0" value="0" class="form-control"></td>
				<td><input style="text-align: center" type="number" name="bo_quantity[{{ $data->sku_id }}]" min="0" value="0" class="form-control"></td>
				<td>
					<input type="hidden" name="unit_price[{{ $data->sku_id }}]" value="{{ $data->unit_price }}">
					{{ number_format($data->unit_price,2,".",",")  }}
				</td>
				<td>
					<input type="text" name="remarks[{{ $data->sku_id }}]" class="form-control">
				</td>
			</tr>
			@endforeach
			<tfoot>
				<tr>
					<td colspan="7">
						<input type="hidden" name="agent_id" value="{{ $sales_invoice->agent_id }}">
						<input type="hidden" name="customer_id" value="{{ $sales_invoice->customer_id }}">
						<input type="hidden" name="principal_id" value="{{ $sales_invoice->principal_id }}">
						<input type="hidden" name="delivery_receipt" value="{{ $delivery_receipt }}">
						<button type="submit" class="btn btn-info btn-block">PROCEED TO FINAL SUMMARY</button>
					</td>
				</tr>
			</tfoot>
		</tbody>
	</table>
</form>

<script type="text/javascript">
  $("#pcm_manual_generate_final_summary").on('submit',(function(e){
      e.preventDefault();
    //   $('.loading').show();
        $.ajax({
          url: "pcm_manual_generate_final_summary",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
            $('.loading').hide();
            $('#pcm_manual_generate_final_summary_page').html(data);
          },
        });
    }));
</script>
<form id="van_selling_sku_price_adjustments_generate_final_summary">
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
						<td>{{ $data->price }}</td>
						<td>{{ $data->attributes->new_unit_price }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<input type="hidden" name="customer_id" value="{{ $customer_id }}">
	<button type="submit" class="btn btn-info btn-block">PROCEED TO FINAL SUMMARY</button>
</form>
<script type="text/javascript">

$("#van_selling_sku_price_adjustments_generate_final_summary").on('submit',(function(e){
      e.preventDefault();
      $('.loading').show();
        $.ajax({
          url: "van_selling_sku_price_adjustments_generate_final_summary",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            if(data == 'NO_DATA'){
               Swal.fire(
              'NO DATA FOUND',
              'NO DR FOR THE MOMENT',
              'error'
              )
              $('.loading').hide(); 
            }else{
              $('.loading').hide();
              $('#van_selling_sku_price_adjustments_generate_final_summary_page').html(data);
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


</script>
<form id="generate_dr_details">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<button type="submit" class="btn btn-info float-right">SHOW DR DETAILS</button>
			</div>
		</div>
	</div><br />
	<table class="table table-bordered table-hover" id="example1">
		<thead>
			<tr>
				<th>SALES ORDER #</th>
				<th>PRINCIPAL</th>
				<th>LOCATION</th>
				<th>SKU TYPE</th>
				<th>PRICE LEVEL</th>
				<th>SELECT</th>
			</tr>
		</thead>
		<tbody>
			@foreach($sales_order_agent_data as $data)
			<tr>
				<td>
					{{ $data->sales_order_number }}
				</td>
				<td>{{ $data->principal->principal }}</td>
				<td style="text-transform: uppercase;">{{ $data->location->location }}</td>
				<td>{{ $data->sku_type }}</td>
				<td>{{ $data->price_level }}</td>
				<td>
					<input type="radio" name="data_input" value="{{ $data->id .",". $data->sales_order_number .",". $data->principal->principal .",". $data->sku_type .",". $data->price_level  .",". $agent_name .",". $data->location->location }}" class="form-control">
					<input type="hidden" name="sales_order_number" value="{{ $data->sales_order_number }}">
					<input type="hidden" name="principal" value="{{ $data->principal->principal }}">
					<input type="hidden" name="sku_type" value="{{ $data->sku_type }}">
					<input type="hidden" name="price_level" value="{{ $data->price_level }}">
					<input type="hidden" name="agent_name" value="{{ $agent_name }}">
					<input type="hidden" name="location" value="{{ $data->location->location }}">
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</form>

<script type="text/javascript">
	$("#example1").DataTable();
	$('#example2').DataTable({
	"paging": false,
	"lengthChange": false,
	"searching": false,
	"ordering": true,
	"info": true,
	"autoWidth": false,
	});




  $("#generate_dr_details").on('submit',(function(e){
      e.preventDefault();
       //$('.loading').show();
     
        $.ajax({
          url: "sales_order_converted_report_show_dr",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
            console.log(data);
             $('.loading').hide();
            $('#sales_order_converted_report_show_dr').html(data);
          },
        });
    }));
</script>
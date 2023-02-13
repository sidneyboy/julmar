<form id="van_selling_inventory_export_admin_export_verify">
	<div class="table table-responsive">
		<table class="table table-bordered table-hover" id="export">
			<thead>
				<tr>
					<th>{{ $customer_data->store_name }}</th>
					<th>{{ $customer_data->id }}</th>
					<th>VAN SELLING ADMIN EXPORT DATA</th>
					<th>{{ $date }}</th>
					<th>VAN SELLING ADMIN EXPORT DATA-{{ $date."".$time }}</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				<tr>
					<th>TYPE</th>
					<th>PRINCIPAL</th>
					<th>CODE</th>
					<th>DESCRIPTION</th>
					<th>UOM</th>
					<th>QTY</th>
					<th>QUANTITY BUTAL</th>
					<th>PRICE</th>
					{{-- <th>SUB TOTAL</th> --}}
				</tr>
			</thead>
			@for ($i=0; $i < $counter; $i++)
			  @if($van_selling_ledger[$i]->beg + $van_selling_ledger[$i]->total_van_load - $van_selling_ledger[$i]->total_sales + $van_selling_ledger[$i]->total_adjustments - $van_selling_ledger[$i]->total_pcm + $van_selling_ledger[$i]->total_inventory_adjustments != 0)
				<tr>
					<td>{{ $sku_type_array[$i] }}</td>
					<td>{{ $van_selling_ledger[$i]->principal }}</td>
					<td>{{ $sku_code_array[$i] }}</td>
					<td>{{ $van_selling_ledger[$i]->description }}</td>
					<td>{{ $unit_of_measurement_array[$i] }}</td>
					<td>{{ $ending_array[$i] }}</td>
					@if($van_selling_ledger[$i]->sku_code == $sku_code_array[$i])
					<td style="text-align: right">
						{{ $butal_equivalent_array[$i] }}
					</td>
					@endif
					@if($van_selling_ledger[$i]->sku_code == $sku_code_array[$i])
					<td style="text-align: right">{{ $unit_price_array[$i] }}</td>
					@endif
				</tr>
				@endif
			@endfor
		</table>
	</div>
	@if(count($van_selling_printed) != 0)
		@foreach($van_selling_printed as $data)
			<input type="hidden" name="van_selling_printed[]" value="{{ $data->id }}">
		@endforeach
	@else
		<input type="hidden" name="van_selling_printed" value="{{ 0 }}">
	@endif
	<div class="row" id="hide_if_granted">
		<div class="col-md-6">
			<label>PLEASE ENTER SYSTEM ADMIN/AUDIT HEAD/OPERATIONS MANAGER SECRET KEY:</label>
			<input type="password" name="secret_key" placeholder="PLEASE ENTER ADMIN SECRET KEY" class="form-control" required>
		</div>
		<div class="col-md-6">
			<label>&nbsp;</label>
			<button type="submit" class="btn btn-block btn-info">PROCEED</button>
		</div>
	</div>
	<div class="row" id="show_if_granted" style="display: none;">
		<button id="click_if_trigger" class="btn btn-success btn-flat btn-sm btn-block" type="button" style="font-weight: bold;" onclick="exportTableToCSV('{{ 'VS-ADMIN EXPORT-'. strtoupper($customer_data->store_name) ."-". $date ."-". $time }}.csv')" >EXPORT NOW</button>
	</div>
</form>

<script type="text/javascript">
	$("#van_selling_inventory_export_admin_export_verify").on('submit',(function(e){
      e.preventDefault();
      //$('.loading').show();
        $.ajax({
          url: "van_selling_inventory_export_admin_export_verify",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
       //       if (data == 'access_denied') {
       //       	Swal.fire(
							//   'ACCESS DENIED',
							//   'CANNOT PROCEED',
							//   'error'
							// )
							// $('.loading').hide();
       //       }else if(data == 'access_granted'){
       //       	$('#hide_if_granted').hide();
       //       	$('#show_if_granted').show();
       //       	$('.loading').hide();
       //       	$('#click_if_trigger').click();
       //       	//exportTableToCSV();
       //       }
       	$('#hide_if_granted').hide();
             	$('#show_if_granted').show();
             	$('.loading').hide();
             	$('#click_if_trigger').click();
          },
        });
    }));

	function downloadCSV(csv, filename) {
      var csvFile;
      var downloadLink;

      // CSV file
      csvFile = new Blob([csv], {type: "text/csv"});

      // Download link
      downloadLink = document.createElement("a");

      // File name
      downloadLink.download = filename;

      // Create a link to the file
      downloadLink.href = window.URL.createObjectURL(csvFile);

      // Hide download link
      downloadLink.style.display = "none";

      // Add the link to DOM
      document.body.appendChild(downloadLink);

      // Click download link
      downloadLink.click();
  }

  function exportTableToCSV(filename) {
  	 $('.loading').show();
      var csv = [];
      var rows = document.querySelectorAll("#export tr");
      
      for (var i = 0; i < rows.length; i++) {
          var row = [], cols = rows[i].querySelectorAll("td, th");
          
          for (var j = 0; j < cols.length; j++) 
              row.push(cols[j].innerText);
          
          csv.push(row.join(","));        
      }

      // Download CSV file
      downloadCSV(csv.join("\n"), filename);
      location.reload();
  }
</script>
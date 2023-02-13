<form method="post" action="{{ route('van_selling_inventory_export_inventory_adjustments_save') }}">
	@csrf
	<div class="table table-responsive">
		<table class="table table-bordered table-hover" id="export">
			<thead>
				<tr>
					<th style="text-align:center;">{{ $van_selling_inventory_adjustments->customer_id }}</th>
					<th style="text-align: right;">ADJUSTMENT DATE:</th>
					<th style="text-align:center;">{{ $van_selling_inventory_adjustments->date }}</th>
					<th style="text-align:center;">{{ 'VAN SELLING INVENTORY ADJUSTMENTS' }}</th>
					<th style="text-align:center;">{{ 'VAN SELLING INVENTORY ADJUSTMENTS-'. $date ." ". $time }}</th>
					<th style="text-align:center;">
						{{ $van_selling_inventory_adjustments->customer->store_name }}
						@php
							$export_name = $van_selling_inventory_adjustments->customer->store_name;
						@endphp
					</th>
				</tr>
				<tr>
					<th>PRINCIPAL</th>
					<th>CODE</th>
					<th>DESCRIPTION</th>
					<th>END</th>
					<th>INVENTORY ADJUSTMENTS</th>
					<th>ACTUAL STOCKS ON HAND</th>
				</tr>
			</thead>
			<tbody>
				@foreach($van_selling_inventory_adjustments->van_selling_inventory_adjustments_details as $data)
					<tr>
	                    <td>{{ $data->principal }}</td>
	                    <td>{{ $data->sku_code }}</td>
	                    <td>{{ $data->description }}</td>
	                    <td style="text-align: right;">{{ $data->end }}</td>
	                    <td style="text-align: right;">{{ $data->inventory_adjustments }}</td>
	                    <td style="text-align: right;">{{ $data->actual_stocks_on_hand }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<input type="hidden" name="vs_inv_adj_id" value="{{ $van_selling_inventory_adjustments->id }}">
			<button class="btn btn-success btn-flat btn-sm btn-block" style="font-weight: bold;" onclick="exportTableToCSV('{{ 'VS-INVENTORY ADJUSTMENTS-'. $export_name ."-". $date ."-". $time }}.csv')">EXPORT NOW</button>
	    <button type="submit" id="trigger" style="display:none"></button>
	</div>
</form>

<script>
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
      document.getElementById("trigger").click();
  }
</script>
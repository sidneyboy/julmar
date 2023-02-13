{{-- <form action="{{ route('van_selling_adjustmnets_export_save') }}" method="post"> --}}
	@csrf
		<table class="table table-bordered table-hover" id="export_table">
			<thead>
				<tr>
					<th>CUSTOMER</th>
					<th>{{ $van_selling_adjustments->customer->store_name }}</th>
					<th>{{ $van_selling_adjustments->van_selling_printed->sku_type }}</th>
					<th>{{ $van_selling_adjustments->customer_id }}</th>
					<th>EXPORT CODE</th>
					<th>VSADJUSTMENTS-{{ $van_selling_adjustments->customer->store_name ."-". $date ."-". $time }}</th>
				</tr>
				<tr>
					<th style="text-align: center;">CODE</th>
					<th style="text-align: center;">DESCRIPTION</th>
					<th style="text-align: center;">BUTAL EQUIVALENT</th>
					<th style="text-align: center;">UOM</th>
					<th style="text-align: center;">QUANTITY</th>
					<th style="text-align: center;">PRICE</th>
				</tr>
			</thead>
			<tbody>
				@foreach($van_selling_adjustments->van_selling_adjustments_details as $data)
					<tr>
						<td style="text-align: center;">{{ $data->sku->sku_code }}</td>
						<td style="text-align: center;">{{ $data->sku->description }}</td>
						<td style="text-align: center;">{{ $data->sku->equivalent_butal_pcs}}</td>
						<td style="text-align: center;">{{ $data->sku->unit_of_measurement }}</td>
						<td style="text-align: right;">{{ $data->adjusted_quantity }}</td>
						<td style="text-align: right;">{{ $data->price }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
<input type="hidden" id="van_selling_adjustments_id" value="{{ $van_selling_adjustments->id }}">
<button class="btn btn-success btn-block" onclick="exportTableToCSV('VS-ADJUSTMENTS-{{ $van_selling_adjustments->customer->store_name ."-". $date }}.csv')">EXPORT TABLE DATA</button>

</form>
<script type="text/javascript">
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
	    var rows = document.querySelectorAll("#export_table tr");
	    
	    for (var i = 0; i < rows.length; i++) {
	        var row = [], cols = rows[i].querySelectorAll("td, th");
	        
	        for (var j = 0; j < cols.length; j++) 
	            row.push(cols[j].innerText);
	        
	        csv.push(row.join(","));        
	    }

	    // Download CSV file
	    downloadCSV(csv.join("\n"), filename);
	} 
	


</script>
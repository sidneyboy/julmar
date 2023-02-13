<div class="table table-responsive" id="printableArea">
	<table class="table table-bordered table-hover" id="export_table">
		<thead>
			<tr>
				<td style="text-align: center;">{{ $customer_id }}</td>
				<td style="text-align: center;">VAN SELLING UPDATED PRICE LIST</td>
				<td style="text-align: center;">{{ $export_customer_name ."-". $date ."-". $time }}</td>
			</tr>
			<tr>
				<th>CODE</th>
				<th>DESCRIPTION</th>
				<th>PRICE</th>
			</tr>
		</thead>
		<tbody>
			@for ($i=0; $i < $counter; $i++)
				<tr>
					<td>{{ $van_selling_ledger[$i]->sku_code }}</td>
					<td>{{ $van_selling_ledger[$i]->description }}</td>
					<td style="text-align: right">{{ $price[$i] }}</td>
				</tr>
	   		@endfor
		</tbody>
	</table>
</div>

<div class="row">
	<div class="col-md-6">
		<input type="button" class="btn btn-block btn-warning" onclick="printDiv('printableArea')" value="PRINT TABLE" />
	</div>
	<div class="col-md-6">
		<button class="btn btn-block btn-success" onclick="exportTableToCSV('{{ 'VS-PRICEUPDATE-'. $export_customer_name ."-". $date ."-". $time }}.csv')">EXPORT VS UPDATED PRICE LIST</button>
	</div>
</div>

<script type="text/javascript">
	function printDiv(divName) {
	     var printContents = document.getElementById(divName).innerHTML;
	     var originalContents = document.body.innerHTML;

	     document.body.innerHTML = printContents;

	     window.print();

	     document.body.innerHTML = originalContents;
	}

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
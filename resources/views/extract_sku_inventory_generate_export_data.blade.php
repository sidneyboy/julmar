	<table class="table table-bordered table-hover" id="export_sku_inventory">
		<thead>
			<tr>
				<th>ID</th>
				<th>Code</th>
				<th>Description</th>
				<th>Principal</th>
				<th>Principal ID</th>
				<th>Sku Type</th>
				<th>UOM</th>
				<th>Inventory</th>
				<th>P1</th>
				<th>P2</th>
				<th>P3</th>
				<th>P4</th>
			</tr>
		</thead>
		<tbody>
			@foreach($sku as $data)
			<tr>
				<td>{{ $data->id }}</td>
				<td>{{ $data->sku_code }}</td>
				<td>{{ $data->description }}</td>
				<td>{{ $data->skuPrincipal->principal }}</td>
				<td>{{ $data->principal_id }}</td>
				<td>{{ $data->sku_type }}</td>
				<td>{{ $data->unit_of_measurement }}</td>
				<td>{{ $data->sku_ledger_quantity->running_balance }}</td>
				<td>{{ $data->sku_price_details_one->price_1 }}</td>
				<td>{{ $data->sku_price_details_one->price_2 }}</td>
				<td>{{ $data->sku_price_details_one->price_3 }}</td>
				<td>{{ $data->sku_price_details_one->price_4 }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	{{-- <table id="export_sku_inventory" class="table table-sm" style="display: ;">
		<thead>
			<tr>
				<th>{{ $date ."". $time }}</th>
				<th>{{ $data->skuPrincipal->id }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($sku as $data)
			<tr>
				<td>{{ $data->id }}</td>
				<td>{{ $data->sku_code }}</td>
				<td>{{ $data->description }}</td>
				<td>{{ $data->sku_type }}</td>
				<td>{{ $data->skuPrincipal->id }}</td>
				<td>{{ $data->sku_ledger_quantity->running_balance }}</td>
				<td>{{ $data->sku_price_details_one->price_1 }}</td>
				<td>{{ $data->sku_price_details_one->price_2 }}</td>
				<td>{{ $data->sku_price_details_one->price_3 }}</td>
				<td>{{ $data->sku_price_details_one->price_4 }}</td>
				<td>{{ $data->unit_of_measurement }}</td>
			</tr>
			@endforeach
		</tbody>
	</table> --}}

<button class="btn btn-success btn-flat btn-sm btn-block" style="font-weight: bold;" onclick="exportTableToCSV('{{ 'SKU-'. $date ."". $time }}.csv')">EXPORT NOW</button>

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

	$('.loading').show();
	 
				
				    
	let timerInterval
	Swal.fire({
	  title: 'Extracting data!!',
	  html: 'Reloading page in <b></b> milliseconds.',
	  timer: 2000,
	  timerProgressBar: true,
	  didOpen: () => {
	    Swal.showLoading()
	    timerInterval = setInterval(() => {
	      const content = Swal.getContent()
	      if (content) {
	        const b = content.querySelector('b')
	        if (b) {
	          b.textContent = Swal.getTimerLeft()
	        }
	      }
	    }, 100)
	  },
	  willClose: () => {
	    clearInterval(timerInterval)
	  }
	}).then((result) => {
	  /* Read more about handling dismissals below */
	  if (result.dismiss === Swal.DismissReason.timer) {
		var csv = [];
		var rows = document.querySelectorAll("#export_sku_inventory tr");
		for (var i = 0; i < rows.length; i++) {
			var row = [], cols = rows[i].querySelectorAll("td, th");
			for (var j = 0; j < cols.length; j++)
				row.push(cols[j].innerText);
				csv.push(row.join(","));

		}
		downloadCSV(csv.join("\n"), filename);
		location.reload();
	  }
	})
}
</script>

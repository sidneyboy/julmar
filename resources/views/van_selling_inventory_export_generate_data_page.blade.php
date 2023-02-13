<form method="post" action="{{ route('van_selling_inventory_export_save') }}">
  @csrf
  <table class="table table-bordered table-hover" id="export">
    <thead>
      <tr>
        <th colspan="9" style="text-align: center;font-weight: bold;">VAN SELLING NEW INVENTORY</th>
      </tr>
      <tr>
        <th colspan="4" style="text-align: center;">
          {{ $customer_id }}
          <input type="hidden" name="customer_id" value="{{ $customer_id }}">
        </th>
        <th>{{ $customer->store_name }}</th>
        <th>{{ count($van_selling_printed) }}</th>
        <th colspan="3" style="text-align: center;">{{ $export_customer_name ."". $date ."". $time }}</th>
      </tr>
      @foreach($van_selling_printed as $data)
        <tr>
          <th>NEW VAN LOAD</th>
          <th>{{ $data->delivery_receipt }}</th>
          <th>{{ $data->principal->principal }}</th>
          <th>{{ $data->total_amount }}</th>
        </tr>  
      @endforeach
      <tr>
        <th>TYPE</th>
        <th>SKU ID</th>
        <th>PRINCIPAL</th>
        <th>CODE</th>
        <th>DESCRIPTION</th>
        <th>UOM</th>
        <th>QTY</th>
        <th>QUANTITY BUTAL</th>
        <th>PRICE</th>
      </tr>
    </thead>
    <tbody>
        @foreach($van_selling_printed as $data)
          @foreach($data->van_selling_printed_details as $details)
            <tr>
              <td>
                {{ $details->sku->sku_type }}
                <input type="hidden" name="van_selling_printed_id[]" value="{{ $data->id }}">
              </td>
              <td>{{ $details->sku_id }}</td>
              <td>{{ $data->principal->principal }}</td>
              <td>{{ $details->sku->sku_code }}</td>
              <td>{{ $details->sku->description }}</td>
              <td>{{ $details->sku->unit_of_measurement }}</td>
              <td>{{ $details->quantity }}</td>
              <td>{{ $details->butal_quantity }}</td>
              <td>{{ $details->price }}</td>
            </tr>
          @endforeach
        @endforeach
    </tbody>
  </table>

  <div class="form-group">
        <button class="btn btn-success btn-flat btn-sm btn-block" style="font-weight: bold;" onclick="exportTableToCSV('{{ 'VS-NEW VAN LOAD-'. $export_customer_name ."-". $date ."-". $time }}.csv')">EXPORT NOW</button>
        <button type="submit" id="trigger" style="display:none"></button>
  </div>
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
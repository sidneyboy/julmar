<div class="table table-responsive">
    <table class="table table-sm table-bordered table-hover table-striped" id="export_sales_register"
        style="text-align: center;">
        <thead>
            <tr>
                <th>{{ $sales_invoice->customer->store_name }}</th>
                <th>{{ $sales_invoice->principal->principal }}</th>
                <th>{{ $sales_invoice->agent->full_name }}</th>
                <th>SR-CODE</th>
                <th>TOTAL AMOUNT</th>
                <th>DR</th>
                <th>{{ $sales_invoice->date }}</th>
            </tr>
            <tr>
                <th>{{ $sales_invoice->customer_id }}</th>
                <th>{{ $sales_invoice->principal_id }}</th>
                <th>{{ $sales_invoice->agent_id }}</th>
                <th>{{ 'SR-' . $sales_invoice->customer_id . '' . $sales_invoice->id }}</th>
                <th>{{ $sales_invoice->total }}</th>
                <th>{{ $sales_invoice->delivery_receipt }}</th>
                <th>
                    @if ($sales_invoice->delivered_date != null)
                        {{ date('Y-m-d', strtotime($sales_invoice->delivered_date)) }}
                    @else
                        N/A
                    @endif
                </th>
                <th>{{ $sales_invoice->sku_type }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales_invoice->sales_invoice_details as $details)
                <tr>
                    <td>{{ $details->sku_id }}</td>
                    <td>{{ $details->quantity }}</td>
                    <td>{{ $details->unit_price }}</td>
                    <td>{{ $details->sku->sku_type }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-md-12">
        <button class="btn btn-success btn-sm float-right"
            onclick="exportTableToCSV('{{ strtoupper($sales_invoice->agent->full_name) .' - '. $sales_invoice->principal->principal . ' - ' . strtoupper($sales_register_store_name) . ' SALES REGISTER - ' . $date . '-' . $sales_invoice->sku_type }}.csv')">Export</button>
    </div>
</div>

<script type="text/javascript">
    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        // CSV file
        csvFile = new Blob([csv], {
            type: "text/csv"
        });

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

        //$('.loading').show();
        var csv = [];
        var rows = document.querySelectorAll("#export_sales_register tr");
        for (var i = 0; i < rows.length; i++) {
            var row = [],
                cols = rows[i].querySelectorAll("td, th");
            for (var j = 0; j < cols.length; j++)
                row.push(cols[j].innerText);
            csv.push(row.join(","));

        }
        downloadCSV(csv.join("\n"), filename);
    }
</script>

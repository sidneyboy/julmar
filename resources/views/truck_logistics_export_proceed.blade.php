<div class="table table-responsive">
    <table class="table table-bordered table-striped table-sm table-hover" id="export_sales_register"
        style="width:100%;font-size:13px;" id="example1">
        <thead>
            <tr>
                <th colspan="2">Prepared By: </th>
                <th colspan="11">{{ strtoupper($logistics->user->name) }}</th>
            </tr>
            <tr>
                <th colspan="2">Driver & Helper: </th>
                <th colspan="11">{{ strtoupper($logistics->load_sheet_driver->full_name) }},
                    {{ strtoupper($logistics->helper_1) }}, {{ strtoupper($logistics->helper_2) }}</th>
            </tr>
            <tr>
                <th colspan="2">Logistics ID</th>
                <th colspan="11">{{ $logistics->id }}</th>
            </tr>
            <tr>
                <th class="text-center">INVOICE ID</th>
                <th class="text-center">CUSTOMER ID</th>
                <th class="text-center">DELIVERY RECEIPT</th>
                <th class="text-center">OUTLET</th>
                <th class="text-center">SALES AREA</th>
                <th class="text-center">SALESMAN</th>
                <th class="text-center">ADDRESS</th>
                <th class="text-center">CASE</th>
                <th class="text-center">BUTAL</th>
                <th class="text-center">AMOUNT</th>
                <th class="text-center">TRANSACTION</th>
                <th class="text-center">PRINCIPAL</th>
                <th class="text-center">PRINCIPAL ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logistics->logistics_invoices as $details)
                @if ($details->status == null)
                    <tr>
                        <td>{{ $details->sales_invoice_id }}</td>
                        <td>{{ $details->sales_invoice->customer_id }}</td>
                        <td>{{ $details->sales_invoice->delivery_receipt }}</td>
                        <td>{{ $details->sales_invoice->customer->store_name }}</td>
                        <td>{{ $details->sales_invoice->customer->location_details->barangay }}</td>
                        <td>{{ $details->sales_invoice->agent->full_name }}</td>
                        <td>{{ $details->sales_invoice->customer->detailed_location }}</td>
                        <td style="text-align: right">{{ $details->case }}</td>
                        <td style="text-align: right">{{ $details->butal }}</td>
                        <td style="text-align: right">{{ $details->amount }}</td>
                        <td>{{ $details->sales_invoice->customer->mode_of_transaction }}</td>
                        <td>{{ $details->principal->principal }}</td>
                        <td>{{ $details->principal_id }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-md-12">
        <button class="btn btn-success btn-sm float-right"
            onclick="exportTableToCSV('LOAD SHEET - {{ $logistics->id . ' - ' . strtoupper($logistics->load_sheet_driver->full_name) . ' - ' . $date }}.csv')">Export</button>
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

<div class="table table-responsive">
    <table class="table table-bordered table-sm table-hover" id="export_sales_register">
        <thead>
            <tr>
                <td colspan="13">export_customer_applied_to_agent</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($customer_data as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->location_id }}</td>
                    <td>{{ $data->credit_line_amount }}</td>
                    <td>{{ str_replace(',','',$data->store_name)}}</td>
                    <td></td>
                    <td>
                        @if ($data->max_number_of_transactions == 0)
							1
                        @else
                            {{ $data->max_number_of_transactions }}
                        @endif
                    </td>
                    <td>{{ $data->special_account }}</td>
                    <td>{{ $data->mode_of_transaction }}</td>
                    <td>{{ $data->status }}</td>
					<td>{{ $data->kind_of_business }}</td>
					<td>{{ str_replace(',','',$data->contact_person) }}</td>
					<td>{{ $data->contact_number }}</td>
					<td>{{ str_replace(',','',$data->detailed_location) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="table table-bordered table-sm table-hover" id="export_principal_price_level">
        <thead>
            <tr>
                <th colspan="3">customer_principal_price</th>
            </tr>
            <tr>
                <th>Customer</th>
                <th>Principal</th>
                <th>Price Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customer_data as $data)
                @foreach ($data->customer_principal_price as $details)
                    <tr>
                        <td>{{ $details->customer_id }}</td>
                        <td>{{ $details->principal_id }}</td>
                        <td>{{ $details->price_level }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>


<div class="row">
    <div class="col-md-6">
        <button class="btn btn-success btn-block" style="font-weight: bold;"
            onclick="exportTableToCSV('customer_profile-{{ $date }}.csv')">EXPORT CUSTOMER</button>
    </div>
    <div class="col-md-6">
        <button class="btn btn-warning btn-block" style="font-weight: bold;"
            onclick="exportTableToCusTomerPrice('customer_profile_price_level-{{ $date }}.csv')">EXPORT CUSTOMER PRICE
            LEVEL</button>
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

    function exportTableToCusTomerPrice(filename) {

        //$('.loading').show();
        var csv = [];
        var rows = document.querySelectorAll("#export_principal_price_level tr");
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

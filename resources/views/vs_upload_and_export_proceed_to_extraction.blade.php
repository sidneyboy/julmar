<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm table-striped table-hover" id="extract_data">
        <thead>
            <tr>
                <th colspan="9">van_selling_customer_exported_from_main_system</th>
            </tr>
            <tr>
                <th>Location ID</th>
                <th>Store Name</th>
                <th>Store Type</th>
                <th>Barangay</th>
                <th>Address</th>
                <th>Contact Person</th>
                <th>Contact Number</th>
                <th>Latitude</th>
                <th>Longitude</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($van_selling_customer as $data)
                <tr>
                    <td>{{ $data->location_id }}</td>
                    <td>{{ $data->store_name }}</td>
                    <td>{{ $data->store_type }}</td>
                    <td>{{ $data->barangay }}</td>
                    <td>{{ $data->address }}</td>
                    <td>{{ $data->contact_person }}</td>
                    <td>{{ $data->contact_number }}</td>
                    <td>{{ $data->latitude }}</td>
                    <td>{{ $data->longitude }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<br />
<button class="btn btn-sm float-right btn-success"
    onclick="exportTableToCSV('VAN SELLING CUSTOMER MAIN SYSTEM - {{ $location->location }}.csv')">Export Van Selling
    Customer Data</button>


<script>
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
        var csv = [];
        var rows = document.querySelectorAll("#extract_data tr");

        for (var i = 0; i < rows.length; i++) {
            var row = [],
                cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++)
                row.push(cols[j].innerText);

            csv.push(row.join(","));
        }

        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
    }
</script>

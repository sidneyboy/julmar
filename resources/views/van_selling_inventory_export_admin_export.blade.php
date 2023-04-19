<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm table-striped" id="export">
        <thead>
            <tr>
                <th>{{ $customer->store_name }}</th>
                <th>{{ $customer->id }}</th>
                <th>VAN SELLING ADMIN EXPORT DATA</th>
                <th>{{ $date }}</th>
                <th>VAN SELLING ADMIN EXPORT DATA-{{ $date . '' . $time }}</th>
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
            </tr>
        </thead>
        <tbody>
            @foreach ($ledger as $data)
                <tr>
                    <td>{{ $sku[$data->sku_id]->sku_type }}</td>
                    <td>{{ $sku[$data->sku_id]->skuPrincipal->principal }}</td>
                    <td>{{ $sku[$data->sku_id]->sku_code }}</td>
                    <td>{{ $sku[$data->sku_id]->description }}</td>
                    <td>{{ $sku[$data->sku_id]->unit_of_measurement }}</td>
                    <td style="text-align: right">{{ $data->ending_inventory }}</td>
                    <td style="text-align: right">{{ $sku[$data->sku_id]->equivalent_butal_pcs }}</td>
                    <td style="text-align: right">{{ $data->unit_price }}</td>
                </tr>
            @endforeach
            {{-- @foreach ($sku_add as $sku_data)
                <tr>
                    <td>{{ $sku_data->sku_type }}</td>
                    <td>{{ $sku_data->skuPrincipal->principal }}</td>
                    <td>{{ $sku_data->sku_code }}</td>
                    <td>{{ $sku_data->description }}</td>
                    <td>{{ $sku_data->unit_of_measurement }}</td>
                    <td style="text-align: right">0</td>
                    <td style="text-align: right">{{ $sku_data->equivalent_butal_pcs }}</td>
                    <td>
                        @if ($sku_data->principal_id == )
                            
                        @else
                            
                        @endif
                    </td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>
</div>

<button id="click_if_trigger" class="btn btn-success btn-sm btn-block" type="button"
    onclick="exportTableToCSV('{{ 'VS-ADMIN EXPORT-' . strtoupper($customer->store_name) . '-' . $date . '-' . $time }}.csv')">EXPORT</button>

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
        $('.loading').show();
        var csv = [];
        var rows = document.querySelectorAll("#export tr");

        for (var i = 0; i < rows.length; i++) {
            var row = [],
                cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++)
                row.push(cols[j].innerText);

            csv.push(row.join(","));
        }

        // Download CSV file
        downloadCSV(csv.join("\n"), filename);
        location.reload();
    }
</script>

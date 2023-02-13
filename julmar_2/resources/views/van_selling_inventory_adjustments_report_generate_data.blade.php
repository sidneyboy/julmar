<div class="table table-responsive">
    <table id="table" class="table-sm" data-show-columns="true">
        <thead class="thead-light">
            <tr>
                <th>Date</th>
                <th>Salesman</th>
                <th>Code</th>
                <th>Principal</th>
                <th>Description</th>
                <th>Old Quantity</th>
                <th>Adjustments</th>
                <th>Quantity</th>
                <th>U/P</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @if (count($van_selling_inventory_adjustments) != 0)
                @foreach ($van_selling_inventory_adjustments as $data)
                    @foreach ($data->van_selling_inventory_adjustments_details as $details)
                        <tr>
                            <td>{{ $data->date }}</td>
                            <td>{{ $data->customer->store_name }}</td>
                            <td>{{ $details->sku_code }}</td>
                            <td>{{ $details->principal }}</td>
                            <td>{{ $details->description }}</td>
                            <td style="text-align: right">{{ $details->old_quantity }}</td>
                            <td style="text-align: right">{{ $details->adjusted_quantity }}</td>
                            <td style="text-align: right">
                                @php
                                    $final_quantity = $details->old_quantity + $details->adjusted_quantity;
                                @endphp
                                {{ $final_quantity }}
                            </td>
                            <td style="text-align: right">{{ $details->unit_price }}</td>
                            <td style="text-align: right">
                                {{ $details->unit_price * $final_quantity }}
                                @php
                                    $total[] = round($details->unit_price * $details->adjusted_quantity, 2);
                                @endphp
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @else
                @php
                    $total[] = 0;
                @endphp
            @endif
            <tr>
                <td>TOTAL ADJUSTMENTS</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right">{{ array_sum($total) }}</td>
            </tr>
        </tbody>
    </table>
    <br />
    <button type="button" class="btn btn-success btn-block"
        onclick="exportTableToCSV('{{ $store_name }} INVENTORY ADJUSTMENT REPORT {{ $date_from }} TO {{ $date_to }}.csv')">EXPORT
        INVENTORY ADJUSTMENT REPORT</button>

</div>

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
        var rows = document.querySelectorAll("#table tr");

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

    var $table = $('#table')

    function buildTable($el, cells, rows) {
        var i
        var j
        var row
        var columns = []
        var data = []

        var classes = $('.toolbar input:checked').next().text()

        $el.bootstrapTable('destroy').bootstrapTable({
            columns: columns,
            data: data,
            showFullscreen: true,
            search: true,
            stickyHeader: true,
            stickyHeaderOffsetLeft: parseInt($('body').css('padding-left'), 10),
            stickyHeaderOffsetRight: parseInt($('body').css('padding-right'), 10),
            theadClasses: classes
        })
    }
    $(function() {
        $('.toolbar input').change(function() {
            buildTable($table, 20, 50)
        })
        buildTable($table, 20, 50)
    })
</script>

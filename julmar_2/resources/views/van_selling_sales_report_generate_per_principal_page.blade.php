<div class="table table-responsive">
    <table class="table table-striped table-hover table-bordered" id="export_table" data-show-columns="true">
        <thead class="thead-light">    
            <tr>
                <th>SOLD TO</th>
                <th>DATE SOLD</th>
                <th>DATE UPLOADED</th>
                <th>LOCATION</th>
                <th>SALESMAN</th>
                <th>PRINCIPAL</th>
                <th>REFERENCE</th>
                <th>CODE</th>
                <th>DESCRIPTION</th>
                <th>UOM</th>
                <th>CASE QTY</th>
                <th>QTY BUTAL</th>
                <th>QTY CASE</th>
                <th>U/P</th>
                <th>SUB TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @if (count($van_selling_sales) != 0)
                @foreach ($van_selling_sales as $data)
                    <tr>
                        <td>{{ $data->store_name }}</td>
                        <td>{{ $data->date_sold }}</td>
                        <td>{{ $data->date }}</td>
                        <td>{{ $data->location }}</td>
                        <td>{{ $data->customer->store_name }}</td>
                        <td>{{ $data->principal }}</td>
                        <td>{{ $data->reference }}</td>
                        <td>{{ $data->sku_code }}</td>
                        <td>{{ $data->description }}</td>
                        <td>{{ $data->unit_of_measurement }}</td>
                        <td style="text-align: right">{{ $data->butal_equivalent }}</td>
                        <td style="text-align: right">{{ $data->sales }}</td>
                        <td style="text-align: right">
                            @if ($data->principal == 'EPI' or $data->principal == 'epi')
                                {{ 0 }}
                            @else
                                @php
                                    echo round($data->sales / $data->butal_equivalent, 2);
                                @endphp
                            @endif
                        </td>
                        <td style="text-align: right">
                            {{ round($data->unit_price, 2) }}
                        </td>
                        <td style="text-align: right">
                            @php
                                $sub_total = $data->unit_price * $data->sales;
                                $total_amount[] = $sub_total;
                                $total_quantity[] = $data->sales;
                                
                                echo round($sub_total, 2);
                            @endphp
                        </td>
                    </tr>
                @endforeach
            @else
                @php
                    $total_amount[] = 0;
                    $total_quantity[] = 0;
                @endphp
            @endif
            <tr>
                <th>TOTAL</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right;">{{ round(array_sum($total_amount), 2) }}</th>
            </tr>
        </tbody>
    </table>
    <br />
    <button class="btn btn-success btn-block"
        onclick="exportTableToCSV('{{ $store_name }} VAN SELLING SALES REPORT {{ $date_from . ' TO ' . $date_to }}.csv')">EXPORT
        DATA INTO EXCEL</button>
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
        var rows = document.querySelectorAll("#export_table tr");

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

    
    var $table = $('#export_table')

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

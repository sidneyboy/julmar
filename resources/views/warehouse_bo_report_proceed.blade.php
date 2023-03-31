<table class="table table-bordered table-sm table-striped table-hover" id="example1">
    <thead>
        <tr>
            <th>Date</th>
            <th>Sales Rep</th>
            <th>Principal</th>
            <th>SKU Type</th>
            <th>Desc</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bo as $data)
            @foreach ($data->bad_order_details as $details)
                <tr>
                    <td>{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                    <td>{{ $data->agent->full_name }}</td>
                    <td>{{ $data->principal->principal }}</td>
                    <td>{{ $data->sku_type }}</td>
                    <td>{{ $details->sku->sku_code }} - {{ $details->sku->description }}</td>
                    <td style="text-align: right;">
                        @php
                            $sum_quantity[] = $details->quantity;
                            echo $details->quantity;
                        @endphp
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Total Quantity</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th style="text-align: right;">{{ array_sum($sum_quantity) }}</th>
        </tr>
    </tfoot>
</table>

<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            responsive: true,
            paging: false,
            ordering: true,
            info: false,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>

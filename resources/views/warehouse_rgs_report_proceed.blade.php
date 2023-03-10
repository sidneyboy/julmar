<div class="table table-responsive">
    <table class="table table-bordered table-sm" id="example1">
        <thead>
            <tr>
                <th>Date</th>
                <th>Delivery Receipt</th>
                <th>Principal</th>
                <th>SKU Type</th>
                <th>Desc</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rgs as $data)
                @foreach ($data->return_good_stock_details as $details)
                    <tr>
                        <td>{{ date('F j, Y', strtotime($data->created_at)) }}</td>
                        <td>{{ $data->delivery_receipt }}</td>
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
</div>

<script>
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "paging": false,
        "buttons": [{
                extend: 'copyHtml5',
                footer: true
            },
            {
                extend: 'excelHtml5',
                footer: true
            },
            {
                extend: 'csvHtml5',
                footer: true
            },
            {
                extend: 'print',
                footer: true
            }
        ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>

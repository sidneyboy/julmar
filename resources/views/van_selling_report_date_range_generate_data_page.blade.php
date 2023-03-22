<div class="table table-responsive">
    <table class="table table->bordered table-sm table-hover" id="example1">
        <thead>
            <tr>
                <th>Principal</th>
                <th>Description</th>
                <th>Type</th>
                <th>Transaction</th>
                <th>Beginning</th>
                <th>Quantity</th>
                <th>Ending</th>
                <th>U/P</th>
                <th>Sub-Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sku_ledger as $data)
                <tr>
                    <td>{{ $sku[$data->sku_id]->skuPrincipal->principal }}</td>
                    <td><span style="color:green;font-weight:bold">{{ $sku[$data->sku_id]->sku_code }}</span> -
                        {{ $sku[$data->sku_id]->description }}</td>
                    <td>{{ $sku[$data->sku_id]->sku_type }}</td>
                    <td>{{ Str::ucfirst($data->transaction) }}</td>
                    <td style="text-align: right">{{ $data->beginning_inventory }}</td>
                    <td style="text-align: right">{{ $data->quantity }}</td>
                    <td style="text-align: right">{{ $data->ending_inventory }}</td>
                    <td style="text-align: right">
                        {{ number_format($data->unit_price, 2, '.', ',') }}
                    </td>
                    <td style="text-align: right">
                        @php
                            $total = $data->unit_price * $data->ending_inventory;
                            $sum_total[] = $total;
                            echo number_format($total, 2, '.', ',');
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right">
                    {{ number_format(array_sum($sum_total), 2, '.', ',') }}
                </th>
            </tr>
        </tfoot>
    </table>
</div>

<script>
    $("#example1").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "paging": false,
        "fixedHeader": true,
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

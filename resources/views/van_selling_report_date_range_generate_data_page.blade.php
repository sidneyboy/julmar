<div style="width:100%;">
    <table class="table table-sm table-hover table-bordered table-striped" id="example1">
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

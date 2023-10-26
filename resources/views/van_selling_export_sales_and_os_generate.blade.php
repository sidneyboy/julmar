@if ($report_type == 'os')
    <div style="width:100%;">
        <table class="table table-bordered table-hover table-sm table-striped" style="width:100%;font-size:13px;"
            id="example1">
            <thead>
                <tr>
                    <th>Remarks</th>
                    <th>Date</th>
                    <th>Salesman</th>
                    <th>Store Name</th>
                    <th>Principal</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Sku Type</th>
                    <th>Qty</th>
                    <th>U/P</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($van_data as $data)
                    <tr>
                        <td>OS</td>
                        <td>{{ $data->date }}</td>
                        <td>{{ $data->vs_os->customer->store_name }}</td>
                        <td>{{ $data->store_name }}</td>
                        <td>{{ $data->sku->skuPrincipal->principal }}</td>
                        <td>{{ $data->sku->sku_code }}</td>
                        <td>{{ $data->sku->description }}</td>
                        <td>{{ $data->sku->sku_type }}</td>
                        <td style="text-align: right">{{ $data->quantity }}</td>
                        <td style="text-align: right">{{ number_format($data->unit_price, 2, '.', ',') }}</td>
                        <td style="text-align: right">
                            @php
                                $sub_total = $data->quantity * $data->unit_price;
                                $sum_sub_total[] = $sub_total;
                            @endphp
                            {{ number_format($sub_total, 2, '.', ',') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@elseif($report_type == 'van_selling_sales')
    <div style="width:100%;">
        <table class="table table-bordered table-hover table-sm table-striped" style="width:100%;font-size:13px;"
            id="example1">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Principal</th>
                    <th>Sales Area</th>
                    <th>Detailed Area</th>
                    <th>Salesman</th>
                    <th>Reference</th>
                    <th>Store Name</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Sku Type</th>
                    <th>Qty</th>
                    <th>U/P</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($van_data as $data)
                    <tr>
                        <td>{{ $data->date_sold }}</td>
                        <td>{{ $data->principal->principal }}</td>
                        <td>{{ $data->location_details->location_van_selling_sales->location }}</td>
                        <td>{{ $data->area }}</td>
                        <td>{{ $data->customer->store_name }}</td>
                        <td>{{ $data->reference }}</td>
                        <td>{{ $data->customer_store_name }}</td>
                        <td>{{ $data->sku->sku_code }}</td>
                        <td>{{ $data->sku->description }}</td>
                        <td>{{ $data->sku->sku_type }}</td>
                        <td style="text-align: right">{{ $data->quantity }}</td>
                        <td style="text-align: right">
                            {{ number_format($data->unit_price,2,".",",") }}
                        </td>
                        <td>
                            @php
                                $sub_total = $data->quantity * $data->unit_price;
                                echo  number_format($sub_total,2,".",",")
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            responsive: true,
            paging: false,
            ordering: true,
            info: false,
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'csvHtml5',
            ]
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>

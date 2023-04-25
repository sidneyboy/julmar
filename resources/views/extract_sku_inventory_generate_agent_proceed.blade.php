<table class="table table-bordered table-hover table-sm table-striped" id="example1">
    <thead>
        <tr>
            <th>VAN SELLING INVENTORY</th>
            <th>ID</th>
            <th>Code</th>
            <th>Description</th>
            <th>Principal</th>
            <th>Sku Type</th>
            <th>UOM</th>
            <th>U/P</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($agent_price_level as $key => $data)
            @foreach ($data->principal->sku as $details)
                <tr>
                    <td>OS</td>
                    <td>{{ $details->id }}</td>
                    <td>{{ $details->sku_code }}</td>
                    <td>{{ $details->description }}</td>
                    <td>{{ $data->principal->principal }}</td>
                    <td>{{ $details->sku_type }}</td>
                    <td>{{ $details->unit_of_measurement }}</td>
                    <td style="text-align: right">
                        @if ($details->sku_price_details_one)
                            @if ($data->price_level == 'price_1')
                                {{ number_format($details->sku_price_details_one->price_1, 2, '.', ',') }}
                            @elseif($data->price_level == 'price_2')
                                {{ number_format($details->sku_price_details_one->price_2, 2, '.', ',') }}
                            @elseif($data->price_level == 'price_3')
                                {{ number_format($details->sku_price_details_one->price_3, 2, '.', ',') }}
                            @elseif($data->price_level == 'price_4')
                                {{ number_format($details->sku_price_details_one->price_4, 2, '.', ',') }}
                            @elseif($data->price_level == 'price_5')
                                {{ number_format($details->sku_price_details_one->price_5, 2, '.', ',') }}
                            @endif
                        @else
                            0
                        @endif
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            responsive: true,
            paging: false,
            ordering: true,
            info: false,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'csvHtml5',
                    title: 'Van Selling Inventory OS'
                },
                'copyHtml5',
                'excelHtml5',
                // 'pdfHtml5'
            ]
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>

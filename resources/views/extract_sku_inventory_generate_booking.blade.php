<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm table-striped" style="width:100%;font-size:13px;" id="example1">
        <thead>
            <tr>
                <th>BOOKING INVENTORY</th>
                <th>Principal</th>
                <th>Code</th>
                <th>Description</th>
                <th>Sku Type</th>
                <th>Unit of Measurement</th>
                <th>Inventory</th>
                <th>P1</th>
                <th>P2</th>
                <th>P3</th>
                <th>P4</th>
                <th>P5</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < count($sku_ledger); $i++)
                <tr>
                    <td>{{ $sku_ledger[$i]->sku_id }}</td>
                    <td>{{ $sku_ledger[$i]->principal_id }}</td>
                    <td>{{ $description[$i]->sku_code }}</td>
                    <td>{{ $description[$i]->description }}</td>
                    <td>{{ $description[$i]->sku_type }}</td>
                    <td>{{ $description[$i]->unit_of_measurement }}</td>
                    <td style="text-align: right">{{ $sku_ledger[$i]->running_balance }}</td>
                    <td style="text-align: right">
                        @if ($description[$i]->sku_price_details_one)
                            {{ $description[$i]->sku_price_details_one->price_1 }}
                        @else
                            0
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if ($description[$i]->sku_price_details_one)
                            {{ $description[$i]->sku_price_details_one->price_2 }}
                        @else
                            0
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if ($description[$i]->sku_price_details_one)
                            {{ $description[$i]->sku_price_details_one->price_3 }}
                        @else
                            0
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if ($description[$i]->sku_price_details_one)
                            {{ $description[$i]->sku_price_details_one->price_4 }}
                        @else
                            0
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if ($description[$i]->sku_price_details_one)
                            {{ $description[$i]->sku_price_details_one->price_5 }}
                        @else
                            0
                        @endif
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
    <input type="hidden" id="principal_name" value="{{ $principal_name->principal }}">
</div>

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
                    title: 'Van Selling Inventory OS',
                    filename: $('#principal_name').val() + '-BOOKING INVENTORY',
                },
                'copyHtml5',
                'excelHtml5',
                // 'pdfHtml5'
            ]
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>

<div class="table table-responsive">
    <table class="table table-bordered table-hover table-sm table-striped" style="width:100%;font-size:11px;"
        id="example1">
        <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Category</th>
                <th>Principal</th>
                <th>UOM</th>
                <th>Type</th>
                <th>Butal Equivalent</th>
                <th>Barcode</th>
                <th>Unit Cost</th>
                <th>Final Unit Cost</th>
                <th>P1</th>
                <th>P2</th>
                <th>P3</th>
                <th>P4</th>
                <th>P5</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sku as $data)
                <tr>
                    <td>{{ $data->sku_code }}</td>
                    <td>{{ $data->description }}</td>
                    <td>
                        @if ($data->skuCategory)
                            {{ $data->skuCategory->category }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $data->skuPrincipal->principal }}</td>
                    <td>{{ $data->unit_of_measurement }}</td>
                    <td>{{ $data->sku_type }}</td>
                    <td style="text-align: right">{{ $data->equivalent_butal_pcs }}</td>
                    <td style="text-align: right">{{ $data->barcode }}</td>
                    <td style="text-align: right">
                        @if ($data->sku_price_details_one)
                            {{ number_format($data->sku_price_details_one->unit_cost, 2, '.', ',') }}
                        @else
                            0
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if ($data->sku_price_details_one)
                            {{ number_format($data->sku_price_details_one->final_unit_cost, 2, '.', ',') }}
                        @else
                            0
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if ($data->sku_price_details_one)
                            {{ number_format($data->sku_price_details_one->price_1, 2, '.', ',') }}
                        @else
                            0
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if ($data->sku_price_details_one)
                            {{ number_format($data->sku_price_details_one->price_1, 2, '.', ',') }}
                        @else
                            0
                        @endif

                    </td>
                    <td style="text-align: right">
                        @if ($data->sku_price_details_one)
                            {{ number_format($data->sku_price_details_one->price_1, 2, '.', ',') }}
                        @else
                            0
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if ($data->sku_price_details_one)
                            {{ number_format($data->sku_price_details_one->price_1, 2, '.', ',') }}
                        @else
                            0
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if ($data->sku_price_details_one)
                            {{ number_format($data->sku_price_details_one->price_1, 2, '.', ',') }}
                        @else
                            0
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            responsive: true,
            paging: true,
            ordering: true,
            info: true,
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

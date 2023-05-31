<div class="table table-responsive">
    <table class="table table-sm table-striped table-bordered table-hover" style="width:100%;">
        <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>SKU Type</th>
                <th>QTY Case</th>
                <th>QTY Butal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales_invoice_details as $data)
                <tr>
                    <td>{{ $data->sku->sku_code }}</td>
                    <td>{{ $data->sku->description }}</td>
                    <td>
                        @if ($data->sku->sku_type == 'CASE')
                            <span style="font-weight:bold;color:blue">{{ $data->sku->sku_type }}</span>
                        @else
                            <span style="font-weight:bold;color:green">{{ $data->sku->sku_type }}</span>
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if ($data->sku->sku_type == 'CASE')
                            {{ $data->total }}
                            @php
                                $total_case[] = $data->total;
                            @endphp
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if ($data->sku->sku_type == 'BUTAL')
                            {{ $data->total }}
                            @php
                                $total_butal[] = $data->total;
                            @endphp
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right">
                    @if (count($total_case) != 0)
                        {{ array_sum($total_case) }}
                    @endif
                </th>
                <th style="text-align: right">
                    @if (count($total_butal) != 0)
                        {{ array_sum($total_butal) }}
                    @endif
                </th>
            </tr>
        </tfoot>
    </table>
</div>

<table class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th>No.</th>
            <th>Desc</th>
            
            <th>Qty</th>
            <th>U/P</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @if (count($top_10_sku_sales) != 0)
            @foreach ($top_10_sku_sales as $top_10_sku_sales_data)
                <tr>
                    <td style="text-align: center">
                        @php
                            echo $number_series;
                            $number_series++;
                        @endphp
                    </td>
                    <td>
                        {{ $top_10_sku_sales_data['description'] }} <br /> <span
                            style="color:blue">{{ $top_10_sku_sales_data['principal'] }}</span>
                        -
                        <span style="color:red">{{ $top_10_sku_sales_data['sku_code'] }}</span>

                    </td>
                    <td style="text-align: right">
                        {{ number_format($top_10_sku_sales_data['total_quantity']) }}
                    </td>
                    <td style="text-align: right">
                        {{ number_format($top_10_sku_sales_data['unit_price'], 2, '.', ',') }}
                    </td>
                    <td style="text-align: right">
                        {{ number_format($top_10_sku_sales_data['total_sales'], 2, '.', ',') }}
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <th colspan="5" style="text-align: center">NO DATA!</th>
            </tr>
        @endif
    </tbody>
</table>

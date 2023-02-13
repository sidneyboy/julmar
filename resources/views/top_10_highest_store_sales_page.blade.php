<table class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th>No.</th>
            <th>Location</th>
            <th>Store Name</th>
            <th>Sales</th>
        </tr>
    </thead>
    <tbody>
        @if (count($top_10_stores_sales) != 0)
            @foreach ($top_10_stores_sales as $store_sales)
                <tr>
                    <td style="text-align: center">
                        @php
                            echo $number_series;
                            $number_series++;
                        @endphp
                    </td>
                    <td>{{ $store_sales['location'] }}</td>
                    <td>{{ $store_sales['store_name'] }}</td>
                    <td style="text-align: right">
                        {{ number_format($store_sales['total_sales'], 2, '.', ',') }}
                        @php
                            $total[] = $store_sales['total_sales'];
                        @endphp
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" style="text-align: center">
                    NO DATA!
                    @php
                        $total[] = 0;
                    @endphp
                </td>
            </tr>
        @endif
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th style="text-align: right">{{ number_format(array_sum($total), 2, '.', ',') }}</th>
        </tr>
    </tfoot>
    </tbody>
</table>

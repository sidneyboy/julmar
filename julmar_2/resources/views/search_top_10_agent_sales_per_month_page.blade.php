<table class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th>No.</th>
            <th>Agent</th>
            <th>Sales</th>
        </tr>
    </thead>
    <tbody>
        @if ($top_10_agent_sales)
            @for ($i = 0; $i < count($top_10_agent_data); $i++)
                <tr>
                    <td style="text-align: center">
                        @php
                            echo $number_series;
                            $number_series++;
                        @endphp
                    </td>
                    <td>{{ $top_10_agent_data[$i]->store_name }}</td>
                    <td style="text-align: right">
                        {{ number_format($top_10_agent_sales[$i]['total_sales'], 2, '.', ',') }}
                        @php
                            $top_10_agent_sales_total[] = $top_10_agent_sales[$i]['total_sales'];
                        @endphp
                    </td>
                </tr>
            @endfor
        @else
            <tr>
                <td colspan="3" style="text-align: center">
                    NO DATA!
                    @php
                        $top_10_agent_sales_total[] = 0;
                    @endphp
                </td>
            </tr>
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th style="text-align:right">{{ number_format(array_sum($top_10_agent_sales_total), 2, '.', ',') }}</th>
        </tr>
    </tfoot>
</table>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<table class="table table-bordered table-hover table-sm">
    <thead>
        <tr>
            <th>SOLD TO</th>
            <th>PRINCIPAL</th>
            <th>REFERENCE</th>
            <th>CODE</th>
            <th>DESCRIPTION</th>
            <th>UOM</th>
            <th>BUTAL PER CASE</th>
            <th>BUTAL SOLD</th>
            <th>CASE SOLD</th>
            <th>U/P</th>
            <th>SUB TOTAL</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($van_selling_sales as $data)
            <tr>
                <td>{{ $data->store_name }}</td>
                <td>{{ $data->principal }}</td>
                <td>{{ $data->reference }}</td>
                <td>{{ $data->sku_code }}</td>
                <td>{{ $data->description }}</td>
                <td>{{ $data->unit_of_measurement }}</td>
                <td style="text-align: right">{{ $data->butal_equivalent }}</td>
                <td style="text-align: right">
                    {{ $data->sales }}
                </td>
                <td style="text-align: right">
                    @if ($data->principal == 'EPI' or $data->principal == 'epi')
                        {{ 0 }}
                    @else
                        @php
                            echo round($data->sales / $data->butal_equivalent, 2);
                        @endphp
                    @endif
                </td>
                <td style="text-align: right">
                    {{ round($data->unit_price, 2) }}
                </td>
                <td style="text-align: right">
                    @php
                        $sub_total = $data->unit_price * $data->sales;
                        $total_amount[] = $sub_total;
                        $total_quantity[] = $data->sales;
                        
                        echo round($sub_total, 2);
                    @endphp
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

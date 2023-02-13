<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="table table-responsive">

    <table class="table table-bordered table-hover">
        <thead style="position: sticky;top: 0" class="thead-dark">
            <tr>
                <th class="header">DATE</th>
                <th class="header">PRINCIPAL</th>
                <th class="header">CODE</th>
                <th class="header">DESCRIPTION</th>
                <th class="header">REFERENCE</th>
                <th class="header">BUTAL EQUIVALENT</th>
                <th class="header">QTY CASE</th>
                <th class="header">IN AS</th>
                <th class="header">SKU TYPE</th>
                <th class="header">BEG</th>
                <th class="header">T - VAN LOAD</th>
                <th class="header">T - SALES</th>
                <th class="header">ADJUSTMENTS</th>
                <th class="header">PCM</th>
                <th class="header">END</th>
                <th class="header">U/P</th>
                <th class="header">RUNNING BALANCE</th>
                <th class="header">REMARKS/USER</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($van_selling_ledger as $data)
                <tr>
                    <td>{{ $data->date }}</td>
                    <td>{{ $data->principal }}</td>
                    <td>{{ $data->sku_code }}</td>
                    <td>{{ $data->description }}</td>
                    <td>{{ $data->reference }}</td>
                    <td style="text-align: right">{{ $data->butal_equivalent }}</td>
                    <td style="text-align: right">
                        @if ($data->butal_equivalent == '0')
                            NO BUTAL EQUIVALENT
                        @else
                            {{ number_format(($data->beg + $data->van_load - $data->sales) / $data->butal_equivalent, 2, '.', ',') }}
                        @endif
                    </td>
                    <td style="text-transform: uppercase;">{{ $data->sku_type }}</td>
                    <td>BUTAL</td>
                    <td style="text-align: right;">{{ $data->beg }}</td>
                    <td style="text-align: right;">
                        {{ $data->van_load }}
                    </td>
                    <td style="text-align: right;">
                        ({{ $data->sales }})
                    </td>
                    <td style="text-align: right;">
                        @if ($data->inventory_adjustments < 0)
                            ({{ $data->inventory_adjustments }})
                        @else
                            {{ $data->inventory_adjustments }}
                        @endif
                    </td>
                    <td style="text-align: right;">
                        {{ $data->pcm }}
                    </td>
                    <td style="text-align: right;">
                        {{ $data->end }}
                    </td>
                    <td style="text-align: right;">{{ $data->unit_price }}</td>
                    <td style="text-align: right;">{{ $data->end * $data->unit_price }}
                    </td>
                    <td>{{ $data->remarks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

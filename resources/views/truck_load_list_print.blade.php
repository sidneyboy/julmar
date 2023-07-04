<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('adminLTE/dist/css/adminlte.min.css') }}">
    <title>Document</title>
</head>

<body>
    <br />
    <div class="container" style="width:50%;">
        <table class="table table-bordered table-sm" style="text-align: center;">
            <thead>
                <tr>
                    <th>JULMAR COMMERCIAL INC</th>
                </tr>
                <tr>
                    <th>ST. IGNATIUS ST. KAUSWAGAN, CAGAYAN DE ORO CITY</th>
                </tr>
                <tr>
                    <th>MISAMIS ORIENTAL</th>
                </tr>
                <tr>
                    <th>DISPATCHING TRIP TICKET FORM</th>
                </tr>
            </thead>
        </table>

        <table class="table table-sm table-striped table-bordered table-hover" style="width:100%;">
            <tbody>
                <tr>
                    <td style="width:200px;text-align:center;">TRUCKING COMPANY:</td>
                    <td style="text-align: center;" colspan="6">{{ $logistics->trucking_company }}</td>
                </tr>
                <tr>
                    <td style="text-align:center;">PLATE #:</td>
                    <td style="text-align: center;" colspan="6">{{ $logistics->truck->plate_no }}</td>
                </tr>
                <tr>
                    <td style="text-align:center;">DRIVER:</td>
                    <td style="text-align: center;" colspan="6">{{ $logistics->driver }}</td>
                </tr>
                <tr>
                    <td style="text-align:center;">DRIVER CONTACT #:</td>
                    <td style="text-align: center;" colspan="6">{{ $logistics->contact_number }}</td>
                </tr>
                <tr>
                    <td style="text-align:center;">HELPER 1:</td>
                    <td style="text-align: center;" colspan="6">{{ $logistics->helper_1 }}</td>
                </tr>
                <tr>
                    <td style="text-align:center;">HELPER 2:</td>
                    <td style="text-align: center;" colspan="6">{{ $logistics->helper_2 }}</td>
                </tr>
                <tr>
                    <td style="text-align:center;">TOTAL OUTLET/INVOICES:</td>
                    <td style="text-align: center;" colspan="6"> {{ $logistics->total_outlet }}
                        OUTLET(S)/{{ $logistics->number_of_invoices }} INVOICE(S)</td>
                </tr>
                <tr>
                    <td style="text-align:center;">TOTAL EXPENSE:</td>
                    <td style="text-align: center;" colspan="6">{{ $logistics->total_expense }}</td>
                </tr>
            </tbody>
        </table>
        <table class="table table-sm table-striped table-bordered table-hover" style="width:100%;">
            <thead>
                <tr style="background: orange">
                    <th style="text-align: center;">PRINCIPAL</th>
                    <th style="text-align: center;">CASE</th>
                    <th style="text-align: center;">BUTAL</th>
                    <th style="text-align: center;">CONVERSION</th>
                    <th style="text-align: center;">AMOUNT</th>
                    <th style="text-align: center;">WEIGHT</th>
                    <th style="text-align: center;">PERCENTAGE</th>
                    <th style="text-align: center;">EQUIVALENT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logistics->logistics_details as $data)
                    <tr>
                        <td style="text-align: center;">{{ $data->principal->principal }}</td>
                        <td style="text-align: right">
                            {{ $data->case }}
                            @php
                                $sum_case[] = $data->case;
                            @endphp
                        </td>
                        <td style="text-align: right">{{ $data->butal }}
                            @php
                                $sum_butal[] = $data->butal;
                            @endphp
                        </td>
                        <td style="text-align: right">{{ $data->conversion }}
                            @php
                                $sum_conversion[] = $data->conversion;
                            @endphp
                        </td>
                        <td style="text-align: right">{{ $data->amount }}
                            @php
                                $sum_amount[] = $data->amount;
                            @endphp
                        </td>
                        <td style="text-align: right">{{ $data->weight }}
                            @php
                                $sum_weight[] = $data->weight;
                            @endphp
                        </td>
                        <td style="text-align: right">{{ $data->percentage }}
                            @php
                                $sum_percentage[] = $data->percentage;
                            @endphp
                        </td>
                        <td style="text-align: right">{{ $data->equivalent }}
                            @php
                                $sum_equivalent[] = $data->equivalent;
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th style="text-align: center;">TOTAL</th>
                    <td style="text-align: right">{{ array_sum($sum_case) }}</td>
                    <td style="text-align: right">{{ array_sum($sum_butal) }}</td>
                    <td style="text-align: right">{{ array_sum($sum_conversion) }}</td>
                    <td style="text-align: right">{{ array_sum($sum_amount) }}</td>
                    <td style="text-align: right">{{ array_sum($sum_weight) }}</td>
                    <td style="text-align: right">{{ array_sum($sum_percentage) }}</td>
                    <td style="text-align: right">{{ array_sum($sum_equivalent) }}</td>
                </tr>
                <tr>
                    <td style="text-align: center">AREA</td>
                    <td colspan="7" style="text-align: center;">
                        @foreach ($logistics->location->location_details as $item)
                            {{ $item->barangay }},
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">LOADING </td>
                    <td colspan="7" style="text-align: center;">
                        {{ $logistics->loading_date }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">DEPARTURE </td>
                    <td colspan="7" style="text-align: center;">
                        {{ $logistics->departure_date }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">SG </td>
                    <td colspan="7" style="text-align: center;">
                        {{ $logistics->sg_departure_noted_by }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">ARRIVAL</td>
                    <td colspan="7" style="text-align: center;">
                        {{ $logistics->arrival_date }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">SG </td>
                    <td colspan="7" style="text-align: center;">
                        {{ $logistics->sg_arrival_noted_by }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">FUEL GIVEN </td>
                    <td colspan="7" style="text-align: center;">
                        {{ $logistics->fuel_given_amount }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">REMARKS</td>
                    <td colspan="7" style="text-align: center;">
                        {{ $logistics->remarks }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">PREPARED BY</td>
                    <td colspan="7" style="text-align: center;">
                        {{ $logistics->user->name }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>

<div class="table table-responsive">
    <table class="table table-sm table-striped table-bordered table-hover" style="width:100%;">
        <tbody>
            <tr>
                <td>TRUCKING COMPANY:</td>
                <td style="text-align: center;" colspan="6">JULMAR COMMERCIAL</td>
            </tr>
            <tr>
                <td>PLATE #:</td>
                <td style="text-align: center;" colspan="6">{{ $plate_no }}</td>
            </tr>
            <tr>
                <td>DRIVER:</td>
                <td style="text-align: center;" colspan="6">{{ $driver }}</td>
            </tr>
            <tr>
                <td>DRIVER CONTACT #:</td>
                <td style="text-align: center;" colspan="6">{{ $contact_number }}</td>
            </tr>
            <tr>
                <td>HELPER 1:</td>
                <td style="text-align: center;" colspan="6">{{ $helper_1 }}</td>
            </tr>
            <tr>
                <td>HELPER 2:</td>
                <td style="text-align: center;" colspan="6">{{ $helper_2 }}</td>
            </tr>
            <tr>
                <td>TOTAL OUTLET/INVOICES</td>
                <td style="text-align: center;" colspan="6"> {{ count($number_of_customers) }}
                    OUTLET(S)/{{ count($final_sales_invoice_id) }} INVOICE(S)</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="table table-responsive">
    <table class="table table-sm table-striped table-bordered table-hover" style="width:100%;">
        <thead>
            <tr style="background: orange">
                <th></th>
                <th style="text-align: center;">CASE</th>
                <th style="text-align: center;">BUTAL</th>
                <th style="text-align: center;">CONVERSION</th>
                <th style="text-align: center;">AMOUNT</th>
                <th style="text-align: center;">PERCENTAGE</th>
                <th style="text-align: center;">EQUIVALENT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($outlet as $outlet_data)
                <tr>
                    <td>TOTAL QTY/AMT {{ $outlet_data->principal->principal }}:</td>
                    {{-- <td style="text-align: right">{{ array_sum($total_quantity_per_case[$outlet_data->principal_id]) }}
                        @php
                            $sum_case[] = array_sum($total_quantity_per_case[$outlet_data->principal_id]);
                        @endphp
                    </td> --}}
                    <td style="text-align: right">
                        @if (array_sum($total_quantity_per_case[$outlet_data->principal_id]) != 0)
                            {{ array_sum($total_quantity_per_case[$outlet_data->principal_id]) }}
                            @php
                                $sum_case[] = array_sum($total_quantity_per_case[$outlet_data->principal_id]);
                            @endphp
                        @else
                            0
                            @php
                                $sum_case[] = 0;
                            @endphp
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if (array_sum($total_quantity_per_butal[$outlet_data->principal_id]) != 0)
                            {{ array_sum($total_quantity_per_butal[$outlet_data->principal_id]) }}
                            @php
                                $sum_butal[] = array_sum($total_quantity_per_butal[$outlet_data->principal_id]);
                            @endphp
                        @else
                            0
                            @php
                                $sum_butal[] = 0;
                            @endphp
                        @endif
                    </td>
                    <td style="text-align: right">
                        @if (isset($conversion_butal[$outlet_data->principal_id]))
                            @php
                                $conversion = array_sum($conversion_butal[$outlet_data->principal_id]);
                                echo number_format($conversion, 2, '.', ',');
                                $sum_conversion[] = $conversion;
                            @endphp
                        @else
                            @php
                                $conversion = 0;
                                echo number_format($conversion, 2, '.', ',');
                                $sum_conversion[] = $conversion;
                            @endphp
                        @endif
                    </td>
                    <td style="text-align: right">
                        @php
                            $amount = array_sum($total_amount_per_butal[$outlet_data->principal_id]) + array_sum($total_amount_per_case[$outlet_data->principal_id]);
                            echo number_format($amount, 2, '.', ',');
                            $sum_amount[] = $amount;
                        @endphp
                    </td>
                    <td style="text-align: right">
                        @php
                            $percentage = (array_sum($total_quantity_per_case[$outlet_data->principal_id]) + $conversion) / (array_sum($sum_total_quantity_per_case) + array_sum($sum_total_conversion));
                            echo number_format($percentage, 2, '.', ',');
                            $sum_percentage[] = $percentage;
                        @endphp
                    </td>
                    <td style="text-align: right">
                        {{ number_format($total_expense_per_delivery * $percentage, 2, '.', ',') }}
                        @php
                            $sum_equivalent[] = $total_expense_per_delivery * $percentage;
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background: yellowgreen">
                <th>OVERALL</th>
                <th style="text-align: right">{{ array_sum($sum_case) }}</th>
                <th style="text-align: right">{{ array_sum($sum_butal) }}</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_conversion), 2, '.', ',') }}</th>
                <th style="text-align: right">
                    {{ number_format(array_sum($sum_amount), 2, '.', ',') }}
                </th>
                <th style="text-align: right">
                    {{ number_format(array_sum($sum_percentage), 2, '.', ',') }}
                </th>
                <th style="text-align: right">
                    {{ number_format(array_sum($sum_equivalent), 2, '.', ',') }}
                </th>
            </tr>
            <tr>
                <th colspan="7" style="text-align: center;">{{ $detailed_location }}</th>
            </tr>
        </tfoot>
    </table>
</div>

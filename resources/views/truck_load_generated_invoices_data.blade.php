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
                <td style="text-align: center;" colspan="6">{{ count($sales_invoice_id) }} INVOICE(S)</td>
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
                    <td style="text-align: right">{{ $outlet_details_case[$outlet_data->principal_id][0]->total }}
                        @php
                            $sum_case[] = $outlet_details_case[$outlet_data->principal_id][0]->total;
                        @endphp
                    </td>
                    <td style="text-align: right">{{ $outlet_details_butal[$outlet_data->principal_id][0]->total }}
                        @php
                            $sum_butal[] = $outlet_details_butal[$outlet_data->principal_id][0]->total;
                        @endphp
                    </td>
                    <td></td>
                    @if ($outlet_details_case[$outlet_data->principal_id][0]->total_amount != 0)
                        <td style="text-align: right">
                            {{ number_format($outlet_details_case[$outlet_data->principal_id][0]->total_amount, 2, '.', ',') }}
                            @php
                                $sum_amount[] = $outlet_details_case[$outlet_data->principal_id][0]->total_amount;
                            @endphp
                        </td>
                    @elseif($outlet_details_butal[$outlet_data->principal_id][0]->total_amount != 0)
                        <td style="text-align: right">
                            {{ number_format($outlet_details_butal[$outlet_data->principal_id][0]->total_amount, 2, '.', ',') }}
                            @php
                                $sum_amount[] = $outlet_details_butal[$outlet_data->principal_id][0]->total_amount;
                            @endphp
                        </td>
                    @elseif(
                        $outlet_details_butal[$outlet_data->principal_id][0]->total_amount != 0 &&
                            $outlet_details_case[$outlet_data->principal_id][0]->total_amount != 0)
                        <td style="text-align: right">
                            {{ number_format($outlet_details_case[$outlet_data->principal_id][0]->total_amount + $outlet_details_butal[$outlet_data->principal_id][0]->total_amount, 2, '.', ',') }}
                            @php
                                $sum_amount[] = $outlet_details_case[$outlet_data->principal_id][0]->total_amount + $outlet_details_butal[$outlet_data->principal_id][0]->total_amount;
                            @endphp
                        </td>
                    @endif
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background: yellowgreen">
                <th>OVERALL</th>
                <th style="text-align: right">{{ array_sum($sum_case) }}</th>
                <th style="text-align: right">{{ array_sum($sum_butal) }}</th>
                <th></th>
                <th style="text-align: right">
                    {{ number_format(array_sum($sum_amount), 2, '.', ',') }}
                </th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th colspan="7" style="text-align: center;">{{ $detailed_location }}</th>
            </tr>
        </tfoot>
    </table>
</div>

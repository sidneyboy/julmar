<form id="truck_load_save">
    <div class="table table-responsive">
        <table class="table table-sm table-striped table-bordered table-hover" style="width:100%;">
            <tbody>
                <tr>
                    <td>TRUCKING COMPANY:</td>
                    <td style="text-align: center;" colspan="6">{{ $trucking_company }}</td>
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
                    <td style="text-align: center;" colspan="6">{{ $driver_data->contact_number }}</td>
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
                    <th style="text-align: center;">WEIGHT</th>
                    <th style="text-align: center;">PERCENTAGE</th>
                    <th style="text-align: center;">EQUIVALENT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($outlet as $outlet_data)
                    <tr>
                        <td>TOTAL QTY/AMT {{ $outlet_data->principal->principal }}:
                            <input type="hidden" name="principal_id[]" value="{{ $outlet_data->principal_id }}">
                        </td>
                        <td style="text-align: right">
                            @if (array_sum($total_quantity_per_case[$outlet_data->principal_id]) != 0)
                                @php
                                    $case = array_sum($total_quantity_per_case[$outlet_data->principal_id]);
                                    echo number_format($case, 2, '.', ',');
                                    $sum_case[] = array_sum($total_quantity_per_case[$outlet_data->principal_id]);
                                @endphp
                            @else
                                @php
                                    $case = 0;
                                    echo number_format($case, 2, '.', ',');
                                    $sum_case[] = 0;
                                @endphp
                            @endif
                            <input type="hidden" name="case[{{ $outlet_data->principal_id }}]"
                                value="{{ $case }}">
                        </td>
                        <td style="text-align: right">
                            @if (array_sum($total_quantity_per_butal[$outlet_data->principal_id]) != 0)
                                @php
                                    $butal = array_sum($total_quantity_per_butal[$outlet_data->principal_id]);
                                    echo number_format($butal, 2, '.', ',');
                                    $sum_butal[] = array_sum($total_quantity_per_butal[$outlet_data->principal_id]);
                                @endphp
                            @else
                                @php
                                    $butal = 0;
                                    echo number_format($butal, 2, '.', ',');
                                    $sum_butal[] = 0;
                                @endphp
                            @endif
                            <input type="hidden" name="butal[{{ $outlet_data->principal_id }}]"
                                value="{{ $butal }}">
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
                            <input type="hidden" name="conversion[{{ $outlet_data->principal_id }}]"
                                value="{{ $conversion }}">
                        </td>
                        <td style="text-align: right">
                            @php
                                $amount = array_sum($total_amount_per_butal[$outlet_data->principal_id]) + array_sum($total_amount_per_case[$outlet_data->principal_id]);
                                echo number_format($amount, 2, '.', ',');
                                $sum_amount[] = $amount;
                            @endphp
                            <input type="hidden" name="amount[{{ $outlet_data->principal_id }}]"
                                value="{{ $amount }}">
                        </td>
                        <td style="text-align: right">
                            @php
                                $kg = array_sum($total_kilogram_per_butal[$outlet_data->principal_id]) + array_sum($total_kilogram_per_case[$outlet_data->principal_id]);
                                echo number_format($kg, 2, '.', ',');
                                $sum_kg[] = $kg;
                            @endphp
                            <input type="hidden" name="weight[{{ $outlet_data->principal_id }}]"
                                value="{{ $kg }}">
                        </td>
                        <td style="text-align: right">
                            @php
                                $percentage = (array_sum($total_quantity_per_case[$outlet_data->principal_id]) + $conversion) / (array_sum($sum_total_quantity_per_case) + array_sum($sum_total_conversion));
                                echo number_format($percentage, 2, '.', ',');
                                $sum_percentage[] = $percentage;
                            @endphp
                            <input type="hidden" name="percentage[{{ $outlet_data->principal_id }}]"
                                value="{{ $percentage }}">
                        </td>
                        <td style="text-align: right">
                            @php
                                $equivalent = $total_expense_per_delivery * $percentage;
                                echo number_format($equivalent, 2, '.', ',');
                                $sum_equivalent[] = $equivalent;
                            @endphp
                            <input type="hidden" name="equivalent[{{ $outlet_data->principal_id }}]"
                                value="{{ $equivalent }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background: yellowgreen">
                    <th>OVERALL</th>
                    <th style="text-align: right">{{ array_sum($sum_case) }}
                        <input type="hidden" name="sum_case" value="{{ array_sum($sum_case) }}">
                        <input type="hidden" name="sum_conversion" value="{{ array_sum($sum_conversion) }}">
                    </th>
                    <th style="text-align: right">{{ array_sum($sum_butal) }}

                    </th>
                    <th style="text-align: right">{{ number_format(array_sum($sum_conversion), 2, '.', ',') }}</th>
                    <th style="text-align: right">
                        {{ number_format(array_sum($sum_amount), 2, '.', ',') }}
                    </th>
                    <th style="text-align: right">
                        {{ number_format(array_sum($sum_kg), 2, '.', ',') }}
                    </th>
                    <th style="text-align: right">
                        {{ number_format(array_sum($sum_percentage), 2, '.', ',') }}
                    </th>
                    <th style="text-align: right">
                        {{ number_format(array_sum($sum_equivalent), 2, '.', ',') }}
                    </th>
                </tr>
                <tr>
                    <th colspan="8" style="text-align: center;">{{ $detailed_location }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <input type="hidden" name="total_outlet" id="total_outlet" value="{{ count($number_of_customers) }}">
    <input type="hidden" name="number_of_invoices" id="number_of_invoices"
        value="{{ count($final_sales_invoice_id) }}">
    <input type="hidden" name="location_id" id="location_id" value="{{ $location_id }}">
    <input type="hidden" name="trucking_company" id="trucking_company" value="{{ $trucking_company }}">
    <input type="hidden" name="truck_primary_id" id="truck_primary_id" value="{{ $truck_primary_id }}">
    <input type="hidden" name="total_expense_per_delivery" id="total_expense_per_delivery"
        value="{{ $total_expense_per_delivery }}">
    <input type="hidden" name="driver" id="driver" value="{{ $driver }}">
    <input type="hidden" name="driver_id" id="driver_id" value="{{ $driver_id }}">
    <input type="hidden" name="contact_number" id="contact_number" value="{{ $driver_data->contact_number }}">
    <input type="hidden" name="helper_1" id="helper_1" value="{{ $helper_1 }}">
    <input type="hidden" name="helper_2" id="helper_2" value="{{ $helper_2 }}">
    @foreach ($cart as $item)
        <input type="hidden" name="sales_invoice_id[]" value="{{ $item->id }}">
    @endforeach
    <button class="btn btn-sm float-right btn-success" type="submit">Submit</button>
</form>

<script>
    $("#truck_load_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "truck_load_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                 Swal.fire({
                     position: 'top-end',
                     icon: 'success',
                     title: 'Your work has been saved',
                     showConfirmButton: false,
                     timer: 1500
                 });

                 location.reload();
            },
            error: function(error) {
                $('#loader').hide();
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));
</script>

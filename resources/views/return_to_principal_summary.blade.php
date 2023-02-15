<form id="return_to_principal_save">
    @if ($discount_type == 'type_a')
        <div class="table table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Desc</th>
                        <th>Qty</th>
                        <th>U/C</th>
                        <th>Amount</th>
                        <th style="text-align: center">Discount {{ $selected_discount_allocation->total_discount }}%</th>
                        <th style="text-align: center">BO Allowance
                            {{ $selected_discount_allocation->total_bo_allowance_discount }}%</th>
                        <th style="text-align: center">T.Discount<br />(VAT INC)</th>
                        <th style="text-align: center">Final Total Cost</th>
                        <th style="text-align: center">Final Unit Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($checkbox_entry as $data)
                        <tr>
                            <td>
                                <span style="color:green;font-weight:bold;">{{ $code[$data] }}</span>-
                                {{ $description[$data] }}
                            </td>
                            <td style="text-align: right">{{ $quantity[$data] }}</td>
                            <td style="text-align: right">{{ $unit_cost[$data] }}</td>
                            <td style="text-align: right">
                                @php
                                    $total_amount = $quantity[$data] * $unit_cost[$data];
                                    $sum_total_amount[] = $total_amount;
                                @endphp
                                {{ number_format($total_amount, 2, '.', ',') }}
                            </td>
                            <td style="text-align: right">
                                @php
                                    $discount = $total_amount * ($selected_discount_allocation->total_discount / 100);
                                    $sum_discount[] = $discount;
                                    echo number_format($discount, 2, '.', ',');
                                @endphp
                            </td>
                            <td style="text-align: right">
                                @php
                                    $bo_allowance_discount = $total_amount * ($selected_discount_allocation->total_bo_allowance_discount / 100);
                                    $sum_bo_allowance_discount[] = $bo_allowance_discount;
                                    echo number_format($bo_allowance_discount, 2, '.', ',');
                                @endphp
                            </td>
                            <td style="text-align: right">
                                @php
                                    $total_discount = $discount + $bo_allowance_discount;
                                    $sum_total_discount[] = $total_discount;
                                    echo number_format($total_discount, 2, '.', ',');
                                @endphp
                            </td>
                            <td style="text-align: right">
                                @php
                                    $final_total_cost = $total_amount - $total_discount;
                                    $sum_final_total_cost[] = $final_total_cost;
                                    echo number_format($final_total_cost, 2, '.', ',');
                                @endphp
                                {{-- <input type="hidden" name="final_total_cost_per_sku[{{ $data }}]"
                                value="{{ $final_total_cost }}"> --}}
                            </td>
                            <td style="text-align: right">
                                @php
                                    $final_unit_cost = $final_total_cost / $quantity[$data];
                                    $sum_final_unit_cost[] = $final_unit_cost;
                                @endphp
                                {{ number_format($final_unit_cost, 2, '.', ',') }}

                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th style="text-align: center;" colspan="3">GRAND TOTAL</th>
                        <th style="text-align: right;">
                            {{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}</th>
                        <th style="text-align: right;">{{ number_format(array_sum($sum_discount), 2, '.', ',') }}</th>
                        <th style="text-align: right;">
                            {{ number_format(array_sum($sum_bo_allowance_discount), 2, '.', ',') }}</th>
                        <th style="text-align: right;">{{ number_format(array_sum($sum_total_discount), 2, '.', ',') }}
                        </th>
                        <th style="text-align: right;">
                            {{ number_format(array_sum($sum_final_total_cost), 2, '.', ',') }}
                        </th>
                        <th style="text-align: right;">
                            {{ number_format(array_sum($sum_final_unit_cost), 2, '.', ',') }}
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>

        <table class="table table-bordered table-hover float-right table-sm" style="width:30%;">
            <tr>
                <td style="font-weight: bold; text-align: left;width:50%;">SUMMARY:</td>
                <td></td>
            </tr>
            <tr>
                <td style="font-weight: bold; text-align: left;width:50%;">VATABLE PURCHASE:</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;">
                    @php
                        $vatable_purchase = array_sum($sum_total_amount) / 1.12;
                    @endphp
                    {{ number_format($vatable_purchase, 2, '.', ',') }}

                </td>
            </tr>
            <tr>
                <td style="text-align: left;width:50%;">LESS: DISCOUNTS</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                    @php
                        $less_discount = array_sum($sum_total_discount) / 1.12;
                    @endphp
                    {{ number_format($less_discount * -1, 2, '.', ',') }}
                    <input type="text" value="{{ $less_discount }}" name="return_less_discount">
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">NET OF DISCOUNTS</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;">
                    @php
                        $net_discount = $vatable_purchase - $less_discount;
                    @endphp
                    {{ number_format($net_discount, 2, '.', ',') }}
                </td>
            </tr>
            <tr>
                <td>VAT AMOUNT</td>
                <td style="text-align: right;font-size: 15px;">
                    @php
                        $vat_amount = (array_sum($sum_final_total_cost) / 1.12) * 0.12;
                    @endphp
                    {{ number_format($vat_amount, 2, '.', ',') }}

                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">TOTAL FINAL COST</td>
                <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                    @php
                        $grand_total_final_cost = $net_discount + $vat_amount;
                    @endphp
                    {{ number_format($grand_total_final_cost, 2, '.', ',') }}

                </td>
            </tr>
        </table>

        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                    <th style="text-align: center;">DR</th>
                    <th style="text-align: center;">CR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">ACCOUNTS PAYABLE -
                        {{ $selected_discount_allocation->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;">
                        {{ number_format($grand_total_final_cost, 2, '.', ',') }}</td>
                    <td><input type="hidden" value="{{ $grand_total_final_cost }}" name="total_amount_return">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">INVENTORY -
                        {{ $selected_discount_allocation->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;">
                        {{ number_format($grand_total_final_cost, 2, '.', ',') }}</td>
                </tr>
            </tbody>
        </table>
    @elseif($discount_type == 'type_b')
        <div class="table table-responsive">
            <table class="table table-bordered table-sm table-hover">
                <thead>
                    <tr>
                        <th>Desc</th>
                        <th>Qty</th>
                        <th>U/C</th>
                        <th>Amount</th>
                        @foreach ($selected_discount_allocation->principal_discount_details as $data)
                            <th style="text-align: center;">{{ $data->discount_name }} ({{ $data->discount_rate }}%)
                            </th>
                        @endforeach
                        <th style="text-align:center;">BO Allowance
                            {{ $selected_discount_allocation->total_bo_allowance_discount }}</th>
                        <th>VAT</th>
                        <th style="text-align: center">T.Discount<br />(VAT INC)</th>
                        {{-- <th style="text-align: center">Freight</th> --}}
                        <th style="text-align: center">Final Total Cost</th>
                        <th style="text-align: center">Final Unit Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($checkbox_entry as $data)
                        <tr>
                            <td>
                                <span style="color:green;font-weight:bold;">{{ $code[$data] }}</span>-
                                {{ $description[$data] }}
                            </td>
                            <td style="text-align: right">{{ $quantity[$data] }}</td>
                            <td style="text-align: right">{{ number_format($unit_cost[$data], 2, '.', ',') }}</td>
                            <td style="text-align: right">
                                @php
                                    $total_amount = $quantity[$data] * $unit_cost[$data];
                                    $sum_total_amount[] = $total_amount;
                                @endphp
                                {{ number_format($total_amount, 2, '.', ',') }}
                            </td>
                            @php
                                $total = $total_amount;
                                
                                $discount_value_holder = $total;
                                $discount_value_holder_history = [];
                                $discount_value_holder_history_for_bo_allowance = [];
                                $totalArray = [];
                                $percent = [];
                                foreach ($selected_discount_allocation->principal_discount_details as $data_discount) {
                                    $discount_value_holder_dummy = $discount_value_holder;
                                    $less_percentage_by = $data_discount->discount_rate / 100;
                                
                                    $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                    $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                                
                                    $discount_value_holder_history[] = $discount_rate_answer;
                                    $discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                                    echo '<td style="text-align:right;">' . number_format($discount_rate_answer, 2, '.', ',') . '</td>';
                                }
                            @endphp
                            <td style="text-align: right">
                                @php
                                    $bo_allowance = end($discount_value_holder_history_for_bo_allowance) - end($discount_value_holder_history_for_bo_allowance) * ($selected_discount_allocation->total_bo_allowance_discount / 100);
                                    $bo_allowance_per_sku = end($discount_value_holder_history_for_bo_allowance) - $bo_allowance;
                                    $sum_bo_allowance_per_sku[] = $bo_allowance_per_sku;
                                @endphp
                                {{ number_format($bo_allowance_per_sku, 2, '.', ',') }}
                            </td>
                            <td style="text-align: right;">
                                @php
                                    
                                    $vat = ($total_amount - (array_sum($discount_value_holder_history) + $bo_allowance_per_sku)) * 0.12;
                                    $sum_vat_per_sku[] = $vat;
                                @endphp
                                {{ number_format($vat, 2, '.', ',') }}
                            </td>
                            <td style="text-align: right;">
                                @php
                                    $vat_inclusive_total_cost_per_sku = $bo_allowance * 1.12;
                                    $sum_vat_inclusive_total_cost_per_sku[] = $vat_inclusive_total_cost_per_sku;
                                @endphp
                                {{ number_format($vat_inclusive_total_cost_per_sku, 2, '.', ',') }}
                            </td>
                            {{-- <td style="text-align: right">
                            @php
                                $freight_per_sku = $freight * $quantity[$data];
                                $sum_freight_per_sku[] = $freight_per_sku;
                            @endphp
                            {{ number_format($freight_per_sku, 2, '.', ',') }}
                        </td> --}}
                            <td style="text-align: right">
                                @php
                                    // $final_total_cost_per_sku = $vat_inclusive_total_cost_per_sku + $freight_per_sku;
                                    $final_total_cost_per_sku = $vat_inclusive_total_cost_per_sku;
                                    $sum_final_total_cost_per_sku[] = $final_total_cost_per_sku;
                                @endphp
                                {{ number_format($final_total_cost_per_sku, 2, '.', ',') }}

                            </td>
                            <td style="text-align: right">
                                @php
                                    $final_unit_cost_per_sku = $final_total_cost_per_sku / $quantity[$data];
                                    $sum_final_unit_cost_per_sku[] = $final_unit_cost_per_sku;
                                @endphp
                                {{ number_format($final_unit_cost_per_sku, 2, '.', ',') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table table-bordered table-hover table-sm float-right" style="width:30%;">
                <tr>
                    <td style="font-weight: bold; text-align: left;width:50%;">SUMMARY:</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; text-align: left;width:50%;text-align: center;">GROSS PURCHASES:</td>
                    <td style="font-weight: bold; text-align: right;font-size: 15px;">
                        @php
                            $gross_purchase = array_sum($sum_total_amount);
                        @endphp
                        {{ number_format($gross_purchase, 2, '.', ',') }}
                    </td>
                </tr>
                @php
                    $total = $gross_purchase;
                    
                    $discount_value_holder = $total;
                    $discount_value_holder_history = [];
                    $less_discount_value_holder_history_for_bo_allowance = [];
                    $totalArray = [];
                    $percent = [];
                    foreach ($selected_discount_allocation->principal_discount_details as $data_discount) {
                        echo '<tr><td style="text-align:right"> Less ' . $data_discount->discount_rate / 100 . '% </td>';
                        $discount_value_holder_dummy = $discount_value_holder;
                        $less_percentage_by = $data_discount->discount_rate / 100;
                    
                        // $discount_value_holder = $discount_value_holder_dummy - ($discount_value_holder_dummy * $less_percentage_by);
                        $less_discount_rate_answer = $discount_value_holder * $less_percentage_by;
                        $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                    
                        $less_discount_value_holder_history[] = $less_discount_rate_answer;
                        $less_discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                        echo '<td style="text-align:right;">' . number_format($less_discount_rate_answer, 2, '.', ',') . '</td></tr>';
                    }
                @endphp
                <tr>
                    <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">TOTAL <br />DISCOUNT:
                    </td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        {{ number_format(array_sum($less_discount_value_holder_history), 2, '.', ',') }}
                        <input type="text" value="{{ array_sum($less_discount_value_holder_history) }}" name="return_less_discount">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">BO <br />ALLOWANCE:
                        {{ number_format($selected_discount_allocation->total_bo_allowance_discount, 2, '.', ',') }} %
                    </td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $less_bo_allowance = end($less_discount_value_holder_history_for_bo_allowance) - end($less_discount_value_holder_history_for_bo_allowance) * ($selected_discount_allocation->total_bo_allowance_discount / 100);
                            $less_bo_allowance_per_summary = end($less_discount_value_holder_history_for_bo_allowance) - $less_bo_allowance;
                        @endphp
                        {{ number_format($less_bo_allowance_per_summary, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">VATABLE<br />PURCHASE:
                    </td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $net_discount = $gross_purchase - (array_sum($less_discount_value_holder_history) + $less_bo_allowance_per_summary);
                        @endphp
                        {{ number_format($net_discount, 2, '.', ',') }}

                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">ADD VAT: 12%</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $less_vat = ($net_discount - $net_discount * 1.12) * -1;
                        @endphp
                        {{ number_format($less_vat, 2, '.', ',') }}

                    </td>
                </tr>
                {{-- <tr>
                    <td style="text-align: left;width:50%;font-weight: bold;text-align: center">FREIGHT</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $freight = array_sum($sum_freight_per_sku);
                            
                        @endphp
                        {{ number_format($freight, 2, '.', ',') }}

                    </td>
                </tr> --}}
                <tr>
                    <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">TOTAL</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;font-weight: bold">
                        @php
                            // $total = $gross_purchase - (array_sum($less_discount_value_holder_history) + $less_bo_allowance_per_summary);
                            // $grand_total_final_cost = $total + $less_vat + $freight;
                            $total = $gross_purchase - (array_sum($less_discount_value_holder_history) + $less_bo_allowance_per_summary);
                            $grand_total_final_cost = $total + $less_vat;
                            
                        @endphp
                        {{ number_format($grand_total_final_cost, 2, '.', ',') }}

                    </td>
                </tr>
            </table>


            <table class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                        <th style="text-align: center;">DR</th>
                        <th style="text-align: center;">CR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">ACCOUNTS PAYABLE -
                            {{ $selected_discount_allocation->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format($grand_total_final_cost, 2, '.', ',') }}</td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">INVENTORY -
                            {{ $selected_discount_allocation->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format($grand_total_final_cost, 2, '.', ',') }}</td>
                    </tr>
                </tbody>
            </table>

        </div>


    @endif

    <input type="hidden" value="{{ $principal_id }}" name="principal_id">
    <input type="hidden" value="{{ $received_id }}" name="received_id">
    <input type="hidden" value="{{ $personnel }}" name="personnel">
    <input type="hidden" value="{{ $discount_id }}" name="discount_id">
    <input type="hidden" value="{{ $grand_total_final_cost }}" name="total_amount_return">
    <input type="hidden" value="{{ $net_discount }}" name="return_vatable_purchase">
    <input type="hidden" value="{{ $net_discount }}" name="return_net_discount">
    
    <button class="btn btn-success btn-sm float-right" type="submit">Submit</button>

</form>

<script>
    $("#return_to_principal_save").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "return_to_principal_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {

            },
            error: function(error) {
                console.log(error);
            }
        });
    }));
</script>

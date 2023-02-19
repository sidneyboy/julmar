@if ($received_purchase_order->discount_type == 'type_a')
    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-hover">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Qty</th>
                    <th style="text-align: center;">U/C <br /> Adjustment</th>
                    <th style="text-align: center">Sub-Total<br />Amount(VAT EX)</th>
                    <th style="text-align: center">Vatable<br />Purchase</th>
                    <th style="text-align: center">Discount
                        @foreach ($received_purchase_order->received_discount_details as $data)
                            @php
                                $sum_discount_selected[] = $data->discount_rate;
                            @endphp
                        @endforeach
                        ({{ array_sum($sum_discount_selected) }}%)
                    </th>
                    <th style="text-align: center">Bo<br />Allowance</th>
                    <th style="text-align: center">Vat<br />Amount</th>
                    <th style="text-align: center">Net Adjustment<br />(VAT INC)</th>
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
                        <td style="text-align: right">
                            @php
                                $difference_of_new_and_old_unit_cost = $unit_cost_adjustment[$data] - $unit_cost[$data];
                                echo number_format($difference_of_new_and_old_unit_cost, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right;">
                            @php
                                $total_amount = $difference_of_new_and_old_unit_cost * $quantity[$data];
                                $sum_total_amount[] = $total_amount;
                            @endphp
                            {{ number_format($total_amount, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                $vatable_purchase = $total_amount / 1.12;
                                $sum_vatable_purchase[] = $vatable_purchase;
                            @endphp
                            {{ number_format($vatable_purchase, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                $discount = ($vatable_purchase * array_sum($sum_discount_selected)) / 100;
                                $sum_discount[] = $discount;
                            @endphp
                            {{ number_format($discount, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                $bo_allowance = ($vatable_purchase * $received_purchase_order->total_bo_allowance_discount_rate) / 100;
                                $sum_bo_allowance[] = $bo_allowance;
                            @endphp
                            {{ number_format($bo_allowance, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                $vat_amount = ($vatable_purchase - $discount - $bo_allowance) * 0.12;
                                $sum_vat_amount[] = $vat_amount;
                            @endphp
                            {{ number_format($vat_amount, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                $total_adjustment = $vatable_purchase - $discount - $bo_allowance + $vat_amount;
                                $sum_total_adjustment[] = $total_adjustment;
                            @endphp
                            {{ number_format($total_adjustment, 2, '.', ',') }}
                            <input type="hidden" name="total_adjustment[{{ $data }}]"
                                value="{{ $total_adjustment }}">
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
                    <td style="font-weight: bold;text-align: right;">
                        {{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}
                    </td>
                    <td style="font-weight: bold;text-align: right;">
                        {{ number_format(array_sum($sum_vatable_purchase), 2, '.', ',') }}
                    </td>
                    <td style="font-weight: bold;text-align: right;">
                        {{ number_format(array_sum($sum_discount), 2, '.', ',') }}
                    </td>
                    <td style="font-weight: bold;text-align: right;">
                        {{ number_format(array_sum($sum_bo_allowance), 2, '.', ',') }}
                    </td>
                    <td style="font-weight: bold;text-align: right;">
                        {{ number_format(array_sum($sum_vat_amount), 2, '.', ',') }}
                    </td>
                    <td style="font-weight: bold;text-align: right;">
                        {{ number_format(array_sum($sum_total_adjustment), 2, '.', ',') }}
                    </td>
                </tr>
            </tbody>
        </table>


    </div>

    <table class="table table-bordered table-hover table-sm float-right" style="width:30%">
        <tr>
            <td style="font-weight: bold; text-align: center;width:50%;" colspan="2">SUMMARY OF DEDUCTION</td>
        </tr>
        <tr>
            <td style="font-weight: bold; text-align: left;width:50%;">VATABLE PURCHASE:</td>
            <td style="font-weight: bold; text-align: right;font-size: 15px;">

                @php
                    $total_vatable_purchase = array_sum($sum_total_amount) / 1.12;
                @endphp
                {{ number_format($total_vatable_purchase, 2, '.', ',') }}
                <input type="hidden" name="total_vatable_purchase" value={{ $total_vatable_purchase }}>
            </td>
        </tr>
        <tr>
            <td style="text-align: left;width:50%;">LESS: DISCOUNTS</td>
            <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                @php
                    $total_less_discount = array_sum($sum_discount) + array_sum($sum_bo_allowance);
                @endphp
                {{ number_format($total_less_discount, 2, '.', ',') }}
                <input type="hidden" name="total_less_discount" value={{ $total_less_discount }}>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">NET OF DISCOUNTS</td>
            <td style="font-weight: bold; text-align: right;font-size: 15px;">
                @php
                    $total_net_discount = $total_vatable_purchase - $total_less_discount;
                @endphp
                {{ number_format($total_net_discount, 2, '.', ',') }}
                <input type="hidden" name="total_net_discount" value={{ $total_net_discount }}>
            </td>
        </tr>
        <tr>
            <td>VAT AMOUNT</td>
            <td style="text-align: right;font-size: 15px;">
                @php
                    $total_vat_amount = $total_net_discount * 0.12;
                @endphp
                {{ number_format($total_vat_amount, 2, '.', ',') }}
                <input type="hidden" name="total_vat_amount" value={{ $total_vat_amount }}>
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold;">NET ADJUSTMENT</td>
            <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                @php
                    $total_net_adjustment = $total_net_discount + $total_vat_amount;
                @endphp
                {{ number_format($total_net_adjustment, 2, '.', ',') }}
                <input type="hidden" name="total_net_adjustment" value={{ $total_net_adjustment }}>
            </td>
        </tr>
    </table>

    {{-- <input type="hidden" value="{{ $received_id }}" name="received_id">
    <input type="hidden" value="{{ $principal_name }}" name="principal_name"> --}}


    @if (array_sum($sum_total_adjustment) < 0)
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
                    <td style="text-align: center;">ACCOUNTS PAYABLE
                        {{ $received_purchase_order->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;">
                        {{ number_format(array_sum($sum_total_adjustment) * -1, 2, '.', ',') }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">INVENTORY -
                        {{ $received_purchase_order->principal->principal }}</td>
                    <td>
                        <input type="hidden" name="total_invoice_adjusted" value="{{ $total_net_adjustment }}">
                        <input type="hidden" name="total_bo_allowance" value="{{ array_sum($sum_bo_allowance) }}">
                    </td>
                    <td style="font-weight: bold;text-align: center;">
                        {{ number_format(array_sum($sum_total_adjustment) * -1, 2, '.', ',') }}


                    </td>
                </tr>
            </tbody>
        </table>
    @else
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
                    <td style="text-align: center;">INVENTORY {{ $received_purchase_order->principal->principal }}
                    </td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($sum_total_adjustment), 2, '.', ','); ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">ACCOUNTS PAYABLE -
                        {{ $received_purchase_order->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($sum_total_adjustment), 2, '.', ','); ?>
                        <input type="hidden" name="total_invoice_adjusted" value="{{ $total_net_adjustment }}">
                        <input type="hidden" name="total_bo_allowance" value="{{ array_sum($sum_bo_allowance) }}">
                    </td>
                </tr>
            </tbody>
        </table>
    @endif
@elseif($received_purchase_order->discount_type == 'type_b')
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Qty</th>
                    <th style="text-align: center;">U/C <br /> Adjustment</th>
                    <th style="text-align: center">Sub-Total<br />Amount(VAT EX)</th>
                    @foreach ($received_purchase_order->received_discount_details as $principal_discount)
                        <th style="text-align: center">
                            {{ $principal_discount->discount_name . ' ' . $principal_discount->discount_rate }}%</th>
                    @endforeach
                    <th style="text-align: center">Bo<br />Allowance</th>
                    <th style="text-align: center">Vat<br />Amount</th>
                    <th style="text-align: center">Net Adjustment<br />(VAT INC)</th>
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
                        <td style="text-align: right">
                            @php
                                $difference_of_new_and_old_unit_cost = $unit_cost_adjustment[$data] - $unit_cost[$data];
                                echo number_format($difference_of_new_and_old_unit_cost, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right;">
                            @php
                                $total_amount_per_sku = $difference_of_new_and_old_unit_cost * $quantity[$data];
                                $sum_total_amount_per_sku[] = $total_amount_per_sku;
                            @endphp
                            {{ number_format($total_amount_per_sku, 2, '.', ',') }}
                        </td>
                        @php
                            $total = $total_amount_per_sku;
                            
                            $discount_value_holder = $total;
                            $discount_value_holder_history = [];
                            $discount_value_holder_history_for_bo_allowance = [];
                            $totalArray = [];
                            $percent = [];
                            foreach ($received_purchase_order->received_discount_details as $principal_discount) {
                                $discount_value_holder_dummy = $discount_value_holder;
                                $less_percentage_by = $principal_discount->discount_rate / 100;
                            
                                // $discount_value_holder = $discount_value_holder_dummy - ($discount_value_holder_dummy * $less_percentage_by);
                                $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                            
                                $discount_value_holder_history[] = $discount_rate_answer;
                                $discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                                echo '<td style="text-align:right;">' . number_format($discount_rate_answer, 2, '.', ',') . '</td>';
                            }
                        @endphp
                        <td style="text-align: right;">
                            @php
                                $bo_allowance = end($discount_value_holder_history_for_bo_allowance) - end($discount_value_holder_history_for_bo_allowance) * ($received_purchase_order->total_bo_allowance_discount / 100);
                                $bo_allowance_per_sku = end($discount_value_holder_history_for_bo_allowance) - $bo_allowance;
                                $sum_bo_allowance_per_sku[] = $bo_allowance_per_sku;
                            @endphp
                            {{ number_format($bo_allowance_per_sku, 2, '.', ',') }}

                        </td>
                        <td style="text-align: right;">
                            @php
                                $vat = ($total_amount_per_sku - (array_sum($discount_value_holder_history) + $bo_allowance_per_sku)) * 0.12;
                                $sum_vat_per_sku[] = $vat;
                            @endphp
                            {{ number_format($vat, 2, '.', ',') }}
                        </td>
                        <td style="text-align: right;">
                            @php
                                $net_adjusted_amount = $bo_allowance * 1.12;
                                $sum_total_adjustment[] = $net_adjusted_amount;
                                
                            @endphp
                            {{ number_format($net_adjusted_amount, 2, '.', ',') }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: center;font-weight: bold">GRAND TOTAL</td>
                    <td style="font-weight: bold;text-align: right;">
                        {{ number_format(array_sum($sum_total_amount_per_sku), 2, '.', ',') }}
                    </td>
                    @php
                        $total_sum = array_sum($sum_total_amount_per_sku);
                        
                        $discount_value_holder_sum = $total_sum;
                        foreach ($received_purchase_order->received_discount_details as $principal_discount) {
                            $discount_value_holder_sum_dummy = $discount_value_holder_sum;
                            $less_percentage_by = $principal_discount->discount_rate / 100;
                        
                            $discount_rate_answer = $discount_value_holder_sum * $less_percentage_by;
                            $discount_value_holder_sum = $discount_value_holder_sum - $discount_value_holder_sum_dummy * $less_percentage_by;
                            echo '<td style="text-align:right;font-weight:bold;">' . number_format($discount_rate_answer, 2, '.', ',') . '</td>';
                        }
                    @endphp
                    <td style="font-weight: bold;text-align: right;">
                        {{ number_format(array_sum($sum_bo_allowance_per_sku), 2, '.', ',') }}
                    </td>
                    <td style="font-weight: bold;text-align: right;">
                        {{ number_format(array_sum($sum_vat_per_sku), 2, '.', ',') }}
                    </td>
                    <td style="font-weight: bold;text-align: right;">
                        {{ number_format(array_sum($sum_total_adjustment), 2, '.', ',') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <table class="table table-bordered table-hover table-sm float-right" style="width:30%;">
        <tr>
            <td style="font-weight: bold; text-align: center;width:50%;" colspan="2">SUMMARY OF DEDUCTION</td>
        </tr>
        <tr>
            <td style="font-weight: bold; text-align: left;width:50%;text-align: center;">GROSS:</td>
            <td style="font-weight: bold; text-align: right;font-size: 15px;">
                @php
                    $gross_purchase = array_sum($sum_total_amount_per_sku);
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
            foreach ($received_purchase_order->received_discount_details as $data_discount) {
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

            </td>
        </tr>
        <tr>
            <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">BO <br />ALLOWANCE:
                {{ number_format($received_purchase_order->total_bo_allowance_discount, 2, '.', ',') }} %</td>
            <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                @php
                    $less_bo_allowance = end($less_discount_value_holder_history_for_bo_allowance) - end($less_discount_value_holder_history_for_bo_allowance) * ($received_purchase_order->total_bo_allowance_discount / 100);
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
                    $vatable_purchase = $gross_purchase - (array_sum($less_discount_value_holder_history) + $less_bo_allowance_per_summary);
                @endphp
                {{ number_format($vatable_purchase, 2, '.', ',') }}
                <input type="hidden" name="total_vatable_purchase" value="{{ $vatable_purchase }}">
            </td>
        </tr>
        <tr>
            <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">ADD VAT: 12%</td>
            <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                @php
                    $less_vat = ($vatable_purchase - $vatable_purchase * 1.12) * -1;
                    
                @endphp
                {{ number_format($less_vat, 2, '.', ',') }}

            </td>
        </tr>
        <tr>
            <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">TOTAL NET ADJUSTMENT
            </td>
            <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;font-weight: bold">
                @php
                    $total = $gross_purchase - (array_sum($less_discount_value_holder_history) + $less_bo_allowance_per_summary);
                    $total_net_adjustment = $total + $less_vat;
                    
                @endphp
                {{ number_format($total_net_adjustment, 2, '.', ',') }}

            </td>
        </tr>
    </table>

    @if (array_sum($sum_total_adjustment) < 0)
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
                    <td style="text-align: center;">ACCOUNTS PAYABLE
                        {{ $received_purchase_order->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;">
                        {{ number_format(array_sum($sum_total_adjustment) * -1, 2, '.', ',') }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">INVENTORY -
                        {{ $received_purchase_order->principal->principal }}</td>
                    <td>
                        <input type="hidden" name="total_invoice_adjusted" value="{{ $total_net_adjustment }}">
                        <input type="hidden" name="total_bo_allowance"
                            value="{{ array_sum($sum_bo_allowance_per_sku) }}">
                    </td>
                    <td style="font-weight: bold;text-align: center;">
                        {{ number_format(array_sum($sum_total_adjustment) * -1, 2, '.', ',') }}


                    </td>
                </tr>
            </tbody>
        </table>
    @else
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
                    <td style="text-align: center;">INVENTORY
                        {{ $received_purchase_order->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($sum_total_adjustment), 2, '.', ','); ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">ACCOUNTS PAYABLE -
                        {{ $received_purchase_order->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($sum_total_adjustment), 2, '.', ','); ?>
                        <input type="hidden" name="total_invoice_adjusted" value="{{ $total_net_adjustment }}">
                        <input type="hidden" name="total_bo_allowance"
                            value="{{ array_sum($sum_bo_allowance_per_sku) }}">
                    </td>
                </tr>
            </tbody>
        </table>
    @endif


@endif

<form id="received_order_save">
    @csrf

    @if ($discount_type == 'type_a')
        <div class="table table-responsive">
            <table class="table table-bordered table-sm table-hover table-striped">
                <thead>
                    <tr>
                        <th>Desc</th>
                        <th>Received</th>
                        <th style="text-align: center;">U/C<br />(VAT EX)</th>
                        <th>Amount</th>
                        <th style="text-align: center">Discount
                            @foreach ($discount_selected as $data)
                                @php
                                    $sum_discount_selected[] = $data->discount_rate;
                                @endphp
                                <input type="hidden" name="discount_selected_name[]" value="{{ $data->discount_name }}">
                                <input type="hidden" name="discount_selected_rate[]" value="{{ $data->discount_rate }}">
                            @endforeach
                            ({{ array_sum($sum_discount_selected) }}%)
                        </th>
                        <th style="text-align: center">BO Allowance
                            ({{ $bo_allowance_discount_selected }}%)</th>
                        <th style="text-align: center">CWO
                            ({{ $cwo_discount_selected }}%)</th>
                        <th style="text-align: center">T.Discount<br /></th>
                        <th>VAT</th>
                        <th>Freight</th>
                        <th style="text-align: center">Final Total Cost</th>
                        <th style="text-align: center">Final Unit Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sku_id as $data)
                        <tr>
                            <td style="font-size:10px;">
                                <span style="color:green;font-weight:bold;">{{ $sku_code[$data] }}</span>-
                                {{ $description[$data] }}
                                <input type="hidden" value="{{ $data }}" name="sku_id[]">
                                <input type="hidden" value="{{ $received_quantity[$data] }}"
                                    name="received_quantity[{{ $data }}]">
                                <input type="hidden" value="{{ $unit_cost[$data] }}"
                                    name="unit_cost[{{ $data }}]">
                            </td>
                            <td style="text-align: right">{{ $received_quantity[$data] }}</td>
                            <td style="text-align: right">{{ number_format($unit_cost[$data], 2, '.', ',') }}</td>
                            <td style="text-align: right">
                                @php
                                    $total_amount = $received_quantity[$data] * $unit_cost[$data];
                                    $sum_total_amount[] = $total_amount;
                                @endphp
                                {{ number_format($total_amount, 2, '.', ',') }}
                            </td>
                            <td style="text-align: right">
                                @php
                                    $discount = $total_amount * (array_sum($sum_discount_selected) / 100);
                                    $sum_discount[] = $discount;
                                    echo number_format($discount, 2, '.', ',');
                                @endphp
                            </td>
                            <td style="text-align: right">
                                @php
                                    $bo_allowance_discount = $total_amount * ($bo_allowance_discount_selected / 100);
                                    $sum_bo_allowance_discount[] = $bo_allowance_discount;
                                    echo number_format($bo_allowance_discount, 2, '.', ',');
                                @endphp
                            </td>
                            <td style="text-align: right">
                                @php
                                    $cwo_discount = $total_amount * ($cwo_discount_selected / 100);
                                    $sum_cwo_discount[] = $cwo_discount;
                                    echo number_format($cwo_discount, 2, '.', ',');
                                @endphp
                            </td>
                            <td style="text-align: right">
                                @php
                                    $total_discount = $discount + $bo_allowance_discount + $cwo_discount;
                                    $sum_total_discount[] = $total_discount;
                                    echo number_format($total_discount, 2, '.', ',');
                                @endphp
                            </td>
                            <td style="text-align: right">
                                @php
                                    $vat_per_sku = ($total_amount - $total_discount) * 0.12;
                                    $sum_vat_per_sku[] = $vat_per_sku;
                                    echo number_format($vat_per_sku, 2, '.', ',');
                                @endphp
                            </td>
                            <td style="text-align: right">
                                @php
                                    $freight_per_sku = $freight[$data] * $received_quantity[$data];
                                    $sum_freight[] = $freight_per_sku;
                                    echo number_format($freight_per_sku, 2, '.', ',');
                                @endphp
                            </td>
                            <td style="text-align: right">
                                @php
                                    $final_total_cost = $total_amount - $total_discount + $vat_per_sku + $freight_per_sku;
                                    $sum_final_total_cost[] = $final_total_cost;
                                    echo number_format($final_total_cost, 2, '.', ',');
                                @endphp
                            </td>
                            <td style="text-align: right">
                                @php
                                    $final_unit_cost = $final_total_cost / $received_quantity[$data];
                                    $sum_final_unit_cost[] = $final_unit_cost;
                                @endphp
                                {{ number_format($final_unit_cost, 2, '.', ',') }}
                                <input type="hidden" name="final_unit_cost[{{ $data }}]"
                                    value="{{ $final_unit_cost }}">
                                <input type="hidden" name="freight_per_sku[{{ $data }}]"
                                    value="{{ $freight[$data] }}">
                                <input type="hidden" name="final_total_cost_per_sku[{{ $data }}]"
                                    value="{{ $final_total_cost }}">
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
                        <th style="text-align: right;">
                            {{ number_format(array_sum($sum_cwo_discount), 2, '.', ',') }}</th>
                        <th style="text-align: right;">{{ number_format(array_sum($sum_total_discount), 2, '.', ',') }}
                        </th>
                        <th style="text-align: right;">{{ number_format(array_sum($sum_vat_per_sku), 2, '.', ',') }}
                        </th>
                        <th style="text-align: right;">{{ number_format(array_sum($sum_freight), 2, '.', ',') }}
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


        @if (isset($less_other_discount_selected))
            <table class="table table-bordered table-hover float-right table-sm table-striped" style="width:35%;">
                <tr>
                    <td style="font-weight: bold; text-align: center;" colspan="2">FINAL SUMMARY OF DISCOUNTS:
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">GROSS PURCHASES:</td>
                    <td style="text-align: right;font-size: 15px;">
                        @php
                            $gross_purchases = array_sum($sum_total_amount);
                        @endphp
                        {{ number_format($gross_purchases, 2, '.', ',') }}

                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">LESS DISCOUNTS:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $less_discount = array_sum($sum_discount);
                        @endphp
                        {{ number_format($less_discount, 2, '.', ',') }}
                        <input type="hidden" name="total_less_discount" value="{{ $less_discount }}">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">BO DISCOUNTS:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $bo_discount = array_sum($sum_bo_allowance_discount);
                        @endphp
                        {{ number_format($bo_discount, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">CWO DISCOUNTS:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $cwo_discount_lower = array_sum($sum_cwo_discount);
                        @endphp
                        {{ number_format($cwo_discount_lower, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">VATABLE PURCHASE:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $vatable_purchase = $gross_purchases - $less_discount - $bo_discount - $cwo_discount_lower;
                        @endphp
                        {{ number_format($vatable_purchase, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">VAT:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $vat = $vatable_purchase * 0.12;
                        @endphp
                        {{ number_format($vat, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">FREIGHT:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $freight = array_sum($sum_freight);
                        @endphp
                        {{ number_format($freight, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">TOTAL FINAL COST:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $total_final_cost = $vatable_purchase + $vat + $freight;
                        @endphp
                        {{ number_format($total_final_cost, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <th>OTHER DISCOUNTS</th>
                </tr>
                @php
                    $total = $total_final_cost;
                    
                    $discount_value_holder = $total;
                    $discount_value_holder_history = [];
                    $less_discount_value_holder_history_for_bo_allowance = [];
                @endphp
                @foreach ($less_other_discount_selected as $data_discount)
                    @php
                        $discount_value_holder_dummy = $discount_value_holder;
                        $less_percentage_by = $data_discount->discount_rate / 100;
                        
                        $less_discount_rate_answer = $discount_value_holder * $less_percentage_by;
                        $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                        
                        $less_discount_value_holder_history[] = $less_discount_rate_answer;
                        $less_discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                    @endphp

                    {{ number_format($less_discount_rate_answer, 2, '.', ',') }}
                    <input type="hidden" name="less_other_discount_selected_name[]"
                        value="{{ $data_discount->discount_name }}">
                    <input type="hidden" name="less_other_discount_selected_rate[]"
                        value="{{ $data_discount->discount_rate }}">
                @endforeach
                <tr>
                    <td style="text-align: left;width:50%;">TOTAL OTHER DISCOUNT:</td>
                    <td style="text-align: right;font-size: 15px;border-top: solid 1px;">
                        @php
                            $total_other_discounts = array_sum($less_discount_value_holder_history);
                        @endphp
                        {{ number_format($total_other_discounts, 2, '.', ',') }}

                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">NET PAYABLE:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $net_payable = $total_final_cost - array_sum($less_discount_value_holder_history);
                        @endphp
                        {{ number_format($net_payable, 2, '.', ',') }}
                        <input type="hidden" value="{{ $net_payable }}" name="net_payable">
                        <input type="hidden" name="total_less_other_discount" value="{{ $total_other_discounts }}">

                    </td>
                </tr>
            </table>

            <table class="table table-bordered table-hover table-sm table-striped">
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
                            {{ $principal_name }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($net_payable, 2, '.', ','); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">ACCOUNTS PAYABLE
                            {{ $principal_name }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($net_payable, 2, '.', ','); ?></td>
                    </tr>
                </tbody>
            </table>
        @else
            <table class="table table-bordered table-hover float-right table-sm table-striped" style="width:35%;">
                <tr>
                    <td style="font-weight: bold; text-align: center;" colspan="2">FINAL SUMMARY OF DISCOUNTS:
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">GROSS PURCHASES:</td>
                    <td style="text-align: right;font-size: 15px;">
                        @php
                            $gross_purchases = array_sum($sum_total_amount);
                        @endphp
                        {{ number_format($gross_purchases, 2, '.', ',') }}

                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">LESS DISCOUNTS:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $less_discount = array_sum($sum_discount);
                        @endphp
                        {{ number_format($less_discount, 2, '.', ',') }}
                        <input type="hidden" name="total_less_discount" value="{{ $less_discount }}">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">BO DISCOUNTS:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $bo_discount = array_sum($sum_bo_allowance_discount);
                        @endphp
                        {{ number_format($bo_discount, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">CWO DISCOUNTS:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $cwo_discount_lower = array_sum($sum_cwo_discount);
                        @endphp
                        {{ number_format($cwo_discount_lower, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">VATABLE PURCHASE:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $vatable_purchase = $gross_purchases - $less_discount - $bo_discount - $cwo_discount_lower;
                        @endphp
                        {{ number_format($vatable_purchase, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">VAT:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $vat = $vatable_purchase * 0.12;
                        @endphp
                        {{ number_format($vat, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">FREIGHT:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $freight = array_sum($sum_freight);
                        @endphp
                        {{ number_format($freight, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">TOTAL FINAL COST:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $total_final_cost = $vatable_purchase + $vat + $freight;
                        @endphp
                        {{ number_format($total_final_cost, 2, '.', ',') }}
                        <input type="hidden" value="{{ 0 }}" name="net_payable">
                        <input type="hidden" name="total_less_other_discount" value="0">
                    </td>
                </tr>
            </table>

            <table class="table table-bordered table-hover table-sm table-striped">
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
                            {{ $principal_name }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost, 2, '.', ','); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">ACCOUNTS PAYABLE
                            {{ $principal_name }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost, 2, '.', ','); ?></td>
                    </tr>
                </tbody>
            </table>
        @endif
    @elseif($discount_type == 'type_b')
        <div class="table table-responsive">
            <table class="table table-bordered table-sm table-hover table-striped">
                <thead>
                    <tr>
                        <th>Desc</th>
                        <th>Received</th>
                        <th style="text-align: center;">U/C<br />(VAT EX)</th>
                        <th>Amount</th>
                        @foreach ($discount_selected as $data)
                            <th style="text-align: center;">{{ Str::ucfirst($data->discount_name) }}
                                ({{ $data->discount_rate }}%)
                            </th>
                            <input type="hidden" name="discount_selected_name[]"
                                value="{{ $data->discount_name }}">
                            <input type="hidden" name="discount_selected_rate[]"
                                value="{{ $data->discount_rate }}">
                        @endforeach
                        {{-- <th style="text-align: center">BO Allowance
                            ({{ $bo_allowance_discount_selected }}%)</th> --}}
                        <th style="text-align: center">T.Discount<br /></th>
                        <th>VAT</th>
                        <th style="text-align: center">Freight</th>
                        <th style="text-align: center">Final Total Cost</th>
                        <th style="text-align: center">Final Unit Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sku_id as $data)
                        <tr>
                            <td style="font-size:10px">
                                <span style="color:green;font-weight:bold;">{{ $sku_code[$data] }}</span>-
                                {{ $description[$data] }}
                                <input type="hidden" value="{{ $data }}" name="sku_id[]">
                                <input type="hidden" value="{{ $received_quantity[$data] }}"
                                    name="received_quantity[{{ $data }}]">
                                <input type="hidden" value="{{ $unit_cost[$data] }}"
                                    name="unit_cost[{{ $data }}]">

                            </td>
                            <td style="text-align: right">{{ $received_quantity[$data] }}</td>
                            <td style="text-align: right">{{ number_format($unit_cost[$data], 2, '.', ',') }}</td>
                            <td style="text-align: right">
                                @php
                                    $total_amount = $received_quantity[$data] * $unit_cost[$data];
                                    $sum_total_amount[] = $total_amount;
                                @endphp
                                {{ number_format($total_amount, 2, '.', ',') }}
                            </td>
                            @php
                                if ($total_amount != 0) {
                                    $total = $total_amount;
                                
                                    $discount_value_holder = $total;
                                    $discount_value_holder_history = [];
                                    $discount_value_holder_history_for_bo_allowance = [];
                                    $totalArray = [];
                                    $percent = [];
                                    foreach ($discount_selected as $data_discount) {
                                        $discount_value_holder_dummy = $discount_value_holder;
                                        $less_percentage_by = $data_discount->discount_rate / 100;
                                
                                        $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                        $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                                
                                        $discount_value_holder_history[] = $discount_rate_answer;
                                        $discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                                        echo '<td style="text-align:right;">' . number_format($discount_rate_answer, 2, '.', ',') . '</td>';
                                    }
                                } else {
                                    $total = $total_amount;
                                
                                    $discount_value_holder = $total;
                                    $discount_value_holder_history = [];
                                    $discount_value_holder_history_for_bo_allowance = [];
                                    $totalArray = [];
                                    $percent = [];
                                    foreach ($discount_selected as $data_discount) {
                                        $discount_value_holder_dummy = $discount_value_holder;
                                        $less_percentage_by = $data_discount->discount_rate / 100;
                                
                                        $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                        $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                                
                                        $discount_value_holder_history[] = 0;
                                        $discount_value_holder_history_for_bo_allowance[] = 0;
                                        echo '<td style="text-align:right;">' . number_format($discount_rate_answer, 2, '.', ',') . '</td>';
                                    }
                                }
                                
                            @endphp
                            @php
                                $bo_allowance = end($discount_value_holder_history_for_bo_allowance);
                                $bo_allowance_per_sku = end($discount_value_holder_history_for_bo_allowance) - $bo_allowance;
                                $sum_bo_allowance_per_sku[] = $bo_allowance_per_sku;
                            @endphp

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
                            <td style="text-align: right">
                                @php
                                    $freight_per_sku = $freight[$data] * $received_quantity[$data];
                                    $sum_freight_per_sku[] = $freight_per_sku;
                                @endphp
                                {{ number_format($freight_per_sku, 2, '.', ',') }}
                            </td>
                            <td style="text-align: right">
                                @php
                                    $final_total_cost_per_sku = $vat_inclusive_total_cost_per_sku + $freight_per_sku;
                                    $sum_final_total_cost_per_sku[] = $final_total_cost_per_sku;
                                @endphp
                                {{ number_format($final_total_cost_per_sku, 2, '.', ',') }}

                            </td>
                            <td style="text-align: right">
                                @php
                                    if ($received_quantity[$data] == 0) {
                                        $final_unit_cost_per_sku = 0;
                                    } else {
                                        $final_unit_cost_per_sku = $final_total_cost_per_sku / $received_quantity[$data];
                                    }
                                    
                                    $sum_final_unit_cost_per_sku[] = $final_unit_cost_per_sku;
                                @endphp
                                {{ number_format($final_unit_cost_per_sku, 2, '.', ',') }}
                                <input type="hidden" name="final_unit_cost[{{ $data }}]"
                                    value="{{ $final_unit_cost_per_sku }}">
                                <input type="hidden" name="freight_per_sku[{{ $data }}]"
                                    value="{{ $freight[$data] }}">
                                <input type="hidden" name="final_total_cost_per_sku[{{ $data }}]"
                                    value="{{ $final_total_cost_per_sku }}">
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="3" style="text-align: center;font-weight: bold">GRAND TOTAL</th>
                        <th style="text-align: right;font-weight: bold">
                            {{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}

                        </th>
                        @php
                            $total = array_sum($sum_total_amount);
                            
                            $discount_value_holder = $total;
                            $discount_value_holder_history = [];
                            
                            $totalArray = [];
                            $percent = [];
                            foreach ($discount_selected as $data_discount) {
                                $discount_value_holder_dummy = $discount_value_holder;
                                $less_percentage_by = $data_discount->discount_rate / 100;
                            
                                $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                            
                                $discount_value_holder_history[] = $discount_rate_answer;
                                echo '<th style="text-align:right;">' . number_format($discount_rate_answer, 2, '.', ',') . '</th>';
                            }
                            $cwo_discount_lower = end($discount_value_holder_history);
                            $bo_discount = prev($discount_value_holder_history);
                        @endphp

                        <th style="text-align: right;">
                            {{ number_format(array_sum($sum_vat_per_sku), 2, '.', ',') }}

                        </th>
                        <th style="text-align: right;">

                            {{ number_format(array_sum($sum_vat_inclusive_total_cost_per_sku), 2, '.', ',') }}
                        </th>
                        <th style="text-align: right;">
                            {{ number_format(array_sum($sum_freight_per_sku), 2, '.', ',') }}

                        </th>
                        <th style="text-align: right;">
                            {{ number_format(array_sum($sum_final_total_cost_per_sku), 2, '.', ',') }}

                        </th>
                        <th style="text-align: right;">
                            {{ number_format(array_sum($sum_final_unit_cost_per_sku), 2, '.', ',') }}

                        </th>
                    </tr>
                </tbody>
            </table>
        </div>

        @if (isset($less_other_discount_selected))
            <table class="table table-bordered table-hover table-sm float-right table-striped" style="width:35%;">
                <tr>
                    <td style="font-weight: bold; text-align: center;" colspan="2">FINAL SUMMARY OF DISCOUNTS:
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; text-align: left;width:50%;">GROSS PURCHASES:</td>
                    <td style="font-weight: bold; text-align: right;font-size: 15px;">
                        @php
                            $gross_purchases = array_sum($sum_total_amount);
                        @endphp
                        {{ number_format($gross_purchases, 2, '.', ',') }}
                    </td>
                </tr>
                @php
                    $total = $gross_purchases;
                    
                    $discount_value_holder = $total;
                    $discount_value_holder_history = [];
                    $less_discount_value_holder_history_for_bo_allowance = [];
                    $totalArray = [];
                    $percent = [];
                    foreach ($discount_selected as $data_discount) {
                        echo '<tr><td style="text-align:left">' . Str::ucfirst($data_discount->discount_name) . '(' . $data_discount->discount_rate / 100 . '%) </td>';
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
                <input type="text" name="total_less_discount"
                    value="{{ array_sum($less_discount_value_holder_history) }}">
                <tr>
                    <td style="text-align: left;width:50%;">VATABLE PURCHASE:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $vatable_purchase = $gross_purchases - array_sum($less_discount_value_holder_history);
                        @endphp
                        {{ number_format($vatable_purchase, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">VAT:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $vat = $vatable_purchase * 0.12;
                        @endphp
                        {{ number_format($vat, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">FREIGHT:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $freight = array_sum($sum_freight_per_sku);
                        @endphp
                        {{ number_format($freight, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">TOTAL FINAL COST:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;font-weight:bold">
                        @php
                            $total_final_cost = $vatable_purchase + $vat + $freight;
                        @endphp
                        {{ number_format($total_final_cost, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <th>OTHER DISCOUNTS</th>
                </tr>
                @php
                    $total = $total_final_cost;
                    
                    $discount_value_holder = $total;
                    $discount_value_holder_history = [];
                    $less_discount_value_holder_history_for_bo_allowance = [];
                @endphp
                @foreach ($less_other_discount_selected as $data_discount)
                    @php
                        $discount_value_holder_dummy = $discount_value_holder;
                        $less_percentage_by = $data_discount->discount_rate / 100;
                        
                        $less_discount_rate_answer = $discount_value_holder * $less_percentage_by;
                        $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                        
                        $less_discount_value_holder_history[] = $less_discount_rate_answer;
                        $less_discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                    @endphp

                    <input type="hidden" name="less_other_discount_selected_name[]"
                        value="{{ $data_discount->discount_name }}">
                    <input type="hidden" name="less_other_discount_selected_rate[]"
                        value="{{ $data_discount->discount_rate }}">
                @endforeach
                <tr>
                    <td style="text-align: left;width:50%;">TOTAL OTHER DISCOUNT:</td>
                    <td style="text-align: right;font-size: 15px;border-top: solid 1px;">
                        @php
                            $total_other_discounts = array_sum($less_discount_value_holder_history);
                        @endphp
                        {{ number_format($total_other_discounts, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">NET PAYABLE:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;font-weight:bold">
                        @php
                            $net_payable = $total_final_cost - array_sum($less_discount_value_holder_history);
                        @endphp
                        {{ number_format($net_payable, 2, '.', ',') }}
                        <input type="hidden" value="{{ $net_payable }}" name="net_payable">
                        <input type="hidden" name="total_less_other_discount"
                            value="{{ $total_other_discounts }}">
                    </td>
                </tr>
            </table>

            <table class="table table-bordered table-hover table-sm table-striped">
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
                            {{ $principal_name }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($net_payable, 2, '.', ','); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">ACCOUNTS PAYABLE
                            {{ $principal_name }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($net_payable, 2, '.', ','); ?></td>
                    </tr>
                </tbody>
            </table>
        @else
            <table class="table table-bordered table-hover table-sm float-right table-striped" style="width:35%;">
                <tr>
                    <td style="font-weight: bold; text-align: center;" colspan="2">FINAL SUMMARY OF DISCOUNTS:
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; text-align: left;width:50%;">GROSS PURCHASES:</td>
                    <td style="font-weight: bold; text-align: right;font-size: 15px;">
                        @php
                            $gross_purchases = array_sum($sum_total_amount);
                        @endphp
                        {{ number_format($gross_purchases, 2, '.', ',') }}
                    </td>
                </tr>
                @php
                    $total = $gross_purchases;
                    
                    $discount_value_holder = $total;
                    $discount_value_holder_history = [];
                    $less_discount_value_holder_history_for_bo_allowance = [];
                    $totalArray = [];
                    $percent = [];
                    foreach ($discount_selected as $data_discount) {
                        echo '<tr><td style="text-align:left">' . Str::ucfirst($data_discount->discount_name) . '(' . $data_discount->discount_rate / 100 . '%) </td>';
                        $discount_value_holder_dummy = $discount_value_holder;
                        $less_percentage_by = $data_discount->discount_rate / 100;
                    
                        $less_discount_rate_answer = $discount_value_holder * $less_percentage_by;
                        $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                    
                        $less_discount_value_holder_history[] = $less_discount_rate_answer;
                        $less_discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                        echo '<td style="text-align:right;">' . number_format($less_discount_rate_answer, 2, '.', ',') . '</td></tr>';
                    }
                @endphp

                <input type="hidden" name="total_less_discount"
                    value="{{ array_sum($less_discount_value_holder_history) }}">

                <tr>
                    <td style="text-align: left;width:50%;">VATABLE PURCHASE:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $vatable_purchase = $gross_purchases - array_sum($less_discount_value_holder_history);
                        @endphp
                        {{ number_format($vatable_purchase, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">VAT:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $vat = $vatable_purchase * 0.12;
                        @endphp
                        {{ number_format($vat, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">FREIGHT:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $freight = array_sum($sum_freight_per_sku);
                        @endphp
                        {{ number_format($freight, 2, '.', ',') }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;">TOTAL FINAL COST:</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;font-weight:bold">
                        @php
                            $total_final_cost = $vatable_purchase + $vat + $freight;
                        @endphp
                        {{ number_format($total_final_cost, 2, '.', ',') }}
                    </td>
                    <input type="hidden" value="0" name="net_payable">
                    <input type="hidden" name="total_less_other_discount" value="0">
                </tr>
            </table>

            <table class="table table-bordered table-hover table-sm table-striped">
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
                            {{ $principal_name }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost, 2, '.', ','); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">ACCOUNTS PAYABLE
                            {{ $principal_name }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost, 2, '.', ','); ?></td>
                    </tr>
                </tbody>
            </table>
        @endif
    @endif



    <br />

    <input type="hidden" value="{{ $discount_type }}" name="discount_type">
    <input type="hidden" value="{{ $branch }}" name="branch">
    <input type="hidden" value="{{ $principal_id }}" name="principal_id">
    <input type="hidden" value="{{ $dr_si }}" name="dr_si">
    <input type="hidden" value="{{ $truck_number }}" name="truck_number">
    <input type="hidden" value="{{ $courier }}" name="courier">
    <input type="hidden" value="{{ $invoice_date }}" name="invoice_date">
    <input type="hidden" value="{{ $scanned_by }}" name="scanned_by">
    <input type="hidden" value="{{ $bo_allowance_discount_selected }}" name="bo_allowance_discount_rate">
    <input type="hidden" value="{{ $cwo_discount_selected }}" name="cwo_discount_rate">
    <input type="hidden" value="{{ $cwo_discount_lower }}" name="cwo_discount">
    <input type="hidden" value="{{ $purchase_order_id }}" name="purchase_order_id">
    <input type="hidden" value="{{ $gross_purchases }}" name="gross_purchases">
    <input type="hidden" value="{{ $bo_discount }}" name="bo_discount">
    <input type="hidden" value="{{ $vatable_purchase }}" name="vatable_purchase">
    <input type="hidden" value="{{ $vat }}" name="vat">
    <input type="hidden" value="{{ $freight }}" name="freight">
    <input type="hidden" value="{{ $total_final_cost }}" name="total_final_cost">
    <input type="hidden" value="{{ $draft_session_id }}" name="draft_session_id">
    <input type="hidden" value="{{ $sku_type }}" name="sku_type">
    <button class="btn btn-sm float-right btn-success" type="submit">Submit Transaction</button>
</form>

<script>
    $("#received_order_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();

        $.ajax({
            url: "received_order_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
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
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
                $('#loader').hide();

            }
        });
    }));
</script>

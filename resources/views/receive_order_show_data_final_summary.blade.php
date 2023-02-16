<form id="received_order_save">
    @csrf
    <div class="table table-responsive">
        @if ($discount_type == 'type_a')
            <table class="table table-bordered table-sm table-hover">
                <thead>
                    <tr>
                        <th>Desc</th>
                        <th>Received</th>
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
                    @foreach ($sku_id as $data)
                        <tr>
                            <td>
                                <span style="color:green;font-weight:bold;">{{ $sku_code[$data] }}</span>-
                                {{ $description[$data] }}
                                <input type="hidden" value="{{ $data }}" name="sku_id[]">
                                <input type="hidden" value="{{ $received_quantity[$data] }}"
                                    name="received_quantity[{{ $data }}]">
                                <input type="hidden" value="{{ $unit_cost[$data] }}"
                                    name="unit_cost[{{ $data }}]">
                                <input type="hidden" value="{{ $freight }}" name="freight[{{ $data }}]">
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
                                    $final_unit_cost = $final_total_cost / $received_quantity[$data];
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

            <table class="table table-bordered table-hovered">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>

                        <th style="text-align: center;">DR</th>
                        <th style="text-align: center;">CR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">INVENTORY {{ $selected_discount_allocation->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($grand_total_final_cost, 2, '.', ','); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">ACCOUNTS PAYABLE {{ $selected_discount_allocation->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($grand_total_final_cost, 2, '.', ','); ?></td>
                    </tr>
                </tbody>
            </table>
        @elseif($discount_type == 'type_b')
            <table class="table table-bordered table-sm table-hover">
                <thead>
                    <tr>
                        <th>Desc</th>
                        <th>Received</th>
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
                        <th style="text-align: center">Freight</th>
                        <th style="text-align: center">Final Total Cost</th>
                        <th style="text-align: center">Final Unit Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sku_id as $data)
                        <tr>
                            <td>
                                <span style="color:green;font-weight:bold;">{{ $sku_code[$data] }}</span>-
                                {{ $description[$data] }}
                                <input type="hidden" value="{{ $data }}" name="sku_id[]">
                                <input type="hidden" value="{{ $received_quantity[$data] }}"
                                    name="received_quantity[{{ $data }}]">
                                <input type="hidden" value="{{ $unit_cost[$data] }}"
                                    name="unit_cost[{{ $data }}]">
                                <input type="hidden" value="{{ $freight }}" name="freight[{{ $data }}]">
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
                                $total = $total_amount;
                                
                                $discount_value_holder = $total;
                                $discount_value_holder_history = [];
                                $discount_value_holder_history_for_bo_allowance = [];
                                $totalArray = [];
                                $percent = [];
                                foreach ($selected_discount_rate as $data_discount) {
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
                            <td style="text-align: right">
                                @php
                                    $freight_per_sku = $freight * $received_quantity[$data];
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
                                    $final_unit_cost_per_sku = $final_total_cost_per_sku / $received_quantity[$data];
                                    $sum_final_unit_cost_per_sku[] = $final_unit_cost_per_sku;
                                @endphp
                                {{ number_format($final_unit_cost_per_sku, 2, '.', ',') }}

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
                            foreach ($selected_discount_rate as $data_discount) {
                                $discount_value_holder_dummy = $discount_value_holder;
                                $less_percentage_by = $data_discount->discount_rate / 100;
                            
                                // $discount_value_holder = $discount_value_holder_dummy - ($discount_value_holder_dummy * $less_percentage_by);
                                $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                            
                                $discount_value_holder_history[] = $discount_rate_answer;
                                echo '<th style="text-align:right;">' . number_format($discount_rate_answer, 2, '.', ',') . '</th>';
                            }
                        @endphp
                        <th style="text-align: right;">
                            {{ number_format(array_sum($sum_bo_allowance_per_sku), 2, '.', ',') }}

                        </th>
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
                    foreach ($selected_discount_rate as $data_discount) {
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
                <tr>
                    <td style="text-align: left;width:50%;font-weight: bold;text-align: center">FREIGHT</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                        @php
                            $freight = array_sum($sum_freight_per_sku);
                            
                        @endphp
                        {{ number_format($freight, 2, '.', ',') }}

                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;width:50%;font-weight: bold;text-align: center;">TOTAL</td>
                    <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;font-weight: bold">
                        @php
                            $total = $gross_purchase - (array_sum($less_discount_value_holder_history) + $less_bo_allowance_per_summary);
                            $grand_total_final_cost = $total + $less_vat + $freight;
                            
                        @endphp
                        {{ number_format($grand_total_final_cost, 2, '.', ',') }}

                    </td>
                </tr>
            </table>

            <table class="table table-bordered table-sm table-hovered">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                        <th style="text-align: center;">DR</th>
                        <th style="text-align: center;">CR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">INVENTORY {{ $selected_discount_allocation->principal->principal }} </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($grand_total_final_cost, 2, '.', ','); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">ACCOUNTS PAYABLE {{ $selected_discount_allocation->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($grand_total_final_cost, 2, '.', ','); ?></td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
    <br />

    <input type="hidden" value="{{ $discount_type }}" name="discount_type">
    <input type="hidden" value="{{ $branch }}" name="branch">
    <input type="hidden" value="{{ $selected_discount_allocation->id }}" name="discount_id">
    <input type="hidden" value="{{ $principal_id }}" name="principal_id">
    <input type="hidden" value="{{ $dr_si }}" name="dr_si">
    <input type="hidden" value="{{ $truck_number }}" name="truck_number">
    <input type="hidden" value="{{ $courier }}" name="courier">
    <input type="hidden" value="{{ $invoice_date }}" name="invoice_date">
    <input type="hidden" value="{{ $scanned_by }}" name="scanned_by">
    <input type="hidden" value="{{ $purchase_order_id }}" name="purchase_order_id">
    <input type="hidden" value="{{ $grand_total_final_cost }}" name="grand_total_final_cost">
    <input type="text" value="{{ $draft_session_id }}" name="draft_session_id">
    <button class="btn btn-sm float-right btn-success" type="submit">Submit Transaction</button>
</form>

<script>
    $("#received_order_save").on('submit', (function(e) {
        e.preventDefault();
        //$('.loading').show();
        $('#hide_if_trigger').hide();
        $.ajax({
            url: "received_order_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                // Swal.fire({
                //     position: 'top-end',
                //     icon: 'success',
                //     title: 'Your work has been saved',
                //     showConfirmButton: false,
                //     timer: 1500
                // });

                // location.reload();
            },
            error: function(error) {
                Swal.fire(
                    'Cannot Proceed',
                    'Please Contact IT Support',
                    'error'
                )
            }
        });
    }));
</script>

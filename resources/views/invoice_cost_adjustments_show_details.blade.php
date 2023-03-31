<link rel="stylesheet" href="{{ asset('adminLTE/dist/css/adminlte.min.css') }}">
<div class="row">
    <div class="col-12">
        <center>
            <h2 class="page-header">
                JULMAR COMMERCIAL. INC,
            </h2>
        </center>
    </div>

    <div class="col-sm-12 invoice-col">
        <center>
            <h5>St Ignatius St., Brgy. Kauswagan <br /> Cagayan de Oro City, Misamis Oriental</h5>
            <h6 style="font-family: verdana;">TELEPHONE NO: 881-9973 / 09177058232</h6>
        </center>
        <br />
        <center>
            <span style="font-weight: bold;font-size:18px;">INVOICE COST ADJUSTMENT DETAILED REPORT REPORT: </span><br />
        </center>
        <br />
        @php
            $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        @endphp


        <center>
            {!! $generator->getBarcode($invoice_cost_adjustment->id, $generator::TYPE_CODE_128) !!}
            <p>{{ $invoice_cost_adjustment->id }}</p>
        </center>

    </div>
</div>
@if ($invoice_cost_adjustment->received_purchase_order->discount_type == 'type_a')
    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-hover table-striped">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Received</th>
                    <th style="text-align: center;">U/C<br />(VAT EX)</th>
                    <th>Amount</th>
                    <th style="text-align: center">Discount
                        @foreach ($invoice_cost_adjustment->received_purchase_order->received_discount_details as $data)
                            @php
                                $sum_discount_selected[] = $data->discount_rate;
                            @endphp
                        @endforeach
                        ({{ array_sum($sum_discount_selected) }}%)
                    </th>
                    <th style="text-align: center">BO Allowance
                        ({{ $invoice_cost_adjustment->received_purchase_order->bo_allowance_discount_rate }}%)</th>
                    <th style="text-align: center">T.Discount<br /></th>
                    <th>VAT</th>
                    <th>Freight</th>
                    <th style="text-align: center">Total Cost Adjustment</th>
                    <th style="text-align: center">Unit Cost Adjustment</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice_cost_adjustment->invoice_cost_adjustment_details as $data)
                    <tr>
                        <td>
                            <span style="color:green;font-weight:bold;">{{ $data->sku->sku_code }}</span>-
                            {{ $data->sku->description }}
                        </td>
                        <td style="text-align: right">{{ $data->quantity }}</td>
                        <td style="text-align: right">
                            @php
                                $difference_of_new_and_old_unit_cost = $data->original_unit_cost - $data->adjusted_amount;
                                echo number_format($difference_of_new_and_old_unit_cost, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $total_amount = $data->quantity * $difference_of_new_and_old_unit_cost;
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
                                $bo_allowance_discount = $total_amount * ($invoice_cost_adjustment->received_purchase_order->bo_allowance_discount_rate / 100);
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
                                $vat_per_sku = ($total_amount - $total_discount) * 0.12;
                                $sum_vat_per_sku[] = $vat_per_sku;
                                echo number_format($vat_per_sku, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $freight_per_sku = $data->freight * $data->quantity;
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
                                $final_unit_cost = $final_total_cost / $data->quantity;
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


    @if ($invoice_cost_adjustment->received_purchase_order->total_less_other_discount != 0)
        <table class="table table-bordered table-hover table-striped float-right table-sm" style="width:35%;">
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
                <td style="text-align: left;width:50%;">VATABLE PURCHASE:</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                    @php
                        $vatable_purchase = $gross_purchases - $less_discount - $bo_discount;
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
                <td style="text-align: left;width:50%;">FINAL COST ADJUSTMENT:</td>
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
            @foreach ($invoice_cost_adjustment->received_purchase_order->received_other_discount_details as $data_discount)
                <tr>
                    <td style="text-align:left">
                        {{ Str::ucfirst($data_discount->discount_name) . '(' . $data_discount->discount_rate / 100 . ')' }}
                    </td>
                    @php
                        $discount_value_holder_dummy = $discount_value_holder;
                        $less_percentage_by = $data_discount->discount_rate / 100;
                        
                        // $discount_value_holder = $discount_value_holder_dummy - $discount_value_holder_dummy * $less_percentage_by;
                        $less_discount_rate_answer = $discount_value_holder * $less_percentage_by;
                        $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                        
                        $less_discount_value_holder_history[] = $less_discount_rate_answer;
                        $less_discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                    @endphp
                    <td style="text-align:right;">
                        {{ number_format($less_discount_rate_answer, 2, '.', ',') }}
                    </td>
                </tr>
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
                <td style="text-align: left;width:50%;">NET ADJUSTMENT:</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                    @php
                        $net_payable = $total_final_cost - array_sum($less_discount_value_holder_history);
                    @endphp
                    {{ number_format($net_payable, 2, '.', ',') }}

                </td>
            </tr>
        </table>

        <table class="table table-bordered table-hover table-striped table-sm">
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
                        {{ $invoice_cost_adjustment->received_purchase_order->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($net_payable, 2, '.', ','); ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">ACCOUNTS PAYABLE
                        {{ $invoice_cost_adjustment->received_purchase_order->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($net_payable, 2, '.', ','); ?></td>
                </tr>
            </tbody>
        </table>
    @else
        <table class="table table-bordered table-hover table-striped float-right table-sm" style="width:35%;">
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
                <td style="text-align: left;width:50%;">VATABLE PURCHASE:</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                    @php
                        $vatable_purchase = $gross_purchases - $less_discount - $bo_discount;
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
                <td style="text-align: left;width:50%;">FINAL COST ADJUSTMENT:</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                    @php
                        $total_final_cost = $vatable_purchase + $vat + $freight;
                    @endphp
                    {{ number_format($total_final_cost, 2, '.', ',') }}
                </td>
            </tr>
        </table>

        <table class="table table-bordered table-hover table-striped table-sm">
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
                        {{ $invoice_cost_adjustment->received_purchase_order->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost, 2, '.', ','); ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">ACCOUNTS PAYABLE
                        {{ $invoice_cost_adjustment->received_purchase_order->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost, 2, '.', ','); ?></td>
                </tr>
            </tbody>
        </table>
    @endif
@elseif($invoice_cost_adjustment->received_purchase_order->discount_type == 'type_b')
    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-hover table-striped">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Received</th>
                    <th style="text-align: center;">U/C<br />(VAT EX)</th>
                    <th>Amount</th>
                    @foreach ($invoice_cost_adjustment->received_purchase_order->received_discount_details as $data)
                        <th style="text-align: center;">{{ Str::ucfirst($data->discount_name) }}
                            ({{ $data->discount_rate }}%)
                        </th>
                        <input type="hidden" name="discount_selected_name[]" value="{{ $data->discount_name }}">
                        <input type="hidden" name="discount_selected_rate[]" value="{{ $data->discount_rate }}">
                    @endforeach
                    <th style="text-align: center">T.Discount<br /></th>
                    <th>VAT</th>
                    <th style="text-align: center">Freight</th>
                    <th style="text-align: center">Total Cost Adjustment</th>
                    <th style="text-align: center">Unit Cost Adjustment</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice_cost_adjustment->invoice_cost_adjustment_details as $data)
                    <tr>
                        <td>
                            <span style="color:green;font-weight:bold;">{{ $data->sku->sku_code }}</span>-
                            {{ $data->sku->description }}
                        </td>
                        <td style="text-align: right">{{ $data->quantity }}</td>
                        <td style="text-align: right">
                            @php
                                $difference_of_new_and_old_unit_cost = $data->adjustments;
                                echo number_format($difference_of_new_and_old_unit_cost, 2, '.', ',');
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $total_amount = $data->quantity * $difference_of_new_and_old_unit_cost;
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
                            foreach ($invoice_cost_adjustment->received_purchase_order->received_discount_details as $data_discount) {
                                $discount_value_holder_dummy = $discount_value_holder;
                                $less_percentage_by = $data_discount->discount_rate / 100;
                            
                                $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                            
                                $discount_value_holder_history[] = $discount_rate_answer;
                                $discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                                echo '<td style="text-align:right;">' . number_format($discount_rate_answer, 2, '.', ',') . '</td>';
                            }
                        @endphp
                        {{-- <td style="text-align: right"> --}}
                            @php
                                $bo_allowance = end($discount_value_holder_history_for_bo_allowance);
                                $bo_allowance_per_sku = end($discount_value_holder_history_for_bo_allowance) - $bo_allowance;
                                $sum_bo_allowance_per_sku[] = $bo_allowance_per_sku;
                            @endphp
                            {{-- {{ number_format($bo_allowance_per_sku, 2, '.', ',') }}
                        </td> --}}

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
                                if ($total_amount > 0) {
                                    $freight_per_sku = $data->freight * $data->quantity;
                                } else {
                                    $freight_per_sku = ($data->freight * $data->quantity)*-1;
                                }
                                
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
                                $final_unit_cost_per_sku = $final_total_cost_per_sku / $data->quantity;
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
                        foreach ($invoice_cost_adjustment->received_purchase_order->received_discount_details as $data_discount) {
                            $discount_value_holder_dummy = $discount_value_holder;
                            $less_percentage_by = $data_discount->discount_rate / 100;
                        
                            // $discount_value_holder = $discount_value_holder_dummy - ($discount_value_holder_dummy * $less_percentage_by);
                            $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                            $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                        
                            $discount_value_holder_history[] = $discount_rate_answer;
                            echo '<th style="text-align:right;">' . number_format($discount_rate_answer, 2, '.', ',') . '</th>';
                        }
                    @endphp
                    {{-- <th style="text-align: right;">
                        {{ number_format(array_sum($sum_bo_allowance_per_sku), 2, '.', ',') }}

                    </th> --}}
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

    @if ($invoice_cost_adjustment->received_purchase_order->total_less_other_discount != 0)
        <table class="table table-bordered table-hover table-striped table-sm float-right" style="width:35%;">
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
                foreach ($invoice_cost_adjustment->received_purchase_order->received_discount_details as $data_discount) {
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
            {{-- <tr> --}}
                <input type="hidden" name="total_less_discount"
                    value="{{ array_sum($less_discount_value_holder_history) }}">
                {{-- <td style="text-align: left;width:50%;">BO DISCOUNTS:</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                    @php
                        $bo_discount = array_sum($sum_bo_allowance_per_sku);
                    @endphp
                    {{ number_format($bo_discount, 2, '.', ',') }}
                </td>
            </tr> --}}
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
                <td style="text-align: left;width:50%;">FINAL COST ADJUSTMENT:</td>
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
            @foreach ($invoice_cost_adjustment->received_purchase_order->received_other_discount_details as $data_discount)
                <tr>
                    <td style="text-align:left">
                        {{ Str::ucfirst($data_discount->discount_name) . '(' . $data_discount->discount_rate / 100 . ')' }}
                    </td>
                    @php
                        $discount_value_holder_dummy = $discount_value_holder;
                        $less_percentage_by = $data_discount->discount_rate / 100;
                        
                        // $discount_value_holder = $discount_value_holder_dummy - $discount_value_holder_dummy * $less_percentage_by;
                        $less_discount_rate_answer = $discount_value_holder * $less_percentage_by;
                        $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                        
                        $less_discount_value_holder_history[] = $less_discount_rate_answer;
                        $less_discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                    @endphp
                    <td style="text-align:right;">
                        {{ number_format($less_discount_rate_answer, 2, '.', ',') }}

                    </td>
                </tr>
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
                <td style="text-align: left;width:50%;">NET ADJUSTMENT:</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                    @php
                        $net_payable = $total_final_cost - array_sum($less_discount_value_holder_history);
                    @endphp
                    {{ number_format($net_payable, 2, '.', ',') }}
                </td>
            </tr>
        </table>

        <table class="table table-bordered table-hover table-striped table-sm">
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
                        {{ $invoice_cost_adjustment->received_purchase_order->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($net_payable, 2, '.', ','); ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">ACCOUNTS PAYABLE
                        {{ $invoice_cost_adjustment->received_purchase_order->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($net_payable, 2, '.', ','); ?></td>
                </tr>
            </tbody>
        </table>
    @else
        <table class="table table-bordered table-hover table-striped table-sm float-right" style="width:35%;">
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
                foreach ($invoice_cost_adjustment->received_purchase_order->received_discount_details as $data_discount) {
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
            {{-- <tr> --}}
                <input type="hidden" name="total_less_discount"
                    value="{{ array_sum($less_discount_value_holder_history) }}">
                {{-- <td style="text-align: left;width:50%;">BO DISCOUNTS:</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                    @php
                        $bo_discount = array_sum($sum_bo_allowance_per_sku);
                    @endphp
                    {{ number_format($bo_discount, 2, '.', ',') }}
                </td>
            </tr> --}}
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
                <td style="text-align: left;width:50%;">FINAL COST ADJUSTMENT:</td>
                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                    @php
                        $total_final_cost = $vatable_purchase + $vat + $freight;
                    @endphp
                    {{ number_format($total_final_cost, 2, '.', ',') }}
                </td>
                <input type="hidden" value="0" name="net_payable">
                <input type="hidden" name="total_less_other_discount" value="0">
            </tr>
        </table>

        <table class="table table-bordered table-hover table-striped table-sm">
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
                        {{ $invoice_cost_adjustment->received_purchase_order->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost, 2, '.', ','); ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">ACCOUNTS PAYABLE
                        {{ $invoice_cost_adjustment->received_purchase_order->principal->principal }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost, 2, '.', ','); ?></td>
                </tr>
            </tbody>
        </table>
    @endif
@endif

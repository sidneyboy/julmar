@extends('layouts.master')

@section('title', 'Return To Principal REPORT')

@section('navbar')


@section('sidebar')


@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title" style="font-weight: bold;">INVOICE COST ADJUSTMENT DETAILED REPORT</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                @if ($invoice_cost_adjustment->received_purchase_order->discount_type == 'type_a')
                    <div class="table table-responsive">
                        <table class="table table-bordered table-sm table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle" style="text-transform: uppercase">Description</th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">Received</th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">Invoice Cost
                                        Adjustment
                                    </th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">Amount</th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">Discount
                                        @foreach ($invoice_cost_adjustment->received_purchase_order->received_discount_details as $data)
                                            @php
                                                $sum_discount_selected[] = $data->discount_rate;
                                            @endphp
                                        @endforeach
                                    </th>
                                    </th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">BO Allowance</th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">CWO</th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">T.Discount<br />
                                    </th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">VAT</th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">Freight</th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">Total Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice_cost_adjustment->invoice_cost_adjustment_details as $data)
                                    <td>
                                        <span style="color:green;font-weight:bold;">{{ $data->sku->sku_code }}</span>-
                                        {{ $data->sku->description }}
                                    </td>
                                    <td style="text-align: right">{{ $data->quantity }}</td>
                                    <td style="text-align: right">{{ $data->adjustments }}</td>
                                    <td style="text-align: right">
                                        @php
                                            $total_amount = $data->quantity * $data->adjustments;
                                            $sum_total_amount[] = $total_amount;
                                            echo number_format($total_amount, 2, '.', ',');
                                        @endphp
                                    </td>
                                    <td style="text-align: right">
                                        {{ number_format($data->discount, 2, '.', ',') }}
                                        @php
                                            $sum_discount[] = $data->discount;
                                        @endphp
                                    </td>
                                    <td style="text-align: right">
                                        {{ number_format($data->bo_allowance, 2, '.', ',') }}
                                        @php
                                            $sum_bo_allowance_discount[] = $data->bo_allowance;
                                        @endphp
                                    </td>
                                    <td style="text-align: right">
                                        {{ number_format($data->cwo, 2, '.', ',') }}
                                        @php
                                            $sum_cwo[] = $data->cwo;
                                        @endphp
                                    </td>
                                    <td style="text-align: right">
                                        {{ number_format($data->total_discount, 2, '.', ',') }}
                                        @php
                                            $sum_total_discount[] = $data->total_discount;
                                        @endphp
                                    </td>
                                    <td style="text-align: right">
                                        {{ number_format($data->vat, 2, '.', ',') }}
                                        @php
                                            $sum_vat[] = $data->vat;
                                        @endphp
                                    </td>
                                    <td style="text-align: right">
                                        {{ number_format($data->freight, 2, '.', ',') }}
                                        @php
                                            $sum_freight[] = $data->freight;
                                        @endphp
                                    </td>
                                    <td style="text-align: right">
                                        {{ number_format($data->total_cost, 2, '.', ',') }}
                                        @php
                                            $sum_total_cost[] = $data->total_cost;
                                        @endphp
                                    </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    @if ($invoice_cost_adjustment->received_purchase_order->total_less_other_discount != 0)
                        <table class="table table-bordered table-hover table-striped float-right table-sm"
                            style="width:35%;">
                            <tr>
                                <td style="font-weight: bold; text-align: center;" colspan="2">FINAL SUMMARY OF
                                    DISCOUNTS:
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
                                <td style="text-align: left;width:50%;">CWO:</td>
                                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                                    @php
                                        $lower_cwo = array_sum($sum_cwo);
                                    @endphp
                                    {{ number_format($lower_cwo, 2, '.', ',') }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left;width:50%;">VATABLE PURCHASE:</td>
                                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                                    @php
                                        $vatable_purchase = $gross_purchases - $less_discount - $bo_discount + $lower_cwo;
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
                                        $discount_value_holder =
                                            $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;

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
                                        $net_payable =
                                            $total_final_cost - array_sum($less_discount_value_holder_history);
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
                        <table class="table table-bordered table-hover table-striped float-right table-sm"
                            style="width:35%;">
                            <tr>
                                <td style="font-weight: bold; text-align: center;" colspan="2">FINAL SUMMARY OF
                                    DISCOUNTS:
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
                                <td style="text-align: left;width:50%;">CWO:</td>
                                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                                    @php
                                        $lower_cwo = array_sum($sum_cwo);
                                    @endphp
                                    {{ number_format($lower_cwo, 2, '.', ',') }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left;width:50%;">VATABLE PURCHASE:</td>
                                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                                    @php
                                        $vatable_purchase = $gross_purchases - $less_discount - $bo_discount - $lower_cwo;
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
                                        <input type="hidden" name="discount_selected_name[]"
                                            value="{{ $data->discount_name }}">
                                        <input type="hidden" name="discount_selected_rate[]"
                                            value="{{ $data->discount_rate }}">
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
                                            foreach (
                                                $invoice_cost_adjustment->received_purchase_order
                                                    ->received_discount_details
                                                as $data_discount
                                            ) {
                                                $discount_value_holder_dummy = $discount_value_holder;
                                                $less_percentage_by = $data_discount->discount_rate / 100;

                                                $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                                $discount_value_holder =
                                                    $discount_value_holder -
                                                    $discount_value_holder_dummy * $less_percentage_by;

                                                $discount_value_holder_history[] = $discount_rate_answer;
                                                $discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                                                echo '<td style="text-align:right;">' .
                                                    number_format($discount_rate_answer, 2, '.', ',') .
                                                    '</td>';
                                            }
                                        @endphp
                                        {{-- <td style="text-align: right"> --}}
                                        @php
                                            $bo_allowance = end($discount_value_holder_history_for_bo_allowance);
                                            $bo_allowance_per_sku =
                                                end($discount_value_holder_history_for_bo_allowance) - $bo_allowance;
                                            $sum_bo_allowance_per_sku[] = $bo_allowance_per_sku;
                                        @endphp
                                        {{-- {{ number_format($bo_allowance_per_sku, 2, '.', ',') }}
                        </td> --}}

                                        <td style="text-align: right;">
                                            @php
                                                $vat =
                                                    ($total_amount -
                                                        (array_sum($discount_value_holder_history) +
                                                            $bo_allowance_per_sku)) *
                                                    0.12;
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
                                                    $freight_per_sku = $data->freight * $data->quantity * -1;
                                                }

                                                $sum_freight_per_sku[] = $freight_per_sku;
                                            @endphp
                                            {{ number_format($freight_per_sku, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right">
                                            @php
                                                $final_total_cost_per_sku =
                                                    $vat_inclusive_total_cost_per_sku + $freight_per_sku;
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
                                        foreach (
                                            $invoice_cost_adjustment->received_purchase_order->received_discount_details
                                            as $data_discount
                                        ) {
                                            $discount_value_holder_dummy = $discount_value_holder;
                                            $less_percentage_by = $data_discount->discount_rate / 100;

                                            // $discount_value_holder = $discount_value_holder_dummy - ($discount_value_holder_dummy * $less_percentage_by);
                                            $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                            $discount_value_holder =
                                                $discount_value_holder -
                                                $discount_value_holder_dummy * $less_percentage_by;

                                            $discount_value_holder_history[] = $discount_rate_answer;
                                            echo '<th style="text-align:right;">' .
                                                number_format($discount_rate_answer, 2, '.', ',') .
                                                '</th>';
                                        }
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

                    @if ($invoice_cost_adjustment->received_purchase_order->total_less_other_discount != 0)
                        <table class="table table-bordered table-hover table-striped table-sm float-right"
                            style="width:35%;">
                            <tr>
                                <td style="font-weight: bold; text-align: center;" colspan="2">FINAL SUMMARY OF
                                    DISCOUNTS:
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
                                foreach (
                                    $invoice_cost_adjustment->received_purchase_order->received_discount_details
                                    as $data_discount
                                ) {
                                    echo '<tr><td style="text-align:left">' .
                                        Str::ucfirst($data_discount->discount_name) .
                                        '(' .
                                        $data_discount->discount_rate / 100 .
                                        '%) </td>';
                                    $discount_value_holder_dummy = $discount_value_holder;
                                    $less_percentage_by = $data_discount->discount_rate / 100;

                                    // $discount_value_holder = $discount_value_holder_dummy - ($discount_value_holder_dummy * $less_percentage_by);
                                    $less_discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                    $discount_value_holder =
                                        $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;

                                    $less_discount_value_holder_history[] = $less_discount_rate_answer;
                                    $less_discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                                    echo '<td style="text-align:right;">' .
                                        number_format($less_discount_rate_answer, 2, '.', ',') .
                                        '</td></tr>';
                                }
                            @endphp
                            <input type="hidden" name="total_less_discount"
                                value="{{ array_sum($less_discount_value_holder_history) }}">

                            <tr>
                                <td style="text-align: left;width:50%;">VATABLE PURCHASE:</td>
                                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                                    @php
                                        $vatable_purchase =
                                            $gross_purchases - array_sum($less_discount_value_holder_history);
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
                                        $discount_value_holder =
                                            $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;

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
                                        $net_payable =
                                            $total_final_cost - array_sum($less_discount_value_holder_history);
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
                        <table class="table table-bordered table-hover table-striped table-sm float-right"
                            style="width:35%;">
                            <tr>
                                <td style="font-weight: bold; text-align: center;" colspan="2">FINAL SUMMARY OF
                                    DISCOUNTS:
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
                                foreach (
                                    $invoice_cost_adjustment->received_purchase_order->received_discount_details
                                    as $data_discount
                                ) {
                                    echo '<tr><td style="text-align:left">' .
                                        Str::ucfirst($data_discount->discount_name) .
                                        '(' .
                                        $data_discount->discount_rate / 100 .
                                        '%) </td>';
                                    $discount_value_holder_dummy = $discount_value_holder;
                                    $less_percentage_by = $data_discount->discount_rate / 100;

                                    // $discount_value_holder = $discount_value_holder_dummy - ($discount_value_holder_dummy * $less_percentage_by);
                                    $less_discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                    $discount_value_holder =
                                        $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;

                                    $less_discount_value_holder_history[] = $less_discount_rate_answer;
                                    $less_discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                                    echo '<td style="text-align:right;">' .
                                        number_format($less_discount_rate_answer, 2, '.', ',') .
                                        '</td></tr>';
                                }
                            @endphp
                            {{-- <tr> --}}
                            <input type="hidden" name="total_less_discount"
                                value="{{ array_sum($less_discount_value_holder_history) }}">

                            <tr>
                                <td style="text-align: left;width:50%;">VATABLE PURCHASE:</td>
                                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                                    @php
                                        $vatable_purchase =
                                            $gross_purchases - array_sum($less_discount_value_holder_history);
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


            </div>
            <!-- /.card-body -->
            <div class="card-footer">
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->

@endsection


@section('footer')
    @parent
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    </body>

    </html>
@endsection

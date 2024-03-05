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
                <h3 class="card-title" style="font-weight: bold;">RETURN TO PRINCIPAL DETAILED REPORT</h3>

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
                @if ($return_to_principal->received_purchase_order->discount_type == 'type_a')
                    <div class="table table-responsive">
                        <table class="table table-bordered table-sm table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Desc</th>
                                    <th>Received</th>
                                    <th style="text-align: center;">U/C<br />(VAT EX)</th>
                                    <th>Amount</th>
                                    <th style="text-align: center">Discount
                                        @foreach ($return_to_principal->received_purchase_order->received_discount_details as $data)
                                            @php
                                                $sum_discount_selected[] = $data->discount_rate;
                                            @endphp
                                        @endforeach
                                        ({{ array_sum($sum_discount_selected) }}%)
                                    </th>
                                    <th style="text-align: center">BO Allowance
                                        ({{ $return_to_principal->received_purchase_order->bo_allowance_discount_rate }}%)
                                    </th>
                                    <th style="text-align: center">CWO
                                        ({{ $return_to_principal->received_purchase_order->cwo_discount_rate }}%)</th>
                                    <th style="text-align: center">T.Discount<br /></th>
                                    <th>VAT</th>
                                    <th>Freight</th>
                                    <th style="text-align: center">Final Total Cost</th>
                                    <th style="text-align: center">Final Unit Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($return_to_principal->return_to_principal_details as $data)
                                    <tr>
                                        <td><span style="color:green;font-weight:bold;">{{ $data->sku->sku_code }}</span>-
                                            {{ $data->sku->description }}
                                        </td>
                                        <td style="text-align: right">{{ $data->quantity_return }}</td>
                                        <td style="text-align: right">{{ number_format($data->unit_cost, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right">
                                            @php
                                                $total_amount = $data->quantity_return * $data->unit_cost;
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
                                                $bo_allowance_discount =
                                                    $total_amount *
                                                    ($return_to_principal->received_purchase_order
                                                        ->bo_allowance_discount_rate /
                                                        100);
                                                $sum_bo_allowance_discount[] = $bo_allowance_discount;
                                                echo number_format($bo_allowance_discount, 2, '.', ',');
                                            @endphp
                                        </td>
                                        <td style="text-align: right">

                                            @php
                                                $cwo_discount =
                                                    $total_amount *
                                                    ($return_to_principal->received_purchase_order->cwo_discount_rate /
                                                        100);
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
                                                $freight_per_sku = $data->freight * $data->quantity_return;
                                                $sum_freight[] = $freight_per_sku;
                                                echo number_format($freight_per_sku, 2, '.', ',');
                                            @endphp
                                        </td>
                                        <td style="text-align: right">
                                            @php
                                                $final_total_cost =
                                                    $total_amount - $total_discount + $vat_per_sku + $freight_per_sku;
                                                $sum_final_total_cost[] = $final_total_cost;
                                                echo number_format($final_total_cost, 2, '.', ',');
                                            @endphp
                                        </td>
                                        <td style="text-align: right">
                                            @php
                                                $final_unit_cost = $final_total_cost / $data->quantity_return;
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
                                    <th style="text-align: right;">
                                        {{ number_format(array_sum($sum_discount), 2, '.', ',') }}</th>
                                    <th style="text-align: right;">
                                        {{ number_format(array_sum($sum_bo_allowance_discount), 2, '.', ',') }}</th>
                                    <th style="text-align: right;">
                                        {{ number_format(array_sum($sum_cwo_discount), 2, '.', ',') }}</th>
                                    <th style="text-align: right;">
                                        {{ number_format(array_sum($sum_total_discount), 2, '.', ',') }}
                                    </th>
                                    <th style="text-align: right;">
                                        {{ number_format(array_sum($sum_vat_per_sku), 2, '.', ',') }}
                                    </th>
                                    <th style="text-align: right;">
                                        {{ number_format(array_sum($sum_freight), 2, '.', ',') }}
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

                    @if ($return_to_principal->received_purchase_order->total_less_other_discount != 0)
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
                                        $vatable_purchase =
                                            $gross_purchases - $less_discount - $bo_discount - $cwo_discount_lower;
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
                            @foreach ($return_to_principal->received_purchase_order->received_other_discount_details as $data_discount)
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
                                <td style="text-align: left;width:50%;">NET PAYABLE:</td>
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
                                    <td style="text-align: center;">ACCOUNTS PAYABLE
                                        {{ $return_to_principal->received_purchase_order->principal->principal }}</td>
                                    <td></td>
                                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($net_payable, 2, '.', ','); ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: center;">INVENTORY
                                        {{ $return_to_principal->received_purchase_order->principal->principal }}</td>
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
                                        $vatable_purchase =
                                            $gross_purchases - $less_discount - $bo_discount - $cwo_discount_lower;
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
                                    <td style="text-align: center;">ACCOUNTS PAYABLE
                                        {{ $return_to_principal->received_purchase_order->principal->principal }}</td>
                                    <td></td>
                                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost, 2, '.', ','); ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: center;">INVENTORY
                                        {{ $return_to_principal->received_purchase_order->principal->principal }}</td>
                                    <td></td>
                                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost, 2, '.', ','); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                @elseif($return_to_principal->received_purchase_order->discount_type == 'type_b')
                    <div class="table table-responsive">
                        <table class="table table-bordered table-sm table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle" style="text-transform: uppercase">Description
                                    </th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">Received</th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">U/C<br />(VAT
                                        EX)</th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">Amount</th>
                                    @foreach ($return_to_principal->received_purchase_order->received_discount_details as $data)
                                        <th class="text-center align-middle" style="text-transform: uppercase">
                                            {{ Str::ucfirst($data->discount_name) }}
                                        </th>
                                    @endforeach
                                    {{-- <th class="text-center align-middle" style="text-transform: uppercase">BO Allowance
                                    ({{ $return_to_principal->received_purchase_order->bo_allowance_discount_rate }}%)</th> --}}
                                    <th class="text-center align-middle" style="text-transform: uppercase">
                                        T.Discount<br /></th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">VAT</th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">Freight</th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">Final Total
                                        Cost</th>
                                    <th class="text-center align-middle" style="text-transform: uppercase">Final Unit Cost
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($return_to_principal->return_to_principal_details as $data)
                                    <tr>
                                        <td style="font-size:10px;">
                                            <span style="color:green;font-weight:bold;">{{ $data->sku->sku_code }}</span>-
                                            {{ $data->sku->description }}
                                        </td>
                                        <td style="text-align: right">{{ $data->quantity_return }}</td>
                                        <td style="text-align: right">{{ number_format($data->unit_cost, 2, '.', ',') }}
                                        </td>
                                        <td style="text-align: right">
                                            @php
                                                $total_amount = $data->quantity_return * $data->unit_cost * -1;
                                                $sum_total_amount[] = $total_amount;
                                            @endphp
                                            {{ number_format($total_amount, 2, '.', ',') }}
                                        </td>
                                        @php
                                            $total = $total_amount;
                                            $discount_value_holder = $total;
                                            $discount_value_holder_history = [];
                                            $discount_value_holder_history_for_bo_allowance = [];
                                        @endphp
                                        @foreach ($return_to_principal->received_purchase_order->received_discount_details as $data_discount)
                                            @php
                                                $discount_value_holder_dummy = $discount_value_holder;
                                                if ($data_discount->discount_name != 'BO') {
                                                    $less_percentage_by = $data_discount->discount_rate / 100;
                                                } else {
                                                    $less_percentage_by = $bo_allowance_layer / 100;
                                                }
                                                $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                                $discount_value_holder =
                                                    $discount_value_holder -
                                                    $discount_value_holder_dummy * $less_percentage_by;

                                                $discount_value_holder_history[] = $discount_rate_answer;
                                                $discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                                            @endphp
                                        @endforeach
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
                                                $freight_per_sku = $data->freight;
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
                                                $final_unit_cost_per_sku =
                                                    $final_total_cost_per_sku / $data->quantity_return;
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
                                            $return_to_principal->received_purchase_order->received_discount_details
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

                    @if ($return_to_principal->received_purchase_order->total_less_other_discount != 0)
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
                                    $return_to_principal->received_purchase_order->received_discount_details
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
                            {{-- <tr>
            
                            <td style="text-align: left;width:50%;">BO DISCOUNTS:</td>
                            <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;"> --}}
                            @php
                                $bo_discount = array_sum($sum_bo_allowance_per_sku);
                            @endphp
                            {{ number_format($bo_discount, 2, '.', ',') }}
                            {{-- </td>
                        </tr> --}}
                            <tr>
                                <td style="text-align: left;width:50%;">VATABLE PURCHASE:</td>
                                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                                    @php
                                        $vatable_purchase =
                                            $gross_purchases -
                                            array_sum($less_discount_value_holder_history) -
                                            $bo_discount;
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
                            @foreach ($return_to_principal->received_purchase_order->received_other_discount_details as $data_discount)
                                {{-- <tr>
                            <td style="text-align:left">
                                {{ Str::ucfirst($data_discount->discount_name) . '(' . $data_discount->discount_rate / 100 . ')' }}
                            </td> --}}
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
                                {{-- <td style="text-align:right;">
                                {{ number_format($less_discount_rate_answer, 2, '.', ',') }}
                            </td>
                        </tr> --}}
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
                                    <td style="text-align: center;">ACCOUNTS PAYABLE
                                        {{ $return_to_principal->received_purchase_order->principal->principal }}</td>
                                    <td></td>
                                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($net_payable * -1, 2, '.', ','); ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: center;">INVENTORY
                                        {{ $return_to_principal->received_purchase_order->principal->principal }}</td>
                                    <td></td>
                                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($net_payable * -1, 2, '.', ','); ?></td>
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
                                    $return_to_principal->received_purchase_order->received_discount_details
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
                            {{-- <tr>
            
                            <td style="text-align: left;width:50%;">BO DISCOUNTS:</td>
                            <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;"> --}}
                            @php
                                $bo_discount = array_sum($sum_bo_allowance_per_sku);
                            @endphp
                            {{-- {{ number_format($bo_discount, 2, '.', ',') }}
                            </td>
                        </tr> --}}
                            <tr>
                                <td style="text-align: left;width:50%;">VATABLE PURCHASE:</td>
                                <td style="text-align: right;font-size: 15px;border-bottom: solid 1px;">
                                    @php
                                        $vatable_purchase =
                                            $gross_purchases -
                                            array_sum($less_discount_value_holder_history) -
                                            $bo_discount;
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
                                    <td style="text-align: center;">ACCOUNTS PAYABLE
                                        {{ $return_to_principal->received_purchase_order->principal->principal }}</td>
                                    <td></td>
                                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost * -1, 2, '.', ','); ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: center;">INVENTORY
                                        {{ $return_to_principal->received_purchase_order->principal->principal }}</td>
                                    <td></td>
                                    <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost * -1, 2, '.', ','); ?></td>
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

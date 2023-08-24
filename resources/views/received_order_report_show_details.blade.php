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
            <span style="font-weight: bold;font-size:18px;">RECEIVING REPORT: </span><br />
        </center>
    </div>
</div>

<div class="row invoice-info" style="width:80%;margin-left:25%;margin-right:25%;">
    <div class="col-sm-6 invoice-col">
        <table>
            <tr>
                <td style="font-weight: bold;">Received No. <span class="float-right">:</span></td>
                <td> {{ $received_purchase_order->id }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">RR Date. <span class="float-right">:</span></td>
                <td>{{ date('F j, Y', strtotime($received_purchase_order->created_at)) }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Po No. <span class="float-right">:</span></td>
                <td> {{ $received_purchase_order->purchase_order->purchase_id }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Po Date <span class="float-right">:</span></td>
                <td>
                    {{ $received_purchase_order->purchase_order->date }}
                </td>
            </tr>
        </table>
    </div>
    <!-- /.col -->

    <!-- /.col -->
    <div class="col-sm-6 invoice-col">
        <table>
            <tr>
                <td style="font-weight: bold;">Principal <span class="float-right">:</span></td>
                <td> {{ $received_purchase_order->principal->principal }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Principal Invoice No. <span class="float-right">:</span></td>
                <td style="text-transform: uppercase;"> {{ $received_purchase_order->dr_si }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Invoice Date <span class="float-right">:</span></td>
                <td> {{ $received_purchase_order->invoice_date }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Delivery Status. <span class="float-right">:</span></td>
                <td>
                    @if ($received_purchase_order->purchase_order->remarks == 'Received')
                        {{ 'COMPLETE' }}
                    @else
                        {{ 'PARTIAL' }}
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <!-- /.col -->
</div>

<br />
@php
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
@endphp


<center>
    {!! $generator->getBarcode($received_purchase_order->id, $generator::TYPE_CODE_128) !!}
    <p>{{ $received_purchase_order->id }}</p>
</center>


<div class="container-fluid">
    @if ($received_purchase_order->discount_type == 'type_a')
        <div class="table table-responsive">
            <table class="table table-bordered table-sm table-hover table-striped">
                <thead>
                    <tr>
                        <th>Desc</th>
                        <th>Received</th>
                        <th style="text-align: center;">U/C<br />(VAT EX)</th>
                        <th>Amount</th>
                        <th style="text-align: center">Discount
                            @foreach ($received_purchase_order->received_discount_details as $data)
                                @php
                                    $sum_discount_selected[] = $data->discount_rate;
                                @endphp
                            @endforeach
                            ({{ array_sum($sum_discount_selected) }}%)
                        </th>
                        <th style="text-align: center">BO Allowance
                            ({{ $received_purchase_order->bo_allowance_discount_rate }}%)</th>
                        <th style="text-align: center">CWO
                            ({{ $received_purchase_order->cwo_discount_rate }}%)</th>
                        <th style="text-align: center">T.Discount<br /></th>
                        <th>VAT</th>
                        <th>Freight</th>
                        <th style="text-align: center">Final Total Cost</th>
                        <th style="text-align: center">Final Unit Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($received_purchase_order->received_purchase_order_details as $details)
                        <tr>
                            <td><span style="color:green;font-weight:bold;">{{ $details->sku->sku_code }}</span>-
                                {{ $details->sku->description }}
                            </td>
                            <td style="text-align: right">{{ $details->quantity - $details->quantity_returned }}
                                @php
                                    $quantity_final = $details->quantity - $details->quantity_returned;
                                @endphp
                            </td>
                            <td style="text-align: right">{{ number_format($details->unit_cost, 2, '.', ',') }}</td>
                            <td style="text-align: right">
                                @php
                                    $total_amount = $quantity_final * $details->unit_cost;
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
                                    $bo_allowance_discount = $total_amount * ($received_purchase_order->bo_allowance_discount_rate / 100);
                                    $sum_bo_allowance_discount[] = $bo_allowance_discount;
                                    echo number_format($bo_allowance_discount, 2, '.', ',');
                                @endphp
                            </td>
                            <td style="text-align: right">
                                @php
                                    $cwo_discount = $total_amount * ($received_purchase_order->cwo_discount_rate / 100);
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
                                    $freight_per_sku = $details->freight * $quantity_final;
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
                                    $final_unit_cost = $final_total_cost / $quantity_final;
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

        @if ($received_purchase_order->total_less_other_discount != 0)
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
                @foreach ($received_purchase_order->received_other_discount_details as $data_discount)
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
                            {{ $received_purchase_order->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($net_payable, 2, '.', ','); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">ACCOUNTS PAYABLE
                            {{ $received_purchase_order->principal->principal }}</td>
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
                            {{ $received_purchase_order->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost, 2, '.', ','); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">ACCOUNTS PAYABLE
                            {{ $received_purchase_order->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost, 2, '.', ','); ?></td>
                    </tr>
                </tbody>
            </table>
        @endif
    @elseif($received_purchase_order->discount_type == 'type_b')
        <div class="table table-responsive">
            <table class="table table-bordered table-sm table-hover table-striped">
                <thead>
                    <tr>
                        <th>Desc</th>
                        <th>Received</th>
                        <th style="text-align: center;">U/C<br />(VAT EX)</th>
                        <th>Amount</th>
                        @foreach ($received_purchase_order->received_discount_details as $data)
                            <th style="text-align: center;">{{ Str::ucfirst($data->discount_name) }}
                                ({{ $data->discount_rate }}%)
                            </th>
                        @endforeach
                        {{-- <th style="text-align: center">BO Allowance
                        ({{ $received_purchase_order->bo_allowance_discount_rate }}%)</th> --}}
                        <th style="text-align: center">T.Discount<br /></th>
                        <th>VAT</th>
                        <th style="text-align: center">Freight</th>
                        <th style="text-align: center">Final Total Cost</th>
                        <th style="text-align: center">Final Unit Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($received_purchase_order->received_purchase_order_details as $details)
                        <tr>
                            <td style="font-size:10px;">
                                <span style="color:green;font-weight:bold;">{{ $details->sku->sku_code }}</span>-
                                {{ $details->sku->description }}

                            </td>
                            <td style="text-align: right">{{ $details->quantity }}
                                @php
                                    $quantity_final = $details->quantity - $details_quantity_returned;
                                @endphp
                            </td>
                            <td style="text-align: right">{{ number_format($details->unit_cost, 2, '.', ',') }}</td>
                            <td style="text-align: right">
                                @php
                                    $total_amount = $quantity_final * $details->unit_cost;
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
                                foreach ($received_purchase_order->received_discount_details as $data_discount) {
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
                                    $freight_per_sku = $details->freight * $quantity_final;
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
                                    $final_unit_cost_per_sku = $final_total_cost_per_sku / $quantity_final;
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
                            foreach ($received_purchase_order->received_discount_details as $data_discount) {
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

        @if ($received_purchase_order->total_less_other_discount != 0)
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
                    foreach ($received_purchase_order->received_discount_details as $data_discount) {
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
                {{-- <tr>
                <input type="hidden" name="total_less_discount"
                    value="{{ array_sum($less_discount_value_holder_history) }}">
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
                            $vatable_purchase = $gross_purchases - array_sum($less_discount_value_holder_history) - $bo_discount;
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
                @foreach ($received_purchase_order->received_other_discount_details as $data_discount)
                    {{-- <tr>
                        <td style="text-align:left">
                            {{ Str::ucfirst($data_discount->discount_name) . '(' . $data_discount->discount_rate / 100 . ')' }}
                        </td> --}}
                    @php
                        $discount_value_holder_dummy = $discount_value_holder;
                        $less_percentage_by = $data_discount->discount_rate / 100;
                        
                        // $discount_value_holder = $discount_value_holder_dummy - $discount_value_holder_dummy * $less_percentage_by;
                        $less_discount_rate_answer = $discount_value_holder * $less_percentage_by;
                        $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                        
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
                            $net_payable = $total_final_cost - array_sum($less_discount_value_holder_history);
                        @endphp
                        {{ number_format($net_payable, 2, '.', ',') }}
                        <input type="hidden" value="{{ $net_payable }}" name="net_payable">
                        <input type="hidden" name="total_less_other_discount" value="{{ $total_other_discounts }}">
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
                            {{ $received_purchase_order->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($net_payable, 2, '.', ','); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">ACCOUNTS PAYABLE
                            {{ $received_purchase_order->principal->principal }}</td>
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
                    foreach ($received_purchase_order->received_discount_details as $data_discount) {
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
                {{-- <tr>
                <input type="hidden" name="total_less_discount"
                    value="{{ array_sum($less_discount_value_holder_history) }}">
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
                            $vatable_purchase = $gross_purchases - array_sum($less_discount_value_holder_history) - $bo_discount;
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
                        <td style="text-align: center;">INVENTORY
                            {{ $received_purchase_order->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost, 2, '.', ','); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">ACCOUNTS PAYABLE
                            {{ $received_purchase_order->principal->principal }}</td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;"><?php echo number_format($total_final_cost, 2, '.', ','); ?></td>
                    </tr>
                </tbody>
            </table>
        @endif
    @endif
</div>

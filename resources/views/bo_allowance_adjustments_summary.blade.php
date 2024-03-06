<form id="bo_allowance_adjustments_save">
    <div class="table table-responsive">
        @if ($received_purchase_order->discount_type == 'type_a')
            <div class="table table-responsive">
                <table class="table table-bordered table-hover table-striped table-sm">
                    <thead>
                        <tr>
                            <th colspan="10">Particulars: {{ $particulars }}</th>
                        </tr>
                        <tr>
                            <th class="text-center align-middle">Code</th>
                            <th class="text-center align-middle">Description</th>
                            <th class="text-center align-middle">UOM</th>
                            <th class="text-center align-middle">Quantity</th>
                            {{-- <th class="text-center align-middle">Invoice Cost</th> --}}
                            {{-- <th class="text-center align-middle">Amount</th> --}}
                            <th class="text-center align-middle">BO Cost Adjustment</th>
                            <th class="text-center align-middle">BO Discount</th>
                            <th class="text-center align-middle">BO Allowance</th>
                            <th class="text-center align-middle">Vat</th>
                            {{-- <th class="text-center align-middle">Adjusted Amount</th>
                        <th class="text-center align-middle">Adjusted FUC</th> --}}
                            <th class="text-center align-middle">Freight</th>
                            <th class="text-center align-middle">Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sku as $data)
                            <tr>
                                <td style="text-transform: uppercase;text-align: center;">{{ $code[$data->sku_id] }}
                                </td>
                                <td style="text-transform: uppercase;text-align: center;">
                                    {{ $description[$data->sku_id] }}
                                </td>
                                <td style="text-transform: uppercase;text-align: center;">
                                    {{ $unit_of_measurement[$data->sku_id] }}
                                    <input type="hidden" name="sku_id[]" value="{{ $data->sku_id }}">
                                </td>
                                <td style="text-align: center;">{{ $quantity[$data->sku_id] }}
                                    <input type="hidden" name="quantity[{{ $data->sku_id }}]"
                                        value="{{ $quantity[$data->sku_id] }}">
                                </td>
                                <td style="text-align: right;">
                                    {{ number_format($unit_cost_adjustment, 4, '.', ',') }}
                                    <input type="hidden" name="bo_cost_adjustment[{{ $data->sku_id }}]"
                                        value="{{ $unit_cost_adjustment }}">
                                </td>
                                <td style="text-align: right;">
                                    @php
                                        $new_bo_allowance_layer = (($unit_cost_adjustment / $data->unit_cost)*100) + $bo_allowance_layer;
                                    @endphp
                                    {{ number_format($bo_allowance_layer, 4, '.', ',') . '%' }}
                                    <input type="text" name="new_bo_allowance_layer"
                                        value="{{ $new_bo_allowance_layer }}">
                                    <input type="text" name="bo_discount[{{ $data->sku_id }}]"
                                        value="{{ $bo_allowance_layer }}">

                                        {{-- @php
                                        $new_bo_allowance_layer =
                                $unit_cost_adjustment / $data->unit_cost + $bo_allowance_layer;
                                    @endphp
                                    {{ number_format($bo_allowance_layer*100, 4, '.', ',') . '%' }}
                                    <input type="hidden" name="bo_discount[{{ $data->sku_id }}]"
                                        value="{{ $bo_allowance_layer*100 }}">
    
                                    <input type="text" name="new_bo_allowance_layer"
                                        value="{{ ((($unit_cost_adjustment / ($invoice_cost_layer - array_sum($discount_value_holder_history))) * 100 + $bo_allowance_layer * 100) / 100)*100 }}"> --}}
                                </td>
                                <td style="text-align: right;">
                                    @php
                                        $total_amount = $unit_cost_adjustment * $quantity[$data->sku_id];
                                        $sum_total_amount[] = $total_amount;
                                    @endphp
                                    {{ number_format($total_amount, 4, '.', ',') }}
                                    <input type="hidden" name="bo_allowance[{{ $data->sku_id }}]"
                                        value="{{ $total_amount }}">
                                </td>
                                <td style="text-align: right">
                                    @if ($unit_cost_adjustment > 0)
                                        @php
                                            $vat = $total_amount * -0.12;
                                            $sum_total_vat[] = $vat;
                                            echo number_format($vat, 4, '.', ',');
                                        @endphp
                                    @else
                                        @php
                                            $vat = $total_amount * 0.12 * -1;
                                            $sum_total_vat[] = $vat;
                                            echo number_format($vat, 4, '.', ',');
                                        @endphp
                                    @endif
                                    <input type="hidden" name="vat[{{ $data->sku_id }}]" value="{{ $vat }}">
                                </td>
                                <td style="text-align: right">
                                    {{ number_format($data->freight, 4, '.', ',') }}
                                    <input type="hidden" name="freight[{{ $data->sku_id }}]"
                                        value="{{ $data->freight }}">
                                </td>
                                <td style="text-align: right">
                                    @if ($unit_cost_adjustment > 0)
                                        @php
                                            $total_cost = ($total_amount - $vat + $data->freight) * -1;
                                        @endphp
                                        {{ number_format($total_cost, 4, '.', ',') }}
                                    @else
                                        @php
                                            $total_cost = ($total_amount - $vat + $data->freight) * -1;
                                        @endphp
                                        {{ number_format($total_cost, 4, '.', ',') }}
                                    @endif
                                    @php
                                        $sum_total_cost[] = $total_cost;
                                    @endphp
                                    <input type="hidden" name="total_cost[{{ $data->sku_id }}]"
                                        value="{{ $total_cost }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" style="text-align: center;font-weight: bold;">GRAND TOTAL</th>
                            <th style="text-align: right;">
                                {{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}
                            </th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right;">{{ number_format(array_sum($sum_total_cost), 2, '.', ',') }}
                            </th>

                        </tr>
                    </tfoot>
                </table>
            </div>


            <table class="table table-bordered table-hover table-striped table-sm float-right" style="width:35%;">
                <tr>
                    <td style="font-weight: bold; text-align: center;" colspan="2">FINAL SUMMARY:
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">BO ALLOWANCE</td>
                    <td style="font-weight: bold; text-align: right;font-size: 15px;">
                        @php
                            $bo_allowance_deduction = array_sum($sum_total_cost);
                        @endphp
                        {{ number_format($bo_allowance_deduction, 2, '.', ',') }}
                        <input type="hidden" name="bo_allowance_deduction" value="{{ $bo_allowance_deduction }}">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">NET DEDUCTION</td>
                    <td style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                        {{-- @php
                    $vat_deduction = array_sum($sum_total_amount) * 0.12;
                @endphp
                <input type="hidden" name="vat_deduction" value="{{ $vat_deduction }}"> --}}
                        @php
                            $net_deduction = $bo_allowance_deduction;
                        @endphp
                        {{ number_format($net_deduction, 2, '.', ',') }}
                        <input type="hidden" name="net_deduction" value="{{ $net_deduction }}">
                    </td>
                </tr>
            </table>
            @if ($net_deduction > 0)
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
                            <td style="text-align: center;">{{ $get_merchandise_inventory->account_name }}</td>
                            <td></td>
                            <td style="font-weight: bold;text-align: center;">
                                {{ number_format($net_deduction, 2, '.', ',') }}
                            </td>
                            <td></td>

                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: center;">{{ $get_accounts_payable->account_name }}</td>
                            <td></td>
                            <td style="font-weight: bold;text-align: center;">
                                {{ number_format($net_deduction, 2, '.', ',') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @else
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
                            <td style="text-align: center;">{{ $get_accounts_payable->account_name }}</td>
                            <td></td>
                            <td style="font-weight: bold;text-align: center;">
                                {{ number_format($net_deduction * -1, 2, '.', ',') }}
                            </td>
                            <td></td>

                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: center;">{{ $get_merchandise_inventory->account_name }}</td>
                            <td></td>
                            <td style="font-weight: bold;text-align: center;">
                                {{ number_format($net_deduction * -1, 2, '.', ',') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        @elseif($received_purchase_order->discount_type == 'type_b')
            <table class="table table-bordered table-hover table-striped table-sm">
                <thead>
                    <tr>
                        <th colspan="10">Particulars: {{ $particulars }}</th>
                    </tr>
                    <tr>
                        <th class="text-center align-middle">Code</th>
                        <th class="text-center align-middle">Description</th>
                        <th class="text-center align-middle">UOM</th>
                        <th class="text-center align-middle">Quantity</th>
                        <th class="text-center align-middle">BO Cost Adjustment</th>
                        <th class="text-center align-middle">BO Discount</th>
                        <th class="text-center align-middle">BO Allowance</th>
                        <th class="text-center align-middle">Vat</th>
                        <th class="text-center align-middle">Freight</th>
                        <th class="text-center align-middle">Total Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sku as $data)
                        <tr>
                            <td style="text-transform: uppercase;text-align: center;">{{ $code[$data->sku_id] }}
                            </td>
                            <td style="text-transform: uppercase;text-align: center;">
                                {{ $description[$data->sku_id] }}
                            </td>
                            <td style="text-transform: uppercase;text-align: center;">
                                {{ $unit_of_measurement[$data->sku_id] }}
                                <input type="hidden" name="sku_id[]" value="{{ $data->sku_id }}">
                            </td>
                            <td style="text-align: center;">{{ $quantity[$data->sku_id] }}
                                <input type="hidden" name="quantity[{{ $data->sku_id }}]"
                                    value="{{ $quantity[$data->sku_id] }}">
                            </td>
                            @php
                                $total = round($data->unit_cost, 2);
                                $discount_value_holder = $total;
                                $discount_value_holder_history = [];
                                $discount_value_holder_history_for_bo_allowance = [];
                            @endphp
                            @foreach ($received_purchase_order->received_discount_details as $data_discount)
                                @if ($data_discount->discount_name != 'BO' && $data_discount->discount_name != 'CWO')
                                    @php
                                        $discount_value_holder_dummy = $discount_value_holder;

                                        $less_percentage_by = $data_discount->discount_rate / 100;
                                        $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                        $discount_value_holder =
                                            $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;

                                        $discount_value_holder_history[] = $discount_rate_answer;
                                        $discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;

                                    @endphp
                                @endif
                            @endforeach
                            <td style="text-align: right;">
                                {{ number_format($unit_cost_adjustment, 4, '.', ',') }}
                                <input type="hidden" name="bo_cost_adjustment[{{ $data->sku_id }}]"
                                    value="{{ $unit_cost_adjustment }}">
                            </td>
                            <td style="text-align: right;">
                                @php
                                    $new_bo_allowance_layer =
                            $unit_cost_adjustment / $data->unit_cost + $bo_allowance_layer;
                                @endphp
                                {{ number_format($bo_allowance_layer*100, 4, '.', ',') . '%' }}
                                <input type="hidden" name="bo_discount[{{ $data->sku_id }}]"
                                    value="{{ $bo_allowance_layer*100 }}">

                                <input type="text" name="new_bo_allowance_layer"
                                    value="{{ ((($unit_cost_adjustment / ($invoice_cost_layer - array_sum($discount_value_holder_history))) * 100 + $bo_allowance_layer * 100) / 100)*100 }}">
                            </td>
                            <td style="text-align: right;">
                                @php
                                    $total_amount = $unit_cost_adjustment * $quantity[$data->sku_id];
                                    $sum_total_amount[] = $total_amount;
                                @endphp
                                {{ number_format($total_amount, 4, '.', ',') }}
                                <input type="hidden" name="bo_allowance[{{ $data->sku_id }}]"
                                    value="{{ $total_amount }}">
                            </td>
                            <td style="text-align: right">

                                @if ($unit_cost_adjustment > 0)
                                    @php
                                        $vat = $total_amount * -0.12;
                                        $sum_total_vat[] = $vat;
                                        echo number_format($vat, 4, '.', ',');
                                    @endphp
                                @else
                                    @php
                                        $vat = $total_amount * 0.12 * -1;
                                        $sum_total_vat[] = $vat;
                                        echo number_format($vat, 4, '.', ',');
                                    @endphp
                                @endif
                                <input type="hidden" name="vat[{{ $data->sku_id }}]" value="{{ $vat }}">
                            </td>
                            <td style="text-align: right">
                                {{ number_format($data->freight, 4, '.', ',') }}
                                <input type="hidden" name="freight[{{ $data->sku_id }}]"
                                    value="{{ $data->freight }}">
                            </td>
                            <td style="text-align: right">
                                @if ($unit_cost_adjustment > 0)
                                    @php
                                        $total_cost = ($total_amount - $vat + $data->freight) * -1;
                                    @endphp
                                    {{ number_format($total_cost, 4, '.', ',') }}
                                @else
                                    @php
                                        $total_cost = ($total_amount - $vat + $data->freight) * -1;
                                    @endphp
                                    {{ number_format($total_cost, 4, '.', ',') }}
                                @endif
                                @php
                                    $sum_total_cost[] = $total_cost;
                                @endphp
                                <input type="hidden" name="total_cost[{{ $data->sku_id }}]"
                                    value="{{ $total_cost }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6" style="text-align: center;font-weight: bold;">GRAND TOTAL</th>
                        <th style="text-align: right;">
                            {{ number_format(array_sum($sum_total_amount), 2, '.', ',') }}
                        </th>
                        <th></th>
                        <th></th>
                        <th style="text-align: right;">{{ number_format(array_sum($sum_total_cost), 2, '.', ',') }}
                        </th>

                    </tr>
                </tfoot>
            </table>

            <table class="table table-bordered table-hover table-striped table-sm float-right" style="width:35%;">
                <tr>
                    <td style="font-weight: bold; text-align: center;" colspan="2">FINAL SUMMARY:
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">BO ALLOWANCE</td>
                    <td style="font-weight: bold; text-align: right;font-size: 15px;">
                        @php
                            $bo_allowance_deduction = array_sum($sum_total_cost);
                        @endphp
                        {{ number_format($bo_allowance_deduction, 2, '.', ',') }}
                        <input type="hidden" name="bo_allowance_deduction" value="{{ $bo_allowance_deduction }}">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">NET DEDUCTION</td>
                    <td
                        style="font-weight: bold; text-align: right;font-size: 15px;border-bottom: 3px double #000000;">
                        {{-- @php
                                $vat_deduction = array_sum($sum_total_amount) * 0.12;
                            @endphp
                            <input type="hidden" name="vat_deduction" value="{{ $vat_deduction }}"> --}}
                        @php
                            $net_deduction = $bo_allowance_deduction;
                        @endphp
                        {{ number_format($net_deduction, 2, '.', ',') }}
                        <input type="hidden" name="net_deduction" value="{{ $net_deduction }}">
                    </td>
                </tr>
            </table>
            @if ($net_deduction > 0)
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
                            <td style="text-align: center;">{{ $get_merchandise_inventory->account_name }}</td>
                            <td></td>
                            <td style="font-weight: bold;text-align: center;">
                                {{ number_format($net_deduction, 2, '.', ',') }}
                            </td>
                            <td></td>

                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: center;">{{ $get_accounts_payable->account_name }}</td>
                            <td></td>
                            <td style="font-weight: bold;text-align: center;">
                                {{ number_format($net_deduction, 2, '.', ',') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @else
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
                            <td style="text-align: center;">{{ $get_accounts_payable->account_name }}</td>
                            <td></td>
                            <td style="font-weight: bold;text-align: center;">
                                {{ number_format($net_deduction * -1, 2, '.', ',') }}
                            </td>
                            <td></td>

                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: center;">{{ $get_merchandise_inventory->account_name }}</td>
                            <td></td>
                            <td style="font-weight: bold;text-align: center;">
                                {{ number_format($net_deduction * -1, 2, '.', ',') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        @endif
    </div>
    <input type="hidden" value="{{ $transaction_date }}" name="transaction_date">
    <input type="hidden" value="{{ $received_id }}" name="received_id">
    <input type="hidden" value="{{ $principal_name }}" name="principal_name">
    <input type="hidden" value="{{ $principal_id }}" name="principal_id">
    <input type="hidden" value="{{ $particulars }}" name="particulars">


    <div class="row">
        <div class="col-md-12">
            <input type="hidden" value="{{ $get_accounts_payable->account_name }}"
                name="accounts_payable_account_name">
            <input type="hidden" value="{{ $get_accounts_payable->account_number }}"
                name="accounts_payable_account_number">
            <input type="hidden" value="{{ $get_accounts_payable->chart_of_accounts->account_number }}"
                name="accounts_payable_general_account_number">
            <input type="hidden" value="{{ $get_merchandise_inventory->account_name }}"
                name="merchandise_inventory_account_name">
            <input type="hidden" value="{{ $get_merchandise_inventory->account_number }}"
                name="merchandise_inventory_account_number">
            <input type="hidden" value="{{ $get_merchandise_inventory->chart_of_accounts->account_number }}"
                name="merchandise_inventory_general_account_number">

            <button class="btn btn-success btn-sm float-right" type="submit">Submit</button>
        </div>
    </div>

</form>

<script>
    $("#bo_allowance_adjustments_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "bo_allowance_adjustments_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
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

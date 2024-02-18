<form id="sales_order_draft_save">
    <div class="table table-responsive">
        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th style="text-align: center">Agent</th>
                    <th style="text-align: center">Customer</th>
                    <th style="text-align: center">Customer Code</th>
                    <th style="text-align: center">Price Level</th>
                    <th style="text-align: center">Principal</th>
                    <th style="text-align: center">Sku Type</th>
                    <th style="text-align: center">Mode of Transaction</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">{{ $sales_order_draft->agent->full_name }}</td>
                    <td style="text-align: center;">{{ $sales_order_draft->customer->store_name }}</td>
                    <td style="text-align: center;">{{ $customer_principal_code }}</td>
                    <td style="text-transform:uppercase;text-align:center;">{{ $customer_principal_price }}</td>
                    <td style="text-align: center;">{{ $sales_order_draft->principal->principal }}</td>
                    <td style="text-align: center;">{{ $sales_order_draft->sku_type }}</td>
                    <td style="text-align: center;">
                        {{ $sales_order_draft->mode_of_transaction }}
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered table-hover table-sm table-striped text-center" style="font-size:14px;">
            <thead>
                <tr>
                    @if ($customer_discount != 0)
                        <th colspan="{{ 11 + count($customer_discount) }}">DR: {{ $delivery_receipt }}</th>
                    @else
                        <th colspan="11">DR: {{ $delivery_receipt }}</th>
                    @endif
                </tr>
                <tr>
                    <th>Code</th>
                    <th>Desc</th>
                    <th>UOM</th>
                    <th>Qty</th>
                    <th>U/P</th>
                    <th>Sub Total</th>
                    @if ($customer_discount != 0)
                        @foreach ($customer_discount as $item_discount_rate)
                            <th>Less - {{ $item_discount_rate }}%</th>
                        @endforeach
                    @endif
                    <th>Total Discount</th>
                    <th>Final Total</th>
                    <th>Avg Cost</th>
                    <th>Sub Total</th>
                    <th>FUC</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_order_draft->sales_order_draft_details as $details)
                    <tr>
                        <td>{{ $details->sku->sku_code }}</td>
                        <td>{{ $details->sku->description }}</td>
                        <td>{{ $details->sku->unit_of_measurement }}</td>
                        <td style="text-align: right">{{ $final_quantity[$details->sku_id] }}
                            @php
                                $sum_quantity[] = $final_quantity[$details->sku_id];
                            @endphp
                        </td>
                        <td style="text-align: right">
                            {{ number_format($unit_price[$details->sku_id], 2, '.', ',') }}

                        </td>
                        <td style="text-align: right">
                            @php
                                $sub_total = $final_quantity[$details->sku_id] * $unit_price[$details->sku_id];
                                $sum_total[] = $sub_total;
                                echo number_format($sub_total, 2, '.', ',');
                                $sum_kg[] = $details->sku->kilograms;
                            @endphp
                            <input type="hidden" name="sku_id[]" value="{{ $details->sku_id }}">
                            <input type="hidden" name="unit_price[{{ $details->sku_id }}]"
                                value="{{ $unit_price[$details->sku_id] }}">
                            <input type="hidden" name="final_quantity[{{ $details->sku_id }}]"
                                value="{{ $final_quantity[$details->sku_id] }}">
                            <input type="hidden" name="kilograms[{{ $details->sku_id }}]"
                                value="{{ $details->sku->kilograms }}">

                        </td>
                        @php
                            $total = $sub_total;

                            $discount_value_holder = $total;
                            $discount_value_holder_history = [];
                            $discount_value_holder_history_for_bo_allowance = [];
                            $totalArray = [];
                            $percent = [];
                        @endphp
                        @if ($customer_discount != 0)
                            @foreach ($customer_discount as $item_discount_rate)
                                @php
                                    $discount_value_holder_dummy = $discount_value_holder;
                                    $less_percentage_by = $item_discount_rate / 100;

                                    $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                    $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;

                                    $discount_value_holder_history[] = $discount_rate_answer;
                                    $discount_value_holder_history_for_bo_allowance[] = $discount_value_holder;
                                    echo '<td style="text-align:right;">' . number_format($discount_rate_answer, 2, '.', ',') . '</td>';
                                @endphp
                            @endforeach
                        @else
                            @php
                                $discount_value_holder_history[] = 0;
                                $discount_value_holder_history_for_bo_allowance[] = 0;
                            @endphp
                        @endif
                        <td style="text-align:right">
                            @if ($customer_discount == 0)
                                @php
                                    $total_discount_per_sku = 0;
                                @endphp
                            @else
                                @php
                                    $total_discount_per_sku = $sub_total - end($discount_value_holder_history_for_bo_allowance);
                                @endphp
                            @endif

                            {{ number_format($total_discount_per_sku, 2, '.', ',') }}
                            <input type="hidden" name="total_discount_per_sku[{{ $details->sku_id }}]"
                                value="{{ $total_discount_per_sku }}">
                        </td>
                        <td style="text-align: right">
                            @if ($customer_discount == 0)
                                @php
                                    $final_total_per_sku = $sub_total;
                                @endphp
                            @else
                                @php
                                    $final_total_per_sku = $sub_total - $total_discount_per_sku;
                                @endphp
                            @endif
                            {{ number_format($final_total_per_sku, 2, '.', ',') }}
                            @php
                                $sum_total_discount_per_sku[] = $final_total_per_sku;
                            @endphp
                            <input type="hidden" name="total_amount_per_sku[{{ $details->sku_id }}]"
                                value="{{ $final_total_per_sku }}">
                        </td>
                        <td style="text-align: right">
                            @php
                                $unit_cost_sub_total = $details->sku->sku_ledger_get_average_cost->running_amount / $details->sku->sku_ledger_get_average_cost->running_balance;
                                $sum_unit_cost_sub_total[] = $unit_cost_sub_total * $final_quantity[$details->sku_id];

                                echo number_format($unit_cost_sub_total, 2, '.', ',');
                            @endphp

                            <input type="hidden" name="average_cost[{{ $details->sku_id }}]"
                                value="{{ $unit_cost_sub_total }}">
                            <input type="hidden" name="final_unit_cost[{{ $details->sku_id }}]"
                                value="{{ $details->sku->sku_ledger_get_average_cost->final_unit_cost }}">
                        </td>
                        <td style="text-align:right">
                            {{ number_format($unit_cost_sub_total * $final_quantity[$details->sku_id], 2, '.', ',') }}
                        </td>
                        <td style="text-align: right">
                            {{ $details->sku->sku_ledger_get_average_cost->final_unit_cost }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                @if ($customer_discount != 0)
                    <tr>
                        <th colspan="3" style="text-align: center">GROSS</th>
                        <th></th>
                        <th></th>
                        <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        @if ($customer_discount != 0)
                            @for ($i = 0; $i < count($customer_discount); $i++)
                                <th></th>
                            @endfor
                        @endif
                    </tr>
                    @php
                        $total = array_sum($sum_total);
                        $discount_holder = [];
                        $discount_value_holder = $total;
                    @endphp
                    @foreach ($customer_discount as $data_discount)
                        <tr>
                            <th style="text-align: center" colspan="3">LESS - {{ $data_discount }}</th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right">
                                @php
                                    $discount_value_holder_dummy = $discount_value_holder;
                                    $less_percentage_by = $data_discount / 100;

                                    $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                                    $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                                    $customer_discount_holder[] = $discount_value_holder_dummy * $less_percentage_by;
                                    $discount_holder[] = $discount_value_holder;
                                    echo number_format($discount_value_holder, 2, '.', ',');
                                @endphp
                                <input type="hidden" name="discount_rate[]" value="{{ $data_discount }}">
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            @if ($customer_discount != 0)
                                @for ($i = 0; $i < count($customer_discount); $i++)
                                    <th></th>
                                @endfor
                            @endif
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="3" style="text-align: center">TOTAL</th>
                        <th style="text-align: right">
                            {{ number_format(array_sum($sum_quantity), 2, '.', ',') }}
                        </th>
                        <th></th>
                        <th style="text-align: right;text-decoration: overline;color:green">
                            {{ number_format(end($discount_holder), 2, '.', ',') }}
                            @php
                                $final_total = end($discount_holder);
                            @endphp
                            <input type="hidden" value="{{ $final_total }}" name="final_total">
                            <input type="hidden" value="{{ array_sum($customer_discount_holder) }}"
                                name="customer_discount">
                        </th>
                        <th></th>
                        @if ($customer_discount != 0)
                            @for ($i = 0; $i < count($customer_discount); $i++)
                                <th></th>
                            @endfor
                        @endif
                        <th style="text-align: right;text-decoration: overline;color:red;">

                            {{ number_format(array_sum($sum_total_discount_per_sku), 2, '.', ',') }}

                        </th>
                        <th></th>
                        <th style="text-align: right;text-decoration: overline">
                            {{ number_format(array_sum($sum_unit_cost_sub_total), 2, '.', ',') }}
                        </th>
                    </tr>
                @else
                    <tr>
                        <th colspan="4" style="text-align: center">TOTAL</th>
                        <th style="text-align: right">
                            {{ number_format(array_sum($sum_quantity), 2, '.', ',') }}
                        </th>
                        <th style="text-align: right">
                            {{ number_format(array_sum($sum_total), 2, '.', ',') }}
                            <input type="hidden" value="{{ array_sum($sum_total) }}" name="final_total">
                            <input type="hidden" value="{{ 0 }}" name="customer_discount">
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th style="text-align: right">
                            {{ number_format(array_sum($sum_unit_cost_sub_total), 2, '.', ',') }}
                        </th>
                    </tr>
                @endif
            </tfoot>
        </table>

        @if ($customer_discount != 0)
            {{-- <table class="table table-bordered table-hover table-sm table-striped">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>

                        <th style="text-align: center;">DR</th>
                        <th style="text-align: center;">CR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">{{ $get_customer_ar->account_name }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format($final_total, 2, '.', ',') }}
                            <input type="hidden" value="{{ $final_total }}" name="customer_ar_total">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">{{ $get_sales->account_name }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format($final_total, 2, '.', ',') }}
                            <input type="hidden" name="final_gross_amount_jer" value="{{ $final_total }}">
                            <input type="hidden" value="{{ $final_total }}" name="sales_total">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">{{ $get_cost_of_sales->account_name }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format(array_sum($sum_unit_cost_sub_total), 2, '.', ',') }}
                            <input type="hidden" value="{{ array_sum($sum_unit_cost_sub_total) }}"
                                name="cost_of_sales_total">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">{{ $get_merchandise_inventory->account_name }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format(array_sum($sum_unit_cost_sub_total), 2, '.', ',') }}
                            <input type="hidden" name="final_unit_cost_amount_jer"
                                value="{{ array_sum($sum_unit_cost_sub_total) }}">
                            <input type="hidden" value="{{ array_sum($sum_unit_cost_sub_total) }}"
                                name="inventory_total">
                        </td>
                    </tr>
                </tbody>
            </table> --}}


            <input type="hidden" value="{{ $final_total }}" name="customer_ar_total">
            <input type="hidden" name="final_gross_amount_jer" value="{{ $final_total }}">
            <input type="hidden" value="{{ $final_total }}" name="sales_total">
            <input type="hidden" value="{{ array_sum($sum_unit_cost_sub_total) }}" name="cost_of_sales_total">
            <input type="hidden" name="final_unit_cost_amount_jer" value="{{ array_sum($sum_unit_cost_sub_total) }}">
            <input type="hidden" value="{{ array_sum($sum_unit_cost_sub_total) }}" name="inventory_total">
        @else
            {{-- <table class="table table-bordered table-hover table-sm table-striped">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                        <th style="text-align: center;">DR</th>
                        <th style="text-align: center;">CR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">{{ $get_customer_ar->account_name }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format(array_sum($sum_total), 2, '.', ',') }}
                            <input type="hidden" value="{{ array_sum($sum_total) }}" name="customer_ar_total">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">{{ $get_sales->account_name }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format(array_sum($sum_total), 2, '.', ',') }}
                            <input type="hidden" name="final_gross_amount_jer" value="{{ array_sum($sum_total) }}">
                            <input type="hidden" value="{{ array_sum($sum_total) }}" name="sales_total">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">{{ $get_cost_of_sales->account_name }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format(array_sum($sum_unit_cost_sub_total), 2, '.', ',') }}
                            <input type="hidden" value="{{ array_sum($sum_unit_cost_sub_total) }}"
                                name="cost_of_sales_total">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: center;">{{ $get_merchandise_inventory->account_name }}
                        </td>
                        <td></td>
                        <td style="font-weight: bold;text-align: center;">
                            {{ number_format(array_sum($sum_unit_cost_sub_total), 2, '.', ',') }}
                            <input type="hidden" name="final_unit_cost_amount_jer"
                                value="{{ array_sum($sum_unit_cost_sub_total) }}">
                            <input type="hidden" value="{{ array_sum($sum_unit_cost_sub_total) }}"
                                name="inventory_total">
                        </td>
                    </tr>
                </tbody>
            </table> --}}


            <input type="hidden" value="{{ array_sum($sum_total) }}" name="customer_ar_total">
            <input type="hidden" name="final_gross_amount_jer" value="{{ array_sum($sum_total) }}">
            <input type="hidden" value="{{ array_sum($sum_total) }}" name="sales_total">
            <input type="hidden" value="{{ array_sum($sum_unit_cost_sub_total) }}" name="cost_of_sales_total">
            <input type="hidden" name="final_unit_cost_amount_jer"
                value="{{ array_sum($sum_unit_cost_sub_total) }}">
            <input type="hidden" value="{{ array_sum($sum_unit_cost_sub_total) }}" name="inventory_total">
        @endif


    </div>
    <div class="row">
        <div class="col-md-12">
            <br />


            <input type="hidden" value="{{ $get_merchandise_inventory->account_name }}"
                name="merchandise_inventory_account_name">
            <input type="hidden" value="{{ $get_merchandise_inventory->account_number }}"
                name="merchandise_inventory_account_number">
            <input type="hidden" value="{{ $get_merchandise_inventory->chart_of_accounts->account_number }}"
                name="merchandise_inventory_general_account_number">

            <input type="hidden" value="{{ $get_sales->account_name }}" name="sales_account_name">
            <input type="hidden" value="{{ $get_sales->account_number }}" name="sales_account_number">
            <input type="hidden" value="{{ $get_sales->chart_of_accounts->account_number }}"
                name="sales_general_account_number">

            <input type="hidden" value="{{ $get_cost_of_sales->account_name }}" name="cost_of_sales_account_name">
            <input type="hidden" value="{{ $get_cost_of_sales->account_number }}"
                name="cost_of_sales_account_number">
            <input type="hidden" value="{{ $get_cost_of_sales->chart_of_accounts->account_number }}"
                name="cost_of_sales_general_account_number">

            <input type="hidden" value="{{ $get_customer_ar->account_name }}" name="customer_ar_account_name">
            <input type="hidden" value="{{ $get_customer_ar->account_number }}" name="customer_ar_account_number">
            <input type="hidden" value="{{ $get_customer_ar->chart_of_accounts->account_number }}"
                name="customer_ar_general_account_number">




            <input type="hidden" value="{{ $customer_id }}" name="customer_id">
            <input type="hidden" value="{{ $mode_of_transaction }}" name="mode_of_transaction">
            <input type="hidden" value="{{ $sku_type }}" name="sku_type">
            <input type="hidden" value="{{ $agent_id }}" name="agent_id">
            <input type="hidden" value="{{ $delivery_receipt }}" name="delivery_receipt">
            <input type="hidden" value="{{ $principal_id }}" name="principal_id">
            <input type="hidden" value="{{ $sales_order_draft->sales_order_number }}" name="sales_order_number">
            <input type="hidden" value="{{ $sales_order_draft->id }}" name="sales_order_draft_id">
            <button type="submit" class="btn btn-success btn-sm float-right">Submit</button>
        </div>
    </div>
</form>


<script>
    $("#sales_order_draft_save").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "sales_order_draft_save",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                Swal.fire(
                    'Transaction Saved',
                    '',
                    'success'
                )
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

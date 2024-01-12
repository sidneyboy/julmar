<center>
    <h3 style="font-weight: bold;">COLLECTION RECEIPT FINAL SUMMARY</h3>
</center><br />

<form id="collection_saved">
    @csrf
    <table class="table table-bordered table-sm table-striped">
        <tr>
            <th>SALES AGENT</th>
            <th>{{ $sales_invoice[0]->sales_invoice_agent->full_name }}
                <input type="hidden" name="agent_id" value="{{ $sales_invoice[0]->sales_invoice_agent->id }}">
            </th>
            <th>DATE</th>
            <th>{{ $date }}</th>
        </tr>
        <tr>
            <th>CUSTOMER NAME</th>
            <th>{{ $sales_invoice[0]->sales_invoice_customer->store_name }}</th>
            <th>CHECK REF./CASH</th>
            <th>{{ $check_ref_cash }}
                <input type="hidden" name="check_ref_cash" value="{{ $check_ref_cash }}">
            </th>
        </tr>
        <tr>
            <th>OFFICIAL RECEIPT NO.</th>
            <th>{{ $official_receipt_no }}
                <input type="hidden" name="official_receipt_no" value="{{ $official_receipt_no }}">
            </th>
            <th>BANK</th>
            <th>
                {{ $bank }}
                <input type="hidden" name="bank" value="{{ $bank }}">
            </th>
        </tr>
        <tr>
            <th colspan="2"></th>
            <th>PAYMENT DATE</th>
            <th>{{ $payment_date }}
                <input type="hidden" name="payment_date" value="{{ $payment_date }}">
            </th>
        </tr>
    </table>

    <div class="table table-responsive">
        <table class="table table-bordered table-sm table-striped">
            <thead>
                <tr>
                    <th style="text-align: center">DRIVER</th>
                    <th style="text-align: center">DELIVERED DATE</th>
                    <th style="text-align: center">DELIVERY RECEIPT</th>
                    <th style="text-align: center">PRINCIPAL</th>
                    <th style="text-align: center">A/R BALANCE</th>
                    <th style="text-align: center">AMOUNT COLLECTED</th>
                    <th style="text-align: center">OUTSTANDING BALANCE</th>
                    <th style="text-align: center">CM APPLIED</th>
                    <th style="text-align: center">REMARKS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales_invoice as $data)
                    <tr>
                        <td>
                            @if (!isset($data->logistics_invoices->logistics_driver))
                                Not yet updated
                            @else
                                {{ $data->logistics_invoices->logistics_driver->driver }}
                            @endif
                        </td>
                        <td>
                            @if (!isset($data->delivered_date))
                                Not yet updated
                            @else
                                {{ $data->delivered_date }}
                            @endif
                        </td>
                        <td>{{ $data->delivery_receipt }}</td>
                        <td>{{ $data->principal->principal }}</td>
                        <td style="text-align: right">
                            @php
                                $outstanding_balance = $data->total - $data->total_returned_amount - $data->total_payment;
                                echo number_format($outstanding_balance, 2, '.', ',');
                            @endphp

                            <input type="hidden" name="outstanding_balance[{{ $data->id }}]"
                                value="{{ $outstanding_balance }}">
                        </td>
                        <td style="text-align:right">
                            @php
                                $sum_amount_collected[] = $amount_collected[$data->id];
                                echo number_format($amount_collected[$data->id], 2, '.', ',');
                            @endphp
                            <input type="hidden" name="amount_collected[{{ $data->id }}]"
                                value="{{ $amount_collected[$data->id] }}">
                        </td>
                        <td style="text-align: right">
                            @php
                                $new_outstanding_balance = $outstanding_balance - $amount_collected[$data->id];
                                echo number_format($new_outstanding_balance, 2, '.', ',');
                            @endphp

                            <input type="hidden" name="new_outstanding_balance[{{ $data->id }}]"
                                value="{{ $new_outstanding_balance }}">
                        </td>
                        <td style="text-align: center">
                            {{ $cm_number[$data->id] }}
                        </td>
                        <td>
                            {{ $remarks[$data->id] }}
                            <input type="hidden" name="remarks[{{ $data->id }}]"
                                value="{{ $remarks[$data->id] }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5"></th>
                    <th style="text-align: right">
                        {{ number_format(array_sum($sum_amount_collected), 2, '.', ',') }}
                    </th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <input type="hidden" value="{{ $disbursement }}" name="disbursement">
    <input type="hidden" value="{{ $customer_id }}" name="customer_id">


    <table class="table table-bordered table-hover table-sm table-striped">
        <thead>
            <tr>
                <th colspan="2" style="text-align: center;">JOURNAL ENTRY</th>
                <th style="text-align: center;">DR</th>
                <th style="text-align: center;">CR</th>
            </tr>
        </thead>
        <tbody>
            @if (array_sum($bo_accounts_receivable) != 0)
                <tr>
                    <td style="text-align: center;">{{ $get_spoiled_goods->account_name }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($bo_poiled_goods), 2, '.', ','); ?></td>
                    <td>
                        <input type="hidden" name="bo_spoiled_goods" value="{{ array_sum($bo_poiled_goods) }}">
                        <input type="hidden" value="{{ $get_spoiled_goods->account_name }}"
                            name="get_spoiled_goods_account_name">
                        <input type="hidden" value="{{ $get_spoiled_goods->account_number }}"
                            name="get_spoiled_goods_account_number">
                        <input type="hidden" value="{{ $get_spoiled_goods->chart_of_accounts->account_number }}"
                            name="get_spoiled_goods_general_account_number">

                        @for ($bo = 0; $bo < count($bo_principal_id); $bo++)
                            <input type="hidden" name="bo_principal_id[]" value="{{ $bo_principal_id[$bo] }}">
                            <input type="hidden" name="bo_id[]" value="{{ $bo_id[$bo] }}">
                        @endfor
                    </td>
                </tr>
            @endif
            @if (array_sum($rgs_accounts_receivable) != 0)
                <tr>
                    <td style="text-align: center;">{{ $get_sales_return_and_allowances->account_name }}</td>
                    <td>
                        <input type="hidden" value="{{ $get_sales_return_and_allowances->account_name }}"
                            name="get_sales_return_and_allowances_account_name">
                        <input type="hidden" value="{{ $get_sales_return_and_allowances->account_number }}"
                            name="get_sales_return_and_allowances_account_number">
                        <input type="hidden"
                            value="{{ $get_sales_return_and_allowances->chart_of_accounts->account_number }}"
                            name="get_sales_return_and_allowances_general_account_number">
                    </td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($rgs_sales_return_and_allowances), 2, '.', ','); ?></td>
                    <td><input type="hidden" name="rgs_sales_return_and_allowances"
                            value="{{ array_sum($rgs_sales_return_and_allowances) }}">

                        @foreach ($rgs_principal_id as $rgs_principal_id_data)
                            <input type="hidden" name="rgs_principal_id[]" value="{{ $rgs_principal_id_data }}">
                        @endforeach

                        @foreach ($rgs_id as $rgs_id_data)
                            <input type="hidden" name="rgs_id[]" value="{{ $rgs_id_data }}">
                        @endforeach
                    </td>
                </tr>
                @for ($i = 0; $i < count($get_merchandise_inventory_account_name); $i++)
                    @if ($get_merchandise_inventory_account_name[$i] != '')
                        <tr>
                            <td style="text-align: center;">{{ $get_merchandise_inventory_account_name[$i] }}</td>
                            <td>
                                <input type="hidden" value="{{ $get_merchandise_inventory_account_name[$i] }}"
                                    name="get_merchandise_inventory_account_name[]">
                                <input type="hidden" value="{{ $get_merchandise_inventory_account_number[$i] }}"
                                    name="get_merchandise_inventory_account_number[]">
                                <input type="hidden"
                                    value="{{ $get_merchandise_inventory_chart_of_accounts_id[$i] }}"
                                    name="get_merchandise_inventory_general_account_number[]">
                            </td>
                            <td style="font-weight: bold;text-align: center;">
                                {{ number_format($rgs_inventory[$i], 2, '.', ',') }}
                            </td>
                            <td><input type="hidden" name="rgs_inventory[]" value="{{ $rgs_inventory[$i] }}">
                            </td>
                        </tr>
                    @endif
                @endfor
                @for ($j = 0; $j < count($get_cost_of_sales_account_name); $j++)
                    @if ($get_cost_of_sales_account_name[$j] != '')
                        <tr>
                            <td>
                                <input type="hidden" value="{{ $get_cost_of_sales_account_name[$j] }}"
                                    name="get_cost_of_sales_account_name[]">
                                <input type="hidden" value="{{ $get_cost_of_sales_account_number[$j] }}"
                                    name="get_cost_of_sales_account_number[]">
                                <input type="hidden"
                                    value="{{ $get_cost_of_sales_chart_of_accounts_id[$j] }}"
                                    name="get_cost_of_sales_general_account_number[]">
                            </td>
                            <td style="text-align: center;">{{ $get_cost_of_sales_account_name[$j] }}</td>
                            <td><input type="hidden" name="rgs_cost_of_goods_sold[]"
                                    value="{{ $rgs_inventory[$j] }}">
                            </td>
                            <td style="font-weight: bold;text-align: center;">
                                {{ number_format($rgs_cost_of_goods_sold[$j], 2, '.', ',') }}
                            </td>
                        </tr>
                    @endif
                @endfor

            @endif
            <tr>
                <td style="text-align: center;">
                    {{ $bank }}</td>
                <td></td>
                <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($sum_amount_collected), 2, '.', ','); ?></td>
                <td><input type="hidden" name="debit_record" value="{{ array_sum($sum_amount_collected) }}">
                    <input type="hidden" name="cash_in_bank_total" value="{{ array_sum($sum_amount_collected) }}">
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center;">{{ $get_customer_ar->account_name }}</td>
                <td><input type="hidden" name="credit_record" value="{{ array_sum($sum_amount_collected) }}">
                </td>
                <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($sum_amount_collected), 2, '.', ','); ?>
                    <input type="hidden" name="customer_ar_total" value="{{ array_sum($sum_amount_collected) }}">
                </td>
            </tr>










            {{-- <tr>
                    <td></td>
                    <td style="text-align: center;">{{ $get_customer_ar->account_name }}</td>
                    <td><input type="hidden" name="credit_record" value="{{ array_sum($bo_poiled_goods) }}">
                    </td>
                    <td style="font-weight: bold;text-align: center;">
                        <?php echo number_format(array_sum($bo_poiled_goods), 2, '.', ','); ?>
                        <input type="hidden" name="bo_accounts_receivable" value="{{ array_sum($bo_poiled_goods) }}">
                    </td>
                </tr> --}}
        </tbody>
    </table>





    {{-- 

    @if (array_sum($rgs_accounts_receivable) != 0)
        <table class="table table-bordered table-hover table-sm table-striped">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center;">JOURNAL ENTRY - RGS</th>
                    <th style="text-align: center;">DR</th>
                    <th style="text-align: center;">CR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">{{ $get_sales_return_and_allowances->account_name }}</td>
                    <td></td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($rgs_sales_return_and_allowances), 2, '.', ','); ?></td>
                    <td><input type="hidden" name="rgs_sales_return_and_allowances"
                            value="{{ array_sum($rgs_sales_return_and_allowances) }}">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center;">{{ $get_customer_ar->account_name }}</td>
                    <td><input type="hidden" name="credit_record"
                            value="{{ array_sum($rgs_accounts_receivable) }}">
                    </td>
                    <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($rgs_accounts_receivable), 2, '.', ','); ?>
                        <input type="hidden" name="rgs_accounts_receivable"
                            value="{{ array_sum($rgs_accounts_receivable) }}">
                    </td>
                </tr>
                @for ($i = 0; $i < count($get_merchandise_inventory_account_name); $i++)
                    @if ($get_merchandise_inventory_account_name[$i] != '')
                        <tr>
                            <td style="text-align: center;">{{ $get_merchandise_inventory_account_name[$i] }}</td>
                            <td></td>
                            <td style="font-weight: bold;text-align: center;">
                                {{ number_format($rgs_inventory[$i], 2, '.', ',') }}
                            </td>
                            <td><input type="hidden" name="rgs_inventory[]" value="{{ $rgs_inventory[$i] }}">
                            </td>
                        </tr>
                    @endif
                @endfor
                @for ($j = 0; $j < count($get_cost_of_sales_account_name); $j++)
                    @if ($get_cost_of_sales_account_name[$j] != '')
                        <tr>
                            <td></td>
                            <td style="text-align: center;">{{ $get_cost_of_sales_account_name[$j] }}</td>
                            <td><input type="hidden" name="rgs_cost_of_goods_sold[]"
                                    value="{{ $rgs_inventory[$j] }}">
                            </td>
                            <td style="font-weight: bold;text-align: center;">
                                {{ number_format($rgs_cost_of_goods_sold[$j], 2, '.', ',') }}
                            </td>
                        </tr>
                    @endif
                @endfor
            </tbody>
        </table>

        @foreach ($rgs_principal_id as $rgs_principal_id_data)
            <input type="text" name="rgs_principal_id[]" value="{{ $rgs_principal_id_data }}">
        @endforeach

        @foreach ($rgs_id as $rgs_id_data)
            <input type="text" name="rgs_id[]" value="{{ $rgs_id_data }}">
        @endforeach


    @endif --}}


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
                <td style="text-align: center;">
                    {{ $bank }}</td>
                <td></td>
                <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($sum_amount_collected), 2, '.', ','); ?></td>
                <td><input type="hidden" name="debit_record" value="{{ array_sum($sum_amount_collected) }}">
                    <input type="hidden" name="cash_in_bank_total" value="{{ array_sum($sum_amount_collected) }}">
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center;">{{ $get_customer_ar->account_name }}</td>
                <td><input type="hidden" name="credit_record" value="{{ array_sum($sum_amount_collected) }}">
                </td>
                <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($sum_amount_collected), 2, '.', ','); ?>
                    <input type="hidden" name="customer_ar_total" value="{{ array_sum($sum_amount_collected) }}">
                </td>
            </tr>
        </tbody>
    </table> --}}


    <input type="hidden" value="{{ $get_bank->account_name }}" name="get_bank_account_name">
    <input type="hidden" value="{{ $get_bank->account_number }}" name="get_bank_account_number">
    <input type="hidden" value="{{ $get_bank->chart_of_accounts->account_number }}"
        name="get_bank_general_account_number">
    <input type="hidden" value="{{ $get_customer_ar->account_name }}" name="get_customer_ar_account_name">
    <input type="hidden" value="{{ $get_customer_ar->account_number }}" name="get_customer_ar_account_number">
    <input type="hidden" value="{{ $get_customer_ar->chart_of_accounts->account_number }}"
        name="get_customer_ar_general_account_number">

    <button class="btn btn-sm float-right btn-success">Submit</button>
</form>

<script>
    $("#collection_saved").on('submit', (function(e) {
        e.preventDefault();
        $('#loader').show();
        $.ajax({
            url: "collection_saved",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#loader').hide();
                //Swal.fire({
                // position: 'top-end',
                //icon: 'success',
                //title: 'Your work has been saved',
                //showConfirmButton: false,
                //timer: 1500
                //});

                //location.reload();
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

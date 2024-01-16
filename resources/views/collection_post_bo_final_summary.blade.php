<table class="table table-bordered table-sm table-striped">
    <tr>
        <th colspan="8" style="text-align: center;">BAD ORDER CREDIT MEMO</th>
    </tr>
    <tr>
        <td>CM #</td>
        <th style="text-align: center;">{{ $bad_order->pcm_number }}</th>
        <td>SALES AGENT</td>
        <th style="text-align: center;">{{ $bad_order->collection_agent->full_name }}</th>
        <td>DATE</td>
        <th style="text-align: center;">{{ $date }}</th>
        <td>CUSTOMER NAME</td>
        <th style="text-align: center;">{{ $bad_order->collection_customer->store_name }}</th>
    </tr>
</table>

<div class="table table-responsive">
    <table class="table table-bordered table-sm table-striped">
        <thead>
            <tr>
                <th style="text-align: center">INVOICE NO</th>
                <th style="text-align: center">PRINCIPAL</th>
                <th style="text-align: center">OUTSTANDING</th>
                <th style="text-align: center">CM AMOUNT</th>
                <th style="text-align: center">BALANCE</th>
                <th style="text-align: center">REMARKS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales_invoice as $data)
                <tr>
                    <td style="text-align: center;">{{ $data->delivery_receipt }}</td>
                    <td style="text-align: center;">{{ $data->principal->principal }}</td>
                    <td style="text-align: right">
                        @php
                            $outstanding_balance = $data->total - $data->total_returned_amount - $data->total_payment;
                            echo number_format($outstanding_balance, 2, '.', ',');
                        @endphp
                        <input type="hidden" value="{{ round($outstanding_balance, 2) }}"
                            name="outstanding_balance[{{ $data->id }}]">
                    </td>
                    <td style="text-align: right">
                        {{ number_format($bo_amount[$data->id], 2, '.', ',') }}
                        <input type="hidden" value="{{ $bo_amount[$data->id] }}"
                            name="bo_amount[{{ $data->id }}]">
                    </td>
                    <td style="text-align: right">
                        @php
                            $balance = $outstanding_balance - $bo_amount[$data->id];
                        @endphp
                        {{ number_format($balance, 2, '.', ',') }}
                    </td>
                    <td>
                        {{ $remarks[$data->id] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

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
            <td style="text-align: center;">{{ $get_spoiled_goods->account_name }}</td>
            <td></td>
            <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($bo_amount), 2, '.', ','); ?></td>
            <td><input type="hidden" name="debit_record" value="{{ array_sum($bo_amount) }}">
                <input type="hidden" name="cash_in_bank_total" value="{{ array_sum($bo_amount) }}">
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center;">{{ $get_customer_ar->account_name }}</td>
            <td><input type="hidden" name="credit_record" value="{{ array_sum($bo_amount) }}">
            </td>
            <td style="font-weight: bold;text-align: center;"><?php echo number_format(array_sum($bo_amount), 2, '.', ','); ?>
                <input type="hidden" name="customer_ar_total" value="{{ array_sum($bo_amount) }}">
            </td>
        </tr>
    </tbody>
</table>

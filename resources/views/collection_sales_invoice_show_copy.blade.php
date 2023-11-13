<table class="table table-bordered table-striped table-sm table-striped"
    style="font-family: Tahoma, Verdana, Segoe, sans-serif;font-size:15px;">
    <thead>
        <tr>
            <th colspan="6">ORIGINAL TRANSACTION</th>
        </tr>
        <tr>
            <th>Code</th>
            <th>Desc</th>
            <th>Uom</th>
            <th style="text-align: right">Qty</th>
            <th style="text-align: right">U/P</th>
            <th style="text-align: right">Sub-Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales_invoice->sales_invoice_details as $details)
            <tr>
                <td>{{ $details->sku->sku_code }}</td>
                <td>{{ $details->sku->description }}</td>
                <td>{{ $details->sku->unit_of_measurement }}</td>
                <td style="text-align: right">
                    @php
                        echo $quantity = $details->quantity - $details->quantity_returned;
                    @endphp
                </td>
                <td style="text-align: right">{{ number_format($details->unit_price, 2, '.', ',') }}</td>
                <td style="text-align: right">
                    @php
                        $sub_total = $quantity * $details->unit_price;
                        echo number_format($sub_total, 2, '.', ',');
                        $sum_total[] = $sub_total;
                    @endphp
                </td>
            </tr>
        @endforeach
    </tbody>
</table>



@if ($sales_invoice->discount_rate != 'none')
    <table class="table table-bordered table-sm float-right"
        style="font-family: Tahoma, Verdana, Segoe, sans-serif;font-size:15px;">
        <tbody>
            <tr>
                <th style="text-align: right">GROSS</th>
                <th style="text-align: right">{{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
            </tr>
            @php
                $total = array_sum($sum_total);
                $discount_holder = [];
                $discount_value_holder = $total;
            @endphp
            @foreach (explode('-', $sales_invoice->discount_rate) as $data_discount)
                <tr>
                    <th style="text-align: right">Less - {{ $data_discount }}</th>
                    <th style="text-align: right;width:50px;">
                        @php
                            $discount_value_holder_dummy = $discount_value_holder;
                            $less_percentage_by = $data_discount / 100;

                            $discount_rate_answer = $discount_value_holder * $less_percentage_by;
                            $discount_value_holder = $discount_value_holder - $discount_value_holder_dummy * $less_percentage_by;
                            $discount_holder[] = $discount_value_holder;
                            echo number_format($discount_value_holder, 2, '.', ',');
                        @endphp

                    </th>
                </tr>
            @endforeach
            <tr>
                <th style="text-align: right">Final Total</th>
                <th style="text-align: right;text-decoration: overline">
                    {{ number_format(end($discount_holder), 2, '.', ',') }}
                    @php
                        $final_total = end($discount_holder);
                    @endphp
                </th>
            </tr>
        </tbody>
    </table>
@else
    <table class="table table-bordered table-sm float-right"
        style="font-family: Tahoma, Verdana, Segoe, sans-serif;font-size:15px;">
        <tbody>
            <tr>
                <th style="text-align: right;">TOTAL</th>
                <th style="text-align: right;width:50px">
                    {{ number_format(array_sum($sum_total), 2, '.', ',') }}</th>
            </tr>
        </tbody>
    </table>
@endif

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
            <td style="text-align: center;">ACCOUNTS RECEIVABLE -
                {{ $sales_invoice->customer->store_name }}
            </td>
            <td></td>
            <td style="font-weight: bold;text-align: center;">
                {{ number_format($sales_invoice->sales_invoice_jer->debit_record_ar, 2, '.', ',') }}
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center;">SALES - {{ $sales_invoice->principal->principal }}
            </td>
            <td></td>
            <td style="font-weight: bold;text-align: center;">
                {{ number_format($sales_invoice->sales_invoice_jer->credit_record_sales, 2, '.', ',') }}
            </td>
        </tr>


        <tr>
            <td style="text-align: center;">COST OF SALES -
                {{ $sales_invoice->principal->principal }}
            </td>
            <td></td>
            <td style="font-weight: bold;text-align: center;">
                {{ number_format($sales_invoice->sales_invoice_jer->debit_record_cost_of_sales, 2, '.', ',') }}
            </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center;">INVENTORY - {{ $sales_invoice->principal->principal }}
            </td>
            <td></td>
            <td style="font-weight: bold;text-align: center;">
                {{ number_format($sales_invoice->sales_invoice_jer->credit_record_inventory, 2, '.', ',') }}
            </td>
        </tr>
    </tbody>
</table>
